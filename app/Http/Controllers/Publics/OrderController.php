<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Support\Facades\DB;

use App\Notifications\Order\PaymentVerifiedNotification as OrderPaymentNotification;
use App\Notifications\Admin\NewOrderCreatedNotification;
use App\Notifications\Admin\UserPaymentSuccessNotification;

use App\Models\User;
use App\Models\Pesanan as Order;
use App\Models\DetailPesanan as OrderDetail;
use App\Models\Pembayaran as OrderPayment;

class OrderController extends Controller
{
    // check dulu kalau mau checkout
    public function checkData(Request $request) {
        $validator = \Validator::make($request->all(), [
            'produk' => ['required'],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $validated_input = $validator->validated();
        $user = auth()->user();
        $validators = ['nama' => $user->profile->nama, 'telepon' => $user->profile->telepon, 'alamat' => $user->profile->alamat];
        foreach($validators as $item) {
            if(!$item) {
                return back()->with(['msg_error' => 'Mohon lengkapi (nama, nomor hp, alamat) biodata Anda!']);
            }
        }

        if($user) {
            $cartWithStat = $user->cartWithStat($validated_input['produk']);
        } else {
            $keranjangs_array = [];
        }

        session(['cart' => [
            'maintains' => $cartWithStat['keranjangs'],
            'stat' => $cartWithStat['stat'],
            'payment_type' => 2
        ]]);

        $data = [
            'keranjangs' => $cartWithStat['keranjangs'],
            'stat' => $cartWithStat['stat'],
        ];

        return redirect(route('order.proses.checkout.view'));
    }

    // api ganti tipe pembayaran dp / full
    public function changePaymentType($type) {
        $total_bayar = session('cart')['stat']['total_bayar'];
        if($type == 1) {
            $dp = (40*(int)$total_bayar/100);
            $full = $total_bayar - $dp;
        } else {
            $dp = 0;
            $full = $total_bayar;
        }
        return response()->json(['dp' => $dp, 'other'=> $full]);
    }

    // kalau ganti tanggal pinjam pas proses checkout, ini untuk yg tidak nge set tanggal durasi di produk
    public function changeBookDuration(Request $request) {
        $validator = \Validator::make($request->all(), [
            'to' => ['required', 'string'],
            'from' => ['required', 'string'],
        ]);

        if($validator->fails()):
            return response()->json(['msg_error' => 'Server Error!']);
        endif;


        session()->put('book', $request->only(['from', 'to']));
        session()->save();

        $user = auth()->user();
        $validated_input = $validator->validated();
        $old_cart_maintain = session('cart');
        $cartWithStat = $user->cartWithStat(array_column($old_cart_maintain['maintains'], 'id_produk'));        
        session()->put('cart.maintains', $cartWithStat['keranjangs']);
        session()->put('cart.stat', $cartWithStat['stat']);
        session()->put('cart.payment_type', $old_cart_maintain['payment_type']);
        session()->save();
        
        return response()->json(['msg' => '']);
    }

    // tampilan checkout
    public function checkoutView() {
        if(!session()->has('cart')) {
            return redirect('/cart');
        };

        $data = [
            'keranjangs' => session('cart')['maintains'],
            'stat' => auth()->user()->cartWithStat(array_column(session('cart')['maintains'], 'id_produk'))['stat'],
        ];

        // session()->forget('book');
        // session()->save();
        // return dd($data);

        return view('public-pages.checkout', $data);
    }

    // sedikit validasi dan tambah beberapa data
    public function processPayment(Request $request) {
        $validator = \Validator::make($request->all(), [
            'tanggal_mulai' => ['required', 'string'],
            'tanggal_selesai' => ['required', 'string'],
            'tipe_pembayaran' => ['required', 'numeric'],
        ]);

        if($validator->fails()):
            return redirect('/cart')->withErrors($validator)->withInput();
        endif;

        $validated_input = $validator->validated();

        $user = auth()->user();
        $check_order = $user->order()->where('tanggal_mulai', $validated_input['tanggal_mulai'])->whereIn('status', [1,2])->get();

        if($check_order->count() > 0) {
            $check_order->map(function($item) {
                $item->delete();
            });
        }
        session(['additional_data_order' => [
            'tanggal_mulai' => session('book')['from'],
            'tanggal_selesai' => session('book')['to'],
            'tipe_pembayaran' => $validated_input['tipe_pembayaran'],
        ]]);
        return view('public-pages.proses-pembayaran');
    }

    // mulai pembayaran midtrans
    // jadi sistem nya lngsung buat 2 pembayaran
    // misal pilih pembayaran full, pembayaran yg buat dp atau pembayaran pertama total bayar diset rp 0

    // misal pilih pembayaran dp:
    // pembayaran pertama 40% dari total
    // pembayaran kedua sisanya

    public function makePayment(Request $request) {
        if(!session()->has('cart') || !session()->has('additional_data_order')) {
            return redirect('/cart');
        };

        $filled = DB::transaction(function() {
            $user = auth()->user();
            $stats = ['total_bayar' => 0];
            $keranjang_stat = session('cart')['stat'];
            $keranjangs = session('cart')['maintains'];
            $keranjangs_array = $keranjangs;
            $checkoutable = $user->checkoutable();
            if(!$checkoutable['boolean']) {
                session()->flash('msg_error', 'Mohon pesan ulang Stok '.$checkoutable['msg'].' tidak mencukupi.');
                return response()->json(['msg_error' => 'Mohon pesan ulang Stok '.$checkoutable['msg'].' tidak mencukupi.']);
            }

            $keranjang_total_price = $keranjang_stat['total_bayar'];

            $stats['total_bayar'] = $keranjang_total_price;

            $additional_data_order = session('additional_data_order');

            $dt = date('Ymd');
            $kode_pesanan_build = 'OD-'.$dt.\Str::upper(uniqid()).'-'.$user->profile->telepon;
            $order = new Order();
            $order->kode_pesanan = $kode_pesanan_build;
            $order->status = 1;
            $order->total_bayar = $stats['total_bayar'];
            $order->id_user = $user->id_user;
            $order->tanggal_mulai = $additional_data_order['tanggal_mulai'];
            $order->tanggal_selesai = $additional_data_order['tanggal_selesai'];
            $order->save();

            $pay_total = $additional_data_order['tipe_pembayaran'] == 1 ? (40*(int)$stats['total_bayar']/100): (int)$stats['total_bayar'];

            
            if($additional_data_order['tipe_pembayaran'] == 2) {
                $order->payment()->create([
                    'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.(string)$user->profile->telepon.'-'.(string)$dt,
                    'snap_token' => '',
                    'total_bayar' => 0,
                    'tipe_pembayaran' => 1,
                    'status' => 2, 
                    'kode_pesanan' => $kode_pesanan_build
                ]);    
            } else {
                $order->payment()->create([
                    'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.$user->profile->telepon.'-'.$dt,
                    'snap_token' => '',
                    'total_bayar' => (int)$stats['total_bayar']-$pay_total,
                    'tipe_pembayaran' => 2,
                    'status' => 1, 
                    'kode_pesanan' => $kode_pesanan_build
                ]);
            }

            $current_payment = $order->payment()->create([
                'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.$user->profile->telepon.'-'.$dt,
                'snap_token' => '',
                'total_bayar' => $pay_total,
                'tipe_pembayaran' => $additional_data_order['tipe_pembayaran'],
                'status' => 1, 
                'kode_pesanan' => $kode_pesanan_build
            ]);

            $midtrans = new CreateSnapTokenService($current_payment);
            $snapToken = $midtrans->getSnapToken();

            $current_payment->snap_token = $snapToken;
            $current_payment->save();

            array_map(function($item) use ($order, $user){
                $order->details()->create([
                    'kuantitas' => $item['pivot']['kuantitas'],
                    'id_produk' => $item['id_produk'],
                    'kode_pesanan' => $order['kode_pesanan'],
                    'total_harga' => $item['pivot']['kuantitas']*$item['harga']
                ]);
                $user->carts()->detach([$item['id_produk']]);
            },$keranjangs_array);
            
            session()->forget(['cart', 'additional_data_order', 'book']);

            return ['snap_token' => $snapToken];
        });

        return response()->json(['msg' => '', 'snap_token' => $filled['snap_token']]);
    }

    // buat nerima notifikasi status pembayaran dari midtrans
    public function paymentNotification(Request $request) {
        $payment_data = \json_decode($request->getContent(), true);
        $type = $payment_data['payment_type'];
        $kode_bayar = $payment_data['order_id'];
        $status_code = $payment_data['status_code'];
        $status = $payment_data['transaction_status'];
        $payment = OrderPayment::where('kode_pembayaran', $kode_bayar)->first();
        
        if(!$payment) {
            return response()->json(['msg' => '']);
        }

        $order = $payment->order;
        $user = $order->user;
        $details = $order->details()->with(['produk'])->get();
        $payment->jenis_pembayaran = $type;
        if($payment) {
            if($status == 'settlement' && $status_code == '200') {
                $user_admins = User::admins()->get();
                $sewa = $order->sewa;
                if(!$sewa) {
                    $sewa = $order->sewa()->create([
                        'status' => 1,
                    ]);

                    foreach($user_admins as $row) {
                        $notification_admin = new NewOrderCreatedNotification($order);
                        $row->notify($notification_admin);        
                    }
                }
                
                // if($order->status) {
                //     foreach($details as $row) {
                //         $produk = $row->produk;
                //         $produk->stok = (int)$produk->stok - (int)$row->kuantitas;
                //         $produk->save();
                //     }
                // }

                if($payment->tipe_pembayaran == 1) {
                    $rest_payment = $order->fullPayment();
                    $midtrans = new CreateSnapTokenService($rest_payment);
                    $snapToken = $midtrans->getSnapToken();

                    $rest_payment->snap_token = $snapToken;
                    $rest_payment->save();
                    $order->status = 2;
                } else {
                    $order->status = 3;
                }

                $payment->status = 2;
                $payment->save();
                $order->save();

                foreach($user_admins as $row) {
                    $notification_admin = new UserPaymentSuccessNotification($payment);
                    $row->notify($notification_admin);        
                }
                $notification = new OrderPaymentNotification($payment);
                $user->notify($notification);
            } else if($status == 'pending' && $status_code == '201') {
                
            } else if($status == 'cancel' && $status_code == '202') {
                $order->status = 5;
                $order->save();
                $order->hapus();
            } else {
                $payment->status = 3;
                $order->status = 4;
                $order->save();

                $notification = new OrderPaymentNotification($payment);
                $user->notify($notification);
            }
        }

        return response()->json(['msg' => '']);
    }

    // selesai pembayaran ke url yg diset di dashboard midtrans
    public function finishPayment() {
        return redirect(route('profile.show', auth()->user()->email));
    }


    // public function paymentCheckStatus(Request $request) {
    //     return $response->json($request->getContent());
    // }
}

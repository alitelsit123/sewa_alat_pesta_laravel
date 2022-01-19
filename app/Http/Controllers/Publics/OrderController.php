<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;

use App\Models\Pesanan as Order;
use App\Models\DetailPesanan as OrderDetail;
use App\Models\Pembayaran as OrderPayment;

class OrderController extends Controller
{
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
        ]]);

        $data = [
            'keranjangs' => $cartWithStat['keranjangs'],
            'stat' => $cartWithStat['stat'],
        ];

        return view('public-pages.checkout', $data);
    }
    public function checkoutView() {
        if(!session()->has('cart')) {
            return redirect('/cart');
        };

        $data = [
            'keranjangs' => session('cart')['maintains'],
            'stat' => session('cart')['stat'],
        ];

        return view('public-pages.checkout', $data);
    }
    public function processPayment(Request $request) {
        $validator = \Validator::make($request->all(), [
            'tanggal_mulai' => ['required', 'string'],
            'tanggal_selesai' => ['required', 'string'],
            'tipe_pembayaran' => ['required', 'numeric'],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
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
            'tanggal_mulai' => $validated_input['tanggal_mulai'],
            'tanggal_selesai' => $validated_input['tanggal_selesai'],
            'tipe_pembayaran' => $validated_input['tipe_pembayaran'],
        ]]);
        return view('public-pages.proses-pembayaran');
    }
    public function makePayment(Request $request) {
        if(!session()->has('cart') || !session()->has('additional_data_order')) {
            return redirect('/cart');
        };

        

        $user = auth()->user();
        $stats = ['total_harga' => 0];
        $keranjangs = session('cart')['maintains'];
        $keranjangs_array = $keranjangs;
        $checkoutable = $user->checkoutable();
        if(!$checkoutable['boolean']) {
            session()->flash('msg_error', 'Mohon pesan ulang Stok '.$checkoutable['msg'].' tidak mencukupi.');
            return response()->json(['msg_error' => 'Mohon pesan ulang Stok '.$checkoutable['msg'].' tidak mencukupi.']);
        }

        $keranjangs_array = array_map(function($item){
            $item['total'] = $item['harga'] * $item['pivot']['kuantitas'];
            return $item;
        },$keranjangs_array);
        $keranjangs_pivot = array_map(function($item){
            return $item['pivot'];
        },$keranjangs_array);
        
        $keranjang_total_price = array_sum(array_column($keranjangs_array, 'total'));

        $stats['total_harga'] = $keranjang_total_price;

        $additional_data_order = session('additional_data_order');

        $dt = date('Ymd');
        $kode_pesanan_build = 'OD-'.$dt.\Str::upper(uniqid()).'-'.$user->profile->telepon;
        $order = new Order();
        $order->kode_pesanan = $kode_pesanan_build;
        $order->status = 1;
        $order->total_bayar = $stats['total_harga'];
        $order->id_user = $user->id_user;
        $order->tanggal_mulai = $additional_data_order['tanggal_mulai'];
        $order->tanggal_selesai = $additional_data_order['tanggal_selesai'];
        $order->save();

        $pay_total = $additional_data_order['tipe_pembayaran'] == 1 ? (40*(int)$stats['total_harga']/100): (int)$stats['total_harga'];

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
                'total_bayar' => $pay_total,
                'tipe_pembayaran' => 2,
                'status' => 1, 
                'kode_pesanan' => $kode_pesanan_build
            ]);
            $pay_total -= (int)$stats['total_harga'];
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

        session()->forget(['cart', 'additional_data_order']);
        array_map(function($item) use ($order, $user){
            $order->details()->create([
                'kuantitas' => $item['pivot']['kuantitas'],
                'id_produk' => $item['id_produk'],
                'kode_pesanan' => $order['kode_pesanan'],
                'total_harga' => $item['pivot']['kuantitas']*$item['harga']
            ]);
            $user->carts()->detach([$item['id_produk']]);
        },$keranjangs_array);

        return response()->json(['msg' => '', 'snap_token' => $snapToken]);
    }
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
        $details = $order->details()->with(['produk'])->get();
        $payment->jenis_pembayaran = $type;
        if($payment) {
            if($status == 'settlement' && $status_code == '200') {
                $sewa = $order->sewa()->create([
                    'status' => 1,
                ]);
                
                if($order->status) {
                    foreach($details as $row) {
                        $produk = $row->produk;
                        $produk->stok = (int)$produk->stok - (int)$row->kuantitas;
                        $produk->save();
                    }
                }

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


            } else if($status == 'pending' && $status_code == '201') {
                
            } else if($status == 'cancel' && $status_code == '202') {
                $order->status = 4;
                $order->save();
                $order->hapus();
            } else {
                $order->status = 4;
                $order->save();
            }
        }

        return response()->json(['msg' => '']);
    }
    public function finishPayment() {
        return redirect(route('profile.show', auth()->user->email));
    }
    public function paymentCheckStatus(Request $request) {
        return $response->json($request->getContent());
    }
}

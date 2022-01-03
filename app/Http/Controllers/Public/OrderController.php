<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Midtrans\CreateSnapTokenService;

use App\Models\Pesanan as Order;

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
        $order->total_pending_bayar = $stats['total_harga'];
        $order->id_user = $user->id_user;
        $order->tanggal_mulai = $additional_data_order['tanggal_mulai'];
        $order->tanggal_selesai = $additional_data_order['tanggal_selesai'];
        $order->save();


        array_map(function($item) use ($order, $user){
            $order->details()->create([
                'kuantitas' => $item['pivot']['kuantitas'],
                'id_produk' => $item['id_produk'],
                'kode_pesanan' => $order['kode_pesanan'],
                'total_harga' => $item['pivot']['kuantitas']*$item['harga']
            ]);
            $user->carts()->detach([$item['id_produk']]);
        },$keranjangs_array);

        $pay_total = $additional_data_order['tipe_pembayaran'] == 1 ? (int)$stats['total_harga']-(40*(int)$stats['total_harga']/100): (int)$stats['total_harga'];

        $midtrans = new CreateSnapTokenService($order);
        $snapToken = $midtrans->getSnapToken();
        if($additional_data_order['tipe_pembayaran'] == 2) {
            $order->payment()->create([
                'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.$user->profile->telepon.'-'.$dt,
                'snap_token' => '',
                'total_bayar' => 0,
                'tipe_pembayaran' => 1,
                'status' => 2, 
                'kode_pesanan' => $kode_pesanan_build
            ]);    
            $order->status = 2;
            $order->save();
        } else {
            $order->payment()->create([
                'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.$user->profile->telepon.'-'.$dt,
                'snap_token' => '',
                'total_bayar' => (int)$stats['total_harga'] - $pay_total,
                'tipe_pembayaran' => 2,
                'status' => 1, 
                'kode_pesanan' => $kode_pesanan_build
            ]);
        }

        $order->payment()->create([
            'kode_pembayaran' => 'PAY-'.\Str::upper(uniqid()).'-'.$user->profile->telepon.'-'.$dt,
            'snap_token' => $snapToken,
            'total_bayar' => $pay_total,
            'tipe_pembayaran' => $additional_data_order['tipe_pembayaran'],
            'status' => 1, 
            'kode_pesanan' => $kode_pesanan_build
        ]);

        session()->forget(['cart', 'additional_data_order']);
        return response()->json(['msg' => '', 'snap_token' => $snapToken]);
    }
}

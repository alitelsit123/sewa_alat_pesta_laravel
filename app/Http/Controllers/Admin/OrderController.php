<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pesanan as Order;

class OrderController extends Controller
{
    public function index() {
        $orders = Order::latest()->paginate(15);
        $data = [
            'orders' => $orders
        ];
        return view('admin-pages.pesanan', $data);
    }
    public function show($kode_pesanan) {
        $order = Order::findOrFail($kode_pesanan);
        $data = [
            'order' => $order
        ];
        return view('admin-pages.pesanan.lihat-pesanan', $data);
    }
    public function shipmentOut($kode_pesanan, $type) {
        $order = Order::findOrFail($kode_pesanan);
        $sewa = $order->sewa;
        $sewa->status = $type;
        if($type == 2) {
            $sewa->waktu_pengiriman = now();
        }
        $sewa->save();
        
        return redirect(route('admin.order.show', $kode_pesanan));
    }
}

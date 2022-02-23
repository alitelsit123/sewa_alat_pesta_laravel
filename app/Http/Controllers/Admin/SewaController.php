<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sewa;

class SewaController extends Controller
{
    public function index() {
        $sewa = Sewa::OrderByDesc('id_sewa')->paginate(15);
        $data = [
            'sewa' => $sewa
        ];
        return view('admin-pages.sewa', $data);
    }

    // sewa selesai
    public function complete($id) {
        $sewa = Sewa::findOrFail($id);
        $order = $sewa->order;
        $details = $order->details;
        // foreach($details as $row) {
        //     $produk = $row->produk;
        //     $produk->stok = $produk->stok + $row->kuantitas;
        //     $produk->save();
        // }

        $sewa->status = 4;
        $sewa->waktu_pengembalian = now();
        $sewa->save();

        return back()->with('notes', ['text' => 'Yeay Sewa selesai!']);;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Pembayaran as Payment;

class TransaksiController extends Controller
{
    public function index() {
        $trans = Payment::where('total_bayar', '>', 0)->where('status', 2)->latest()->get();
        $data = [
            'trans' => $trans
        ];
        return view('admin-pages.transaksi', $data);
    }
}

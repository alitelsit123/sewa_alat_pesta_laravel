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
    public function complete($id) {
        return back()->with('notes', ['text' => 'Yeay Transaksi selesai!']);;
    }
}

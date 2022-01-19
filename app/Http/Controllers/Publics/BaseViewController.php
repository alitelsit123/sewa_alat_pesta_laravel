<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\Kategori;

class BaseViewController extends Controller
{
    public function showHomePage() {
        $produks = Produk::take(6)->where('stok', '>', 0)->latest()->get();
        $kategoris = Kategori::all();
        $rekomendasi_ids = DetailPesanan::select('id_produk')
        ->groupBy('id_produk')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(4)
        ->pluck('id_produk')->toArray();
        if(sizeof($rekomendasi_ids) > 0) {
            $rekomendasi = Produk::whereIn('id_produk', $rekomendasi_ids)->get();
        } else {
            $rekomendasi = Produk::inRandomOrder()->limit(4)->get();
        }
        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategoris,
            'rekomendasi' => $rekomendasi
        ];

        return view('public-pages.home', $data);
    }
    public function showAboutPage() {
        return view('public-pages.tentang');
    }
}

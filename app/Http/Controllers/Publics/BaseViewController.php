<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\DetailPesanan;
use App\Models\Kategori;
use App\Models\Stat;

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
        $stats = Stat::whereType('search')->get();
        $stats = $stats->map(function($item) {
            $text = $item->data;
            return \json_decode($text)->text;
        });
        $stats_text = $stats->countBy()->sortDesc()->keys()->take(12);
        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategoris,
            'rekomendasi' => $rekomendasi,
            'popular_search' => $stats_text
        ];

        return view('public-pages.home', $data);
    }
    public function showAboutPage() {
        return view('public-pages.tentang');
    }
}

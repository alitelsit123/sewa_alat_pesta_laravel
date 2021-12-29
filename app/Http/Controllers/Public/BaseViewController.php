<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;

class BaseViewController extends Controller
{
    public function showHomePage() {
        $produks = Produk::take(6)->latest()->get();
        $kategoris = Kategori::all();
        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategoris,
        ];

        return view('public-pages.home', $data);
    }
    public function showProductsPage() {
        $produks = Produk::latest()->simplePaginate(12);
        $kategori = Kategori::latest()->get();
        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategori,
        ];
        return view('public-pages.products', $data);
    }
    public function showCartPage() {
        return view('public-pages.keranjang');
    }
    public function showAboutPage() {
        return view('public-pages.tentang');
    }
}

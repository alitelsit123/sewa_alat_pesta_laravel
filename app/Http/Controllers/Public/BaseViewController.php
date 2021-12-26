<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BaseViewController extends Controller
{
    public function showHomePage() {
        return view('public-pages.home');
    }
    public function showProductsPage() {
        return view('public-pages.products');
    }
    public function showAboutPage() {
        return view('public-pages.tentang');
    }
}

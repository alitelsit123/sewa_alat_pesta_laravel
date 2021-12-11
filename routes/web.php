<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/products');
});
Route::get('/products', [App\Http\Controllers\Public\BaseViewController::class, 'showProductsPage']);

Route::prefix('auth')->group(function() {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index']);
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    
    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index']);
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
});

Route::name('admin.')->group(function() {
    Route::prefix('admin')->group(function() {
        Route::get('/', function () {
            return redirect('/admin/dashboard');
        });
        Route::get('/dashboard', function () {
            return view('admin-pages.dashboard');
        });
    });
    Route::resource('admin/kategori', \App\Http\Controllers\Admin\KategoriController::class);
    Route::resource('admin/produk', \App\Http\Controllers\Admin\ProdukController::class);
});


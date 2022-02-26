<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kategori;
use App\Models\Produk;
use App\Models\Pesanan as Order;
use App\Models\Pembayaran;
use App\Models\User;
use App\Models\Chat;

class GeneralSearchController extends Controller
{
    public function index() {
        // return dd(request()->all());        
        $results = [];
        $filter_types = \App\Helpers\AppSupport::generalSearchFilterTypes();
        
        if(request()->filter_types) {
            $checked_filter_types = request()->filter_types ?? [];
            $checked_filter_types = array_intersect($filter_types, $checked_filter_types);
        } else {
            $checked_filter_types = $filter_types;
        }     

        if(in_array('categories', $checked_filter_types)) {
            $categories = Kategori::when(request()->s, function($query) {
                $query->where('nama_kategori', 'like', '%'.request()->s.'%');
            })->latest()->get();
        } else {
            $categories = collect([]);
        }
        
        
        if(in_array('products', $checked_filter_types)) {
            $products = Produk::when(request()->s, function($query) {
                $query->where('nama_produk', 'like', '%'.request()->s.'%');
            })->latest()->get();
        } else {
            $products = collect([]);    
        }
        
        
        if(in_array('orders', $checked_filter_types)) {
            $orders = Order::when(request()->s, function($query) {
                $query->where('kode_pesanan', 'like', '%'.request()->s.'%');
            })->latest()->get();
        } else {
            $orders = collect([]);
        }
        

        if(in_array('payments', $checked_filter_types)) {
            $payments = Pembayaran::when(request()->s, function($query) {
                $query->where('kode_pembayaran', 'like', '%'.request()->s.'%');
            })->latest()->get();
        } else {
            $payments = collect([]);
        }

        if(in_array('users', $checked_filter_types)) {
            $users = User::when(request()->s, function($query) {
                $query->where('email', 'like', '%'.request()->s.'%')
                ->orWhereHas('profile', function($query) {
                    $query->where('nama', 'like', '%'.request()->s.'%');
                });
            })->latest()->get();
        } else {
            $users = collect([]);
        }

        if(in_array('chats', $checked_filter_types)) {
            $chats = Chat::when(request()->s, function($query) {
                $query->where('chat', 'like', '%'.request()->s.'%');
            })->latest()->get();
        } else {
            $chats = collect([]);
        }
        

        return view('admin-pages.general-search', [
            'categories' => $categories, 
            'products' => $products, 
            'orders' => $orders, 
            'payments' => $payments,
            'users' => $users, 
            'chats' => $chats,
            'total' => $categories->count()+$products->count()+$orders->count()+$payments->count()+$chats->count()+$users->count(),
            'checked_filter_types' => $checked_filter_types
        ]);
    }
}

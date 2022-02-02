<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Keranjang as Cart;

class KeranjangController extends Controller
{
    public function showCartPage() {
        $user = auth()->user();
        $stats = ['total_kuantitas' => 0, 'total_harga' => 0];
        if($user) {
            $keranjangs = $user->carts()->withOrdered()->get();
            $keranjangs_array = $keranjangs->all();
        } else {
            $keranjangs_array = session('cart') ?? [];
        }
        $keranjangs_array = array_map(function($item){
            $item['total'] = $item['harga'] * $item['pivot']['kuantitas'];
            return $item;
        },$keranjangs_array);
        $keranjangs_pivot = array_map(function($item){
            return $item['pivot'];
        },$keranjangs_array);

        $keranjang_total_kuantitas = array_sum(array_column($keranjangs_pivot, 'kuantitas'));
        
        $keranjang_total_price = array_sum(array_column($keranjangs_array, 'total'));

        $stats['total_kuantitas'] = $keranjang_total_kuantitas;
        $stats['total_harga'] = $keranjang_total_price;

        // return dd($keranjangs_array);

        $data = [
            'keranjangs' => $keranjangs_array,
            'stat' => $stats,
        ];

        return view('public-pages.keranjang', $data);
    }
    public function addToCart(Request $request) {
        // session()->flush();
        // session()->save();
        // return dd(session('cart'));
        $produk = Produk::withOrdered()->whereId_produk($request->all()['produk_id'])->first();
        $max_produk = ((int)$produk->stok - (int)$produk->ordered_sum_kuantitas);
        $validator = \Validator::make($request->all(), [
            'produk_id' => ['required', 'integer', 'min:1'],
            'kuantitas' => ['required', 'integer', 'min:1', 'max:'.(string)$max_produk],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $validated_input = $validator->validated();

        $user = auth()->user();

        if($user) {
            // $user_cart = $user->carts;
            $user->carts()->syncWithoutDetaching([$produk->id_produk => ['kuantitas' => $validated_input['kuantitas']]]);
            return back()->with(['msg_success' => 'Produk Di tambahkan ke Keranjang']);
        } else {
            $keranjang = new Cart([
                'kuantitas' => $validated_input['kuantitas'],
                'id_produk' => $produk->id_produk,
            ]);
            $produk->pivot = $keranjang;
            $old_carts = collect(session('cart'));
            $index_cart = $old_carts->search(function($item) use ($produk){
                return $item->id_produk == $produk->id_produk;
            });
            if($index_cart === false) {
                session()->push('cart', $produk);
            }
            return back()->with(['msg_success' => 'Produk Di tambahkan ke Keranjang']);
        }

        return back();
    }
    public function updateCart(Request $request) {
        $user = auth()->user();
        $validated_input = $request->except(['_token']);
        if($user) {
            $produk_ids = [];
            $keranjang_item = [];
            foreach($validated_input as $index => $item) {
                $r_id = explode('_', $index);
                $keranjang = $user->carts()->withOrdered()->where('produk.id_produk', $r_id[1])->first();
                if($keranjang && ($keranjang->stok - $keranjang->ordered_sum_kuantitas) >= $item) {
                    $keranjang_item[$r_id[1]] = ['kuantitas' => $item];
                } else {
                    return back()->with(['msg_error' => 'Kuantitas '.$keranjang->nama_produk.' melebihi batas stok. mohon Update!']);
                }
            }
            $user->carts()->syncWithoutDetaching($keranjang_item);
            return back()->with(['msg_success' => 'Keranjang di update']);
        } else {
            $old_carts = collect(session('cart'));
            foreach($validated_input as $index => $item) {
                $r_id = explode('_', $index);
                // return dd($old_carts);
                $index_cart = $old_carts->search(function($item) use ($r_id){
                    return $item->id_produk == $r_id[1];
                });
                
                $current_cart = $old_carts->get($index_cart);

                if($current_cart && ($current_cart->stok - $current_cart->ordered_sum_kuantitas) >= $item) {
                    $current_cart->pivot->kuantitas = $item;
                    $old_carts[$index_cart] = $current_cart;
                } else {
                    return back()->with(['msg_error' => 'Kuantitas melebihi batas']);
                }
                session()->put('cart', $old_carts->all());
            }
        }
        return back();
    }
    public function deleteCart($id) {
        $user = auth()->user();
        if($user) {
            $user->carts()->detach($id);
            return back()->with(['msg_success' => 'Produk Di hapus dari Keranjang']);
        } else {
            $old_carts = collect(session('cart'));
            $index_cart = $old_carts->search(function($item) use ($id){
                return $item->id_produk == $id;
            });
            if($index_cart !== false) {
                unset($old_carts[$index_cart]);
            }
            session()->put('cart', $old_carts->all());
        }
        return back()->with(['msg_success' => 'Produk Di hapus dari Keranjang']);
    }

    public function addToCartGuess(Request $request) {
        $validator = \Validator::make($request->all(), [
            'produk_id' => ['required', 'integer', 'min:1'],
            'kuantitas' => ['required', 'integer', 'min:1']
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;
    }
}

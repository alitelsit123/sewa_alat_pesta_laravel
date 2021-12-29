<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;

class KeranjangController extends Controller
{
    public function showCartPage() {
        $user = auth()->user();
        $stats = ['total_kuantitas' => 0, 'total_harga' => 0];
        if($user) {
            $keranjangs = $user->carts;
            $keranjangs_array = $keranjangs->toArray();
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
        } else {
            $keranjangs_array = [];
        }
        $data = [
            'keranjangs' => $keranjangs_array,
            'stat' => $stats,
        ];


        return view('public-pages.keranjang', $data);
    }
    public function addToCart(Request $request) {
        $validator = \Validator::make($request->all(), [
            'produk_id' => ['required', 'integer', 'min:1'],
            'kuantitas' => ['required', 'integer', 'min:1']
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $validated_input = $validator->validated();

        $produk = Produk::find($validated_input['produk_id']);
        $user = auth()->user();

        if($user) {
            // $user_cart = $user->carts;
            $user->carts()->syncWithoutDetaching([$produk->id_produk => ['kuantitas' => $validated_input['kuantitas']]]);
            return back()->with(['msg_success' => 'Produk Di tambahkan ke Keranjang']);
        } else {
            // session()->store('cart', []);
            return var_dump([]);
        }
        

        return back();
    }
    public function deleteCart($id) {
        $user = auth()->user();
        if($user) {
            $user->carts()->detach($id);
            return back()->with(['msg_success' => 'Produk Di hapus dari Keranjang']);
        }
        return back();
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

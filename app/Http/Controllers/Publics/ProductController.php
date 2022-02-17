<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Sewa;
use App\Models\Pesanan;

class ProductController extends Controller
{
    public function showProductsPage() {
        $kategori = Kategori::latest()->get();
        $querys = request()->query();
        $validated_query = $this->filterValidator($querys);
        $produks = Produk::withOrdered()->when(in_array('k', $validated_query), function($query) use ($querys) {
            $query->where('id_kategori', $querys['k'])->orWhereHas('kategori', function($q) use ($querys) {
                $q->where('nama_kategori', $querys['k']);
            });
        })
        ->when(in_array('q', $validated_query), function($query) use ($querys) {
            $arr = explode(' ', $querys['q']);
            $query->where('nama_produk', 'like', '%'.$querys['q'].'%');
            foreach($arr as $k => $v) {
                $query->orWhere('nama_produk', 'like', '%'.$v.'%');
            }
        })
        ->paginate(15)->withQueryString();

        $query_new = [];

        foreach($validated_query as $row) {
            $query_new[$row] = $querys[$row];
        }

        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategori,
            'query_new' => $query_new
        ];

        return view('public-pages.products', $data);
    }
    public function setDuration(Request $request) {
        $validator = \Validator::make($request->all(), [
            'from' => ['required', 'date'],
            'to' => ['required', 'date'],
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        if($input['from'] > $input['to']):
            return back()->with(['msg_error' => 'Tanggal sampai harus lebih dari tanggal mulai.']);
        endif;

        if(!session()->has('book')) {
            $book = [
                'from' => $input['from'],
                'to' => $input['to'],
            ];
            session(['book' => $book]);
        } else {
            session()->put('book.from', $input['from']);
            session()->put('book.to', $input['to']);
        }

        return redirect('/products');
    }
    public function showProductsItemPage(Request $request, $kategori, $slug, $id) {
        $produk = Produk::withOrdered()->whereId_produk($id)->first();
        $data = [
            'produk' => $produk,
        ];

        return view('public-pages.produk-single', $data);
    }


    private function filterValidator($query) {
        $validated_query = [];
        // kategori
        if(array_key_exists('k', $query)) {
            $validated_kategori = Kategori::whereId_kategori($query['k'])->orWhere('nama_kategori',$query['k'])->first();
            if($validated_kategori) {
                array_push($validated_query, 'k');
            }
        } 
        // search
        if(array_key_exists('q', $query)) {
            array_push($validated_query, 'q');
        }
        // time from
        if(array_key_exists('f', $query)) {
            array_push($validated_query, 'f');
        }
        // time to
        if(array_key_exists('to', $query) && $query['to'] != null) {
            array_push($validated_query, 'to');
        }

        return $validated_query;
    }
}

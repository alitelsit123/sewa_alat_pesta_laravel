<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;

class ProductController extends Controller
{
    public function showProductsPage() {
        $kategori = Kategori::latest()->get();

        $querys = request()->query();
        $validated_query = $this->filterValidator($querys);
        $produks = Produk::when(in_array('k', $validated_query), function($query) use ($querys) {
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
        // ->when(in_array('f', $validated_query), function($query) use ($querys) {
        //     // $query->where('tanggal_mulai', '>', $querys['f']);
        //     // $query->whereHas('', '>', $querys['f']);
        // })
        ->where('stok', '>', '0')
        ->latest()->paginate(15);

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
    public function showProductsItemPage(Request $request, $kategori, $slug, $id) {
        $produk = Produk::findOrFail($id);
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
        if(array_key_exists('to', $query)) {
            array_push($validated_query, 'to');
        }

        return $validated_query;
    }
}

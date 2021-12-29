<?php

namespace App\Http\Controllers\Public;

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
        ->when(in_array('t', $validated_query), function($query) use ($querys) {
            $query->where('id_kategori', $querys['k']);
        })
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
        if(array_key_exists('k', $query)) {
            $validated_kategori = Kategori::whereId_kategori($query['k'])->orWhere('nama_kategori',$query['k'])->first();
            if($validated_kategori) {
                array_push($validated_query, 'k');
            }
        }

        return $validated_query;
    }
}

<?php

namespace App\Http\Controllers\Publics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Sewa;
use App\Models\Pesanan;
use App\Models\Stat;
use App\Models\DetailPesanan;


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

            $stat = Stat::create([
                'type' => 'search',
                'data' => \json_encode([
                    'text' => $querys['q']
                ], true)
            ]);

            foreach($arr as $k => $v) {
                $query->orWhere('nama_produk', 'like', '%'.$v.'%');
            }
        })
        ->paginate(15)->withQueryString();

        $query_new = [];

        foreach($validated_query as $row) {
            $query_new[$row] = $querys[$row];
        }

        // return dd(Produk::withOrdered()->get()->where('id_produk', 11));

        // $new_ordered_kuantitas = DetailPesanan::selectRaw('id_produk,sum(kuantitas) as ordered_sum_kuantitas')->whereHas('order', function($query) {
        //     $query
        //     ->where('tanggal_mulai', '>', session('book')['from']);
        //     // ->where([['tanggal_mulai', '>', session('book')['from']], ['tanggal_mulai', '<', session('book')['to']]])
        //     // ->orWhere([['tanggal_selesai', '>', session('book')['from']], ['tanggal_selesai', '<', session('book')['to']]])
        //     // ->orWhere([['tanggal_mulai', '<', session('book')['from']], ['tanggal_selesai', '>', session('book')['to']]])
        //     // ->has('sewa');
        // })->groupBy('id_produk')->get();
        // $new_ordered_kuantitas = Pesanan::when((session()->has('book')),function($query) {
        //     $query->where([['tanggal_mulai', '>', session('book')['from']], ['tanggal_mulai', '<', session('book')['to']]])
        //     ->orWhere([['tanggal_selesai', '>', session('book')['from']], ['tanggal_selesai', '<', session('book')['to']]])
        //     ->orWhere([['tanggal_mulai', '<', session('book')['from']], ['tanggal_selesai', '>', session('book')['to']]])
        //     ->has('sewa');
        // });
            // ->where('tanggal_mulai', '>', session('book')['from']);

        // return dd(array_column($new_ordered_kuantitas, 'details'));
        // $filteredPesanan = $new_ordered_kuantitas;
        $data = [
            'produk_new' => $produks,
            'kategoris' => $kategori,
            'query_new' => $query_new,
            // 'filteredPesanan' => $filteredPesanan,
            // 'new_ordered_sum' => $new_ordered_kuantitas
        ];

        // return dd($new_ordered_kuantitas->where('id_produk', 20)->first());

        return view('public-pages.products', $data);
    }

    // set filter durasi tanggal
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

    // ini buat validasi url querynya
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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kategori;
use App\Models\Produk;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::latest()
        ->when(request()->has('s'), function($query) {
            $query->where('nama_produk', 'like', '%'.request('s').'%');
        })
        ->paginate(10);

        $data = [
            'produk' => $produk
        ];
        return view('admin-pages.produk', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();

        $data = [
            'kategori' => $kategori
        ];

        return view('admin-pages.produk.tambah-produk', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'nama_produk' => ['required'],
            'kategori' => ['required', 'numeric'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'gambar' => ['required','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'keterangan' => ['nullable'],
            'keterangan_pendek' => ['nullable', 'max:100'],
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $validator->validated();

        $produk = new Produk();

        $file = request()->file('gambar');
        $extension = $file->getClientOriginalExtension();
        $filename = 'mita_img_'.time().uniqid().'.'.$extension;
        
        if(!$file->storeAs('produk', $filename, 'upload')) {
            return redirect(route('admin.produk.index'))->with('notes', ['text' => 'An Error Occured!', 'type' => 'error']);
        }

        $produk->kode_produk = uniqid();
        $produk->nama_produk = $input['nama_produk'];
        $produk->id_kategori = $input['kategori'];
        $produk->keterangan = $input['keterangan'];
        $produk->keterangan_pendek = $input['keterangan_pendek'];
        $produk->gambar = $filename;
        $produk->harga = $input['harga'];
        $produk->stok = $input['stok'];
        $produk->save();

        return redirect(route('admin.produk.index'))->with('notes', ['text' => 'Tambah Produk Berhasil!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        $kategori = Kategori::all();

        $data = [
            'produk' => $produk,
            'kategori' => $kategori
        ];

        return view('admin-pages.produk.edit-produk', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = \Validator::make($request->all(), [
            'nama_produk' => ['required'],
            'harga' => ['required', 'numeric'],
            'stok' => ['required', 'numeric'],
            'gambar' => ['nullable','image','mimes:jpeg,png,jpg,gif,svg','max:2048'],
            'keterangan' => ['nullable'],
            'keterangan_pendek' => ['nullable', 'max:100'],
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $validator->validated();

        $produk = Produk::findOrFail($id);
        // $produk->timestamps = false;

        if(request()->hasFile('gambar')):
            $file = request()->file('gambar');
            $extension = $file->getClientOriginalExtension();
            $filename = 'mita_img_'.time().uniqid().'.'.$extension;
            
            if(!$file->storeAs('produk', $filename, 'upload')) {
                return redirect(route('admin.produk.index'))->with('notes', ['text' => 'An Error Occured!', 'type' => 'error']);
            }

            $produk->gambar = $filename;
        endif;

        $produk->kode_produk = uniqid();
        $produk->nama_produk = $input['nama_produk'];
        $produk->keterangan = $input['keterangan'];
        $produk->keterangan_pendek = $input['keterangan_pendek'];
        $produk->harga = $input['harga'];
        $produk->stok = $input['stok'];
        $produk->save();

        return redirect(route('admin.produk.index'))->with('notes', ['text' => 'Update Produk Berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $produk = Produk::find($id);
       
       if(!$produk) {
            return redirect(route('admin.produk.index'))->with('notes', ['text' => 'An Error Occured']);
       } 

       $produk->delete();
        return redirect(route('admin.produk.index'))->with('notes', ['text' => 'Hapus Produk Berhasil!']);
    }
}

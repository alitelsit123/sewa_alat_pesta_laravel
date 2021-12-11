<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Kategori::all();

        $data = [
            'categories' => $categories
        ];
        return view('admin-pages.kategori', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-pages.kategori.tambah-kategori');
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
            'nama_kategori' => ['required', 'unique:kategori,nama_kategori,NULL,id_kategori,deleted_at,NULL']
        ]);

        if($validator->fails()):
            return back()->withErrors($validator)->withInput();
        endif;

        $input = $validator->validated();

        $kategori = Kategori::create([
            'nama_kategori' => $input['nama_kategori']
        ]);

        return redirect(route('admin.kategori.index'))->with('notes', ['text' => 'Tambah kategori Berhasil!']);
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
        $kategori = Kategori::find($id);
        
        if(!$kategori) {
            return redirect(route('admin.kategori.index'))->with('notes', ['text' => 'An Error Occured!', 'type' => 'error']);
        }

        $data = ['kategori' => $kategori];

        return view('admin-pages.kategori.edit-kategori', $data);
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
            'nama_kategori' => ['required', 'unique:kategori,nama_kategori,'.$id.',id_kategori,deleted_at,NULL']
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $input = $validator->validated();

        $kategori = Kategori::find($id);
        $kategori->nama_kategori = $input['nama_kategori'];
        $kategori->save();

        return redirect(route('admin.kategori.index'))->with('notes', ['text' => 'Update kategori Berhasil!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if($kategori) {
            $kategori->delete();
        }
        return redirect(route('admin.kategori.index'))->with('notes', ['text' => 'Hapus kategori Berhasil!']);
    }
}

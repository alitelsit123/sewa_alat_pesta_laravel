@extends('layouts.app-admin')

@section('css_head')
<!-- summernote -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('script_body')
<!-- Summernote -->
<script src="{{ asset('/assets/plugins/summernote/summernote-bs4.min.js') }}"></script> 
<script>
    var inputFile = document.getElementById('inputFile')
    var inputFileLabel = document.getElementById('inputFileLabel')
    inputFile.addEventListener('change', function(e) {
        let imageObject = e.target.files[0]
        let output = document.getElementById('preview-gambar');
        output.src = URL.createObjectURL(imageObject);
        output.onload = function() {
            URL.revokeObjectURL(output.src)
        }
        inputFileLabel.innerHTML = imageObject.name
    })
    // Summernote
    $('.summernote').summernote({
        height: 200
    });
</script>
@endsection

@section('content-body')
<div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card">
              <div class="card-header">
                    <h5>Edit Produk</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body py-2">
                    <form action="{{ route('admin.produk.update', $produk->id_produk) }}" method="post" class="w-100" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group flex-grow-1">
                                    <label for="Nama">Nama Produk</label>
                                    <input type="text" name="nama_produk" value="{{ $produk->nama_produk }}" class="form-control" placeholder="Tambah produk" required>
                                </div>
                                @error('nama_produk')
                                <div class="validation-error">
                                    <div class="alert alert-danger" style="width: 100%;">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group flex-grow-1">
                                    <label for="Nama">Kategori Produk</label>
                                    <select name="kategori" id="pilih-kategori" class="form-control" required>
                                        <option value="0">-- Pilih Kategori --</option>
                                        @foreach($kategori as $row)
                                        <option value="{{$row->id_kategori}}">{{ $row->nama_kategori }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('kategori')
                                <div class="validation-error">
                                    <div class="alert alert-danger" style="width: 100%;">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group flex-grow-1">
                                    <label for="Harga">Harga</label>
                                    <input type="number" name="harga" value="{{ $produk->harga }}" class="form-control" placeholder="Harga" required>
                                </div>
                                @error('harga')
                                <div class="validation-error">
                                    <div class="alert alert-danger" style="width: 100%;">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group flex-grow-1">
                                    <label for="Stok">Stok</label>
                                    <input type="number" name="stok"  value="{{ $produk->stok }}" class="form-control" placeholder="Stok" required>
                                </div>
                                @error('status')
                                <div class="validation-error">
                                    <div class="alert alert-danger" style="width: 100%;">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group flex-grow-1">
                                    <label for="Keterangan">Keterangan Pendek</label>
                                    <input name="keterangan_pendek" rows="1" class="form-control" placeholder="Max 100 kata" value="{{ $produk->keterangan_pendek }}" />
                                </div>
                                @error('keterangan_pendek')
                                <div class="validation-error">
                                    <div class="alert alert-danger" style="width: 100%;">
                                        {{ $message }}
                                    </div>
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group flex-grow-1">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" rows="6" class="form-control summernote">
                                    {{ $produk->keterangan }}
                                    </textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="Gambar">Gambar</label>
                                    <div class="custom-file mb-3">
                                        <input type="file" name="gambar" class="custom-file-input" id="inputFile" accept="image/*">
                                        <label class="custom-file-label" for="customFile" id="inputFileLabel">Pilih Gambar</label>
                                    </div>
                                    <img src="{{ asset('assets/uploads/produk/'.$produk->gambar) }}" id="preview-gambar" alt="" srcset="" class="w-50" />
                                </div>
                            </div>
                        </div>

                        <div class="text-right w-100">
                            <a href="{{ route('admin.produk.index') }}" class="btn">Batal</a>
                            <button class="btn btn-primary" type="submit">Simpan</button>
                        </div>
                    </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div><!-- /.container-fluid -->
@endsection

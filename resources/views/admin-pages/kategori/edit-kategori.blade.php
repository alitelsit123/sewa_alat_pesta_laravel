@extends('layouts.app-admin')

@section('content-body')
<div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card">
              <div class="card-header">
                    <h5>Update Kategori</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body py-2">
                    <form action="{{ route('admin.kategori.update', $kategori->id_kategori) }}" method="post" class="w-100">
                        @csrf
                        @method('PUT')
                        <div class="form-group flex-grow-1">
                            <label for="Nama">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Cari Kategori" value="{{$kategori->nama_kategori}}" required>
                        </div>
                        @error('nama_kategori')
                        <div class="validation-error">
                            <div class="alert alert-danger" style="width: 100%;">
                                {{ $message }}
                            </div>
                        </div>
                        @enderror
                        <div class="text-right w-100">
                            <a href="{{ route('admin.kategori.index') }}" class="btn">Batal</a>
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

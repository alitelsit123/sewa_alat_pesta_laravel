@extends('layouts.app-admin')

@section('content-body')
<div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card">
              <div class="card-header">
                    <h5>Tambah Kategori</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-body py-2">
                    <form action="" class="w-100">
                        <div class="form-group flex-grow-1">
                            <label for="Nama">Nama Kategori</label>
                            <input type="text" class="form-control" placeholder="Cari Kategori">
                        </div>
                        <div class="text-right w-100">
                            <button class="btn btn-primary">Simpan</button>
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
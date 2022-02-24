@extends('layouts.app-admin')
@section('css_head')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('script_body')
<!-- Toastr -->
<script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
<script>
    @if (session('notes') && (!in_array('type', session('notes')) || session('notes')['type'] == 'success') )
    window.addEventListener('load', function() {
        toastr.success('{{ session("notes")["text"] ?? "success" }}');
    });
    @elseif (session('notes') && (session('notes')['type'] == 'error'))
    window.addEventListener('load', function() {
        toastr.error('{{ session("notes")["text"] ?? "success" }}');
    });
    @else

    @endif
    var selected_data_id = -1;
    function hapusData() {
      $('#confirm-box').modal('hide');
      $('#form-delete').attr('action', "{{ url('/admin/produk') }}/"+selected_data_id);
      $('#form-delete').submit();
      selected_data_id = -1;
    }
    function openModal(key) {
      selected_data_id = key
      $('#confirm-box').modal();
    }
    $(document).ready(function() {
            
    });

</script>

<!-- <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                  Launch Default Modal
                </button> -->
@endsection
@section('content-body')
<div class="container-fluid">
    <!-- Main row -->
    <div class="row">
        <div class="col-md-12">
        <div class="card" style="min-height: 500px;">
              <div class="card-header">
                    <h5>Produk</h5>
                    
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                    <form action="{{ route('admin.produk.index') }}" class="form-inline w-100">
                      <div class="form-group flex-grow-1">
                          <input type="text" name="s" value="{{ request('s') }}" class="form-control" placeholder="Cari Produk">
                          <a href="{{ route('admin.produk.index') }}" class="btn btn-warning">Reset</a>
                      </div>
                    <!-- <a disabled class="btn btn-primary" href="{{ route('admin.kategori.create') }}">Tambah Kategori</a> -->
                        <a class="btn btn-primary" href="{{ route('admin.produk.create') }}">Tambah Produk</a>
                    </form>    
              </div>
              <div class="card-body p-0">
                
                <table class="table">
                  <thead>
                    <tr>
                      <th style="width: 15%">Kode</th>
                      <th>Nama</th>
                      <th class="text-center">Keterangan Pendek</th>
                      <th style="width: 10%" class="text-center">Stok</th>
                      <th style="width: 10%" class="text-center">Harga</th>
                      <th style="width: 20%" class="text-center">#</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($produk as $row)  
                    <tr>
                      <td>{{ $row->kode_produk }}</td>
                      <td>{{ $row->nama_produk }}</td>
                      <td class="text-center">{{ $row->keterangan_pendek }}</td>
                      <td class="text-center">{{ $row->stok }}</td>
                      <td class="text-center">{{ $row->harga }}</td>
                      <td class="text-center">
                          <a href="{{ route('admin.produk.edit', $row->id_produk) }}" class="btn btn-sm btn-warning">Edit</a>
                          <button class="btn btn-sm btn-danger" onclick="openModal({{ $row->id_produk }})" >Hapus</button>
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="6">Tidak Ada produk!!!</td>
                    </tr>
                    @endforelse
                    <tr>
                      <td colspan="6">
                          {{ $produk->links('vendor.pagination.bootstrap-4') }}
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div><!-- /.container-fluid -->

<form action="" method="post" id="form-delete" class="d-none">
  @csrf
  <input type="hidden" name="_method" value="DELETE" />
</form>

<div class="modal fade" id="confirm-box">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- <div class="modal-header">
        <h4 class="modal-title">Default Modal</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> -->
      <div class="modal-body">
        <p>Yakin ingin menghapus ?</p>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="hapusData()">Hapus</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
@endsection
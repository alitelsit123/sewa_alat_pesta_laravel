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
                <h3 class="card-title">Pengguna</h3>

                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>Email</th>
                      <th>Status</th>
                      <th>Online</th>
                      <th style="width: 20%;">#</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($users as $row)
                    <tr>
                      <td>{{ $row->email }}</td>
                      <td>{{ $row->email_verified_at ? 'Terverifikasi': 'Belum Diverifikasi' }}</td>
                      <td>{{ $row->online ? 'Ya': 'Tidak' }}</td>
                      <td>
                          <!-- <a href="#" class="btn btn-sm btn-info">Pesan</a> -->
                          <a href="{{ route('admin.user.show', $row->id_user) }}" class="btn btn-sm btn-default">Lihat</a>
                          @if(!$row->isAdmin())
                          <a href="{{ route('admin.user.set.role.admin', $row->id_user) }}" class="btn btn-sm btn-info">set as ADMIN</a>
                          @endif
                      </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3">Tidak Ada Data</td>
                    </tr>                    
                    @endforelse
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
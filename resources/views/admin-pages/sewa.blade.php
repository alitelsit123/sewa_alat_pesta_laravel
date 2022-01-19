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
      $('#form-delete').attr('action', "{{ url('/admin/kategori') }}/"+selected_data_id);
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
                    <h5>Sewa</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                    <form action="" class="form-inline w-100">
                    <div class="form-group flex-grow-1">
                        <input type="text" class="form-control" placeholder="Cari Transaksi" disabled>
                    </div>
                </form>    
              </div>
              <div class="card-body p-0">
                <div class="callout callout-info">
                    <h5><i class="fas fa-info"></i> Note:</h5>
                    Dengan klik selesai, semua status transaksi mulai pembayaran sampai pengiriman dll. diselesaikan!
                </div>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Waktu Sewa</th>
                      <th>Dikirim</th>
                      <th>Dikembalikan</th>
                      <!-- <th>Pembayaran</th> -->
                      <th>Status</th>
                      <th style="width: 20%" class="text-center">#</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($sewa as $row)  
                    <tr>
                      <td>{{ $row->user()->profile->nama }}</td>
                      <td>{{ $row->order->tanggal_mulai.' - '.$row->order->tanggal_selesai }}</td>
                      <td>{{ $row->waktu_pengiriman ?? '-' }}</td>
                      <td>{{ $row->waktu_pengembalian ?? '-' }}</td>
                      <!-- <td>{{ $row->order->fullPayment()->status == 1 ? 'Belum Lunas': 'Lunas' }}</td> -->
                      <td>{{ $row->getStatusText() }}</td>
                      <td class="text-center">
                          @if($row->status == 4)
                          -
                          @else
                          <a href="{{ route('admin.sewa.complete', $row->id_sewa) }}" class="btn btn-sm btn-success">Selesai</a>
                          @endif
                          <!-- <button class="btn btn-sm btn-danger" onclick="openModal({{ $row->id_kategori }})" >Hapus</button> -->
                      </td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="2">Tidak Ada Transaksi!!!</td>
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

<!-- <form action="" method="post" id="form-delete" class="d-none">
  @csrf
  <input type="hidden" name="_method" value="DELETE" />
</form> -->

<!-- <div class="modal fade" id="confirm-box">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <p>Yakin ingin menghapus ?</p>
      </div>
      <div class="modal-footer justify-content-end">
        <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="hapusData()">Hapus</button>
      </div>
    </div>
  </div>
</div> -->
@endsection
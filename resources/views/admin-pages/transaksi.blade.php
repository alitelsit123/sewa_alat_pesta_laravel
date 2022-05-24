@extends('layouts.app-admin')
@section('css_head')
<!-- Toastr -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/toastr/toastr.min.css') }}">
@endsection

@section('script_body')
<!-- Toastr -->
<script src="{{ asset('/assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
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
    $("#print-button").click(function() {
        let table = document.getElementsByTagName("table");
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0');
        var yyyy = today.getFullYear();
        today = mm + '-' + dd + '-' + yyyy;

        TableToExcel.convert(table[0], {
           name: today+` transaksi.xlsx`,
           sheet: {
              name: 'Sheet 1'
           }
        });
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
                    <h5>Transaksi</h5>
              </div>
              <!-- /.card-header -->
              <div class="card-header">
                  <form action="{{ route('admin.transaksi.index') }}" class="form-inline w-100">
                    <div class="form-group flex-grow-1">
                        <input type="text" name="s" value="{{ request('s') }}" class="form-control mr-2" placeholder="Cari Kode Pembayaran">
                        <a class="btn btn-warning" href="{{ route('admin.transaksi.index') }}">Reset</a>
                    </div>
                    <!-- <a class="btn btn-primary" href="#" id="print-button">Export</a> -->

                </form>
              </div>
              <div class="card-body p-0">
                <table class="table" id="table_data">
                  <thead>
                    <tr>
                      <th>User</th>
                      <th>Order</th>
                      <th>Tipe</th>
                      <th>Bayar dengan</th>
                      <th>Jumlah</th>
                      <th class="text-center">#</th>
                    </tr>
                  </thead>
                  <tbody>
                      @forelse($trans as $row)
                      <tr>
                          @if($row->order && $row->order->user && $row->order->user->profile)
                          <td>{{ \ucwords($row->order->user->profile->nama) }}</td>
                          @else
                          <td></td>
                          @endif
                          <td><a href="{{ route('admin.order.show', $row->order->kode_pesanan) }}">{{ $row->order->kode_pesanan }}</a></td>
                          <td>{{ $row->getTipe() }}</td>
                          <td>{{ $row->jenis_pembayaran }}</td>
                          <td>Rp. {{ $row->total_bayar }}</td>
                      </tr>
                      @empty
                      <td>Tidak ada Transaksi</td>
                      @endforelse
                      <tr>
                        <td colspan="6">
                            {{ $trans->links('vendor.pagination.bootstrap-4') }}
                        </td>
                      </tr>
                      @if(!request()->f && request()->f != 'new')
                      <tr>
                        <td colspan="2"><strong>Total Kedaluarsa, Batal</strong></td>
                        <td colspan="4">Rp. {{ \number_format($saldo_cancel) }}</td>
                      </tr>
                      <tr>
                        <td colspan="2"><strong>Total Pending</strong></td>
                        <td colspan="4">Rp. {{ \number_format($saldo_pending) }}</td>
                      </tr>
                      <tr>
                        <td colspan="2"><strong>Total Saldo Masuk</strong></td>
                        <td colspan="4">Rp. {{ \number_format($saldo_in) }}</td>
                      </tr>
                      {{--
                      <tr>
                        <td colspan="2"><strong>Total Semua Transaksi</strong></td>
                        <td colspan="4">Rp. {{ \number_format($saldo_all) }}</td>
                      </tr>
                      --}}
                      @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div><!-- /.container-fluid -->
<iframe id="txtArea1" style="display:none"></iframe>
@endsection

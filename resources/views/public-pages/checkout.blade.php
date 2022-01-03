@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/datatables.net-dt/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/datatables.net-responsive-dt/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-dt/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables.net-responsive-dt/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>

<script>
    $(function(){
    'use strict'

    $('#order-listing').DataTable({
    "aLengthMenu": [
    [5, 10, 15, -1],
    [5, 10, 15, "All"]
    ],
    "iDisplayLength": 10,
    "language": {
    search: ""
    },
    "bInfo": false,
    "bLengthChange": false,
    "bFilter": false,
    "bPaginate": false,
});
$('#order-listing').each(function() {
    var datatable = $(this);
    // SEARCH - Add the placeholder for Search and Turn this into in-line form control
    var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
    search_input.attr('placeholder', 'Search');
    search_input.removeClass('form-control-sm');
    // LENGTH - Inline-Form control
    var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
    length_sel.removeClass('form-control-sm');
});

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });

    });
</script>
<script>
  setTimeout(function(){
    // document.location.href="{{ route('order.proses.payment') }}";
  }, 2000);
</script>
@endsection

@section('content-body')
@if(session()->has('msg_success'))
<div class="alert alert-success" role="alert">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>Berhasil!</strong> {{ session('msg_success') }}
    </div>
</div><!-- alert -->
@endif
@if(session()->has('msg_error'))
<div class="alert alert-danger" role="alert">
    <div class="container">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>!</strong> {{ session('msg_error') }}
    </div>
</div><!-- alert -->
@endif
<form action="{{ route('order.proses.init_payment') }}" method="post">
@csrf
<div class="mt-5 mb-5" style="min-height:600px;">
    <div class="container d-flex">
        <div class="flex-grow-1">
            <h6 class="tx-inverse tx-semibold mg-b-30 mg-t-8 tx-24">Checkout</h6>
            <div class="mg-b-20 alert alert-info">
                <strong>Catatan: </strong> 
                <br />
                - Pastikan data sesuai sebelum ke menu pembayaran
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @error('tanggal_mulai')
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>!</strong> {{ tanggal_mulai }}
                </div>
            </div><!-- alert -->
            @enderror
            @error('tanggal_selesai')
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>!</strong> {{ $message }}
                </div>
            </div><!-- alert -->
            @enderror
            @error('tanggal_mulai')
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>!</strong> {{ $message }}
                </div>
            </div><!-- alert -->
            @enderror
            @error('tipe_pembayaran')
            <div class="alert alert-danger" role="alert">
                <div class="container">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>!</strong> {{ $message }}
                </div>
            </div><!-- alert -->
            @enderror
            <div class="d-flex w-100 justify-content-between align-items-center pd-b-10 mg-b-10 bd-b bd-gray-200">
                <h6 class="tx-inverse tx-medium mg-t-8 tx-16">Pilih Durasi</h6>
                <div class="d-flex align-items-center">
                    <input type="date" name="tanggal_mulai" class="form-control" placeholder="" value="" required>
                    <span class="px-2">Sampai</span>
                    <input type="date" name="tanggal_selesai" class="form-control" placeholder="" value="" class="mg-l-10" required>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center pd-b-10 mg-b-10 bd-b bd-gray-200">
                <h6 class="tx-inverse tx-medium mg-t-8 tx-16">Pilih Tipe Pembayaran</h6>
                <div class="d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="flexRadioDefault1" value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            DP
                        </label>
                    </div>
                    <div class="form-check mg-l-10">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="flexRadioDefault2" checked value="2">
                        <label class="form-check-label" for="flexRadioDefault2">
                            FULL
                        </label>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center pd-b-10 mg-b-10">
                <div class="table-responsive w-100">
                    <table class="table mg-b-0">
                        <thead>
                            <tr>
                                <th style="width: 130px;">Kode Barang</th>
                                <th>Produk</th>
                                <th style="width: 100px;">Kuantitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($keranjangs as $row)
                            <tr>
                                <th scope="row">{{ $row['kode_produk'] }}</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('/assets/uploads/produk/'.$row['gambar']) }}" alt="Produk Image" srcset="" class="img-fluid">
                                        <div>{{ $row['nama_produk'] }}</div>
                                    </div>
                                </td>
                                <td>x{{ $row['pivot']['kuantitas'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
            </div>


        
        </div>
      <div class="pd-l-10" style="width: 300px;">
        <ul class="list-group w-100">
          <li class="list-group-item d-flex align-items-center">
              <div class="w-100">
                  @auth
                  <div class="d-flex justify-content-between align-items-center w-100 mg-b-10">
                      <h6 class="tx-inverse tx-semibold mg-b-10 mg-t-8">Alamat Pengiriman</h6>
                      <a href="{{ url('/profile/'.auth()->user()->email) }}?o=setting" class="btn icon p-0">
                          <i class="typcn icon typcn-pencil"></i> Edit
                      </a>
                  </div>
                  @endauth
                  <div>
                      @if(auth()->user()->profile->alamat && auth()->user()->profile->nama && auth()->user()->profile->telepon)
                      <p class="tx-medium tx-15 m-0" id="alamat-nama">{{ auth()->user()->profile->nama }}</p>
                      <p class="tx-13">{{ auth()->user()->profile->telepon }}</p>
                      <p>
                          
                          {{ auth()->user()->profile->alamat }}
                      </p>
                      @else
                      <div class="alert alert-danger">
                          <strong>Mohon <a href="{{ url('/profile/'.auth()->user()->email) }}?o=setting">lengkapi biodata</a> anda!</strong> Dibutuhkan nama, telepon dan alamat.
                      </div>
                      @endif
                  </div>
              </div>
          </li>
        </ul>
        <ul class="list-group">
            <li class="list-group-item d-flex align-items-center">
                <div class="w-100">
                    <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Ringkasan Produk</h6>
                    @foreach($keranjangs as $row)
                    <div class="d-flex justify-content-between w-100 mg-b-10">
                        <div class="d-block tx-15">{{ $row['nama_produk'] }} ({{ $row['pivot']['kuantitas'] }})</div>
                        <div class="d-block tx-15">
                            Rp <span>{{ number_format($row['total']) }}</span>
                        </div>
                    </div>
                    @endforeach
                    <!-- <div class="d-flex justify-content-between w-100 mg-b-10">
                        <div class="d-block tx-15">Total Harga({{ $stat['total_kuantitas'] }})</div>
                        <div class="d-block tx-15">
                            Rp <span>{{ number_format($stat['total_harga']) }}</span>
                        </div>
                    </div> -->
                </div>
            </li>
            <li class="list-group-item d-flex flex-column">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Total</h6>
                    <span class="tx-semibold">Rp. {{ number_format($stat['total_harga']) }}</span>
                </div>
                @auth
                <button class="btn btn-indigo btn-block w-100" id="btn_submit" type="submit">Pembayaran</button>
                @endauth
                @guest
                <div class="w-100 d-flex justify-content-center align-items-center">
                    <p class="tx-medium tx-indigo tx-18 mg-t-10"><a href="{{ url('/auth/login') }}">Masuk</a> Untuk Order</p>
                </div>
                @endguest
            </li>
        </ul>
      </div>  

      <!-- <div class="d-flex justify-content-center align-items-center flex-column">
        <h3>Tunggu sebentar. Sedang memproses pembayaran pihak ketiga.</h3>
        <div class="spinner-border" role="status">
          <span class="sr-only">Loading...</span>
        </div>
      </div> -->

    </div>
</div>
</form>

@endsection

        
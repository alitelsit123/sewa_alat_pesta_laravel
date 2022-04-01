@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>

<script>
    function changeDuration() {
        $.post("{{ route('order.book.duration.change') }}", {
            _token: '{{ csrf_token() }}',
            from: $('input[name="tanggal_mulai"]').val(),
            to: $('input[name="tanggal_selesai"]').val(),
        }, function(data, status) {
            console.log(data);
        }).done(function() {
            document.location.href="{{ route('order.proses.checkout.view') }}";
        });
    }
    $('input[name="tanggal_mulai"]').change(function(e) {
        var tanggal_selesai = $('input[name="tanggal_selesai"]').val();
        if(tanggal_selesai.length > 0) { 
           changeDuration(); 
        }
    });
    $('input[name="tanggal_selesai"]').change(function(e) {
        var tanggal_mulai = $('input[name="tanggal_mulai"]').val();
        if(tanggal_mulai.length > 0) { 
           changeDuration(); 
        }
    });
    // Create our number formatter.
    var formatter = new Intl.NumberFormat('en-US');
    $('#payment-type-1').click(function() {
        $.get('{{ route('order.payment.type.change', 1) }}', function(data) {
            $('#final-price').html(''+
                '<div class="d-flex justify-content-between align-items-center w-100">'+
                    '<span class="tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">DP</span>'+
                    '<span class="tx-semibold">Rp. '+formatter.format(data.dp)+'</span>'+
                '</div>'+
                '<div class="d-flex justify-content-between align-items-center w-100">'+
                    '<span class="tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">Pelunasan</span>'+
                    '<span class="tx-semibold">Rp. '+formatter.format(data.other)+'</span>'+
                '</div>'+
            '');
        });
    });
    $('#payment-type-2').click(function() {
        $.get('{{ route('order.payment.type.change', 2) }}', function(data) {
            $('#final-price').html(''+
                '<div class="d-flex justify-content-between align-items-center w-100">'+
                    '<span class="tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">Bayar FULL</span>'+
                    '<span class="tx-semibold">Rp. '+formatter.format(data.other)+'</span>'+
                '</div>'+
            '');
        });
    });
</script>
<script>
  setTimeout(function(){
    // document.location.href="{{ route('order.proses.payment') }}";
  }, 2000);
</script>
@endsection

@section('content-body')
<form action="{{ route('order.proses.init_payment') }}" method="post">
@csrf
<div class="mt-5 mb-5" style="min-height:600px;">
    <div class="container d-flex">
        <div class="flex-grow-1 pd-x-20 bd">
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
                <h6 class="tx-inverse tx-medium mg-t-8 tx-16">Funding fee (per 2 hari)</h6>
                <div class="d-flex align-items-center">
                    <div class="tx-medium">
                        <span>30%</span>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center pd-b-10 mg-b-10 bd-b bd-gray-200">
                <h6 class="tx-inverse tx-medium mg-t-8 tx-16">Durasi</h6>
                <div class="d-flex align-items-center">
                    @if(session()->has('book'))
                    <div class="tx-medium tx-gray-500">
                        <span>Dari {{ session('book.from') }}</span>
                    </div>
                    <span class="mg-x-20">|</span>
                    <div class="tx-medium tx-gray-500">
                        <span>Sampai {{ session('book.to') }}</span>
                    </div>
                    <input type="hidden" name="tanggal_mulai" class="form-control" placeholder="" value="{{ session('book.from') }}" required>
                    <input type="hidden" name="tanggal_selesai" class="form-control" placeholder="" value="{{ session('book.to') }}" class="mg-l-10" required>
                    @else
                    <input type="date" name="tanggal_mulai" class="form-control" placeholder="" value="" required>
                    <span class="px-2">Sampai</span>
                    <input type="date" name="tanggal_selesai" class="form-control" placeholder="" value="" class="mg-l-10" required>
                    @endif
                </div>
            </div>
            <div class="d-flex w-100 justify-content-between align-items-center pd-b-10 mg-b-10 bd-b bd-gray-200">
                <h6 class="tx-inverse tx-medium mg-t-8 tx-16">Pilih Tipe Pembayaran</h6>
                <div class="d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="payment-type-1" value="1">
                        <label class="form-check-label" for="flexRadioDefault1">
                            DP
                        </label>
                    </div>
                    <div class="form-check mg-l-10">
                        <input class="form-check-input" type="radio" name="tipe_pembayaran" id="payment-type-2" checked value="2">
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
                                    <div class="d-flex align-items-start">
                                        <img src="{{ asset('/assets/uploads/produk/'.$row['gambar']) }}" 
                                        alt="Produk Image" srcset="" 
                                        class="img-fluid rounded-10 mg-r-10" 
                                        style="width: 100px;">
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
                      <h6 class="tx-inverse tx-semibold mg-t-8">Billing</h6>
                      <!-- <a href="{{ url('/profile/'.auth()->user()->profile->id_profile) }}?o=setting" class="btn icon p-0">
                          <i class="typcn icon typcn-pencil"></i> Edit
                      </a> -->
                  </div>
                  @endauth
                  <div>                    
                      <p class="tx-medium tx-15 m-0" id="alamat-nama">{{ auth()->user()->profile->nama }}</p>
                      <p class="tx-13">{{ auth()->user()->profile->telepon }}</p>
                      @if(auth()->user()->profile->addresses()->count() > 0 && auth()->user()->profile->nama && auth()->user()->profile->telepon)
                      <h6 class="tx-inverse tx-semibold mg-t-8">Alamat Pengiriman</h6>
                      @forelse(auth()->user()->profile->addresses as $row)
                      <div class="d-flex align-items-center">
                          <input type="radio" name="address" value="{{ $row->id_address }}" class="mg-r-5" @if(auth()->user()->profile->addresses->first()->id_address == $row->id_address) checked="checked" @endif> {{ $row->alamat }}
                         <!-- @if(!$row->lat || !$row->lng)
                          (Lokasi map belum diset)
                          @endif -->
                      </div>
                      @empty

                      @endforelse
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
                <div id="sub-price" class="w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span class="tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">Sub Total</span>
                        <span class="tx-semibold">Rp. {{ number_format($stat['total_harga']) }}</span>
                    </div>
                </div>
                <div id="funding-fee" class="w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <a href="#modal-help-funding-fee" data-toggle="modal" style="text-decoration: underline;" class="tx-indigo tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">Funding fee</a>
                        <span class="tx-semibold">Rp. {{ number_format($stat['funding_fee']) }}</span>
                    </div>
                </div>
                <div class="d-flex justify-content-between align-items-center w-100">
                    <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Total</h6>
                    <span class="tx-semibold">Rp. {{ number_format($stat['total_harga'] + $stat['funding_fee']) }}</span>
                </div>
            </li>
            <li class="list-group-item d-flex flex-column">
                <h6 class="tx-18 tx-inverse tx-semibold mg-b-10 mg-t-8">Pembayaran</h6>
                <div id="final-price" class="w-100">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span class="tx-14 tx-inverse tx-semibold mg-b-10 mg-t-8">Bayar FULL</span>
                        <span class="tx-semibold">Rp. {{ number_format($stat['total_bayar']) }}</span>
                    </div>
                </div>
                @auth
                <button class="btn btn-indigo btn-block w-100" @if(session()->has('book')) type="submit" id="btn_submit" @else type="button" disabled="true" @endif>Pembayaran</button>
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

        
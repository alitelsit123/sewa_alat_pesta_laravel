@extends('layouts.app-admin')

@section('script_body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>

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
</script>


@section('content-body')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
   integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
<script type="text/javascript">
$(document).ready(function() {
    var default_lat = -7.993957436359008;
    var default_lng = 112.6318359375;
    if($('#map').data('lat') != '' && $('#map').data('lng') != '') {
        default_lat = $('#map').data('lat');
        default_lng = $('#map').data('lng');
    }
    var map = L.map(document.getElementById('map')).setView([default_lat, default_lng], 6);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWl0YXBlc3RhMTIzIiwiYSI6ImNsMTU1M2VnbjBkMmozanRleW02eHplODMifQ.5TxVEfhUO75qwJ6YSW-0Ug', {
      attribution: 'Mita',
      maxZoom: 18,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoibWl0YXBlc3RhMTIzIiwiYSI6ImNsMTU1M2VnbjBkMmozanRleW02eHplODMifQ.5TxVEfhUO75qwJ6YSW-0Ug'
    }).addTo(map);
    @if($order->address && $order->address->lat && $order->address->lng)    
        var marker = L.marker([default_lat, default_lng]).addTo(map);
    @endif
});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
        <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
        </div>


        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12 d-flex justify-content-between">
                    <h6>
                        <strong>Pesanan #{{ $order->kode_pesanan }}</strong><br/>
                    </h6>
                    <small class="">Date: {{ $order->created_at }}</small>                    
                </div>
                <!-- /.col -->
            </div>
            <!-- /.col -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center w-100">
                    <span class="font-weight-bold">User Detail</span>
                </div>
                <div class="col-6">
                    Nama: {{ $order->user->profile->nama }}<br/> 
                    <!-- <span class="badge badge-info">
                        
                    </span> -->
                    Email: {{ $order->user->email }}<br/>
                    NIK: {{ $order->user->profile->nik }}<br/>  
                    Telepon: {{ $order->user->profile->telepon }}<br/>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center w-100">
                    <span class="font-weight-bold">Pengiriman</span>
                    @if($order->status > 1)
                        @if($order->sewa)
                            @if($order->sewa->status == 1)
                            <a href="{{ route('admin.order.shipment', [$order->kode_pesanan, 2]) }}" class="btn btn-success btn-sm ml-2">
                                <i class="fas fa-truck"></i> Mulai Kirim
                            </a>
                            @endif
                            @if($order->sewa->status == 2)
                            <a href="{{ route('admin.order.shipment', [$order->kode_pesanan, 3]) }}" class="btn btn-success btn-sm ml-2">
                                <i class="fas fa-check"></i> Sampai Tujuan
                            </a>
                            @endif
                        @else
                            <a href="#" class="btn btn-secondary disabled btn-sm ml-2">
                                Pengiriman Tidak Tersedia
                            </a>
                        @endif
                    @endif
                </div>
                <div class="col-6">
                    Status: 
                    <span class="badge badge-info">
                        @if($order->status > 1 && $order->sewa) 
                            {{ $order->sewa->getShipmentStatusText() }} 
                        @else 
                            Belum Dikirim
                        @endif
                    </span>
                </div>
                <div class="col-6">
                    Alamat Pengiriman
                    <div>
                        <strong>{{ $order->user->profile->nama }}.</strong><br>
                        {{ $order->user->profile->telepon }}<br>
                        {{ $order->address ? $order->address->alamat: '' }} <br>
                        {{--
                        @if($order->address && !$order->address->lat && !$order->address->lng)
                        <strong>User Tidak menggunakan Lokasi Map</strong>
                        @endif
                        --}}
                    </div>
                </div>

                <div class="col-12 mt-3" style="position: relative;">
                    @if($order->address)
                    <div id="map" class="map" data-id="{{ $order->address->id_address }}" data-lat="{{ $order->address->lat }}" data-lng="{{ $order->address->lng }}" style="width: 100%;height: 305px;"></div>
                        @if(!$order->address->lat && !$order->address->lng)
                        <div class="map_warn d-flex justify-content-center align-items-center" style="background: black;height: 305px;z-index: 99999;position: absolute;top: 0;left: 0;width: 100%;opacity: .4;">
                            <div class="font-weight-bold" style="font-size: 36px;color: yellow;">USER TIDAK MENGGUNAKAN MAP</div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            <!-- info row -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center w-100">
                    <span class="font-weight-bold">Pembayaran</span>
                    @if($order->dpPayment()->status == 1 && $order->dpPayment()->total_bayar > 0)
                    <a href="{{ route('admin.order.confirm.payment', [$order->kode_pesanan, 2, 'dp']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-truck-loading"></i> Konfirmasi DP Manual
                    </a>
                    @elseif($order->fullPayment()->status == 1)
                    <a href="{{ route('admin.order.confirm.payment', [$order->kode_pesanan, 3, 'full']) }}" class="btn btn-success btn-sm">
                        <i class="fas fa-truck-loading"></i> Konfirmasi Pelunasan Manual
                    </a>
                    @else 
                    
                    @endif
                </div>
                <!-- /.col -->
                <div class="col-12">
                    <b>Pilihan Pembayaran User (DP / FULL):</b> {{ $order->selectedPayment() }}<br>
                </div>
                @if($order->dpPayment()->total_bayar > 0)
                <div class="col-6">
                    DP <br/>
                    <span>Payment Code:</span> {{ $order->dpPayment()->kode_pembayaran }}
                    <span>Payment Amount:</span> {{ $order->dpPayment()->total_bayar }}<br>
                    <span>Payment Due:</span> 2/22/2014<br>
                    <span>Status:</span> <strong>{{ $order->dpPayment()->getStatusText() }}</strong><br>
                </div>
                @endif
                <div class="col-6">
                    Pelunasan <br/>
                    <span>Payment Code:</span> {{ $order->fullPayment()->kode_pembayaran }}
                    <span>Payment Amount:</span> {{ $order->fullPayment()->total_bayar }}<br>
                    <span>Payment Due:</span> 2/22/2014<br>
                    <span>Status:</span> <strong>{{ $order->fullPayment()->getStatusText() }}</strong><br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->details as $row)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <img class="img-fluid mr-1" src="{{ asset('/assets/uploads/produk/'.$row->produk->gambar) }}" alt="prduct image" class="img-fluid" style="width: 80px; height: 80px;" >
                                        <div>{{ $row->produk->nama_produk }}</div>
                                    </div>
                                </td>
                                <td>{{ $row->kuantitas }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
            </div>
            <!-- /.row -->

        </div>
        <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.container-fluid -->
@endsection
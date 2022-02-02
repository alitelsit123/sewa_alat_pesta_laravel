@extends('layouts.app-admin')

@section('content-body')
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
                    Telepon: {{ $order->user->profile->telepon }}<br/>  
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center w-100">
                    <span class="font-weight-bold">Pengiriman</span>
                    @if($order->status > 1)
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
                    @endif
                </div>
                <div class="col-6">
                    Status: 
                    <span class="badge badge-info">
                        @if($order->status > 1) 
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
                        {{ $order->user->profile->alamat }}
                    </div>
                </div>
            </div>
            <!-- info row -->
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-between align-items-center w-100">
                    <span class="font-weight-bold">Pembayaran</span>
                    @if($order->dpPayment()->status == 1)
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-truck-loading"></i> Konfirmasi DP Manual
                    </button>
                    @elseif($order->fullPayment()->status == 1)
                    <button type="button" class="btn btn-success btn-sm">
                        <i class="fas fa-truck-loading"></i> Konfirmasi Pelunasan Manual
                    </button>
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
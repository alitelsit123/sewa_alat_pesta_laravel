@extends('layouts.app')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet"/>
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet"/>

<!-- azia CSS -->
<link href="{{ asset('/assets/dist-base/css/azia.css') }}" rel="stylesheet"/>
@endsection

@section('js_body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/ionicons/ionicons.js') }}"></script>
<script src="{{ asset('/assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

<!-- <script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script> -->
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
<div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
  <div class="container">
    <div class="az-content-left az-content-left-components">
      <div class="component-item mg-b-10"> 
        <span class="tx-20 tx-medium">Filter</span>
      </div><!-- component-item -->
      <div class="component-item py-2"> 
        <label class="pd-b-10">Waktu</label>
        <div class="pd-r-5">
          <input type="date" name="" id="" class="form-control rounded-10" value="12/17/2022">
        </div>
      </div><!-- component-item -->
      <div class="component-item py-2"> 
        <label class="pd-b-10">Kategori</label>
        <nav class="nav flex-column">
          @foreach($kategoris as $row)
          <a href="{{ '?k='.$row->id_kategori }}" class="nav-link text-capitalize @if(request()->query('k') == $row->id_kategori) active @endif">{{ strtolower($row->nama_kategori) }}</a>
          @endforeach
        </nav>
      </div><!-- component-item -->

    </div><!-- az-content-left -->
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
      <!-- <div class="az-content-breadcrumb">
        <span>Utilities</span>
        <span>Display</span>
      </div> -->
      <div class="row mg-b-20">
        <div class="col-md-12 d-flex align-items-center mg-b-20">
          <div class="tx-13 tx-medium tx-gray-500">({{ $produk_new->total() }}) Produk Ditemukan</div>
        </div>
        @foreach($produk_new as $row)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item mb-2 ">
          <div class="card">
            <div class="card-body">
              <div class="product-img-outer">
                <img class="product_image" src="{{ asset('/uploads/produk/'.$row->gambar) }}" alt="prduct image">
              </div>
              <a href="{{ route('product-view', ['kategori' => $row->kategori->nama_kategori,'slug' => $row->nama_produk, 'id' => $row->id_produk]) }}" class="btn pd-0"><p class="product-title tx-18">{{ $row->nama_produk }}</p></a>
              <p class="product-price tx-bold">Rp. {{ number_format($row->harga) }}</p>
              <!-- <p class="product-actual-price">$99.00</p> -->
              <!-- <ul class="product-variation">
                <li><a href="#">S</a></li>
                <li><a href="#">M</a></li>
              </ul> -->
              <p class="product-description">{{ $row->keterangan }}</p>
              
            </div>
            <div class="card-footer">
              <form action="{{ route('add-to-cart') }}" method="post">
                @csrf
                <div class="d-flex justify-content-end">
                  <input type="hidden" name="produk_id" value="{{ $row->id_produk }}" />
                  <input type="hidden" name="kuantitas" class="form-control rounded-pill text-center wd-100" value="1" />
                  <button class="btn btn-icon tx-medium disabled"><i class="typcn icon typcn-heart-outline"></i></button>
                  <button class="btn btn-icon tx-medium btn-rounded">
                    <i class="typcn typcn-shopping-cart"></i>
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        @endforeach
      </div>
      <div class="d-flex justify-content-end">
        {{ $produk_new->appends($query_new)->links('vendor.pagination.default') }}
      </div>
    </div><!-- az-content-body -->
  </div><!-- container -->
</div><!-- az-content -->
@endsection
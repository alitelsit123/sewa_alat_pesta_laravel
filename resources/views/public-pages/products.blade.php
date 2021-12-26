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
<div class="az-content pd-y-20 pd-lg-y-30 pd-xl-y-40">
  <div class="container">
    <div class="az-content-left az-content-left-components">
      <div class="component-item mg-b-10"> 
        <span class="tx-20 tx-medium">Filter</span>
      </div><!-- component-item -->
      <div class="component-item mg-b-10"> 
        <label>Waktu</label>
        <div class="pd-r-5">
          <input type="date" name="" id="" class="form-control rounded-10" value="12/17/2022">
        </div>
      </div><!-- component-item -->
      <div class="component-item"> 
        <label>Kategori</label>
        <nav class="nav flex-column">
          <a href="util-background.html" class="nav-link">Background</a>
          <a href="util-border.html" class="nav-link">Border</a>
          <a href="util-display.html" class="nav-link active">Display</a>
          <a href="util-flex.html" class="nav-link">Flex</a>
          <a href="util-height.html" class="nav-link">Height</a>
          <a href="util-margin.html" class="nav-link">Margin</a>
          <a href="util-padding.html" class="nav-link">Padding</a>
          <a href="util-position.html" class="nav-link">Position</a>
          <a href="util-typography.html" class="nav-link">Typography</a>
          <a href="util-width.html" class="nav-link">Width</a>
          <a href="util-extras.html" class="nav-link">Extras</a>
        </nav>
      </div><!-- component-item -->

    </div><!-- az-content-left -->
    <div class="az-content-body pd-lg-l-40 d-flex flex-column">
      <!-- <div class="az-content-breadcrumb">
        <span>Utilities</span>
        <span>Display</span>
      </div> -->
      <div class="row">
        @for($i = 0; $i < 10 ;$i++)
        <div class="col-lg-4 col-md-6 col-sm-6 col-12 product-item mb-2 ">
          <div class="card">
            <div class="card-body">
              <div class="action-holder">
                <div class="sale-badge bg-success">New</div>
                <span class="favorite-button"><i class="typcn icon typcn-heart-outline"></i></span>
              </div>
              <div class="product-img-outer">
                <img class="product_image" src="../img/product_images_2/thumb_image2.jpg" alt="prduct image">
              </div>
              <p class="product-title">Headphones JBL</p>
              <p class="product-price">$199.00</p>
              <p class="product-actual-price">$99.00</p>
              <ul class="product-variation">
                <li><a href="#">S</a></li>
                <li><a href="#">M</a></li>
              </ul>
              <p class="product-description">Power Capability: 150mW Cable Length: 1.5 meter</p>
            </div>
          </div>
        </div>
        @endfor
      </div>
    </div><!-- az-content-body -->
  </div><!-- container -->
</div><!-- az-content -->
@endsection
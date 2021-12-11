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
<div class="mx-auto px-4">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
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
	</div>
</div>
@endsection
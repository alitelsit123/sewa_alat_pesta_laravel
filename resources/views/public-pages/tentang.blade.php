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
<div class="mt-5" style="min-height:600px;">
    <div class="jumbotron">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-9 col-sm-7">
                    <h1 class="display-4">Tentang Mita</h1>
                    <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
                    <hr class="my-4">
                    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
                    
                    <a class="btn btn-primary btn-lg" href="#" role="button">Facebook</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Twitter</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Instagram</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Youtube</a>
                </div>
                <div class="col-md-3 col-sm-5">
                    <img class="img-fluid" src="data:image/png;base64,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" alt="Image">
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
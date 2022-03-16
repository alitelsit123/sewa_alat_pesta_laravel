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
@endsection

@section('content-body')
<div class="mt-5" style="min-height:600px;">
    <div class="jumbotron">
        <div class="container p-4">
            <div class="row">
                <div class="col-md-9 col-sm-7">
                    <h1 class="display-4">Tentang Mita</h1>
                    <p class="lead">CV Mita alat pesta  berdiri sejak tahun 2015 </br>
                        CV Mita menyewakan segala macam perlengkapan pesta, peralatan yang disewakan dapat digunakan pada acara sekolah, pesta pernikahan, acara di gedung, dan lainnya.
                        CV. Mita berdiri sejak tahun 2015 </br>
                        Lokasi : Jl. Wonoayu No. 171 Medokan Ayu Rungkut Kota Surabaya</p>
                    <hr class="my-4">
                    
                    <a class="btn btn-primary btn-lg" href="#" role="button">Facebook</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Twitter</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Instagram</a>
                    <a class="btn btn-primary btn-lg" href="#" role="button">Youtube</a>
                </div>
                <div class="col-md-3 col-sm-5">
                    <img class="img-fluid" src="http://127.0.0.1:8000/assets/img/imghome.jpg" alt="Image">
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
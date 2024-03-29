@extends('layouts.app-auth')

@section('css_head')
<!-- vendor css -->
<link href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('/assets/plugins/typicons.font/typicons.css') }}" rel="stylesheet">

<!-- azia CSS -->
<link rel="stylesheet" href="{{ asset('/assets/dist-base/css/azia.css') }}">
@endsection

@section('js-body')
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/ionicons/ionicons.js') }}"></script>

<script src="{{ asset('/assets/dist-base/js/azia.js') }}"></script>
<script>
  $(function(){
    'use strict'

  });
</script>
@endsection

@section('content-body')
<div class="az-signin-wrapper" style="background: url('/assets/img/imglogin.jpg');
                background-position: center; background-repeat: no-repeat; background-size: cover; position: relative">
<div class="az-card-signin">
    <h1 class="az-logo text-uppercase" style="color: #0D2F73;">{{ env('APP_NAME') }}</h1>
    <div class="az-signup-header">
      <h4>Daftar gratis.</h4>

      <form action="{{ url('/auth/register') }}" method="post">
      	@csrf
        <div class="form-group mb-2">
          <label>Nama</label>
          <input type="text" name="nama" class="form-control" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
        </div><!-- form-group -->
        <div class="form-group mb-2">
          <label>Nik</label>
          <input type="text" name="nik" class="form-control" placeholder="Masukkan Nik" value="{{ old('nik') }}" required>
        </div><!-- form-group -->
        <div class="form-group mb-2">
          <label>Email</label>
          <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="{{ old('email') }}" required>
        </div><!-- form-group -->
        <div class="form-group mb-2">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Masukkan Password" value="" required>
        </div><!-- form-group -->
        <div class="form-group mb-2">
          <label>Ulangi Password</label>
          <input type="password" name="password_confirmation" class="form-control" placeholder="" value="" required>
        </div><!-- form-group -->
        <div class="d-flex mb-2">
	        @if ($errors->any())
			    <div class="alert alert-danger" style="width: 100%;">
			        <ul class="pb-0">
			            @foreach ($errors->all() as $error)
			                <li>{{ $error }}</li>
			            @endforeach
			        </ul>
			    </div>
		      @endif
        </div>
        <div class="d-flex">
        	<button class="btn btn-block btn-az-primary" type="submit">Buat Akun</button>
        </div>
        <!-- <div class="row row-xs">
          <div class="col-sm-6"><button class="btn btn-block"><i class="fab fa-facebook-f"></i> Signup with Facebook</button></div>
          <div class="col-sm-6 mg-t-10 mg-sm-t-0"><button class="btn btn-primary btn-block"><i class="fab fa-twitter"></i> Signup with Twitter</button></div>
        </div> -->
      </form>
    </div><!-- az-signup-header -->
    <div class="az-signup-footer">
      <p>Sudah punya akun? <a href="{{ url('/auth/login') }}">Masuk</a></p>
    </div><!-- az-signin-footer -->
  </div><!-- az-column-signup -->
</div><!-- az-signup-wrapper -->
@endsection
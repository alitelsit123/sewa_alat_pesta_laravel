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
  <div class="az-card-signin" style="height: 480px; width: 460px;">
    <h1 class="az-logo text-uppercase" style="color: #0D2F73;">{{ env('APP_NAME') }}</h1>
    <div class="az-signin-header">
      <h2 style="color: #0D2F73;">Selamat Datang Kembali!</h2>
      <h4 >Masuk untuk melanjutkan</h4>

      <form action="{{ url('/auth/login') }}" method="post">
        @csrf
        <div class="form-group mb-2">
          <label>Email</label>
          <input type="text" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
        </div><!-- form-group -->
        <div class="form-group mb-2">
          <label>Password</label>
          <input type="password" name="password" class="form-control" placeholder="Password" value="" required>
        </div><!-- form-group -->
        <div class="d-flex">
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
        <button class="btn btn-az-primary btn-block">Masuk</button>
      </form>
    </div><!-- az-signin-header -->
    <div class="az-signin-footer">
      <!--<p><a href="#">Lupa Password?</a></p> -->
      <p>Belum Punya Akun? <a href="{{ url('/auth/register') }}">Daftar</a></p>
    </div><!-- az-signin-footer -->
  </div><!-- az-card-signin -->
</div><!-- az-signin-wrapper -->
@endsection
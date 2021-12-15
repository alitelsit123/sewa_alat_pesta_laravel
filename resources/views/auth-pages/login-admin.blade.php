@extends('layouts.app-auth-admin')

@section('content-body')
<div class="login-logo">
    <a href="../../index2.html"><b>{{ env('APP_NAME', 'Mita') }}</b> Administrator</a>
</div>
<!-- /.login-logo -->
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Masuk</p>

        <form action="{{ route('admin.login') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email" required>
                <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
                <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                </div>
            </div>
            @error('email')
                <div class="validation-error">
                    <div class="alert alert-danger" style="width: 100%;">
                        {{ $message }}
                    </div>
                </div>
            @enderror
            <div class="row">
                <div class="col-8">
                <div class="icheck-primary">
                    <input type="checkbox" id="remember">
                    <label for="remember">
                    Remember Me
                    </label>
                </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mb-1">
            <a href="forgot-password.html">Lupa Password</a>
        </p>
    </div>
    <!-- /.login-card-body -->
</div>
@endsection
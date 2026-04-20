@extends('backend.auth.layout.main')
@section('title', 'Forgot password')
@section('sections')
    <div class="login-box">
        <div class="login-logo">
            <a href="javascript:void(0)"><b>{{ env('APP_NAME') }}</b></a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
                @include('backend.common.message')
                <form action="{{ route('backend.checking.forgot_password') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
                        </div>
                    </div>
                </form>

                <p class="mt-3 mb-1">
                    <a href="{{ route('backend.login') }}">Login</a>
                </p>
            </div>
        </div>
    </div>
@endsection
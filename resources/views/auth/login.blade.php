@extends('layouts.web')
@section('content')

<style>
    a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }
    .login {
        color: #3f3f3f;
        text-decoration: none;
    }
    .login:hover {
        color: white;
        text-decoration: none;
    }
</style>

<div class="container">
    <div class="row">
        <div class="h-100 d-flex align-items-center justify-content-center mt-5 mb-login">
            <div class="login-area" style="width: 460px;">
                <h1>Log In</h1>
                <span>Get started by filling up details below</span>
                <div class="login-option">
                    <a href="{{url('login/google')}}" class="login mb-3" style="line-height: 27px; padding: 13px 0;"><img src="{{url('images/')}}/google.svg"> Log in with Google </a>
                    <a href="{{url('login/facebook')}}" class="login mb-2" style="line-height: 27px; padding: 13px 0;"><img src="{{url('images/')}}/fb.svg"> Log in with Facebook </a>
                </div>
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form id="loginForm" method="POST" action="{{ route('Signin') }}">
                    @csrf
                    <div class="login-field">
                        <label for="exampleInputEmail1" class="form-label">Email id</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter email id">
                        <img src="{{url('images/')}}//mail.svg" alt="">
                        <div class="alert alert-danger mt-1 mb-1 emailError" style="display: none;">Please enter email</div>
                    </div>
                    <div class="login-field">
                        <label for="exampleInputEmail1" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter password">
                        <div class="alert alert-danger mt-1 mb-1 passwordError" style="display: none;">Please enter password</div>
                    </div>
                    <button type="submit" class="login-m loginBtn">Log In</button>
                    <a class="mb-4" href="{{url('forgot-password')}}" style="float: right; margin-top: 4px;">Forgot Password?</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
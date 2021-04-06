@extends('auth.auth_layout')
@section('title', 'Login')
@section('content')
<style>
    .required:after {
        content: '*';
        color: red;
        padding-left: 5px;
    }
</style>
<div class="login-form">
    @if (session()->has('message'))
        <div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
            {{ session('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if ($errors->has('message'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
            <span class="badge badge-pill badge-danger">Error</span>
            {{ $errors->first('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <form action="{{ route('get_login')}}" method="post">
        @csrf
        <div class="form-group">
            <label class="required">Email Address</label>
            <input class="au-input au-input--full" required type="email" name="email" placeholder="Email">
        </div>
        @if ($errors->has('email'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('email') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        
        <div class="form-group">
            <label class="required">Password</label>
            <input class="au-input au-input--full" type="password" required name="password" placeholder="Password">
        </div>
        @if ($errors->has('password'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('password') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="form-group">
            <label class="required">OPT</label>
            <input type="button"class="btn btn-primary" title="Get OTP"type="password" required name="password" placeholder="Password">
        </div>
        @if ($errors->has('password'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('password') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="login-checkbox">
            <label>
                <input type="checkbox" name="remember">Remember Me
            </label>
            <label>
                <a href="#">Forgotten Password?</a>
            </label>
        </div>
        <button class="au-btn au-btn--block au-btn--green m-b-20" >sign in</button>
       
    </form>
    <div class="register-link">
        <p>
        © GrilledChili All rights reserved
           
        </p>
    </div>
</div>
@endsection
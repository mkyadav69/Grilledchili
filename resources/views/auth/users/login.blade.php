@extends('auth.auth_layout')
@section('title', 'Login')
@section('content')
<style>
    .required:after {
        content: '*';
        color: red;
        padding-left: 5px;
    }

    .au-input {
        border-radius : 20px;
        border-color: skyblue;
    }
    .btn-block{
        border-radius : 20px;
    }
    .login-content {
        border-radius: 20px;
    }
</style>
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-error alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif
<div class="login-form">
    <form action="{{route('get_login')}}" method="post">
        @csrf
        <div class="form-group">
            <input class="au-input au-input--full form-control" type="text" name="mobile" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" placeholder="Account Mobile No" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
        </div>
        <button class="btn btn-lg btn-info btn-block" type="submit">Sign In</button>
    </form>
    <div class="form-group  register-link">
        <div>
            <label>Don't have an account ? </lable>
        </div>
        <div>
            <a href="{{route('register')}}">
                Create new account
            </a>
        </div>
    </div>
</div>
@endsection
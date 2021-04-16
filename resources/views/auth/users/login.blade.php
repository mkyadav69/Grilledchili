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
    .au-input {
        margin-left: 25px;
    }
    .au-input--full {
        width: 105%;
    }
</style>
@if ($message = Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
        <span class="badge badge-pill badge-danger">Error</span>
        {{$message }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if (session()->has('message'))
    <div class="sufee-alert alert with-close alert-error alert-dismissible fade show">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div class="login-form">
    <form action="{{route('merchant_login')}}" method="get">
        @csrf
        <div class="row  form-group">
            <div class="col-1">
                <input class="au-input au-input--full" type="tel" id="phone">
            </div>
            <div class="col-10">
                <input class="au-input au-input--full" required type="tel" name="mobile" id="phone" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" value="{{!empty(\Session::get('change')) ? \Session::get('change') : ''}}" placeholder="Account Mobile No" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
            </div>
        </div>
        @if ($errors->has('mobile'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('mobile') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
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

<script>
$(document).ready(function(){
    
    const input = document.querySelector("#phone");
    intlTelInput(input, {
        autoHideDialCode: false,
        autoPlaceholder: "off",
        initialCountry: "us",
        onlyCountries:[
            'us'
        ],
        utilsScript: "{{asset('js/utils.js')}}",
    });
});
</script>
@endsection
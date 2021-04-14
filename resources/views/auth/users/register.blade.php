@extends('auth.auth_layout')
@section('title', 'Register')
@section('content')
<style>
    .required:after {
        content: '*';
        color: red;
        padding-left: 5px;
    }

    .au-input {
        border-radius : 20px;
        border-thickness : 20px;

        border-color: skyblue;
    }
    .btn-block{
        border-radius : 20px;
    }

    .login-content {
        border-radius: 20px;
    }
</style>
<div class="login-form">
    <form action="{{route('register_merchant')}}" method="post">
        @csrf
        <div class="form-group">
            <input class="au-input au-input--full form-control" type="text" name="first_name" value="{{old('first_name')}}" placeholder="First Name">
        </div>
        @if ($errors->has('first_name'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('first_name') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="form-group">
            <input class="au-input au-input--full form-control" type="text" name="last_name" value="{{old('last_name')}}" placeholder="Last Name">
        </div>
        @if ($errors->has('last_name'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('last_name') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="form-group">
            <input class="au-input au-input--full form-control" type="text" name="email" value="{{old('email')}}" placeholder="Email">
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
            <input class="au-input au-input--full form-control" type="password" name="password" value="{{old('password')}}" placeholder="Password">
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
            <input class="au-input au-input--full form-control" type="text" name="mobile" value="{{old('mobile')}}" placeholder="Mobile Number">
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
        <button class="btn btn-lg btn-info btn-block" type="submit">Sign Up</button>
       
    </form>
    <div class="register-link">
        <a href="{{route('login')}}">
            Already have an account?
        </a>
    </div>
</div>
@endsection
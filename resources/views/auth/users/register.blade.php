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
    #phone {
        width: 145%;
    }
    .flag{
        margin-left:50px;
    }
    
</style>
<div class="login-form">
    <form action="{{route('register_merchant')}}" method="post">
        @csrf
        <div class="form-group">
            <input class="au-input au-input--full form-control" type="text" required name="first_name" value="{{old('first_name')}}" placeholder="First Name">
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
            <input class="au-input au-input--full form-control" type="text" required name="last_name" value="{{old('last_name')}}" placeholder="Last Name">
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
            <input class="au-input au-input--full form-control" type="text" required name="email" value="{{old('email')}}" placeholder="Email">
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
            <input class="au-input au-input--full form-control" type="password" required name="password" value="{{old('password')}}" placeholder="Password">
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
        <div class="row  form-group">
            <div class="col-1">
                <input class="au-input au-input--full" type="tel" id="phone">
            </div>
            <div class="col-7">
                <input class="au-input au-input--full flag" required type="tel" name="mobile" id="phone" maxlength="10" pattern="\d{10}" title="Please enter exactly 10 digits" value="{{!empty($mobile) ? $mobile : ''}}" placeholder="Account Mobile No" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
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
        <button class="btn btn-lg btn-info btn-block" type="submit">Sign Up</button>
       
    </form>
    <div class="register-link">
        <a href="{{route('login')}}">
            Already have an account?
        </a>
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
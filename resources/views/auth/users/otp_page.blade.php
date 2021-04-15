@extends('auth.auth_layout')
@section('title', 'OTP Verification')
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
@if ($message = \Session::get('success'))
    <div class="alert alert-success alert-block">
        <button type="button" class="close" data-dismiss="alert">×</button>	
        <strong>{{ $message }}</strong>
    </div>
@endif


<div class="form-group login-form">
    <form action="{{route('auth_merchant')}}" method="post">
        @csrf
        @if (\Session::get('mobile'))
            <div class="form-group">
                <center><p style="font:bold"><b>An OTP has been sent to {{ \Session::get('mobile')}}<a href="{{route('login')}}">&nbsp Change</a></p></b></center>
            </div>
        @endif
        <input type="hidden" class="form-control" id="mobile_no" name="mobile_no" value="{{!empty($mobile_number) ? $mobile_number : ''}}"> 
        <div class="form-group">
            <div class="flag-box">
                   <div class="iti-flag us"></div>
        </div>
            <input class="au-input au-input--full form-control" type="text" required name="otp" maxlength="10" placeholder="Enter OTP">
        </div>
        @if (session()->has('error'))
        <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if ($errors->has('otp'))
            <div class="sufee-alert alert with-close alert-danger alert-dismissible fade show">
                <span class="badge badge-pill badge-danger">Error</span>
                {{ $errors->first('otp') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <button class="btn btn-lg btn-info btn-block" type="submit">SUBMIT</button>
        <div class="form-group">
        </div>
        
        <center><div class="form-group">
            <a class="resend" href="">
                Resend OTP ?
            </a>
        </center>
        </div>
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
        $('.resend').on('click', function() {                    
            var mobile = "{{ \Session::get('mobile')}}";
            var path = "{{route('merchant_login')}}";
            if(mobile !='' && mobile != null){
                 $.ajax({
                    url:path,
                    type:'GET',
					dataType: 'json',
                    data: {'mobile' : mobile},
                    success: function(response) {
                      console.log(response);
                    },error: function(error) {
                        console.log(error);
                    }
                });
            }
        }); 
    });
</script>

@endsection
@extends('user.layouts.master')

@section('content')
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>HRM | Reset Password</title>
<!-- Favicon-->
<link rel="icon" href="{{ asset('wings-favicon.png')}}" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('user/css/style.min.css')}}">
<link rel="stylesheet" href="{{ asset('user/css/sweetalert.css')}}">
<style type="text/css">
    body{
        background: -webkit-linear-gradient(left, #1f6d81, #1f6d81);
    }
</style>
</head>

<body class="theme-blush">

<div class="authentication">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12">              
                <div class="card auth_form">
                    <div class="header">
                        <a href="{{'/'}}">
                            <img class="logo"src="{{ asset('logo_wingsevents.png')}}" alt="Logo">
                        </a>
                        <h5>{{ __('Reset Password') }}</h5>
                    </div>
                    <form class="card-body" method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="copyright text-center">
                    <p style="color: #fff;">&copy;<script>document.write(new Date().getFullYear())</script>, Wings Events. All Rights Reserved  | Powered by <a href="{{'/'}}" target="_blank" style="color: #ff5722;font-weight: bold;">Wings Events</a> </p>
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <div class="card">
                    <img src="{{ asset('user/images/signin.svg')}}" alt="Sign In"/>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Jquery Core Js -->
<script src="{{ asset('user/bundles/libscripts.bundle.js')}}"></script>
<script src="{{ asset('user/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{ asset('user/js/pages/jquery.min.js')}}"></script>
<script src="{{ asset('user/js/pages/sweetalert.min.js')}}"></script>

</body>
@endsection

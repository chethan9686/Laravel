@extends('admin.layouts.master')

@section('content')
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title> Admin | Sign In</title>
<!-- Favicon-->
<link rel="icon" href="{{ asset('wings-favicon.png')}}" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('admin/plugins/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('admin/css/style.min.css')}}">
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
            <div class="col-lg-4 col-sm-12">

                <form class="card auth_form" method="POST" action="{{route('admin.login.submit')}}">
                    @csrf
                    <div class="header">
                        <a href="{{'/'}}">
                            <img class="logo" src="{{ asset('logo_wingsevents.png')}}" alt="Logo">
                        </a>
                        <h5>Admin Log in</h5>
                    </div>
                    <div class="body">                       
                        <div class="input-group mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" placeholder="Email">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password">
                            <div class="input-group-append">                                
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                            </div>      
                            @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror                      
                        </div>                    
                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN IN</button>              
                    </div>
                     <b style="color: red">{!! session()->get('error') !!}</b>
                </form>
                <div class="copyright text-center">
                    <p style="color: #fff;">&copy;<script>document.write(new Date().getFullYear())</script>, Wings Events. All Rights Reserved  | Powered by <a href="{{'/'}}" target="_blank" style="color: #f7974b;font-weight: bold;">Wings Events</a></p>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="{{ asset('admin/images/signin.svg')}}" alt="Sign In"/>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Jquery Core Js -->
<script src="{{ asset('admin/bundles/libscripts.bundle.js')}}"></script>
<script src="{{ asset('admin/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
</body>

@endsection

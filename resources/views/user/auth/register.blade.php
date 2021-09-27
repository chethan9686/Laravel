@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title> Employee | Sign Up</title>
<!-- Favicon-->
<link rel="icon" href="{{ asset('wings-favicon.png')}}" type="image/x-icon">
<!-- Custom Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/bootstrap/css/bootstrap.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('user/plugins/select2/select2.css')}}">

<link rel="stylesheet" href="{{ asset('user/css/style.min.css')}}">
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
                <form class="card auth_form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="header">
                        <a href="{{'/'}}">
                            <img class="logo"  src="{{ asset('logo_wingsevents.png')}}" alt="Logo">
                        </a>
                         <h5>Sign Up</h5>
                        <span>Register a new employee</span>
                    </div>
                    <div class="body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('f_name') is-invalid @enderror" name="f_name"placeholder="First Name">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('f_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="input-group mb-3">
                            <input type="text" class="form-control @error('l_name') is-invalid @enderror"name="l_name" placeholder="Last Name">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            @error('l_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <div class="input-group mb-3">                            
                           <div class=" form-control radio  @error('gender') is-invalid @enderror" style="border: none">
                                <input type="radio" name="gender" id="radio1" value="M">
                                <label for="radio1">Male</label>
                                <input type="radio" name="gender" id="radio2" value="F">
                                <label for="radio2">Female</label>
                            </div>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>  
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="Mobile Number">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                            </div>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>  
                        <div class="input-group mb-3">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="Email ID">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="zmdi zmdi-email"></i></span>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>     
                        <div class="input-group mb-3">
                            <select class="form-control show-tick ms select2 @error('branch') is-invalid @enderror" name="branch" data-placeholder="Select">
                                    <option value="">Select Branch</option>
                                @foreach($Branches as $Branch)
                                    <option value="{{$Branch->id}}">{{$Branch->name}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">                                
                               <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                           </div> 
                            @error('branch')
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
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm Password">
                            <div class="input-group-append">                                
                                <span class="input-group-text"><i class="zmdi zmdi-lock"></i></span>
                            </div> 
                             @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror                                             
                        </div>      
                        <div class="checkbox">
                            <input id="remember_me" type="checkbox" class=" form-control @error('remember_me') is-invalid @enderror" name="remember_me" >
                            <label for="remember_me">I read and agree to the <a href="javascript:void(0);">terms of usage</a></label>
                            @error('remember_me')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                         <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SIGN UP</button>    
                        <div class="signin_with mt-3">
                            <a class="link" href="{{route('login')}}">Are You already Employee?</a>
                        </div>
                    </div>
                </form>
              <div class="copyright text-center">
                    <p style="color: #fff;">&copy;<script>document.write(new Date().getFullYear())</script>, Wings Events. All Rights Reserved  | Powered by <a href="{{'/'}}" target="_blank" style="color: #ff5722;font-weight: bold;">Wings Events</a> </p>
                </div>
            </div>
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <img src="{{ asset('user/images/signup.svg')}}" alt="Sign Up" />
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Jquery Core Js -->
<script src="{{ asset('user/bundles/libscripts.bundle.js')}}"></script>
<script src="{{ asset('user/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{ asset('user/plugins/select2/select2.min.js')}}"></script> <!-- Select2 Js -->
<script src="{{ asset('user/js/pages/forms/advanced-form-elements.js')}}"></script>
</body>
@endsection

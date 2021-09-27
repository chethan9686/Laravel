<!doctype html>
<html class="no-js " lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title>Wings Events | HRM</title>
<!-- Favicon-->
<link rel="icon" href="{{ asset('wings-favicon.png')}}" type="image/x-icon">
<!-- Favicon-->
<link rel="stylesheet" href="{{ asset('user/plugins/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('user/css/style.min.css')}}">
<style>
    .logo{
        text-align: center
    }
    body{
       /* background: -webkit-linear-gradient(left, #1f6d81, #1f6d81);*/
    }
    .color{
        border: 2px solid #b0cbd2;
        border-radius: 56px;
        padding: 3em 3em 3.5em;
        /*background: -webkit-linear-gradient(left, #377f8e, #377f8e);*/
        margin-top:30px;
    }
    .align{
        text-align: center
    }
    .copy{
        margin: 2em 0em 2em 0em;
        text-align: center;
    }
    .copy > p
    {
        color: #fff;
        font-size: 15px;
        letter-spacing: 2px;
        word-spacing: 2px;
    }
</style>
</head>

<body class="theme-blush">

<div class="authentication">    
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">               
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 color">
                <a class="logo" href="{{('/')}}"><h2><img src="{{asset('logo_wingsevents.png')}}"></h2></a>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 align">
                         <a href="{{route('admin.login')}}"><img src="{{asset('admin.png')}}" width="170"></a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 align">
                        <a href="{{route('login')}}"><img src="{{asset('emp.png')}}" width="170"></a>
                    </div>                    
                </div>                
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">                
            </div>
        </div>
        <div class="row copy justify-content-center">
             <p style="color: #222;font-weight:bold;">&copy;<script>document.write(new Date().getFullYear())</script>, Wings Events. All Rights Reserved  | Powered by <a href="https://wingsevents.com/" target="_blank" style="font-weight: bold;"><b style="color:#ed3e00">WINGS</b> <b style="color: #222;">EVENTS</b></a></p>
        </div>
    </div>
</div>


<!-- Jquery Core Js -->
<script src="{{ asset('user/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
<script src="{{ asset('user/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js --> 
</body>

</html>
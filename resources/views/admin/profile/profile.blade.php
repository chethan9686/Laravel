@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title> HRM | Admin Profile</title>

@include('admin.layouts.css')
  
<link rel="stylesheet" href="{{asset('admin/plugins/dropify/css/dropify.min.css')}}">
<style>
    .card .header{
        padding: 0px 0 10px 0;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: .25rem;
        font-size: 90%;
        color: red;
    } 

</style>

</head>

<body class="theme-blush">

@include('admin.layouts.page_loader')

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Admin Profile</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                    
                </div>
            </div>
        </div> 
        <div class="container-fluid">

            <div class="row clearfix">
                <div class="col-lg-4 col-md-12">
                    <div class="card mcard_3">
                        <div class="body">
                            <img src="{{asset('public/'.$User->profile_picture)}}" class="rounded-circle shadow " alt="profile-image">
                            <h4 class="m-t-10"></h4>                            
                            <!--<div class="row">                                
                                <div class="col-4">                                    
                                    <small>Following</small>
                                    <h5>852</h5>
                                </div>
                                <div class="col-4">                                    
                                    <small>Followers</small>
                                    <h5>13k</h5>
                                </div>
                                <div class="col-4">                                    
                                    <small>Post</small>
                                    <h5>234</h5>
                                </div>                            
                            </div>-->
                        </div>
                    </div>
                    <div class="card">
                        <div class="body">
                            <small class="text-muted">Email address: </small>
                            <p>{{$User->email}}</p>
                            <hr>                  
                        </div>
                    </div>                    
                </div>  
                
                <div class="col-lg-4 col-md-12">                   
                    <div class="card">
                        <div class="header">
                            <h2>Change<strong> Profile </strong> Picture</h2>
                        </div>
                        <div class="body">
                           <form class="col-md-10" method="POST" action="{{route('admin.update_profile_pic')}}" enctype="multipart/form-data">
                                 {{csrf_field()}}
                                <label for="email_address">Name</label>
                                <div class="form-group">                                
                                    <input type="text" id="name" class="form-control" name="Admin_Name" value="{{$User->name}}">
                                </div>  
                                @if ($errors->has('Admin_Name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Admin_Name') }}</strong>
                                    </span>
                                @endif                            
                                <label>Profile Picture</label>
                                <div class="form-group">                      
                                        <input type="file" class="form-control"id="dropify-event" name="Admin_Image" data-default-file="{{asset('public/'.$User->profile_picture)}}">
                                </div>
                                @if ($errors->has('Admin_Image'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('Admin_Image') }}</strong>
                                    </span>
                                @endif
                               <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>  
                            </form>                                      
                        </div>
                    </div>
                </div>   

                <div class="col-lg-4 col-md-12">                   
                    <div class="card">
                        <div class="header">
                            <h2>Change<strong> Password </strong> </h2>
                        </div>
                        <div class="body">
                           <form class="col-md-10" method="POST" action="{{route('admin.update_password')}}">
                                 {{csrf_field()}}
                              
                                <label>Old Password</label>
                                <div class="form-group">                                
                                    <input type="password" class="form-control" name="old_password">
                                </div>  
                                @if ($errors->has('old_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
                                @endif      

                                <label>New Password</label>
                                <div class="form-group">                                
                                    <input type="password" class="form-control" name="new_password">
                                </div>  
                                @if ($errors->has('new_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('new_password') }}</strong>
                                    </span>
                                @endif 

                                <label>Confirm New Password</label>
                                <div class="form-group">                                
                                    <input type="password" class="form-control" name="confirm_password">
                                </div>  
                                @if ($errors->has('confirm_password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('confirm_password') }}</strong>
                                    </span>
                                @endif    
                               
                               <button type="submit" class="btn btn-primary waves-effect waves-light">Save</button>  
                            </form>                                      
                        </div>
                    </div>
                </div>      
            </div>
        </div>
    </div>
</section>


@include('admin.layouts.js')

<script src="{{asset('admin/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('admin/js/pages/forms/dropify.js')}}"></script>
{!! Toastr::message() !!}
</body>

@endsection
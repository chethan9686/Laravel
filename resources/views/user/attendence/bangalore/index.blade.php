@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Attendance</title>

@include('user.layouts.css')

<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">

<style>   
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

@include('user.layouts.page_loader')

@include('user.layouts.search')

@include('user.layouts.menu_sidebar')

@include('user.layouts.left_sidebar')

@include('user.layouts.right_sidebar')


<section class="content">
    <div class="body_scroll">
    
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Attendence</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><i class="zmdi zmdi-home"></i> HRM</li>
                        <li class="breadcrumb-item active">Attendance</li>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                       <div class="header">
                          <h2> <strong>Upload Punch In Details</strong></h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{route('upload_punch_in_details')}}" role="form" enctype="multipart/form-data">
                            @csrf
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4">                                                       
                                    </div>
                                    <div class="col-lg-4 col-md-4">                                       
                                        <div class="form-group">                                                       
                                            <input type="file" id="dropify-event"  name="attendence_file">
                                        </div>
                                    </div> 
                                    <div class="col-lg-4 col-md-4">                                                      
                                    </div>                             
                                </div> 
                                <div class="row">
                                    <div class="col-lg-4 col-md-4">                                                       
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                         <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>  
                                    </div>
                                    <div class="col-lg-4 col-md-4">                                                      
                                    </div>
                                </div>        
                            </form>  
                        </div>
                    </div>
                </div>
            </div>           
        </div>     
    </div>
</section>


@include('user.layouts.js')
<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
{!! Toastr::message() !!}
</body>
@endsection
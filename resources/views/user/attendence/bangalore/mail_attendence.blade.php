@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Attendance</title>

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

@include('user.layouts.css')

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
                    <h2>Bangalore Mail Attendance</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Bangalore Mail Attendance</li>
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
                          <h2> <strong>Total Absent For The Day: {{count($absent_users)}} Employees</strong></h2>
                        </div>
                        <div class="body">   
                            <div class="row clearfix">
                                @foreach($absent_users as $ab_user)
                                    <div class="col-lg-2 col-md-2 col-sm-2">   
                                        <div class="form-group">                                                                          
                                            <label>
                                                    {{$ab_user->emp_name}} ,
                                            </label>                                    
                                        </div>                                                    
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="header">
                          <h2> <strong>Total: {{count($users)}} Employees</strong></h2>
                        </div>
                        <div class="body">                              
                            <form method="POST" action="{{route('bang_send_mail')}}" role="form" enctype="multipart/form-data">
                            @csrf
                            <div class="row clearfix">
                                    <div class="col-lg-5 col-md-5 col-sm-5">                             
                                        <div class="form-group">                                                       
                                            <input type="text" class="form-control datepicker" placeholder="Mail Date" name="mail_date">
                                        </div>     
                                        @if ($errors->has('mail_date'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('mail_date') }}</strong>
                                        </span>
                                        @endif                                                
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5">                           
                                        <div class="form-group">                                                       
                                            <select class="form-control show-tick" name="leave_type">
                                               <option value="">Select Mail Type</option>
                                               <option value="1">Absent</option>
                                               <option value="2">Early Departure</option>
                                               <option value="3">Absent For Work After The M/WS</option>   
                                               <option value="4">Late Arrival For Work After The M/WS</option>
                                               <option value="5">Sim Card Not at M/WS Location</option>
                                               <option value="6">In-Active Sim Card During Work Hours</option>      
                                               <option value="7">Not Reported to Work Prior to M/WS</option>                                                                 
                                               <option value="8">Absent - Without ID Card</option>                                                                 
                                            </select> 
                                        </div>  
                                        @if ($errors->has('leave_type'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('leave_type') }}</strong>
                                        </span>
                                        @endif                                                   
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-sm-2">                                          
                                        <button type="submit" class="btn btn-raised btn-primary btn-round waves-effect">SEND MAIL</button>                                                  
                                    </div>
                                </div>  
                                <div class="row clearfix">
                                    @foreach($users as $user)
                                    <div class="col-lg-3 col-md-3 col-sm-3">   
                                        <div class="form-group">                                                       
                                            <div class="checkbox">
                                                <input id="{{$user->emp_name}}" type="checkbox" name="check_user[]"  value="{{$user->user_id}}">
                                                <label for="{{$user->emp_name}}">
                                                        {{$user->emp_name}}
                                                </label>
                                            </div>
                                        </div>                                                    
                                    </div>
                                    @endforeach
                                    @if ($errors->has('check_user'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('check_user') }}</strong>
                                    </span>
                                    @endif   
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

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

{!! Toastr::message() !!}
</body>
@endsection
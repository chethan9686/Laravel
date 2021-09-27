@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Leave</title>

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

@include('user.layouts.css')
 
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
    
<div id="pageloader">
    <img src="{{ asset('loader.gif')}}" alt="processing..." />
</div>

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
                    <h2>Leave</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Leaves</li>
                        <li class="breadcrumb-item active">Leave</li>
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
                <div class="col-lg-2 col-md-2 col-sm-2">                    
                </div>
                <div class="col-lg-8 col-md-8 col-sm-8">                           
                    <div class="card">    
                        <div class="header">
                            <h2>Add<strong> Leave </strong></h2>
                        </div>                                  
                        <div class="body">  
                            <form method="post" action="{{route('add_leave')}}" id="add_leave">
                                @csrf
                                <div class="row">                     
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Employee Name</label>
                                        <div class="form-group">                                                   
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-mood"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="{{$user->first_name}} {{$user->last_name}}" readonly="readonly">
                                                @if ($errors->has('emp_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('emp_name') }}</strong>
                                                </span>
                                                @endif   
                                            </div>                                                                                   
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Leave Type</label>
                                        <div class="form-group">                                
                                            <select class="form-control show-tick" name="leave_type">
                                               <option value="">Select Leave Type</option>
                                               <option value="Casual Leave">Casual Leave</option>
                                               <option value="Sick Leave">Sick Leave</option>
                                               <option value="Comp Off">Comp Off</option>                                            
                                            </select>    
                                            @if ($errors->has('leave_type'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('leave_type') }}</strong>
                                            </span>
                                            @endif                                       
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="email_address">Leave Duration</label>
                                        <div class="form-group gender-bottom"> 
                                            <div class="radio inlineblock m-r-20">                                                                    
                                                <input type="radio" name="duration" id="hd" class="with-gap" value="Half Day" >
                                                <label for="hd"><i class="zmdi zmdi-brightness-2"></i> Half Day</label>
                                                <input type="radio" name="duration" id="fd" class="with-gap" value="Full Day">
                                                <label for="fd"><i class="zmdi zmdi-check-circle"></i> Full Day</label>
                                                <input type="radio" name="duration" id="mtd" class="with-gap" value="More Than 1 Day">
                                                <label for="mtd"><i class="zmdi zmdi-nature-people"></i> More Than 1 Day</label>
                                                @if ($errors->has('duration'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('duration') }}</strong>
                                                </span>
                                                @endif 
                                            </div>   
                                        </div> 
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12" id="start_day">
                                        <label for="email_address">Leave Start Date</label>
                                        <div class="form-group">                                                   
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" placeholder="Leave Start Date" name="start_date">
                                                @if ($errors->has('start_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('start_date') }}</strong>
                                                </span>
                                                @endif 
                                            </div>                                                                                   
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6" id="more_than_day" style="display: none">
                                        <label for="email_address">Leave End Date</label>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" placeholder="Leave End Date" name="end_date">                     
                                            </div>                                          
                                        </div>
                                    </div>                                          

                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="email_address">Reason For Leave</label>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-comment-edit"></i></span>
                                                </div>
                                                <textarea class="form-control" rows="3" name="reason"></textarea>
                                                @if ($errors->has('reason'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('reason') }}</strong>
                                                </span>
                                                @endif 
                                            </div>                                      
                                        </div>                                       
                                    </div>                                         

                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">                                       
                                                                                             
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>                                          
                                        <p style="margin-top: 20px;margin-bottom: 20px;font-size: 14px;"><b style="color:red;">Please Note :</b> Current day leaves can be requested only before <b style="color:red;">2:00 PM </b>.</p>
                                       
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>

                                </div>
                            </form>
                            
                        </div>                               
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2">                    
                </div>
            </div>
        </div>
    </div>
</section>

@php
$Days = \Carbon\Carbon::now()->daysInMonth;
$Day = \Carbon\Carbon::today()->day;
$remaining = ($Days - $Day);
@endphp

@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

<script type="text/javascript">
    var day = <?php echo  $remaining; ?>

    $('.datepicker').bootstrapMaterialDatePicker({minDate : new Date(),time: false,maxDate: moment().add(day, 'days') });

    $("input[type='radio']").change(function(){
        if($(this).val()=="More Than 1 Day")
        {
          $("#more_than_day").show();
          $("#start_day").show().removeClass('col-lg-12 col-md-12 col-sm-12').addClass('col-lg-6 col-md-6 col-sm-6'); 
        }
        else
        {
          $("#start_day").show().removeClass('col-lg-6 col-md-6 col-sm-6').addClass('col-lg-12 col-md-12 col-sm-12'); 
          $("#more_than_day").hide();
        }
    });

    $("#add_leave").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>

{!! Toastr::message() !!}

</body>

@endsection
   
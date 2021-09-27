@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | TEst</title>

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
                    <h2>Test</h2>
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
                            <h2>Add<strong> Test </strong></h2>
                        </div>                                  
                        <div class="body">  
                            <form method="post" action="{{route('submit_file')}}" id="add_leave" enctype="multipart/form-data">
                                @csrf
                                <div class="row">                     
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Test</label>                                                                                        
                                        <input type="file"  name="profile_pic">                                      
                                    </div>                                   
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>
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


@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

<script type="text/javascript">
    $('.datepicker').bootstrapMaterialDatePicker({minDate : new Date(),time: false });

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
   
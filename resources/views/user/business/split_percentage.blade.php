@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Business Signup List</title>
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
 <!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}">

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
    .theme-blush .nav-tabs .nav-link.active {
        border: 1px solid #00bcd4;
        color: #00bcd4;
    }
    .table-bordered{
        border: 1px solid #00BCD4;
    }
    thead{
        background: #00BCD4;
        color: #fff;
    }
    .btn
    {
        margin:0px 0px;
        padding: 6px 14px;
    }
    .btn-round 
    {
        padding:5px 15px;
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
                    <h2>Event Signed Up Percentage</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Business</li>
                        <li class="breadcrumb-item active">SignUp Percentage</li>
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
                          <h2> <strong>Event Signup Percentage</strong></h2>
                    </div>
                    <div class="body">  
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sl.No</th>
                                        <th>BS Number</th>                          
                                        <th>Company Name</th>                                                                  
                                        <th>Event Name</th>              
                                        <th>Allocated Percentage (%)</th>              
                                    </tr>
                                </thead>
                                <tbody> 
                                    @forelse($splitdata as $Key=>$data)
                                        @php
                                            $signup = App\BusinessSignup::where('id','=',$data->Signup_ID)->first();
                                            $signup_percentage = App\BusinessSignupSplit::where('signup_id','=',$data->Signup_ID)->first();
                                        @endphp
                                        <tr>
                                            <td>{{$Key+1}}</td>
                                            <td>{{$data->BS_Number}}</td>
                                            <td>{{$signup->company_name}}</td>
                                            <td>{{$signup->event_name}}</td>
                                            <td>{{$signup_percentage->percentage}} %</td>
                                        </tr>                               
                                        @empty
                                        <tr>
                                            <td colspan="5" style="text-align:center">No Data</td>
                                        </tr>
                                    @endforelse    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('user.layouts.js')

<script src="{{asset('user/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>

{!! Toastr::message() !!}

<script>
     $("#update_leave").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>

</body>

@endsection
   
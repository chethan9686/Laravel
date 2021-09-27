@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>HRM | Business Signup123</title>

@include('user.layouts.css')

<!-- Multi Select Css -->
<link rel="stylesheet" href="{{asset('user/plugins/multi-select/css/multi-select.css')}}">

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('user/plugins/select2/select2.css')}}" />

<link rel="stylesheet" href="{{asset('user/pastimepicker/css/jquery.datetimepicker.min.css')}}" />
<link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}">
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
<style type="text/css">
    .card {
     margin-bottom: 0px; 
    }
    .card .body {
        font-size: 13px;
    }
    .gender-bottom{
        margin-bottom: 1.55rem;
    }    
    .dropdown-menu {   
        box-shadow: 0px 4px 10px 0px rgba(41,42,51,0.2);
    }
    .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
    }
    .download{
        float: right;
    }

    .select2-container-multi .select2-choices{
        background-image: none!important; 
    }
    .select2-container-multi .select2-choices .select2-search-field input{
        padding:0px !important;
    }

    .select2-container .select2-choice {
        border-radius: 0px;
        background-image: none;
        border:0px;
    }
    /* Media Query for Mobile Devices */ 
        @media (max-width: 480px) { 
            #companyList{
                    margin-top: -50px;
            }
            .client{
                margin-top: 60px;
            }
        } 
          
        /* Media Query for low resolution  Tablets, Ipads */ 
        @media (min-width: 481px) and (max-width: 767px) { 
            #companyList{
                    margin-top: -50px;
            }
           
        } 
          
        /* Media Query for Tablets Ipads portrait mode */ 
        @media (min-width: 768px) and (max-width: 1024px){ 
            #companyList{
                    margin-top: -50px;
            }
            
        } 
          
        /* Media Query for Laptops and Desktops */ 
        @media (min-width: 1025px) and (max-width: 1280px){ 
            #companyList{
                    margin-top: -50px;
            }
        } 
          
        /* Media Query for Large screens */ 
        @media (min-width: 1281px) { 
            #companyList{
                    margin-top: -50px;
            }
        } 
        .mandatory{
            color: red;
            font-size: 20px;
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
                    <h2> Signup</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item"><a href="#">Signup</a></li>
                        <li class="breadcrumb-item active">Signup</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                    
                </div>
            </div>
        </div> 
        <div class="container-fluid">
             <!-- Tabs With Icon Title -->
            <div class="row clearfix">
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="card">                         
                        <div class="header">
                            <h2><strong>Signup Form</strong></h2>
                        </div>                      
                        <div class="body">  
                            <form method="post" action="{{route('business_signup')}}" id="add_meeting" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">                        
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="email_address">Company</label>
                                        <div class="form-group gender-bottom"> 
                                            <div class="radio inlineblock m-r-20">                                                                    
                                                <input type="radio" name="company" id="exist" class="with-gap" value="exist" checked >
                                                <label for="exist"><i class="zmdi zmdi-case-check"></i> Exist</label>
                                                <input type="radio" name="company" id="new" class="with-gap" value="new">
                                                <label for="new"><i class="zmdi zmdi-case"></i> New</label>
                                            </div>   
                                        </div>  
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Company Name</label>
                                        <span id="exist_div">
                                        <div class="input-group masked-input" >
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                            </div>
                                           <input type="text" class="form-control" name="exist_company_name" id="exist_company_name" placeholder="Search Company Name" >   
                                                                                   
                                        </div>   
                                        <div id="companyList"></div>                                      
                                        </span>

                                        <div class="input-group masked-input" id="new_div" style="display: none">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                            </div>
                                        <input type="text" class="form-control" name="new_company_name" placeholder="Enter Company Name" value="{{ old('new_company_name') }}">
                                        </div>    
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 client">
                                        <label>Client/User Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_name" placeholder="Client Name" value="{{ old('client_name') }}">
                                            @if ($errors->has('client_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client_name') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                       
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Client Email</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_email" placeholder="Client Email" value="{{ old('client_email') }}">
                                            @if ($errors->has('client_email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client_email') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Client Mobile Number</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_mobile" placeholder="Mobile Number" value="{{ old('client_mobile') }}">
                                            @if ($errors->has('client_mobile'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client_mobile') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                       
                                    </div>
                                     <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Event Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-view-carousel"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="event_name" placeholder="Event Name" value="{{ old('event_name') }}">
                                            @if ($errors->has('event_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('event_name') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                       
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Event Signed in (City)</label>
                                        <div class="input-group masked-input mb-3">                                          
                                            <select class="form-control show-tick " name="city_signedup" data-placeholder="City Name">
                                                    <option value="">Select City</option>
                                                @foreach($Branches as $Branch)
                                                    <option value="{{$Branch->id}}">{{$Branch->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('city_signedup'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('city_signedup') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>                                   
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Starting Date of Event</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                             <input type="text" name="eventstartdate" id="eventstartdate_old" style="z-index: 999 !important;" class="form-control datepicker1" placeholder="Event Start Date" value="{{ old('eventstartdate') }}">
                                             @if ($errors->has('eventstartdate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('eventstartdate') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                       
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Closing Date of Event</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker1" id="eventenddate_old" style="z-index: 999 !important;" name="eventenddate" placeholder="Event End Date" value="{{ old('eventenddate') }}">
                                            @if ($errors->has('eventenddate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('eventenddate') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Date event will be billed</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control datepicker1" id="eventbilldate_old" style="z-index: 999 !important;" name="dateofbilled" placeholder="Date Of event billed" value="{{ old('dateofbilled') }}">
                                            @if ($errors->has('dateofbilled'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dateofbilled') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    
                                    <div class="col-lg-8 col-md-8 col-sm-12">
                                        <label>Budget Sheet</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event2" name="budget_sheet">  
                                            @if ($errors->has('budget_sheet'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('budget_sheet') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label for="email_address">Service</label>
                                        <div class="form-group gender-bottom">
                                            <div class="radio inlineblock m-r-20">                             
                                                <input type="radio" name="service" id="event" class="with-gap" value="event" checked >
                                                <label for="event"><i class="zmdi zmdi-case-check"></i> Event</label>

                                                <input type="radio" name="service" id="payment" class="with-gap" value="payment">
                                                <label for="payment"><i class="zmdi zmdi-case"></i> Pass Through Payment</label>
                                
                                            </div>  
                                        </div>  
                                    </div>
                                  
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Estimate_Amount">
                                        <label>Estimate Amount(without GST)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="estimate_amount" id="estimate_amount" placeholder="Estimate Amount" value="{{ old('estimate_amount') }}">
                                            @if ($errors->has('estimate_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('estimate_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>  
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Budget_Amount">
                                        <label>Budget Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="budget_amount" id="budget_amount" placeholder="Budget Amount" value="{{ old('budget_amount') }}">
                                            @if ($errors->has('budget_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('budget_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div> 

                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Profit_Amount">
                                        <label>Profit Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="profit_amount" id="profit_amount" placeholder="Profit Amount" value="{{ old('profit_amount') }}" readonly>
                                            @if ($errors->has('profit_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('profit_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Profit_Percentage">
                                        <label>Profit %</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" name="profit_percentage" id="profit_percentage" placeholder="Profit %" value="{{ old('profit_percentage') }}" readonly>
                                            @if ($errors->has('profit_percentage'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('profit_percentage') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Estimate_Amount">
                                        <label>Actuals Estimate Amount(without GST)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_estimate_amount" id="actual_estimate_amount" placeholder="Actual Estimate Amount" value="{{ old('actual_estimate_amount') }}">
                                        </div>                                        
                                    </div>  
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Budget_Amount">
                                        <label>Actuals Budget Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_budget_amount" id="actual_budget_amount" placeholder="Actual Budget Amount" value="{{ old('actual_budget_amount') }}">                        
                                        </div>                                        
                                    </div>       
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Profit_Amount">
                                        <label>Actuals Profit Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_profit_amount" id="actual_profit_amount" placeholder="Actual Profit Amount" value="{{ old('actual_profit_amount') }}" readonly>                    
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Profit_Percentage">
                                        <label>Actuals Profit %</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_profit_percentage" id="actual_profit_percentage" placeholder="Actual Profit %" value="{{ old('actual_profit_percentage') }}" readonly>                 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="creative_cost">
                                        <label>Creative Cost</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="creative_amount" id="creative_amount" placeholder="Creative Cost" value="{{ old('creative_amount') }}">
                                            @if ($errors->has('creative_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('creative_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                        
                                    </div> 
                                     <div class="col-lg-4 col-md-6 col-sm-12" id="p_estimate_amount" style="display: none;">
                                        <label>P - Estimate Amount(without GST)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="payment_estimate_amount" id="payment_estimate_amount" placeholder="P - Estimate Amount" value="{{ old('payment_estimate_amount') }}">
                                        </div>                                        
                                    </div>  
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="p_budget_amount" style="display: none;">
                                        <label>P - Budget Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="payment_budget_amount" id="payment_budget_amount" placeholder="P - Budget Amount" value="{{ old('payment_budget_amount') }}">                        
                                        </div>                                        
                                    </div>       
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="p_profit_amount" style="display: none;">
                                        <label>P - Profit Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="payment_profit_amount" id="payment_profit_amount" placeholder="P - Profit Amount" value="{{ old('payment_profit_amount') }}" readonly>         
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="p_profit_percentage" style="display: none;">
                                        <label>P - Profit %</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" name="payment_profit_percentage" id="payment_profit_percentage" placeholder="P - Profit %" value="{{ old('payment_profit_percentage') }}" readonly>                 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Advance Payment Status</label>
                                        <div class="input-group masked-input mb-3">                                       
                                            <select class="form-control show-tick" name="advancepayment" id="advancestatus" >
                                                <option value="">Advance Payment from Client(Yes/No)</option>
                                                <option value="yes" @if (old('advancepayment') == 'yes') selected="selected" @endif>Yes</option>
                                                <option value="no"  @if (old('advancepayment') == 'no') selected="selected" @endif>No</option>
                                            </select>
                                             @if ($errors->has('advancepayment'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('advancepayment') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12" id="advancedate" <?php if($errors->has('dateofadvance')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?> >
                                        <label>Advance Payment Date</label>
                                        <div class="input-group masked-input mb-3">
                                             <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="adavanceammountdate" name="dateofadvance" placeholder="Date Of Advance Payment" value="{{ old('dateofadvance') }}">     
                                            @if ($errors->has('dateofadvance'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('dateofadvance') }}</strong>
                                                </span>
                                            @endif   
                                        </div>                                         
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="advanceammount" <?php if($errors->has('advance_amount')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?> >
                                        <label>Advance Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-rupee"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="advance_amount" placeholder="Advance Amount" value="{{ old('advance_amount') }}">
                                            @if ($errors->has('advance_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('advance_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div> 
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Purchase Order</label>
                                        <div class="input-group masked-input mb-3">                                       
                                            <select class="form-control show-tick" name="purchaseorder" placeholder="Purchase Order(Yes/No)" id="po" >
                                                <option value="">Purchase Order(Yes/No)</option> 
                                                <option value="Yes" @if (old('purchaseorder') == 'Yes') selected="selected" @endif>Yes</option>
                                                <option value="No" @if (old('purchaseorder') == 'No') selected="selected" @endif>No</option>
                                            </select>
                                            @if ($errors->has('purchaseorder'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('purchaseorder') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Client Approvel Mail</label>
                                        <div class="input-group masked-input mb-3">                                       
                                            <select class="form-control show-tick" name="clientmail" placeholder="Client Approvel Mail" id="clientmail" >
                                                <option value="">Client Approvel Mail(Yes/No)</option>
                                                <option value="Yes" @if (old('clientmail') == 'Yes') selected="selected" @endif>Yes</option>
                                                <option value="No" @if (old('clientmail') == 'No') selected="selected" @endif>No</option>
                                            </select>
                                            @if ($errors->has('clientmail'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('clientmail') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>
                                    
                                    <div class="col-lg-12 col-md-12 col-sm-12" id="poupload" <?php if($errors->has('po_pic')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                                        <label>Upload Purchase Order HERE</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event1" name="po_pic[]"  multiple="multiple">  
                                             @if ($errors->has('po_pic'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('po_pic') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12" id="mailupload" <?php if($errors->has('approval_mail')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                                        <label>Upload Client Approvel Mail HERE</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event" name="approval_mail" >  
                                             @if ($errors->has('approval_mail'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('approval_mail') }}</strong>
                                                </span>
                                            @endif 
                                        </div>                                         
                                    </div>

                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Payment terms as per contract with client</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="payment_terms" placeholder="Payment terms"  value="{{ old('payment_terms') }}">
                                            @if ($errors->has('payment_terms'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('payment_terms') }}</strong>
                                                </span>
                                            @endif 
                                        </div> 
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Budget Made By</label>
                                        <div class="input-group masked-input mb-3">                                           
                                            <select class="form-control show-tick ms select2" data-placeholder="Budget Created Employee" name="budgetmadeby">
                                                <option value="">Select Employee</option>
                                                @foreach($Users as $user)
                                                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('budgetmadeby'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('budgetmadeby') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Event Signed up</label>
                                        <div class="input-group masked-input mb-3">                                            
                                            <select class="form-control show-tick ms select2" data-placeholder="Event Signed up Employee" name="eventsignedup">
                                                <option value="">Select Employee</option>
                                                @foreach($Users as $user)
                                                <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('eventsignedup'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('eventsignedup') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="prodction_allw">
                                        <label>Resource Allocation (Production)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group masked-input mb-3">
                                                <select class="form-control show-tick ms select2" multiple name="production_employee[]" data-placeholder="Select Production Employees">
                                                    <option value="">Select Production Employees</option>
                                                    @foreach($Users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endforeach
                                                </select>
                                                 @if ($errors->has('production_employee'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('production_employee') }}</strong>
                                                    </span>
                                                @endif 
                                            </div>
                                        </div>                                        
                                    </div>
                                   <div class="col-lg-4 col-md-6 col-sm-12" id="creative_allw">
                                        <label>Resource Allocation (Creative - Internal)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group masked-input mb-3">                                                      
                                                <select class="form-control show-tick ms select2" multiple data-placeholder="Employee Name" name="creative_employee[]">
                                                    <option value="">Select Creative Employee</option>
                                                    @foreach($Users as $user)
                                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endforeach
                                                </select>                                                   
                                            </div> 
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="outsidecreative_allw">
                                        <label>Resource Allocation (Creative - Outside)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" name="outside_employee" id="profit_percentage" placeholder="Nameone, NameTwo" value="">
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-12" id="split_allw">
                                        <div class="row">
                                            <span class="col-lg-10 col-md-10 col-sm-10 field_wrapper">
                                                <div class="row">
                                                <div class="col-lg-9 col-md-9 col-sm-9">
                                                    <label>Event Sign up split</label>
                                                    <div class="input-group masked-input mb-3">                                                      
                                                        <select class="form-control show-tick ms select2" data-placeholder="Employee Name" name="split_name[]" required="required">
                                                            <option value="">Select Employee</option>
                                                            @foreach($Users as $user)
                                                            <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                                            @endforeach
                                                        </select>                                                                
                                                    </div> 

                                                </div> 
                                                <div class="col-lg-3 col-md-3 col-sm-3">    
                                                    <label style="margin-bottom: 1.6em"> </label>                                    
                                                    <input type="text" class="form-control" name="split_percentage[]" placeholder="%" required="required">                                                
                                                </div>
                                                </div>
                                            </span>
                                            <div class="col-lg-2 col-md-2 col-sm-2 mb-3">
                                                <label>Add</label>
                                                <div class="input-group masked-input">
                                                    <a href="javascript:void(0);" class="add_input_button" title="Add field"><button style="margin:0px" type="button" name="add" id="add" class="btn btn-success"><i class="zmdi zmdi-plus"></i></button></a>  
                                                </div>
                                            </div>  
                                        </div> 
                                    </div>
                                    
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>  
                                            </div>    
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                            </div>
                                        </div>                               
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2">
                </div>
            </div>
        </div>
    </div>
</section>


@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('user/js/pages/forms/advanced-form-elements.js')}}"></script> 
<script src="{{asset('user/plugins/select2/select2.min.js')}}"></script> <!-- Select2 Js -->

<script src="{{asset('user/pastimepicker/js/jquery.datetimepicker.js')}}"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
{!! Toastr::message() !!}

@include('user.scripts.scripts')

<script>
          $(function () {
                $('.datepicker1').datepicker({
                    autoclose: true,
                    minDate: -15,
                    orientation: "top right",
                    dateFormat: 'dd-mm-yy'
                });
            });
        </script>
<script type="text/javascript">
    var _token = $('input[name="_token"]').val();
    $(document).ready(function(){
        $('#budget_amount').keyup(function() {
            var estimate = $('#estimate_amount').val();

            if( estimate.length == 0)
            {
                alert("Please Fill The Estimate Amount Before Budget Amount");
            }
            else
            {
                var budget = $(this).val(); 
                $.ajax({
                    url:"{{ route('budget_amount') }}",
                    method:"POST",
                    dataType: "json",
                    data:{budget:budget,estimate:estimate, _token:_token},
                    success:function(data)
                    {         
                        $("#profit_amount").val(data.profit);    
                        $("#profit_percentage").val(data.percentage);    
                    }
                });
            }          
        });
    });
    
    $(document).ready(function(){
        $('#actual_budget_amount').keyup(function() {
            var estimate = $('#actual_estimate_amount').val();

            if( estimate.length == 0)
            {
                alert("Please Fill The Actual Estimate Amount Before Actual Budget Amount");
            }
            else
            {
                var budget = $('#actual_budget_amount').val(); 
                $.ajax({
                    url:"{{ route('budget_amount') }}",
                    method:"POST",
                    dataType: "json",
                    data:{budget:budget,estimate:estimate, _token:_token},
                    success:function(data)
                    {         
                        $("#actual_profit_amount").val(data.profit);    
                        $("#actual_profit_percentage").val(data.percentage);    
                    }
                });
            }          
        });
    });
    
      $(document).ready(function(){
        $('#payment_budget_amount').keyup(function() {
            var estimate = $('#payment_estimate_amount').val();

            if( estimate.length == 0)
            {
                alert("Please Fill The Payment Pass Through Estimate Amount Before Budget Amount");
            }
            else
            {
                var budget = $('#payment_budget_amount').val(); 
                $.ajax({
                    url:"{{ route('budget_amount') }}",
                    method:"POST",
                    dataType: "json",
                    data:{budget:budget,estimate:estimate, _token:_token},
                    success:function(data)
                    {         
                        $("#payment_profit_amount").val(data.profit);    
                        $("#payment_profit_percentage").val(data.percentage);    
                    }
                });
            }          
        });
    });


     $(document).ready(function(){
        var max_fields = 10;
        var add_input_button = $('.add_input_button');
        var field_wrapper = $('.field_wrapper');  
        var new_field_html = '<div class="row"> <div class="col-lg-8 col-md-8 col-sm-8">  <div class="input-group masked-input mb-3"> <select class="form-control show-tick" data-placeholder="Employee Name" name="split_name[]" required="required">  <option value="">Select Employee</option> @foreach($Users as $user) <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option> @endforeach </select>  </div> </div> <div class="col-lg-2 col-md-2 col-sm-2" style="padding:0px">  <input type="text" class="form-control" name="split_percentage[]" placeholder="%" required="required"> </div> <a href="javascript:void(0);" class="remove_input_button" title="Remove field"><button type="button" name="remove" id="remove" class="btn btn-danger" style="margin: 0px 6px;"><i class="zmdi zmdi-close"></i></button></a>  </div> ';
        var input_count = 1;
        // Add button dynamically
        $(add_input_button).click(function(){
            if(input_count < max_fields){
                input_count++;
                $(field_wrapper).append(new_field_html);
            }
        });
        // Remove dynamically added button
        $(field_wrapper).on('click', '.remove_input_button', function(e){
        e.preventDefault();
            $(this).parent('div').remove();
                input_count--;
        });
    });


    $(document).ready(function(){
        $('#po').on('change', function() {
          if ( this.value == 'Yes')
          {
            $("#poupload").show();
          }
          else
          {
            $("#poupload").hide();
          }
        });
    });
    $(document).ready(function(){
        $('#clientmail').on('change', function() {
          if ( this.value == 'Yes')
          {
            $("#mailupload").show();
          }
          else
          {
            $("#mailupload").hide();
          }
        });
    });
    $(document).ready(function(){
        $('#advancestatus').on('change', function() {
          if ( this.value == 'yes')
          {
            $("#advancedate").show();
            $("#advanceammount").show();
          }
          else
          {
            $("#advancedate").hide();
            $("#advanceammount").hide();
          }
        });
    });
  
    $(function () {
        $('#eventstartdate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });
    
    $(function () {
        $('#eventenddate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });

    $(function () {
        $('#eventbilldate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });

    $(function () {
        $('#adavanceammountdate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });

    $('.datepicker').bootstrapMaterialDatePicker({minDate : new Date(),time: false });

    $("#add_meeting").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit


    $("input[type='radio']").change(function(){
        if($(this).val()=="exist")
        {
            $("#exist_div").show();
            $("#new_div").hide(); 
            $("#new_company_name").val("");
        }
        else
        {
            $("#new_div").show(); 
            $("#exist_div").hide();
            $("#exist_company_name").val("");
        }
    });

    $(document).ready(function(){
        $('#exist_company_name').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                  url:"{{route('business_company_list')}}",
                  method:"POST",
                  data:{query:query, _token:_token},
                  success:function(data)
                  {                             
                    $('#companyList').fadeIn();
                    $('#companyList').html(data);
                  }
                })
            }else{
                $('#companyList').hide();          
            }
        });
    });

    $(document).on('click','ul.businesscompanylist li', function(){
        $('#exist_company_name').val($(this).text());
        $('#companyList').hide();      
    });
    
   $('#event').on('change', function() {
        if($(this).val()=="event")
        {
            $("#creative_cost").show();
            $("#prodction_allw").show();
            $("#creative_allw").show();
            $("#outsidecreative_allw").show();
            $("#split_allw").show();

            $("#Estimate_Amount").show();
            $("#Budget_Amount").show();
            $("#Profit_Amount").show();
            $("#Profit_Percentage").show();

            $("#Actual_Estimate_Amount").show();
            $("#Actual_Budget_Amount").show();
            $("#Actual_Profit_Amount").show();
            $("#Actual_Profit_Percentage").show();

            $("#p_estimate_amount").hide();
            $("#p_budget_amount").hide();
            $("#p_profit_amount").hide();
            $("#p_profit_percentage").hide();
        }
        else if(this.value == 'payment'){
            $("#creative_cost").hide();
            $("#prodction_allw").hide();
            $("#creative_allw").hide();
            $("#outsidecreative_allw").hide();
            // $("#split_allw").hide();

            $("#Estimate_Amount").hide();
            $("#Budget_Amount").hide();
            $("#Profit_Amount").hide();
            $("#Profit_Percentage").hide();

            $("#Actual_Estimate_Amount").hide();
            $("#Actual_Budget_Amount").hide();
            $("#Actual_Profit_Amount").hide();
            $("#Actual_Profit_Percentage").hide();

            $("#p_estimate_amount").show();
            $("#p_budget_amount").show();
            $("#p_profit_amount").show();
            $("#p_profit_percentage").show();
        }       
    });
</script>

</body>

@endsection
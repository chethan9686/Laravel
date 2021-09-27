@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>HRM | Business Additional Signup</title>

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
                    <h2> Additional Signup</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item"><a href="#">Signup</a></li>
                        <li class="breadcrumb-item active">Additional Signup</li>
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
                    <!--<h3>This site is under maintenance. please check back again soon!</h3>-->
                        <div class="header">
                            <h2><strong>Additional Signup Form</strong></h2>
                        </div>                      
                        <div class="body">                             
                            <form method="post" action="{{route('submit_additional_signup')}}" id="add_meeting" enctype="multipart/form-data" autocomplete="off">
                               @csrf
                               <input type="hidden" name="signup_id" id="signup_id" value="">
                                <div class="row">                        
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Enter BS number</label>
                                        <div class="input-group masked-input">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-id-card" aria-hidden="true"></i></span>
                                            </div>
                                           <input type="text" class="form-control" name="bs_number" id="bs_number" placeholder="Search BS Number">                                        
                                        </div>  
                                        @if ($errors->has('bs_number'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('bs_number') }}</strong>
                                            </span>
                                        @endif  
                                        <div id="bsnumberList" style="margin-top: -50px;"></div>
                                    </div> 
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Company Name</label>
                                        <div class="input-group masked-input">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                            </div>
                                           <input type="text" class="form-control" id="company_name" placeholder="Enter Company Name" value="" readonly>
                                        </div>    
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12 client">
                                        <label>Client/User Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_name" id="client_name" placeholder="Client Name" value="" readonly="readonly">
                                           
                                        </div>                                      
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Client Email</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_email" id="client_email" placeholder="Client Email" value="" readonly="readonly">
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Client Mobile Number</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="client_mobile" id="client_mobile" placeholder="Mobile Number" value="" readonly="readonly">
                                        </div>                                      
                                    </div>
                                     <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Event Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-view-carousel"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Event Name" value="" readonly="readonly">
                                        </div>                                      
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label>Event Signed in (City)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-city-alt"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="city_signedup" id="city_signedup" placeholder="City Name" value="" readonly="readonly">
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
                                    
                                    <div class="col-lg-4 col-md-6 col-sm-12">
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
                                            <input type="text" class="form-control" name="estimate_amount" id="estimate_amount" placeholder="Estimate Amount" value="">
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
                                     <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Estimate_Amount" >
                                        <label>Actual Estimate Amount(without GST)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_estimate_amount" id="actual_estimate_amount" placeholder="Actual Estimate Amount" value="{{ old('actual_estimate_amount') }}">
                                        </div>                                        
                                    </div>  
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Budget_Amount" >
                                        <label>Actual Budget Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_budget_amount" id="actual_budget_amount" placeholder="Actual Budget Amount" value="{{ old('actual_budget_amount') }}">                        
                                        </div>                                        
                                    </div>       
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Profit_Amount" >
                                        <label>Actual Profit Amount</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_profit_amount" id="actual_profit_amount" placeholder="Actual Profit Amount" value="{{ old('actual_profit_amount') }}" readonly>                    
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12" id="Actual_Profit_Percentage">
                                        <label>Actual Profit %</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>
                                            </div>
                                            <input type="text" class="form-control" name="actual_profit_percentage" id="actual_profit_percentage" placeholder="Actual Profit %" value="{{ old('actual_profit_percentage') }}" readonly>                 
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

                                    <div class="col-lg-12 col-md-12 col-sm-12" id="poupload" <?php if($errors->has('po_pic')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                                        <label>Upload Purchase Order HERE</label>
                                        <div class="input-group masked-input mb-3">
                                            <input type="file" id="dropify-event1" name="po_pic[]"  multiple="multiple">  
                                        </div>     
                                        @if ($errors->has('po_pic'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('po_pic') }}</strong>
                                            </span>
                                        @endif                                   
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
                                   
                                    <div class="col-lg-12 col-md-12 col-sm-12" id="mailupload" <?php if($errors->has('approval_mail')) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                                        <label>Upload Client Approvel Mail HERE</label>
                                        <div class="input-group masked-input mb-3">
                                            <input type="file" id="dropify-event" name="approval_mail" >  
                                        </div>         
                                        @if ($errors->has('approval_mail'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('approval_mail') }}</strong>
                                            </span>
                                        @endif                                
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
{!! Toastr::message() !!}

@include('user.scripts.scripts')

<script type="text/javascript">
$(function () {
        $('#adavanceammountdate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });
    
    var _token = $('input[name="_token"]').val();
    $(document).ready(function(){
        $('#bs_number').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                  url:"{{route('bsnumber_list')}}",
                  method:"POST",
                  data:{query:query, _token:_token},
                  success:function(data)
                  {                      
                    $('#bsnumberList').fadeIn();
                    $('#bsnumberList').html(data);
                  }
                })
            }else{
                $('#bsnumberList').hide();          
            }
        });
    });

    $(document).on('click','ul.bsnumberList li', function(e){
        e.preventDefault();
        $('#bs_number').val($(this).text());
        $('#bsnumberList').hide();  
        var bs_number = $(this).text();        
        $.ajax({            
            url:"{{ route('fetch_bs_data') }}",
            method:"POST",
            dataType: "json",
            data:{bs_number:bs_number, _token:_token},
            success:function(data)
            {        
                $("#company_name").val(data.company_name); 
                $("#client_name").val(data.client_name);    
                $("#client_email").val(data.client_email);
                $("#client_mobile").val(data.client_mobile);    
                $("#event_name").val(data.event_name);   
                $("#city_signedup").val(data.event_city);   
                $('#signup_id').val(data.signup_id);              
            }
        });             
    });

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
 
    $("#add_meeting").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit

   $("input[type='radio']").change(function(){
        if($(this).val()=="event")
        {           

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
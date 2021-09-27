@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">

<title>Business Management | Billing Information</title>

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
                    <h2> Signup - Billing Information</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Business Management</a></li>
                        <li class="breadcrumb-item"><a href="#">Signup</a></li>
                        <li class="breadcrumb-item active">Billing Info</li>
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
                <div class="col-sm-1 col-md-1 col-lg-1">
                </div>
                <div class="col-sm-10 col-md-10 col-lg-10">
                    <div class="card">  
                        <div class="header">
                            <h2><strong>Billing Information Form</strong></h2>
                        </div>                      
                        <div class="body">  
                            <form method="post" action="{{route('billinginfocreate')}}" id="add_meeting" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                               <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Budget Sheet Number (B.S No)</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <input type="hidden" name="billing_id" value="{{$billing->id}}">                                           
                                            <input type="text" class="form-control" name="bs_number" placeholder="B.S No" value="{{$billing->bs_number}}" readonly="readonly">      
                                            @if ($errors->has('bs_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bs_number') }}</strong>
                                                </span>
                                            @endif    
                                        </div>                                       
                                    </div>
                                   
                                    @if(is_null($signup->purchase_file))
                                    <div class="col-lg-4 col-md-4 col-sm-12">                                       
                                        <label>Upload PO</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event" name="purchase_file[]"  multiple="multiple"> 
                                            @if ($errors->has('purchase_file'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('purchase_file') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    @endif

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label>Alternate address for delivery of invoice</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <textarea class="form-control" name="po_address" id="po_address" rows="9" cols="50" placeholder="Type Altenate TO address for PO">{{ old('po_address') }}</textarea>
                                            @if ($errors->has('po_address'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('po_address') }}</strong>
                                                </span>
                                            @endif                                             
                                        </div>                                       
                                    </div>
                                    
                                    @if(is_null($signup->client_approval_file))
                                    <div class="col-lg-4 col-md-4 col-sm-12">                                       
                                        <label>Upload Client Approval Mail</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event1" name="client_approval_file" > 
                                            @if ($errors->has('client_approval_file'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client_approval_file') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>                                 
                                    @endif

                                    <div class="col-lg-4 col-md-4 col-sm-12">                                       
                                        <label>Upload Final Estimate invoice Excel Sheet</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event3" name="final_invoice_file"> 
                                            @if ($errors->has('final_invoice_file'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('final_invoice_file') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <label for="email_address">Company Type</label>
                                        <div class="form-group gender-bottom"> 
                                            <div class="radio inlineblock m-r-20">                                                                    
                                                <input type="radio" name="company_status" id="exist" class="with-gap" value="exist" @if (old('company_status') == 'exist') checked @endif>
                                                <label for="exist"><i class="zmdi zmdi-case-check"></i> Exist</label>
                                                <input type="radio" name="company_status" id="new" class="with-gap" value="new" @if (old('company_status') == 'new') checked @endif>
                                                <label for="new"><i class="zmdi zmdi-case"></i> New</label>
                                                @if ($errors->has('company_status'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('company_status') }}</strong>
                                                    </span>
                                                @endif 
                                            </div>   
                                        </div>  
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-12"  id="Certificate" <?php if($errors->has('gst_certificate')) {?> style="display: block;"<?php }else{?> style="display: none" <?php }?> >                                       
                                        <label>Please Upload Company GST Certificate</label>
                                        <div class="input-group masked-input mb-3"> 
                                            <input type="file" id="dropify-event4" name="gst_certificate"> 
                                            @if ($errors->has('gst_certificate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('gst_certificate') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label>Comment Box</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <textarea class="form-control" name="single_separate_billing" id="single_separate_billing" rows="9" cols="50" placeholder="Type Comment for single billing or separate billing for additional">{{ old('single_separate_billing') }}</textarea>                    
                                        </div>                                       
                                    </div>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                            </div>
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                                <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>  
                                            </div>    
                                            <div class="col-lg-4 col-md-4 col-sm-12">
                                            </div>
                                        </div>                               
                                    </div>
                                <div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1 col-md-1 col-lg-1">
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
     $("input[type='radio']").change(function(){
        if($(this).val()=="new")
        {
            $("#Certificate").show();
        }
        else
        {
            
            $("#Certificate").hide();
        }
    });

</script>

</body>

@endsection
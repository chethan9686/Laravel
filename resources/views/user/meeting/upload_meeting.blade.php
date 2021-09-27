
@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title> HRM | Send MOM</title>

@include('user.layouts.css')

<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('user/plugins/summernote/dist/summernote.css')}}"/>

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
                    <h2>Send MOM</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Meeting</li>
                        <li class="breadcrumb-item active">Send MOM</li>
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
                <div class="col-sm-12">
                    <div class="card">                        
                        <div class="body">                          
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3 nav-tabs-warning" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#completed"> <i class="zmdi zmdi-assignment-check"></i> Completed</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#postpone"> <i class="zmdi zmdi-rotate-right"></i> Postponed</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#cancel"><i class="zmdi zmdi-calendar-close"></i> Canceled </a></li>   
                            </ul>

                            @include('user.error.error')                          
                            
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="completed">
                                    <div class="container-fluid">
                                        <div class="row clearfix">                                 
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">
                                                <div class="header mb-3">
                                                    <h2><strong>Completed Meeting</strong> Details</h2>
                                                </div>                                                
                                                <form method="post" action="{{route('submit_meeting')}}" id="submit_meeting">
                                                @csrf
                                                <input type="hidden" name="meeting_status" value="Completed">
                                                <input type="hidden" name="mom_id" value="{{$EncryptedID}}">
                                                <input type="hidden" name="parent_mom" value="{{$parent_id}}">
                                                    <div class="row">                                                       
                                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                                            <label>Company Name</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="company_name" placeholder="Enter Company Name" value="{{$Details->company_name}}" readonly autocomplete="off"> 
                                                                @if ($errors->has('company_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('company_name') }}</strong>
                                                                </span>
                                                                @endif 
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                                            <label for="email_address">Client Status</label>
                                                            <div class="form-group gender-bottom"> 
                                                                <div class="radio inlineblock m-r-20">                                                                    
                                                                    <input type="radio" name="client_status" id="exist" class="with-gap" value="exist" checked >
                                                                    <label for="exist"><i class="zmdi zmdi-star-circle"></i> Exist</label>
                                                                    <input type="radio" name="client_status" id="new" class="with-gap" value="new">
                                                                    <label for="new"><i class="zmdi zmdi-plus-circle"></i> New</label>
                                                                    @if ($errors->has('client_status'))
                                                                    <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('client_status') }}</strong>
                                                                    </span>
                                                                    @endif  
                                                                </div>   
                                                            </div>  
                                                        </div>
                                                    </div>
                                                    <div class="row exist">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                                <label>Client Name</label>
                                                                <div class="input-group masked-input">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="exist_company_name" id="exist_company_name" placeholder="Client Name" value="{{$Details->client_name}}" autocomplete="off">    
                                                                </div>                                               
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                                <label>Client Email</label>
                                                                <div class="input-group masked-input">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="exist_company_email" id="exist_company_email" placeholder="Client Email" value="{{$Details->client_email}}" autocomplete="off">
                                                                </div>                                               
                                                            </div>
                                                    </div>
                                                    <div class="row alternate" style="display: none;">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                                <label>Alternate Name</label>
                                                                <div class="input-group masked-input">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="alt_company_name" id="alt_company_name" placeholder="Alternate Name" autocomplete="off">                   
                                                                </div>                                               
                                                            </div>
                                                            <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                                <label>Alternate Email</label>
                                                                <div class="input-group masked-input">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" name="alt_company_email" id="alt_company_email" placeholder="Alternate Email" autocomplete="off">                   
                                                                </div>                                               
                                                            </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Date Of Meeting</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="date" placeholder="Date Of Meeting" value="{{$Details->date}}" readonly autocomplete="off">   
                                                                @if ($errors->has('date'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('date') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Time Of Meeting</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="time" placeholder="Time Of Meeting" value="{{$Details->time}}" readonly autocomplete="off"> 
                                                                @if ($errors->has('time'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('time') }}</strong>
                                                                </span>
                                                                @endif                  
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Location Of Meeting</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="location" placeholder="Location Of Meeting" value="{{$Details->location}}" readonly autocomplete="off">    
                                                                @if ($errors->has('location'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('location') }}</strong>
                                                                </span>
                                                                @endif                   
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Total No Of Persons Involved In Meeting</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-accounts-add"></i></span>
                                                                </div>
                                                                <input type="number" class="form-control" name="person_involved" placeholder="Ex :2" autocomplete="off">   
                                                                @if ($errors->has('person_involved'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('person_involved') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10  bcc_field_wrapper" >
                                                                    <label>BCC Email ID</label>
                                                                    <div class="input-group masked-input mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                       <input type="text" class="form-control" name="bcc_email[]" placeholder="BCC Email ID" autocomplete="off">                   
                                                                    </div> 
                                                                </div> 
                                                                <div class="col-lg-2 col-md-2 col-sm-2 mb-3" >
                                                                    <label>Add</label>
                                                                    <div class="input-group masked-input">
                                                                        <a href="javascript:void(0);" class="bcc_add_input_button" title="Add field"><button style="margin:0px" type="button" name="bcc_add" id="bcc_add" class="btn btn-success"><i class="zmdi zmdi-plus"></i></button></a>  
                                                                    </div>
                                                                </div>  
                                                            </div> 
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-6 mb-3">
                                                            <div class="row">
                                                                <div class="col-lg-10 col-md-10 col-sm-10  field_wrapper">
                                                                    <label>Additional CC Email ID</label>
                                                                    <div class="input-group masked-input mb-3">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                       <input type="text" class="form-control" name="additional_email[]" placeholder="Additional CC Email ID" autocomplete="off">                   
                                                                    </div> 
                                                                </div> 
                                                                <div class="col-lg-2 col-md-2 col-sm-2 mb-3">
                                                                    <label>Add</label>
                                                                    <div class="input-group masked-input">
                                                                        <a href="javascript:void(0);" class="add_input_button" title="Add field"><button style="margin:0px" type="button" name="add" id="add" class="btn btn-success"><i class="zmdi zmdi-plus"></i></button></a>  
                                                                    </div>
                                                                </div>  
                                                            </div>                                         
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>From The Client</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-accounts"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="from_client" placeholder="Ex:Client1,Client2" autocomplete="off">    
                                                                @if ($errors->has('from_client'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('from_client') }}</strong>
                                                                </span>
                                                                @endif               
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>From The Agency</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-airline-seat-recline-normal"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="from_agency" placeholder="From The Agency" value="{{$data}}" readonly autocomplete="off">   
                                                                @if ($errors->has('from_agency'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('from_agency') }}</strong>
                                                                </span>
                                                                @endif                     
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                            <label>Key Points</label>
                                                            <div class="input-group masked-input">
                                                                <textarea class="form-control summernote"  name="key_points" placeholder="Key Points" autocomplete="off"></textarea> 
                                                                @if ($errors->has('key_points'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('key_points') }}</strong>
                                                                </span>
                                                                @endif                   
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Mobile Number</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-smartphone-iphone"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="mobile" placeholder="Mobile Number" <?php if(!is_null($exist)) {?> value="{{$exist->mobile}}" readonly <?php }?> autocomplete="off">  
                                                                @if ($errors->has('mobile'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('mobile') }}</strong>
                                                                </span>
                                                                @endif                  
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 mb-3">
                                                            <label>Landline Number</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-phone-ring"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="landline" placeholder="Landline Number" <?php if(!is_null($exist)) {?> value="{{$exist->landline}}" readonly <?php }?> autocomplete="off" >
                                                                @if ($errors->has('landline'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('landline') }}</strong>
                                                                </span>
                                                                @endif                   
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>Address Line 1</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="address_1" placeholder="Address Line 1"  <?php if(!is_null($exist)) {?> value="{{$exist->address_1}}" readonly <?php }?>autocomplete="off" > 
                                                                @if ($errors->has('address_1'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('address_1') }}</strong>
                                                                </span>
                                                                @endif                   
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>Address Line 2</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="address_2" placeholder="Address Line 2" <?php if(!is_null($exist)) {?> value="{{$exist->address_2}}" readonly <?php }?> autocomplete="off">    
                                                                @if ($errors->has('address_2'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('address_2') }}</strong>
                                                                </span>
                                                                @endif                
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>Address Line 3</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="address_3" placeholder="Address Line 3" <?php if(!is_null($exist)) {?> value="{{$exist->address_3}}" readonly <?php }?> autocomplete="off">   
                                                                @if ($errors->has('address_3'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('address_3') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>State</label>
                                                            <div class="input-group masked-input">
                                                                <select class="form-control" name="state" autocomplete="off">
                                                                    <option value="">Please Select State</option>                                                                                        
                                                                    @foreach($States as $state)   
                                                                        <?php if(!is_null($exist)) {?>   
                                                                            @if($exist->state == $state->id)
                                                                                <option value="{{$state->id}}" selected>{{$state->state_name}}</option>                                                
                                                                            @endif  
                                                                        <?php }else { ?>                                                                  
                                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>    
                                                                        <?php }?>                                                     
                                                                    @endforeach
                                                                </select>  
                                                                @if ($errors->has('state'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('state') }}</strong>
                                                                </span>
                                                                @endif                  
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>City</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-city"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="city" placeholder="City" <?php if(!is_null($exist)) {?> value="{{$exist->city}}" readonly <?php }?> autocomplete="off">  
                                                                @if ($errors->has('city'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('city') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-12 mb-3">
                                                            <label>Zip Code</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-home"></i></span>
                                                                </div>
                                                                <input type="text" class="form-control" name="zip_code" placeholder="Zip Code" <?php if(!is_null($exist)) {?> value="{{$exist->zipcode}}" readonly <?php }?> autocomplete="off">   
                                                                @if ($errors->has('zip_code'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('zip_code') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">SUBMIT</button>   
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                    </div>
                                                </form>                                                          
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                                                       
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="postpone">                                     
                                    <div class="container-fluid">
                                        <div class="row clearfix"> 
                                            <div class="col-lg-1 col-md-1" >                                                     
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">
                                                <div class="header mb-3">
                                                    <h2><strong>Postponed Meeting</strong> Details</h2>
                                                </div> 
                                                <form method="post" action="{{route('submit_meeting')}}" id="submit_meeting">
                                                @csrf
                                                <input type="hidden" name="meeting_status" value="Postponed">
                                                <input type="hidden" name="mom_id" value="{{$EncryptedID}}">
                                                <input type="hidden" name="parent_mom" value="{{$parent_id}}">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                            <label>Reason For Postponed</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                                                                </div>
                                                                <textarea class="form-control" rows="3" name="postpone" placeholder="Reason For Postponed" autocomplete="off"></textarea>   
                                                                @if ($errors->has('postpone'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('postpone') }}</strong>
                                                                </span>
                                                                @endif                 
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">SUBMIT</button>   
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                    </div>
                                                </form>                                                
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="cancel"> 
                                    <div class="container-fluid">
                                        <div class="row clearfix"> 
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">
                                                <div class="header mb-3">
                                                    <h2><strong>Canceled Meeting</strong> Details</h2>
                                                </div>    
                                                <form method="post" action="{{route('submit_meeting')}}" id="submit_meeting">
                                                @csrf
                                                <input type="hidden" name="meeting_status" value="Canceled">
                                                <input type="hidden" name="mom_id" value="{{$EncryptedID}}">
                                                <input type="hidden" name="parent_mom" value="{{$parent_id}}">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                                                            <label>Reason For Canceled</label>
                                                            <div class="input-group masked-input">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                                                                </div>
                                                                <textarea class="form-control" rows="3" name="cancel" placeholder="Reason For Canceled" autocomplete="off"></textarea>  
                                                                @if ($errors->has('cancel'))
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $errors->first('cancel') }}</strong>
                                                                </span>
                                                                @endif                  
                                                            </div>                                               
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                            <button type="submit" class="btn btn-primary waves-effect waves-light btn-block">SUBMIT</button>   
                                                        </div>
                                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                                        </div>
                                                    </div>
                                                </form>                                               
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>                             
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@include('user.layouts.js')

<script src="{{asset('user/plugins/summernote/dist/summernote.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

{!! Toastr::message() !!}

<script type="text/javascript">   

    $("#submit_meeting").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit

    $("input[type='radio']").change(function(){
        var c_name = "<?php echo($Details->client_name) ?>";
        var c_email = "<?php echo($Details->client_email) ?>";       

        if($(this).val()=="exist")
        {
          $(".exist").show();
          $("#exist_company_name").val(c_name);
          $("#exist_company_email").val(c_email);
          $(".alternate").hide(); 
          $("#alt_company_name").val("");
          $("#alt_company_email").val("");
        }
        else
        {
          $(".exist").hide();
          $("#exist_company_name").val("");
          $("#exist_company_email").val("");
          $(".alternate").show();
        }
    });

    $('.summernote').summernote({
        height: 120,   
        width:1500,
        toolbar: [   
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['fontname', ['fontname']]
        ],
        fontSizes: ['16'],
        fontNames: ['Arial'
        ],
        placeholder: 'Key Points / Discussion Details',    
    });
$('.summernote').css('font-size','16px');

    $(document).ready(function(){
        var max_fields = 10;
        var add_input_button = $('.add_input_button');
        var field_wrapper = $('.field_wrapper');  
        var new_field_html = '<div class="input-group masked-input mb-3"> <div class="input-group-prepend"> <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span> </div> <input type="text" class="form-control" name="additional_email[]" placeholder="Additional Client Email" style="height: calc(2.5em + .75rem + 2px);">  <a href="javascript:void(0);" class="remove_input_button" title="Remove field"><button type="button" name="remove" id="remove" class="btn btn-danger" style="margin: 8px 10px;"><i class="zmdi zmdi-close"></i></button></a>  </div> ';
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
        var max_fields = 10;
        var add_input_button = $('.bcc_add_input_button');
        var field_wrapper = $('.bcc_field_wrapper');  
        var new_field_html = '<div class="input-group masked-input mb-3"><div class="input-group-prepend"><span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span></div> <input type="text" class="form-control" name="bcc_email[]" placeholder="BCC Client Email ID" style="height: calc(2.5em + .75rem + 2px);">  <a href="javascript:void(0);" class="bcc_remove_input_button" title="Remove field"><button type="button" name="remove" id="remove" class="btn btn-danger" style="margin: 8px 10px;"><i class="zmdi zmdi-close"></i></button></a> </div>';
        var input_count = 1;
        // Add button dynamically
        $(add_input_button).click(function(){
            if(input_count < max_fields){
                input_count++;
                $(field_wrapper).append(new_field_html);
            }
        });
        // Remove dynamically added button
        $(field_wrapper).on('click', '.bcc_remove_input_button', function(e){
        e.preventDefault();
            $(this).parent('div').remove();
                input_count--;
        });
    });
</script>
<script>$("li").removeAttr("style")</script>
<script>$("ul").removeAttr("style")</script>
<script>$("ul li span").removeAttr("style")</script>
</body>

@endsection
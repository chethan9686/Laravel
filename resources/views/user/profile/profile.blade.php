@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title> Employee | Profile</title>

@include('user.layouts.css')

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">

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
                    <h2>Employee Profile</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Profile</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                    
                </div>
            </div>
        </div> 
        <div class="container-fluid">
            @if($user_details->tl == '0' && $user_details->rm == '0' && $user_details->rh == '0' && is_null($user_details->emp_id))
                 <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="card">                        
                            <div class="body">  
                                <h3 style="text-align: center"><strong>PLease Inform HR Or Admin To Assign Team Lead, Reporting Manager, Regional Head and Employee ID</strong></h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
            <!-- Tabs With Icon Title -->
                <div class="row clearfix">
                    <div class="col-sm-12">
                        <div class="card">                        
                            <div class="body">                          
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#basic_details"> <i class="zmdi zmdi-accounts-list"></i> Basic Details </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pass_details"> <i class="zmdi zmdi-balance"></i> Passport & Bank Details</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#pf"><i class="zmdi zmdi-receipt"></i> P F Form </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#academics"><i class="zmdi zmdi-graduation-cap"></i> Academics Details </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#documents"><i class="zmdi zmdi-file"></i> Documents </a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#others"><i class="zmdi zmdi-memory"></i> Other Details </a></li>
                                </ul>

                                @include('user.error.error')                          
                                
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane in active" id="basic_details">
                                        <div class="container-fluid">
                                            <div class="row clearfix">                                 
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                                   
                                                <div class="col-lg-10 col-md-10">                                               
                                                    <form method="post" action="{{route('update_basic_details')}}" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="header">
                                                            <h2 class="text-center"><strong>Basic</strong> Details</h2>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Team Lead</label>
                                                                <div class="form-group">                                                   
                                                                   <select class="form-control show-tick" data-placeholder="Select" name="team_lead">                              
                                                                        @foreach($tls as $tl)
                                                                            @if($tl->id == $user_details->tl)                                                                               
                                                                                <option value="{{$tl->id}}" selected>{{$tl->first_name}} {{$tl->last_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>                                                                                                
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Reporting Manager</label>
                                                                <div class="form-group">                                                       
                                                                    <select class="form-control show-tick" data-placeholder="Select" name="reporting_manager">                   
                                                                        @foreach($rms as $rm)
                                                                            @if($rm->id == $user_details->rm)                                                                                
                                                                                <option value="{{$rm->id}}" selected>{{$rm->first_name}} {{$rm->last_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>  
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Regional Head</label>
                                                                <div class="form-group">                                                       
                                                                    <select class="form-control show-tick" data-placeholder="Select" name="regional_head">                     
                                                                        @foreach($rhs as $rh)
                                                                            @if($rh->id == $user_details->rh)                                                                               
                                                                                <option value="{{$rh->id}}" selected>{{$rh->first_name}} {{$rh->last_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>    
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <label for="email_address">Profile Picture</label>
                                                                    <div class="form-group">                                                       
                                                                        <input type="file" id="dropify-event" data-default-file="{{asset('public/'.$user_details->profile_picture)}}" name="profile_pic" value="{{asset($user_details->profile_picture)}}">
                                                                    </div>

                                                                    <label for="email_address">Employee ID</label>
                                                                    <div class="form-group">                                
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Employee ID" name="emp_id" value="{{$user_details->emp_id}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">First Name</label>
                                                                    <div class="form-group">                                
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="First Name" value="{{$user->first_name}}" name="f_name">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Gender</label>
                                                                    <div class="form-group gender-bottom"> 
                                                                        <div class="radio inlineblock m-r-20">                                                                    
                                                                            <input type="radio" name="gender" id="male" class="with-gap" value="M" {{ $user->gender == 'M' ? 'checked' : ''}}>
                                                                            <label for="male"><i class="zmdi zmdi-male"></i> Male</label>
                                                                            <input type="radio" name="gender" id="Female" class="with-gap" value="F" {{ $user->gender == 'F' ? 'checked' : ''}}>
                                                                            <label for="Female"><i class="zmdi zmdi-female"></i> Female</label>
                                                                        </div>   
                                                                    </div>                             
                                                                 

                                                                    <label for="email_address">Date Of Birth</label>
                                                                    <div class="form-group">                            
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datepicker" placeholder="Please choose date" name="dob" value="{{$dob_date}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Emergency Mobile/Phone Number</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Emergency Mobile/Phone Number" name="emrg_phone" value="{{$user_details->emergency_phone}}">
                                                                        </div>
                                                                    </div>
                                                        

                                                                    <label for="email_address">Father Name</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-male"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Father Name" name="father_name" value="{{$user_details->father_name}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Occupation</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-accounts-list"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Occupation" name="occupation" value="{{$user_details->occupation}}">
                                                                        </div>
                                                                    </div>

                                                                                                                                  
                                                                    <div class="marriage_date" style="display: none">
                                                                        <label for="email_address">Spouse Name</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-female"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Spouse Name" name="spouse_name" value="{{$user_details->spouse_name}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <label for="email_address">Designation</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-format-color-fill"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Designation" name="designation" value="{{$user_details->designation}}" readonly>
                                                                        </div>
                                                                    </div>

                                                                   
                                                                    <label for="email_address">Work Location</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-google-maps"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Location" name="location" value="{{$user_details->work_location}}">
                                                                        </div>
                                                                    </div>

                                                                  
                                                                    <label for="email_address">Local Address</label>
                                                                    <div class="form-group">                                
                                                                       <div class="form-line">
                                                                            <textarea rows="4" class="form-control no-resize" name="local_addr" placeholder="Please type what you want...">{{$user_details->local_addr}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                            </div>  
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="card">
                                                                    <label for="email_address">Signature</label>
                                                                    <div class="form-group">                                                       
                                                                        <input type="file" id="dropify-event1" data-default-file="{{asset('public/'.$user_details->signature)}}" name="signature" value="{{asset($user_details->signature)}}">
                                                                    </div>

                                                                    <label for="email_address">Reference Employee ID</label>
                                                                    <div class="form-group">                                
                                                                       <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Reference Employee ID" name="ref_emp_id" value="{{$user_details->ref_emp_id}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Last Name</label>
                                                                   <div class="form-group">                                
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-account"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Last Name" value="{{$user->last_name}}" name="l_name">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Mobile Number</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Mobile Number" name="phone" value="{{$user->phone}}">
                                                                        </div>
                                                                    </div>  

                                                                    <label for="email_address">Date Of Joining</label>
                                                                    <div class="form-group">                            
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control datepicker" placeholder="Please choose date " name="doj" value="{{$doj_date}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Business Mobile Number</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Business Mobile Number" name="buss_phone" value="{{$user_details->business_phone}}">
                                                                        </div>
                                                                    </div>

                                                                    <label for="email_address">Mother Name</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-female"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Mother Name" name="mother_name"  value="{{$user_details->mother_name}}">
                                                                        </div>
                                                                    </div>                                                                                                                

                                                                    <label for="email_address">Marital Status</label>
                                                                    <div class="form-group">                                                       
                                                                        <select class="form-control show-tick marital_status" data-placeholder="Select" name="marital_status">        
                                                                            @if($user_details->marital_status == "Single")
                                                                            <option value="{{ $user_details->martial_status }}" selected>{{ $user_details->marital_status }}</option>
                                                                            <option value="Married">Married</option>  
                                                                            @elseif($user_details->marital_status == "Married")
                                                                            <option value="{{ $user_details->martial_status }}" selected>{{ $user_details->marital_status }}</option>
                                                                            <option value="Single">Single</option> 
                                                                            @else
                                                                            <option value="">Please select option</option> 
                                                                            <option value="Single">Single</option>   
                                                                            <option value="Married">Married</option>                                                                    
                                                                            @endif                                        
                                                                        </select>     
                                                                    </div>

                                                                    
                                                                    <div class="marriage_date"  style="display: none">
                                                                        <label for="email_address">Marriage Date</label>
                                                                        <div class="form-group">                            
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control datepicker" placeholder="Please choose date" name="marriage_date" value="{{$marriage_date}}">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                  

                                                                    <label for="email_address">Department</label>
                                                                    <div class="form-group">                                                       
                                                                        <select class="form-control show-tick" data-placeholder="Select" name="department"> 
                                                                        <option value="">Please Select Department</option>                                      
                                                                        @foreach($departments as $department)
                                                                            @if($department->id != $user_details->department)
                                                                                <option value="{{$department->id}}">{{$department->dept_name}}</option>
                                                                            @else
                                                                                <option value="{{$department->id}}" selected>{{$department->dept_name}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                        </select>  
                                                                    </div>

                                                                    <label for="email_address">Blood Group</label>
                                                                    <div class="form-group">
                                                                        <div class="input-group">
                                                                            <div class="input-group-prepend">
                                                                                <span class="input-group-text"><i class="zmdi zmdi-invert-colors"></i></span>
                                                                            </div>
                                                                            <input type="text" class="form-control" placeholder="Blood Group" name="blood_grp" value="{{$user_details->blood_group}}">
                                                                        </div>
                                                                    </div>
                                                                   
                                                                    <label for="email_address">Permanent Address</label>
                                                                    <div class="form-group">                                
                                                                      <div class="form-line">
                                                                            <textarea rows="4" class="form-control no-resize" name="permt_addr" placeholder="Please type what you want...">{{$user_details->permanent_addr}}</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>  
                                                            </div>   
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">City</label>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="City" name="city" value="{{$user_details->city}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">State</label>
                                                                 <div class="form-group">                                                       
                                                                    <select class="form-control show-tick" data-placeholder="Select" name="state"> 
                                                                    <option value="">Please Select State</option>                                      
                                                                      @foreach($states as $state)
                                                                        @if($state->id != $user_details->state)
                                                                            <option value="{{$state->id}}">{{$state->state_name}}</option>
                                                                        @else
                                                                            <option value="{{$state->id}}" selected>{{$state->state_name}}</option>
                                                                        @endif
                                                                    @endforeach
                                                                    </select>    
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Pin Code</label>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Pin Code" name="pin_code" value="{{$user_details->pincode}}">
                                                                    </div>
                                                                </div>
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
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                       
                                            </div>
                                        </div>
                                    </div>
                                     <div role="tabpanel" class="tab-pane" id="pass_details">                                     
                                        <div class="container-fluid">
                                            <div class="row clearfix"> 
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                                   
                                                <div class="col-lg-10 col-md-10">                                                                             
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="header">
                                                                    <h2 class="text-center"><strong>Passport</strong> Details</h2>
                                                                </div>    
                                                                <form method="post" action="{{route('update_passport_details')}}" enctype="multipart/form-data">
                                                                @csrf                                                    
                                                                    <div class="card">                                                           
                                                                        <label for="email_address">Passport Number</label>
                                                                        <div class="form-group">                                
                                                                           <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-collection-case-play"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Passport Number" name="passport_no" value="{{$passport_details->passport_no}}">
                                                                            </div>
                                                                        </div>

                                                                        <label for="email_address">Issued At</label>
                                                                       <div class="form-group">                                
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-pin"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Issued At" name="issued_at" value="{{$passport_details->issued_at}}">
                                                                            </div>
                                                                        </div>                                                           

                                                                        <label for="email_address">Issued On</label>
                                                                        <div class="form-group">                            
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control datepicker" placeholder="Issued On " name="issued_on" value="{{$issued_on}}">
                                                                            </div>
                                                                        </div>

                                                                        <label for="email_address">Expiry On</label>
                                                                        <div class="form-group">                            
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control datepicker" placeholder="Expiry On" name="expiry_on" value="{{$expiry_on}}">
                                                                            </div>
                                                                        </div>   

                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button> 
                                                                    </div>     
                                                                </form>                                                         
                                                            </div>  
                                                            <div class="col-lg-6 col-md-6">
                                                                <div class="header">
                                                                    <h2 class="text-center">Bank<strong> Account </strong> Details</h2>
                                                                </div>  
                                                                <form method="post" action="{{route('update_bank_details')}}" enctype="multipart/form-data">
                                                                @csrf                                                        
                                                                    <div class="card">
                                                                        <label for="email_address">Account Holder Name</label>
                                                                        <div class="form-group">                                
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-account-box-o"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Account Holder Name" name="acc_name" value="{{$bank_details->acc_holder_name}}">
                                                                            </div>
                                                                        </div>

                                                                        <label for="email_address">Account Number</label>
                                                                        <div class="form-group">                                
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-collection-item-9-plus"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Account Number" name="acc_no" value="{{$bank_details->acc_no}}">
                                                                            </div>
                                                                        </div>
                                                                      
                                                                        <label for="email_address">Bank Name</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-accounts-list-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Bank Name" name="bank_name" value="{{$bank_details->   bank_name}}">
                                                                            </div>
                                                                        </div>
                                                            

                                                                        <label for="email_address">IFSC Code</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-codepen"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="IFSC Code" name="bank_ifsc" value="{{$bank_details->bank_ifsc}}">
                                                                            </div>
                                                                        </div>

                                                                        <label for="email_address">Branch</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-map"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Branch" name="bank_branch" value="{{$bank_details->bank_branch}}">
                                                                            </div>
                                                                        </div>

                                                                        <label for="email_address">Division</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-globe-alt"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" placeholder="Division" name="bank_division" value="{{$bank_details->bank_division}}">
                                                                            </div>
                                                                        </div>    

                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">SUBMIT</button>                           
                                                                    </div> 
                                                                </form>
                                                            </div>   
                                                        </div>                                                                                                                                  
                                                </div>
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="pf"> 
                                        <div class="container-fluid">
                                            <div class="row clearfix"> 
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                                   
                                                <div class="col-lg-10 col-md-10">
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>P F</strong> Form</h2>
                                                    </div>  
                                                    <form method="post" action="{{route('update_pf_form')}}" enctype="multipart/form-data">
                                                    @csrf
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-account"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="pf_name" value="{{$pf_details->pf_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose date of birth" name="pf_dob" value="{{$pf_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">DOJ</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose date of joining " name="pf_doj" value="{{$pf_doj}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>  
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Bank Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Bank Name" name="pf_bank_name" value="{{$pf_details->pf_bank_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Bank Account Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-accounts-list-alt"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Account Number" name="pf_acc" value="{{$pf_details->pf_acc_no}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">IFSC Code</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-dribbble"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="IFSC Code" name="pf_ifsc" value="{{$pf_details->pf_bank_ifsc}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Mobile Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Mobile Number" name="pf_phone" value="{{$pf_details->pf_phone}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Aadhar Card Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Card Number" name="pf_aadhar" value="{{$pf_details->pf_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Pan Card Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Pan Card Number" name="pf_pan" value="{{$pf_details->pf_pan}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <b>Father's Details</b>
                                                        <div class="row">                                                   
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="father_name" value="{{$pf_details->father_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Age</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Age" name="father_age" value="{{$pf_details->father_age}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose DOB " name="father_dob" value="{{$father_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Aadhar Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Number" name="father_aadhar" value="{{$pf_details->father_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <b>Mother's Details</b>
                                                        <div class="row">
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="mother_name" value="{{$pf_details->mother_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Age</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Age" name="mother_age" value="{{$pf_details->mother_age}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose DOB " name="mother_dob" value="{{$mother_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-3 col-md-3">
                                                                <label for="email_address">Aadhar Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Number" name="mother_aadhar" value="{{$pf_details->mother_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <b>Husband/Wife Details</b>
                                                        <div class="row">                                                    
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="husb_or_wife_name" value="{{$pf_details->husb_or_wife_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose DOB" name="husb_or_wife_dob" value="{{$husb_or_wife_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Aadhar Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Number" name="husb_or_wife_aadhar" value="{{$pf_details->husb_or_wife_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <b>Son Details</b>
                                                        <div class="row">                                                   
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="son_name" value="{{$pf_details->son_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose DOB " name="son_dob" value="{{$son_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Aadhar Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Number" name="son_aadhar" value="{{$pf_details->son_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                        <b>Daughter Details</b>
                                                        <div class="row">                                                   
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Name" name="daughter_name" value="{{$pf_details->daughter_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">DOB</label>
                                                                <div class="form-group">                            
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control datepicker" placeholder="Please choose DOB" name="daughter_dob" value="{{$daughter_dob}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Aadhar Number</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-card"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Aadhar Number" name="daughter_aadhar" value="{{$pf_details->daughter_aadhar}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 

                                                         <div class="row">                                                   
                                                            <div class="col-lg-6 col-md-6">
                                                                <label for="email_address">Nominee Name</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Nominee Name" name="nominee_name" value="{{$pf_details->nominee_name}}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6 col-md-6">
                                                                <label for="email_address">Nominee Relationship</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                        <input type="text" class="form-control" placeholder="Nominee Relationship" name="nominee_relt" value="{{$pf_details->nominee_relt}}">
                                                                    </div>
                                                                </div>
                                                            </div>                                       
                                                        </div> 

                                                         <div class="row">
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Dispensary(Nearest ESI Hosiptal)</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                        </div>
                                                                        <textarea rows="4" class="form-control no-resize" placeholder="Dispensary.." name="dispensary">{{$pf_details->dispensary}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Permanent Address</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                        </div>
                                                                        <textarea rows="4" class="form-control no-resize" placeholder="Permanent Address..." name="permt_addr">{{$pf_details->permt_addr}}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4 col-md-4">
                                                                <label for="email_address">Temporary Address</label>
                                                                <div class="form-group">                                
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                        </div>
                                                                        <textarea rows="4" class="form-control no-resize" placeholder="Temporary Address..." name="temp_addr">{{$pf_details->temp_addr}}</textarea>
                                                                    </div>
                                                                </div>
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
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="academics"> 
                                        <div class="container-fluid">
                                            <div class="row clearfix">                                                                                                                   
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>Academics</strong> Details</h2>
                                                    </div>                                        
                                                    <div class="card">
                                                        <p>EDUCATION (SSC / HSC Onwards)</p>     
                                                        <div id="message"></div>                                               
                                                        <div class="table-responsive">
                                                        <table id="mainTable" class="table table-striped c_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Course Name</th>
                                                                    <th>From</th>
                                                                    <th>To</th>
                                                                    <th>Institute / University</th>
                                                                    <th>Location</th>
                                                                    <th>Branch</th>
                                                                    <th>Percentage(%)</th>
                                                                    <th>class Obtained</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                                                                
                                                            </tbody>                                                               
                                                        </table>
                                                         @csrf
                                                        </div>
                                                    </div>                                                                                                                            
                                                </div>  
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>EMPLOYMENT</strong> Details</h2>
                                                    </div>                                        
                                                    <div class="card">
                                                        <p>EMPLOYMENT HISTORY</p> 
                                                        <div id="emp_message"></div>                                                  
                                                        <div class="table-responsive">
                                                        <table id="mainTable1" class="table table-striped c_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Duration From</th>
                                                                    <th>Duration To</th>
                                                                    <th>Yrs/Month</th>
                                                                    <th>Name & Address Of Organization</th>
                                                                    <th>Designation</th>
                                                                    <th>Role & Responsibility</th>
                                                                    <th>Reasons for leaving</th>
                                                                    <th>Action</th>                                                             
                                                                </tr>
                                                            </thead>
                                                            <tbody class="employment_table">
                                                                                                                
                                                            </tbody>                                                               
                                                        </table>
                                                         @csrf
                                                        </div>
                                                    </div>                                                                                                                            
                                                </div>    
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>FAMILY</strong> Details</h2>
                                                    </div>                                        
                                                    <div class="card">
                                                        <p>FAMILY BACKGROUND</p>       
                                                        <div id="family_message"></div>                                                
                                                        <div class="table-responsive">
                                                        <table id="mainTable2" class="table table-striped c_table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Relationship</th>
                                                                    <th>Name</th>
                                                                    <th>Age</th>
                                                                    <th>Dependent(Yes / No)</th>                                                           
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="family_table">
                                                                                                                
                                                            </tbody>                                                               
                                                        </table>
                                                         @csrf
                                                        </div>
                                                    </div>                                                                                                                            
                                                </div>    

                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="documents"> 
                                       <div class="container-fluid">
                                            <div class="row clearfix"> 
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                                   
                                                <div class="col-lg-10 col-md-10">    
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>PERSONAL</strong> DOCUMENTS</h2>
                                                    </div>   
                                                    @php
                                                        $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($user->id);
                                                    @endphp
                                                    <form method="post" action="{{route('upload_personal_documents')}}" enctype="multipart/form-data">  
                                                    @csrf                                                               
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">ID Proof</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Id'])}}"> <span class="input-group-text" ><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="id_proof[]"
                                                                   data-default-file="{{asset('public/'.$id_proof)}}">
                                                                </div>
                                                            </div>  
                                                        </div>    
                                                        <div class="col-lg-4 col-md-4">
                                                           <div class="card">
                                                                <label for="email_address">Aadhar Card</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Aadhar'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="aadhar_card[]"
                                                                   data-default-file="{{asset('public/'.$aadhar)}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">PAN Card</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Pan'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="pan_card[]"
                                                                   data-default-file="{{asset('public/'.$pan)}}">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">Experience/Relieving Letter</label>
                                                                <label  class="download"> <a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Exp'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="experience_letter[]" data-default-file="{{asset('public/'.$exp_letter)}}">
                                                                </div>
                                                            </div>  
                                                        </div>    
                                                        <div class="col-lg-4 col-md-4">
                                                           <div class="card">
                                                                <label for="email_address">3 Months Salary Slip</label>
                                                                <label  class="download"> <a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Salary'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="salary_slip[]" data-default-file="{{asset('public/'.$salary_slip)}}">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">Bank Statement</label>
                                                                <label  class="download"> <a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Bank'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="bank_statement[]"data-default-file="{{asset('public/'.$bank_stat)}}" >
                                                                </div>
                                                            </div>  
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
                                                    <div class="header"> 
                                                        <h2 class="text-center"><strong>ACADEMIC</strong> DOCUMENTS</h2>
                                                    </div> 
                                                    <form method="post" action="{{route('upload_academic_documents')}}" enctype="multipart/form-data">  
                                                    @csrf                                                                          
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">SSLC Certificate</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Sslc'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="sslc_cerf[]" data-default-file="{{asset('public/'.$sslc)}}">
                                                                </div>
                                                            </div>  
                                                        </div>    
                                                        <div class="col-lg-4 col-md-4">
                                                           <div class="card">
                                                                <label for="email_address">PUC Certificate</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Puc'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="puc_cerf[]" data-default-file="{{asset('public/'.$puc)}}">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">Graduate Certificate</label>
                                                                <label  class="download"> <a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Grad'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="graduate_cerf[]" data-default-file="{{asset('public/'.$graduate)}}">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">Postgraduate Certificate</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Pg'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="pg_cerf[]" data-default-file="{{asset('public/'.$post_graduate)}}">
                                                                </div>
                                                            </div>  
                                                        </div>    
                                                        <div class="col-lg-4 col-md-4">
                                                           <div class="card">
                                                                <label for="email_address">Any Other Qualification</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Other'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="other_cerf[]" data-default-file="{{asset('public/'.$other_qualification)}}">
                                                                </div>
                                                            </div>  
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <div class="card">
                                                                <label for="email_address">Certificate Courses</label>
                                                                <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Course'])}}"> <span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>
                                                                <div class="form-group">                                                       
                                                                   <input type="file" class="dropify" data-height="120" multiple="multiple" data-allowed-file-extensions="*" name="cerf_course[]" data-default-file="{{asset('public/'.$certificate_course)}}">
                                                                </div>
                                                            </div>  
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
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                           
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="others"> 
                                       <div class="container-fluid">
                                            <div class="row clearfix"> 
                                                <div class="col-lg-1 col-md-1">                                                     
                                                </div>                                                                                   
                                                <div class="col-lg-10 col-md-10">     
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>Career</strong> Objectives</h2>
                                                    </div> 
                                                    <form method="post" enctype="multipart/form-data" action="{{route('career_objective')}}">  @csrf                                                                       
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Career Objectives?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-graduation-cap"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Career Objectives" name="objective">{{$other_details->career_objective}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Growth Plans For the Next Three (3) Years?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-mood"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Growth Plans For the Next Three (3) Years." name="growth_plan">{{$other_details->growth_plan}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Expectations From WINGS as an Employer/Company?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-exposure-alt"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Expectations From WINGS as an Employer/Company?." name="expectation">{{$other_details->expectation}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Please List Down Your Strengths</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-view-list-alt"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Your Strengths." name="strength">{{$other_details->strength}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">List Down Your Areas of Improvement</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-view-toc"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Areas of Improvement..." name="improvement">{{$other_details->improvement}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Plans for Future Studies? If Any</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-library"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Future Studies?..." name="future_study">{{$other_details->future_study}}</textarea>
                                                                </div>
                                                            </div>
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
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>OTHER </strong>ACTIVITIES</h2>
                                                    </div>  
                                                    <form method="post" action="{{route('user_other_activity')}}" enctype="multipart/form-data"> 
                                                    @csrf                                                                       
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Sports?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-playstation"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Sports" name="sports">{{$other_details->sports}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Social / Cultural Activities?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-headset"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Social / Cultural Activities" name="social_activity">{{$other_details->social_activity}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Hobbies?</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-run"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Hobbies." name="hobby">{{$other_details->hobby}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Awards Received</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-reader"></i></span>
                                                                    </div>
                                                                    <textarea rows="4" class="form-control no-resize" placeholder="Awards Received" name="awards">{{$other_details->awards}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-8 col-md-8">
                                                            <label for="email_address">Do You Have any Physical Disability or Did You Suffer From Any Major Illness in the Last 2 years? Yes / No.
                                                            </label>
                                                            <div class="form-group">                                
                                                                 <div class="radio inlineblock m-r-20">                                                                    
                                                                    <input type="radio" name="disability" id="Yes" class="with-gap" value="Yes" {{ $other_details->disability == 'Yes' ? 'checked' : ''}}>
                                                                    <label for="Yes"><i class="zmdi zmdi-mood-bad"></i> Yes</label>
                                                                    <input type="radio" name="disability" id="No" class="with-gap" value="No" {{ $other_details->disability == 'No' ? 'checked' : ''}}>
                                                                    <label for="No"><i class="zmdi zmdi-mood"></i> No</label>                                                          
                                                                </div>   
                                                            </div>
                                                            <div class="header">
                                                            <b class="text-center" style="color: red">Emergency Contact (Name of two people who should be contacted in case of any emergency)</b>
                                                            </div>                                                         
                                                        </div>                                                   
                                                    </div> 
                                                    <b>Contact 1</b>
                                                    <div class="row">                                                   
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Name</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-o"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Name" name="contact1_name" value="{{$other_details->contact1_name}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <label for="email_address">Mobile Number</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Mobile Number" name="contact1_phone" value="{{$other_details->contact1_phone}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5">
                                                            <label for="email_address">Address</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                    </div>
                                                                    <textarea rows="2" class="form-control no-resize" placeholder="Address." name="contact1_address">{{$other_details->contact1_address}}</textarea>
                                                                </div>
                                                            </div>
                                                        </div>                                                    
                                                    </div>
                                                     <b>Contact 2</b>
                                                    <div class="row">
                                                        <div class="col-lg-4 col-md-4">
                                                            <label for="email_address">Name</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-o"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Name" name="contact2_name" value="{{$other_details->contact2_name}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-3">
                                                            <label for="email_address">Mobile Number</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-phone"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Mobile Number" name="contact2_phone" value="{{$other_details->contact2_phone}}">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-5 col-md-5">
                                                            <label for="email_address">Address</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-pin-drop"></i></span>
                                                                    </div>
                                                                    <textarea rows="2" class="form-control no-resize" placeholder="Address." name="contact2_address">{{$other_details->contact2_address}}</textarea>
                                                                </div>
                                                            </div>
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
                                                    <div class="header">
                                                        <h2 class="text-center"><strong>REFERENCES</strong></h2><br>
                                                        <b style="color: red" class="text-center">Name & Contact details of 2 (two) persons who can be contacted for a reference check. One of them should be preferably from any of the past employment who knows you professionally</b>
                                                    </div>  
                                                    <form method="post" action="{{route('user_references')}}" enctype="multipart/form-data">  @csrf                                                                     
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="email_address">Name</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Name" name="ref1_name" value="{{$other_details->reference1_name}}">
                                                                </div>
                                                            </div>
                                                          
                                                            <label for="email_address">Designation & Company</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-laptop-mac"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Designation & Company" name="ref1_company" value="{{$other_details->reference1_company}}">
                                                                </div>
                                                            </div>
                                                           

                                                            <label for="email_address">Contact No</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" placeholder="Contact No" name="ref1_phone" value="{{$other_details->reference1_phone}}">
                                                                </div>
                                                            </div>
                                                          

                                                            <label for="email_address">Email ID</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" placeholder="Email ID" name="ref1_email" value="{{$other_details->reference1_email}}">
                                                                </div>
                                                            </div>                                                 

                                                        </div>
                                                        <div class="col-lg-6 col-md-6">
                                                            <label for="email_address">Name</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-add"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Name" name="ref2_name" value="{{$other_details->reference2_name}}">
                                                                </div>
                                                            </div>
                                                           

                                                            <label for="email_address">Designation & Company</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-laptop-mac"></i></span>
                                                                    </div>
                                                                    <input type="text" class="form-control" placeholder="Designation & Company" name="ref2_company" value="{{$other_details->reference2_company}}">
                                                                </div>
                                                            </div>
                                                           

                                                            <label for="email_address">Contact No</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Contact No" name="ref2_phone" value="{{$other_details->reference2_phone}}">
                                                                </div>
                                                            </div>
                                                          

                                                            <label for="email_address">Email ID</label>
                                                            <div class="form-group">                                
                                                                <div class="input-group">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                                                                    </div>
                                                                     <input type="text" class="form-control" placeholder="Email ID" name="ref2_email" value="{{$other_details->reference2_email}}">
                                                                </div> 
                                                            </div>                                                     

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
            @endif
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

{!! Toastr::message() !!}

<script type="text/javascript">
    $(document).ready(function() {
        $(".marital_status").change(function() {
            var status = $(this).val();
            if (status == "Married") 
            {
                $(".marriage_date").show();
            }
            else if(status == "Single")
            {
                $(".marriage_date").hide();
            }
        });
    });

    function myFunction() 
    {
        var spouse = '<?php echo $user_details->spouse_name ?>';
        var date = '<?php echo $user_details->marriage_date ?>';

        if(spouse == '' && date == '')
        {
            $(".marriage_date").hide();
        }
        else
        {
            $(".marriage_date").show();
        }
    }
</script>

@include('user.scripts.scripts')

</body>

@endsection
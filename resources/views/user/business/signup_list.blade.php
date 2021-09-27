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
                    <h2>SignUp List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">SignUp List</li>
                        <li class="breadcrumb-item active">SignUp List</li>
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
                <div class="card">  
                    <div class="body">  
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Signup Uploaded By</th>                          
                                        <th>Event Signed up By</th>                          
                                        <th>Company Name</th>                                                                  
                                        <th>Event Name</th>
                                        <th>Start Date Of Event</th>
                                        <th>Start Date Of Event</th> 
                                        <th>Status</th>    
                                        <th>Comment</th>       
                                        <th>Replay For Comment</th> 
                                        <th>SignUp View</th>                                                                                       
                                        <th <?php if($User->id == 19) {?> <?php }else{?>  style="display: none" <?php }?>>Signup Action</th>    
                                        <th>Signup Revised</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($Lists as $key=>$List)
                                    @php                                       
                                        $user = \App\User::find($List->user_id);   
                                        $user_eventsignedup = \App\User::find($List->event_signed_up);   
                                        $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($List->id);    
                                        $Revision = \App\UserBusinessRevion::where('signup_id',$List->id)->where('status',2)->first();                                                     
                                    @endphp
                                    <tr>
                                        <td>{{ $key+1 }}</td>                                       
                                        <td>{{$user->first_name }} {{$user->last_name }}</td>                                          
                                        <td>{{$user_eventsignedup->first_name }} {{$user_eventsignedup->last_name }}</td>                                          
                                        <td>{{$List->company_name}}</td>                                      
                                        <td>{{$List->event_name}}</td>
                                        <td>{{$List->event_startdate}}</td>
                                        <td>{{$List->event_enddate}}</td>
                                        <td>
                                            @if($List->level == 0)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 1)
                                                <span class="btn btn-round btn-warning">{{$List->status}}</span>
                                            @elseif($List->level == 2)
                                                <span class="btn btn-round btn-success">{{$List->status}}</span> By Kailash
                                            @elseif($List->level == 3)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 4)
                                                <span class="btn btn-round btn-warning">{{$List->status}}</span>
                                            @elseif($List->level == 5)
                                                <span class="btn btn-round btn-success">{{$List->status}}</span> By Bjorn
                                            @elseif($List->level == 6)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 7)
                                                <span class="btn btn-round btn-warning">{{$List->status}}</span>
                                            @elseif($List->level == 8)
                                                <span class="btn btn-round btn-success">{{$List->status}}</span> By Suresh Babu
                                            @elseif($List->level == 9)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span> By Suresh Babu
                                            @elseif($List->level == 10)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span> By Suresh Babu
                                            @endif
                                        </td>
                                        <td>{{$List->comment}}</td>
                                        <td>
                                            @if($User->id != 19 && ($List->level == 8))
                                                @if(is_null($List->reply))                                      
                                                    <span class="btn btn-round btn-warning">Pending</span>
                                                @elseif($List->reply == 0)
                                                    <a data-toggle="modal" data-target="#reply{{$List->id}}"><button class="btn btn-round btn-success">Reply</button></a>
                                                @elseif($List->reply == 1)
                                                    <span class="btn btn-round btn-danger">Replied</span>
                                                @endif
                                            @else
                                                @if(is_null($List->reply) || $List->reply == 0)                                      
                                                    <span class="btn btn-round btn-warning">Pending</span>
                                                @elseif($List->reply == 1)
                                                    <span class="btn btn-round btn-danger">Replied</span>
                                                @endif                                                
                                            @endif
                                        </td>
                                        <td>
                                            <a data-toggle="modal" data-target="#viewlist{{$List->id}}"><button class="btn btn-round btn-danger">View</button></a>
                                            @if($User->id != 19 && ($List->level == 0 || $List->level == 3 || $List->level == 6) )
                                                @if($List->user_id == $User->id) 
                                                    @if(is_null($List->parent_id))
                                                    <a href="{{route('edit_signup',['EncryptedId' => $EncryptedId])}}"><button class="btn btn-round btn-danger">Edit</button></a>
                                                    @else
                                                    <a href="{{route('edit_additional_signup',['EncryptedId' => $EncryptedId])}}"><button class="btn btn-round btn-danger">Edit</button></a>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>     
                                        <td <?php if($User->id == 19) {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                                            @if($List->level == 0)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>                                           
                                            @elseif($List->level == 2) 
                                                <span class="btn btn-round btn-success">{{$List->status}}</span>
                                            @elseif($List->level == 3)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 4)
                                                <span class="btn btn-round btn-warning">{{$List->status}}</span>
                                            @elseif($List->level == 5)
                                                <span class="btn btn-round btn-success">{{$List->status}}</span>
                                            @elseif($List->level == 6)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 7)
                                                <span class="btn btn-round btn-warning">{{$List->status}}</span>
                                            @elseif($List->level == 8)
                                                <span class="btn btn-round btn-success">{{$List->status}}</span>
                                            @elseif($List->level == 9)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @elseif($List->level == 10)
                                                <span class="btn btn-round btn-danger">{{$List->status}}</span>
                                            @else  
                                                <a class="btn btn-success" data-toggle="modal" data-target="#approveModal{{$List->id}}"><i class="zmdi zmdi-check" 
                                                    style="color: #fff"></i></a>
                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal{{$List->id}}"><i class="zmdi zmdi-close" 
                                                    style="color: #fff"></i></a>
                                            @endif
                                        </td>                                         
                                        <td>
                                            @if($User->id != 19)
                                                @if(!is_null($Revision))
                                                    @if(($Revision->revision == 1) || ($Revision->revision == 3))
                                                        @if(is_null($List->parent_id))
                                                        <a href="{{route('edit_revision_signup',[ 'EncryptedId' => $EncryptedId ])}}"><button class="btn btn-round btn-primary">Edit</button></a>
                                                        @else
                                                        <a href="{{route('edit_additional_signup',[ 'EncryptedId' => $EncryptedId ])}}"><button class="btn btn-round btn-primary">Editad</button></a>
                                                        @endif
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="approveModal{{$List->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header justify-content-center">
                                                    <h4 class="title" id="largeModalLabel">Approve - {{$List->company_name}}</h4>
                                                </div>
                                               <form method="post" action="{{route('approve_signup')}}"  enctype="multipart/form-data" id="signupapprove">
                                                @csrf
                                                <input type="hidden" name="list_id" value="{{$List->id}}">
                                                    <div class="modal-body"> 
                                                        <div class="row clearfix">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <label for="email_address">Comments</label>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                       <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                                                    </div>
                                                                </div>                           
                                                            </div>                                                                                                                
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger btn-round waves-effect" style="float:left" data-dismiss="modal">CLOSE</button>
                                                        <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="rejectModal{{$List->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header justify-content-center">
                                                    <h4 class="title" id="largeModalLabel">Redo - {{$List->company_name}}</h4>
                                                </div>
                                               <form method="post" action="{{route('reject_signup')}}" enctype="multipart/form-data" id="signupredo">
                                                @csrf
                                                <input type="hidden" name="list_id" value="{{$List->id}}">
                                                    <div class="modal-body"> 
                                                        <div class="row clearfix">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <label for="email_address">Comments</label>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                       <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                                                    </div>
                                                                </div>                           
                                                            </div>                                                                                                                 
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                                                        <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                                                        
                                    <div class="modal fade" id="reply{{$List->id}}" tabindex="-1" role="dialog">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header justify-content-center">
                                                    <h4 class="title" id="largeModalLabel">Replay For Comment - {{$List->company_name}}</h4>
                                                </div>
                                               <form method="post" action="{{route('reply_comment')}}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="list_id" value="{{$List->id}}">
                                                    <div class="modal-body"> 
                                                        <div class="row clearfix">
                                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                                <label for="email_address">Your Comments</label>
                                                                <div class="form-group">
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                        </div>
                                                                       <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                                                    </div>
                                                                </div>                           
                                                            </div>                                                                                                                 
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                                                        <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@foreach($Lists as $key=>$List)
@php                                       
    $splits = \App\BusinessSignupSplit::where('signup_id',$List->id)->get();        
    $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($List->id);                                                                         
@endphp
<!-- Large Size -->
<div class="modal fade" id="viewlist{{$List->id}}" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            @if(is_null($List->parent_id))
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Signup - {{$List->company_name}}</h4>
            </div>
            @else
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Additional Signup - {{$List->company_name}}</h4>
            </div>
            @endif
            <div class="modal-body"> 
                <div class="row">                        
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="email_address">Company</label>
                        <div class="form-group gender-bottom"> 
                            <div class="radio inlineblock m-r-20">    
                                @if($List->company_status == "exist")                                                              
                                    <input type="radio" class="with-gap" value="exist"  checked>
                                    <label ><i class="zmdi zmdi-case-check"></i> Exist</label>
                                @else
                                    <input type="radio" class="with-gap" value="new" checked>
                                    <label ><i class="zmdi zmdi-case"></i> New</label>  
                                @endif          
                            </div>   
                        </div>  
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label>Company Name</label>                        
                        <div class="input-group masked-input" >
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-balance"></i></span>
                            </div>
                           <input type="text" class="form-control" value="{{$List->company_name}}">                                         
                        </div>             
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12 client">
                        <label>Client/User Name</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-account-circle"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$List->client_name}}">                           
                        </div>
                       
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Client Email</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-account-box-mail"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->client_email }}">                          
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Client Mobile Number</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->client_mobile }}">                           
                        </div>                                       
                    </div>
                     <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Event Name</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-view-carousel"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{$List->event_name}}">                          
                        </div>                                       
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Event Signed in (City)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-city-alt"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->event_city}}">                           
                        </div>                                        
                    </div>                                   
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Starting Date of Event</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->event_startdate}}">      
                        </div>                                       
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Closing Date of Event</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->event_enddate}}">              
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Date event will be billed</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->event_billeddate}}">    
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label> <b>Download Budget Sheet HERE1</b></label>
                        <label class="download"> <a href="{{route('signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'BSheet'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>                                                               
                    </div>  
                        
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <label for="email_address">Service</label>
                        <div class="form-group gender-bottom">
                            <div class="radio inlineblock m-r-20">                             
                                <input type="radio"  class="with-gap" value="event" {{ $List->service == 'event' ? 'checked' : ''}} >
                                <label for="event"><i class="zmdi zmdi-case-check"></i> Event</label>   

                                <input type="radio" class="with-gap" value="payment" {{ $List->service == 'payment' ? 'checked' : ''}}>
                                <label for="payment"><i class="zmdi zmdi-case"></i> Pass Through Payment</label>
                            </div>  
                        </div>  
                    </div>
                    @if(!is_null($List->estimate_amount) && !is_null($List->budget_amount))
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Estimate Amount(without GST)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->estimate_amount }}">   
                        </div>                                        
                    </div>  
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Budget Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->budget_amount }}">         
                        </div>                                        
                    </div> 
                                                                      
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Profit Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->profit_amount }}">         
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Profit%</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-percent" aria-hidden="true"></i> </span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->profit_percentage }}">    
                        </div>                                        
                    </div>
                    @endif
                    @if(!is_null($List->actual_estimate_amount) && !is_null($List->actual_budget_amount))
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Actuals Estimate Amount(without GST)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->actual_estimate_amount }}">   
                        </div>                                        
                    </div>  
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Actuals Budget Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->actual_budget_amount }}">
                        </div>                                        
                    </div> 
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Actuals Profit Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->actual_profit_amount }}">         
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == "event" ? '' : 'style=display:none' }}>
                        <label>Actuals Profit%</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->actual_profit_percentage }}">    
                        </div>                                        
                    </div>  
                    @endif  
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Creative Cost</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->creative_amount }}">         
                        </div>                                        
                    </div> 
                      <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == 'payment' ? '' : 'style=display:none' }}>
                        <label>P - Estimate Amount(without GST)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->payment_estimate_amount }}">   
                        </div>                                        
                    </div>  
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == 'payment' ? '' : 'style=display:none' }}>
                        <label>P - Budget Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->payment_budget_amount }}">
                        </div>                                        
                    </div> 
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == 'payment' ? '' : 'style=display:none' }}>
                        <label>P - Profit Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->payment_profit_amount }}">         
                        </div>                                        
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12" {{ $List->service == 'payment' ? '' : 'style=display:none' }}>
                        <label>P - Profit%</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-inr" aria-hidden="true"></i> </span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->payment_profit_percentage }}">    
                        </div>                                        
                    </div>  
                  
                    
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Advance Payment Status</label>
                        <div class="input-group masked-input mb-3">                                       
                            <select class="form-control show-tick" >
                                @if($List->advance_payment_status == "yes")
                                <option value="yes" selected="">Yes</option>
                                @else
                                <option value="no" selected="">No</option>
                                @endif
                            </select>                          
                        </div>                                         
                    </div>

                    <div class="col-lg-4 col-md-6 col-sm-12" id="advancedate" <?php if($List->advance_payment_status == "yes") {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                        <label>Advance Payment Date</label>
                        <div class="input-group masked-input mb-3">
                             <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->advance_payment_date }}">   
                        </div>                                         
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12" id="advanceammount" <?php if($List->advance_payment_status == "yes") {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                        <label>Advance Amount</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-rupee"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->advance_payment_amount }}">                         
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Purchase Order</label>
                        <div class="input-group masked-input mb-3">                                       
                            <select class="form-control show-tick" >
                                @if($List->purchase_status == "Yes")
                                <option value="Yes" selected="">Yes</option>
                                @else
                                <option value="No" selected="">No</option>
                                @endif
                            </select>                          
                        </div>                                         
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12" <?php if($List->purchase_status == "Yes") {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?>>
                        <label> <b>Download Purchase Order HERE</b></label>
                        <label class="download"> <a href="{{route('signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'Po'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>                                                               
                        @php
                            $client_po = current(explode('|',$List->purchase_file));
                        @endphp 
                        <a class="btn btn-success" href="{{asset('public/'.$client_po)}}" target="_blank">View PO</a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Client Approvel Mail</label>
                        <div class="input-group masked-input mb-3">                                       
                            <select class="form-control show-tick" >
                                @if($List->client_approval_status == "Yes")
                                <option value="Yes" selected="">Yes</option>
                                @else
                                <option value="No" selected="">No</option>
                                @endif
                            </select>                         
                        </div>                                         
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Payment terms as per contract with client</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->payment_contract }}">                           
                        </div> 
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Budget Made By</label>
                        <div class="input-group masked-input mb-3">                                           
                            <select class="form-control show-tick">
                                @foreach($Users as $user)
                                    @if($user->id == $List->budget_made_by)                                                                                
                                        <option value="{{$user->id}}" selected>{{$user->first_name}} {{$user->last_name}}</option>
                                    @endif
                                @endforeach                              
                            </select>                        
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12" id="mailupload" <?php if($List->client_approval_status == "Yes") {?> style="display: block;"<?php }else{?>  style="display: none" <?php }?> >
                        <label><b>Download Client Approvel Mail Here</b></label>        
                        <label  class="download"> <a  href="{{route('signup_download',[ 'EncryptedId' => $EncryptedId, 'EncryptedProof' => 'Client'])}}"><span class="input-group-text"><i class="zmdi zmdi-download"></i></span></a></label>                                                    
                        @php
                            $client_mail = current(explode('|',$List->client_approval_file));
                        @endphp 
                        <a class="btn btn-success" href="{{asset('public/'.$client_mail)}}" target="_blank">View Client Approvel Mail</a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Event Signed up</label>
                        <div class="input-group masked-input mb-3">                                            
                            <select class="form-control show-tick">
                                @foreach($Users as $user)
                                    @if($user->id == $List->event_signed_up)                                                                                
                                        <option value="{{$user->id}}" selected>{{$user->first_name}} {{$user->last_name}}</option>
                                    @endif
                                @endforeach  
                            </select>                            
                        </div>
                    </div>
                    <?php
                        if(is_null($List->production_employee))
                        {
                            $production = $List->production_employee;
                        }
                        else
                        {
                            $PAllocation = $List->production_employee;
                            $PExplode = explode(',',$PAllocation);
                            $data=array();
                            foreach($PExplode as $res)
                            {                            
                                $User = \App\User::where('id',$res)->first();                    
                                array_push($data,$User['first_name']);   
                            }
                            $production = implode(' , ',$data);
                        }

                        if(is_null($List->creative_employee))
                        {
                            $creative = $List->creative_employee;
                        }
                        else
                        {
                            $CAllocation = $List->creative_employee;                        
                            $CExplode = explode(',',$CAllocation);             
                            $data1=array();                        
                            foreach($CExplode as $res1)
                            {                            
                                $User = \App\User::where('id',$res1)->first();                    
                                array_push($data1,$User['first_name']);   
                            }
                            $creative = implode(' , ',$data1);
                        }
                        
                        
                    ?>
                    @if(!is_null($production))
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Resource Allocation (Production)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group masked-input mb-3">
                                <input type="text" class="form-control" value="{{ $production }}">
                            </div>
                        </div>                                        
                    </div>
                    @endif
                    @if(!is_null($creative))
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Resource Allocation (Creative - Internal)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group masked-input mb-3">                                    
                                <input type="text" class="form-control" value="{{ $creative }}">        
                            </div> 
                        </div>                                        
                    </div>
                    @endif
                    @if(!is_null($List->outside_employee))
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label>Resource Allocation (Creative - Outside)</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i> </span>
                            </div>
                            <input type="text" class="form-control" value="{{ $List->outside_employee }}">
                        </div>                                        
                    </div>
                    @endif
                    @foreach($splits as $split)
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="row">                            
                            <span class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-lg-9 col-md-9 col-sm-9">
                                        <label>Event Sign up split</label>
                                        <div class="input-group masked-input mb-3">                                                      
                                            <select class="form-control show-tick">
                                                @foreach($Users as $user)
                                                    @if($user->id == $split->employee_id)                                                                                
                                                        <option value="{{$user->id}}" selected>{{$user->first_name}} {{$user->last_name}}</option>
                                                    @endif
                                                @endforeach                                           
                                            </select>                                                                
                                        </div> 
                                    </div> 
                                    <div class="col-lg-3 col-md-3 col-sm-3">    
                                        <label style="margin-bottom: 0.6em"> %</label>                                    
                                        <input type="text" class="form-control" value="{{ $split->percentage }}">                                                
                                    </div>
                                </div>
                            </span>                                                    
                        </div> 
                    </div>  
                    @endforeach                                     
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach 


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
    
     $("#signupapprove").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
    
     $("#signupredo").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>

</body>

@endsection
   
@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Business List</title>

    @include('admin.layouts.css')
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}">
    <style>   
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

@include('admin.layouts.page_loader')

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Business List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Business List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>              
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">                       
                        <div class="body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ban">BANGALORE</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mum">MUMBAI</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#del">DELHI</a></li>     
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hyd">HYDERABAD</a></li>                            
                            </ul>                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="ban">
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
                                                    <th>End Date Of Event</th> 
                                                    <th>Status</th>    
                                                    <th>Comment</th>                               
                                                    <th>View</th>       
                                                    @if($User->id == 1 || $User->id == 2)     
                                                    <th>Action</th> 
                                                    @endif                                                                                     
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Bang_Signups as $key=>$List)
                                                @php                                       
                                                    $user = \App\User::find($List->user_id);   
                                                    $user_eventsignup = \App\User::find($List->event_signed_up);   
                                                    $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($List->id);     
                                                    $revision = \App\UserBusinessRevion::where('signup_id',$List->id)->where('status',2)->first();                                                     
                                                @endphp
                                                <?php
                                                if(is_null($revision))
                                                {
                                                $revision['status'] = null;
                                                }
                                                else{
                                                $revision['status'] = $revision['status'];
                                                }
                                                
                                                ?>
                                                <tr>
                                                    <td>{{ $key+1 }}</td>                                       
                                                    <td>{{$user->first_name }} {{$user->last_name }}</td>        
                                                    <td>{{$user_eventsignup->first_name }} {{$user_eventsignup->last_name }}</td>                                          
                                                    <td>{{$List->company_name}}</td>                                      
                                                    <td>{{$List->event_name}}</td>
                                                    <td>{{$List->event_startdate}}</td>
                                                    <td>{{$List->event_enddate}}</td>
                                                    <th>
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
                                                    </th>
                                                    <th>{{$List->comment}}</th>
                                                    <td>
                                                       <button class="btn btn-round btn-danger Signup" data-id="{{ $List->id }}">View</button>     
                                                    </td>  
                                                    @if($User->id == 1)
                                                        @if($List->level == 0)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>
                                                        </td> 
                                                        @elseif($List->level == 1)
                                                        <td>
                                                            <span class="btn btn-round btn-warning">Pending</span>
                                                        </td>
                                                        @elseif($List->level == 2)
                                                        <td>
                                                            <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                            <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>    
                                                        </td> 
                                                        @elseif($List->level == 3)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>
                                                        </td>
                                                        @elseif($List->level == 4)
                                                        <td>
                                                            <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                            <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>          
                                                        </td> 
                                                        @elseif($List->level == 5)
                                                        <td>
                                                            <span class="btn btn-round btn-success">Approved</span>
                                                        </td>
                                                        @elseif($List->level == 6)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 7)
                                                        <td>
                                                            <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 8)
                                                        <td>
                                                            <span class="btn btn-round btn-success">Approved</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 9)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Cancelled</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 10)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Cancelled</span>                                                            
                                                        </td> 
                                                        @endif
                                                    @elseif($User->id == 2)
                                                        @if($List->level == 0)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>
                                                        </td> 
                                                        @elseif($List->level == 1)
                                                        <td>
                                                            <span class="btn btn-round btn-warning">Pending</span>
                                                        </td>
                                                        @elseif($List->level == 2)
                                                        <td>
                                                            <span class="btn btn-round btn-success">Approved</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 3)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>
                                                        </td>                                                                 
                                                        @elseif($List->level == 4)
                                                        <td>
                                                            <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 5)
                                                        <td>
                                                            <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                            <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-redo" style="color:#fff;font-size: 17px"></i></a>
                                                            <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                        </td>
                                                        @elseif($List->level == 6)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Redo</span>
                                                        </td>  
                                                        @elseif($List->level == 7)
                                                        <td>
                                                            <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                            <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-redo" style="color:#fff;font-size: 17px"></i></a>
                                                            <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                        </td>
                                                        @elseif($List->level == 8)
                                                        <td>
                                                            <span class="btn btn-round btn-success">Approved</span>                                                   
                                                        </td> 
                                                        @elseif($List->level == 9)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Cancelled</span>                                                            
                                                        </td> 
                                                        @elseif($List->level == 10)
                                                        <td>
                                                            <span class="btn btn-round btn-danger">Cancelled</span>                                                            
                                                        </td> 
                                                        @endif
                                                    @endif  
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" style="text-align: center">No Signups</td>
                                                    </tr>
                                                @endforelse                                                                                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="mum">
                                  <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>Employee Name</th>                          
                                                    <th>Company Name</th>                                                                  
                                                    <th>Event Name</th>
                                                    <th>Start Date Of Event</th>
                                                    <th>End Date Of Event</th> 
                                                    <th>Status</th>    
                                                    <th>Comment</th>                               
                                                    <th>View</th> 
                                                    @if($User->id == 1 || $User->id == 2)     
                                                    <th>Action</th> 
                                                    @endif                                                                                        
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @forelse ($Mum_Signups as $key=>$List)
                                                    @php                                       
                                                        $user = \App\User::find($List->user_id);   
                                                        $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($List->id);     
                                                        $revision = \App\UserBusinessRevion::where('signup_id',$List->id)->where('status',2)->first();                                                      
                                                    @endphp
                                                     <?php
                                                    if(is_null($revision))
                                                    {
                                                    $revision['status'] = null;
                                                    }
                                                    else{
                                                    $revision['status'] = $revision['status'];
                                                    }
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>                                       
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>                                          
                                                        <td>{{$List->company_name}}</td>                                      
                                                        <td>{{$List->event_name}}</td>
                                                        <td>{{$List->event_startdate}}</td>
                                                        <td>{{$List->event_enddate}}</td>
                                                        <th>
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
                                                            @endif
                                                        </th>
                                                        <th>{{$List->comment}}</th>
                                                        <td>
                                                            <button class="btn btn-round btn-danger Signup" data-id="{{ $List->id }}">View</button>
                                                        </td>   
                                                        @if($User->id == 1)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>     
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 8)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @endif
                                                        @elseif($User->id == 2)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>                                                                 
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <a class="badge badge-success " href="javascript:void(0)"data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px" data-revision="{{$revision['status']}}"></i></a>
                                                                <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>  
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px" data-revision="{{$revision['status']}}"></i></a>
                                                                <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 8)
                                                             <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @endif
                                                        @endif  
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" style="text-align: center">No Signups</td>
                                                    </tr>
                                                @endforelse                                                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="del">
                                   <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>Employee Name</th>                          
                                                    <th>Company Name</th>                                                                  
                                                    <th>Event Name</th>
                                                    <th>Start Date Of Event</th>
                                                    <th>Start Date Of Event</th> 
                                                    <th>Status</th>    
                                                    <th>Comment</th>                               
                                                    <th>View</th>  
                                                    @if($User->id == 1 || $User->id == 2)     
                                                    <th>Action</th> 
                                                    @endif                                                                                         
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @forelse ($Del_Signups as $key=>$List)
                                                    @php                                       
                                                        $user = \App\User::find($List->user_id);   
                                                        $EncryptedId =  \Illuminate\Support\Facades\Crypt::encrypt($List->id);  
                                                        $revision = \App\UserBusinessRevion::where('signup_id',$List->id)->where('status',2)->first();                                                            
                                                    @endphp
                                                     <?php
                                                    if(is_null($revision))
                                                    {
                                                    $revision['status'] = null;
                                                    }
                                                    else{
                                                    $revision['status'] = $revision['status'];
                                                    }
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>                                       
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>                                          
                                                        <td>{{$List->company_name}}</td>                                      
                                                        <td>{{$List->event_name}}</td>
                                                        <td>{{$List->event_startdate}}</td>
                                                        <td>{{$List->event_enddate}}</td>
                                                        <th>
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
                                                            @endif
                                                        </th>
                                                        <th>{{$List->comment}}</th>
                                                        <td>
                                                            <button class="btn btn-round btn-danger Signup" data-id="{{ $List->id }}">View</button>    
                                                        </td>   
                                                        @if($User->id == 1)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>          
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 8)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @endif
                                                        @elseif($User->id == 2)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>                                                                 
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>  
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <a class="badge badge-success" href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-warning" href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 8)
                                                             <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                            
                                                            </td> 
                                                            @endif
                                                        @endif  
                                                    </tr>
                                                @empty
                                                    <tr>
                                                       <td colspan="10" style="text-align: center">No Signups</td>
                                                    </tr>
                                                @endforelse                                                                                 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>     
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                   <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>Employee Name</th>                          
                                                    <th>Company Name</th>                                                                  
                                                    <th>Event Name</th>
                                                    <th>Start Date Of Event</th>
                                                    <th>Start Date Of Event</th> 
                                                    <th>Status</th>    
                                                    <th>Comment</th>                               
                                                    <th>View</th>  
                                                    @if($User->id == 1 || $User->id == 2)     
                                                    <th>Action</th> 
                                                    @endif                                                                                                 
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                 @forelse ($Hyd_Signups as $key=>$List)
                                                    @php                                       
                                                        $user = \App\User::find($List->user_id);   
                                                        $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($List->id);        
                                                        $revision = \App\UserBusinessRevion::where('signup_id',$List->id)->where('status',2)->first();                                                      
                                                    @endphp
                                                     <?php
                                                    if(is_null($revision))
                                                    {
                                                    $revision['status'] = null;
                                                    }
                                                    else{
                                                    $revision['status'] = $revision['status'];
                                                    }
                                                    
                                                    ?>
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>                                       
                                                        <td>{{$user->first_name }} {{$user->last_name }}</td>                                          
                                                        <td>{{$List->company_name}}</td>                                      
                                                        <td>{{$List->event_name}}</td>
                                                        <td>{{$List->event_startdate}}</td>
                                                        <td>{{$List->event_enddate}}</td>
                                                        <th>
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
                                                                <span class="btn btn-round btn-success">{{$List->status}}</span> By Suresh Babu
                                                            @elseif($List->level == 10)
                                                                <span class="btn btn-round btn-success">{{$List->status}}</span> By Suresh Babu
                                                            @endif
                                                        </th>
                                                        <th>{{$List->comment}}</th>
                                                        <td>
                                                            <button class="btn btn-round btn-danger Signup" data-id="{{ $List->id }}">View</button>
                                                        </td>   
                                                        @if($User->id == 1)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <a class="badge badge-success" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="badge badge-warning" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>
                                                                <a class="badge  badge-danger" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff"></i></a>
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <a class="btn btn-success " data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff"></i></a>
                                                                <a class="btn btn-danger " data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff"></i></a>     
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 8)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @endif
                                                        @elseif($User->id == 2)
                                                            @if($List->level == 0)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td> 
                                                            @elseif($List->level == 1)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>
                                                            </td>
                                                            @elseif($List->level == 2)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @elseif($List->level == 3)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>                                                                 
                                                            @elseif($List->level == 4)
                                                            <td>
                                                                <span class="btn btn-round btn-warning">Pending</span>                                                            
                                                            </td> 
                                                            @elseif($List->level == 5)
                                                            <td>
                                                                <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 6)
                                                            <td>
                                                                <span class="btn btn-round btn-danger">Redo</span>
                                                            </td>  
                                                            @elseif($List->level == 7)
                                                            <td>
                                                                <a class="badge badge-success " href="javascript:void(0)" data-toggle="modal" data-target="#approveModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}" data-revision="{{$revision['status']}}"><i class="zmdi zmdi-check" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-warning " href="javascript:void(0)" data-toggle="modal" data-target="#rejectModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-close" style="color:#fff;font-size: 17px"></i></a>
                                                                <a class="badge badge-danger " href="javascript:void(0)" data-toggle="modal" data-target="#cancelModal" data-id="{{$List->id}}" data-heading="{{$List->company_name}}" data-user_id="{{$User->id}}"><i class="zmdi zmdi-delete" style="color:#fff;font-size: 17px"></i></a>
                                                            </td>
                                                            @elseif($List->level == 8)
                                                            <td>
                                                                <span class="btn btn-round btn-success">Approved</span>                                                           
                                                            </td> 
                                                            @endif
                                                        @endif  
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7" style="text-align: center">No Signups</td>
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
        </div>
    </div>
</section>

<!-- Large Size -->
<div class="modal fade" id="viewSignup" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl viewlist" role="document">
       
    </div>
</div>

<div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Approve - <span class="heading"></span></h4>
            </div>
           <form method="post" action="{{route('admin.approve_signup')}}"  enctype="multipart/form-data" id="businessapprove">
            @csrf
            <input type="hidden" name="list_id" id="list_id" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
            <input type="hidden" name="revision" id="revision" value="">
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

<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Redo - <span class="heading"></span></h4>
            </div>
           <form method="post" action="{{route('admin.reject_signup')}}" enctype="multipart/form-data" id="businessredo">
            @csrf
            <input type="hidden" name="list_id" id="list_id" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
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

<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Cancel - <span class="heading"></span></h4>
            </div>
           <form method="post" action="{{route('admin.cancel_signup')}}" enctype="multipart/form-data" id="businessredo">
            @csrf
            <input type="hidden" name="list_id" id="list_id" value="">
            <input type="hidden" name="user_id" id="user_id" value="">
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



@include('admin.layouts.js')
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
{!! Toastr::message() !!}
</body>

<script>
    $(document).ready(function () {
        $('#approveModal').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           
           var heading = button.data('heading');
           var id = button.data('id');    
           var user_id = button.data('user_id');  
           var revision = button.data('revision');     
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('#list_id').val(id);  
           modal.find('#user_id').val(user_id);  
           modal.find('#revision').val(revision);
        });

        $('#rejectModal').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var id = button.data('id');   
           var user_id = button.data('user_id');         
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('#list_id').val(id);  
           modal.find('#user_id').val(user_id);
        });

        $('#cancelModal').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var id = button.data('id');   
           var user_id = button.data('user_id');         
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('#list_id').val(id);  
           modal.find('#user_id').val(user_id);
        });
    });

    $(document).on('click', '.Signup', function (e) {
        e.preventDefault();
        var id = $(this).data('id');     
        
        $.ajax({
            url: '{{ route('admin.view_signup') }}',
            type: "POST",
            dataType: "json",
            data: {"_token": "{{ csrf_token() }}","id" : id},
            success: function (data) 
                    {
                        $(".viewlist").html(data);                 
                        $('#viewSignup').modal('show');           
                    }
            })         
    });  
    
     $("#businessapprove").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
    
     $("#businessredo").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>
@endsection
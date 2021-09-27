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
 <!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

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
    .vps4-header-status {
    float: right;
    position: relative;
    top: 8px;
   
    
}
.vps4-status-indicator {
    display: inline-block;
    width: 10px;
    height: 10px;
    border-radius: 50%;
}
.bg-success {
    color: #111;
    background-color: #02c54c !important;
}
.bg-dang {
    color: #111;
    background-color: red !important;
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
                    <h2>Leave List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Leaves</li>
                        <li class="breadcrumb-item active">Leave List</li>
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
                                        <th>Employee Name</th>                          
                                        <th>Leave Type</th>
                                        <th>Leave Duration</th>                                
                                        <th>Leave Start Date</th>
                                        <th>Leave End Date</th>
                                        <th>Reason</th>
                                        <th>Status</th>                               
                                        <th>Comments</th>                                       
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($Leaves as $key=>$leave)
                                    @php
                                        $User = \App\User::find($leave->user_id);                                    
                                    @endphp
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        @if($User->confirm_status == "1")
                                          <td>{{$User->first_name}} {{$User->last_name}} <div class="vps4-header-status vps4-status-indicator bg-success" style="margin-left:5px;"></div></td>  
                                        @else
                                            <td>{{$User->first_name}} {{$User->last_name}} <div class="vps4-header-status vps4-status-indicator bg-dang" style="margin-left:5px;"></div></td>
                                        @endif
                                        <td>
                                            @if($leave->leave_type == 'Comp Off')
                                                <span class="badge badge-danger">{{$leave->leave_type}}</span>
                                            @else
                                                <span class="badge badge-primary">{{$leave->leave_type}}</span>
                                            @endif                                           
                                        </td>
                                        <td>{{$leave->duration}}</td>
                                        <td>{{$leave->start_date}}</td>
                                        <td>{{$leave->end_date}}</td>
                                        <td>{{$leave->reason}}</td>
                                        @if($leave->admin_status == 'Approved')
                                        <td>
                                             <button class="btn btn-success btn-round">{{$leave->admin_status}}</button>
                                        </td>
                                        @elseif($leave->admin_status == 'Rejected')
                                        <td>
                                            <button class="btn btn-danger btn-round">{{$leave->admin_status}}</button>
                                        </td>
                                        @else
                                        <td>
                                            @if($user->id == $leave->user_id)
                                                <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                            @elseif($leave->level == '0')                                       
                                                @if($leave->tl == $user->id)
                                                    <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$leave->id}}">{{$leave->admin_status}}</button>
                                                @else                                            
                                                    <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                @endif
                                            @elseif($leave->level == '1')
                                                @if($leave->rm == $user->id)
                                                    <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$leave->id}}">{{$leave->admin_status}}</button>
                                                @else
                                                    <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                @endif
                                            @elseif($leave->level == '2')
                                                @if($leave->leave_type == 'Comp Off')    
                                                    @if($leave->rh == $user->id)
                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$leave->id}}">{{$leave->admin_status}}</button> 
                                                    @else
                                                        <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                    @endif
                                                @else
                                                    @if($leave->rh == $user->id)
                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$leave->id}}">{{$leave->admin_status}}</button>
                                                    @else
                                                        <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                    @endif
                                                @endif
                                            @endif                                        
                                        </td>
                                        @endif
                                        <td>{{$leave->admin_comment}}</td>
                                    </tr>
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

@foreach ($Leaves as $key=>$leave)
    @php
        $User = \App\User::find($leave->user_id);                                    
    @endphp
    <!-- For Material Design Colors -->
    <div class="modal fade" id="Modal{{$leave->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title " id="defaultModalLabel">{{$User->first_name}} {{$User->last_name}}</h4>
                </div>
                <form method="post" action="{{route('update_leave')}}"  enctype="multipart/form-data" id="update_leave">
                    @csrf
                    <input type="hidden" class="form-control" name="id" value="{{$leave->id}}">
                    <div class="modal-body">                 
                            <label>Status</label>
                            <div class="form-group">                                
                                <select class="form-control" name="status">
                                    <option value="">Select Status</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <label>Comment</label>
                            <div class="form-group">                                
                                <select class="form-control" name="comment">
                                    <option value="">Select Comment</option>
                                    <option value="Approved">Approved</option>
                                    <option value="As per HR Policy">As per HR Policy</option>
                                    <option value="Approved comp off">Approved comp off</option>
                                    <option value="Comp offs cannot be carried forward">Comp offs cannot be carried forward</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>                                        
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
                        <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>                  
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach


@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

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
   
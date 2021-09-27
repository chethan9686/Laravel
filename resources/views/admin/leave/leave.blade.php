@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Leaves List</title>

    @include('admin.layouts.css')
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

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
                    <h2>Leaves</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Leaves List</li>
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
                <div class="col-sm-12">
                    <div class="card">                       
                        <div class="body employee_data">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#other">Casual / Sick Leave</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#comp">Comp Off</a></li>                                                        
                            </ul>                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="other">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th width="12%">Employee Name</th>    
                                                        <th>Branch</th>                         
                                                        <th>Leave Type</th>
                                                        <th>Leave Duration</th>                                
                                                        <th>Leave Start Date</th>
                                                        <th>Leave End Date</th>
                                                        <th width="20%">Reason</th>
                                                        <th>Status</th>                               
                                                        <th>Comments</th>                                                      
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($Leave_Users as $key=>$leave)
                                                        @php
                                                            $user = \App\User::find($leave->user_id);
                                                            $branch = \App\Branch::find($leave->branch);
                                                            $Month = \Carbon\Carbon::parse($leave->created_at);
                                                            $Now = \Carbon\Carbon::now();
                                                        @endphp
                                                         @if($leave->leave_type != 'Comp Off' && $Month->year == $Now->year && $Month->month == $Now->month)
                                                        <tr>   
                                                            <td>{{$key+1}}</td>     
                                                            @if($user->confirm_status == "1")
                                                              <td>{{$user->first_name}} {{$user->last_name}} <div class="vps4-header-status vps4-status-indicator bg-success" style="margin-left:5px;"></div></td>  
                                                            @else
                                                              <td>{{$user->first_name}} {{$user->last_name}} <div class="vps4-header-status vps4-status-indicator bg-dang" style="margin-left:5px;"></div></td>  
                                                            @endif
                                                            <td>{{$branch->name}}</td>
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
                                                                @if($leave->level == '0')   
                                                                    @if($leave->tl == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                                    @endif                           
                                                                @elseif($leave->level == '1')
                                                                    @if($leave->rm == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                                    @endif
                                                                @elseif($leave->level == '2')                                                                   
                                                                    @if($leave->rh == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>
                                                                    @endif                                                                   
                                                                @endif                                        
                                                            </td>
                                                            @endif
                                                            <td>{{$leave->admin_comment}}</td>
                                                        </tr>
                                                        @endif
                                                    @endforeach                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                                <div role="tabpanel" class="tab-pane" id="comp">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th>Employee Name</th>   
                                                        <th>Branch</th>                          
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
                                                    @foreach($Comp_Users as $key=>$leave)
                                                        @php
                                                            $user = \App\User::find($leave->user_id);
                                                            $branch = \App\Branch::find($leave->branch);                                                                                        
                                                        @endphp
                                                       <tr>    
                                                            <td>{{$key+1}}</td>                                                        
                                                            @if($user->confirm_status == "1")
                                                              <td>{{$user->first_name}} {{$user->last_name}} <div class="vps4-header-status vps4-status-indicator bg-success" style="margin-left:5px;"></div></td>  
                                                            @else
                                                              <td>{{$user->first_name}} {{$user->last_name}} <div class="vps4-header-status vps4-status-indicator bg-dang" style="margin-left:5px;"></div></td>  
                                                            @endif
                                                            <td>{{$branch->name}}</td>
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
                                                                @if($leave->leave_type == "Comp Off" && (!is_null($leave->admin_comment) && $leave->rm != '1' && $leave->rh == '1'))
                                                                    <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                @elseif($leave->leave_type == "Comp Off" && (!is_null($leave->admin_comment) && $leave->rm != '1' && $leave->rh != '1'))
                                                                    <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                @elseif($leave->leave_type == "Comp Off" && $leave->rm == '1' && $leave->rh == '1')
                                                                    <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$user->first_name}} {{$user->last_name}}" data-id="{{$leave->id}}" data-target="#Modal">{{$leave->admin_status}}</button>
                                                                @else                                                                        
                                                                    <button class="btn btn-warning btn-round">{{$leave->admin_status}}</button>                                   
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
                </div>
            </div>    
        </div>
    </div>
</section>

<!-- For Material Design Colors -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title " id="defaulLabel"></h4>
            </div>
            <form method="post" action="{{route('admin.update_user_leave')}}"  enctype="multipart/form-data" id="update_user_leave">
                @csrf
                <input type="hidden" class="form-control id" name="id" value="">
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

<script>
    $(document).ready(function () {
         $('#Modal').on('show.bs.modal', function (event) { 
           var button = $(event.relatedTarget); 
           var id = button.data('id');
           var label = button.data('label');           
        
           var modal = $(this);
           modal.find('.title').text(label);
           modal.find('.id').val(id);  
        
         });
    });

    $("#update_user_leave").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>

{!! Toastr::message() !!}
</body>
@endsection
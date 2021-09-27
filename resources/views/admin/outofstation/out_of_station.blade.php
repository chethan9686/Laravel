@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Out of Station</title>

    @include('admin.layouts.css')
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <!-- Bootstrap Select Css -->
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
    </style>
</head>

<body class="theme-blush">

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
                    <h2>Out Of Station</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Out of Stations List</li>
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
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#ban">BANGALORE</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#mum">MUMBAI</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#del">DELHI</a></li>     
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#hyd">HYDERABAD</a></li>                            
                            </ul>                        
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="ban">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>                                                       
                                                        <th>Employee Name</th>   
                                                        <th>Branch</th>                       
                                                        <th>Event Name</th>
                                                        <th>Event Location</th>                                
                                                        <th>Departure Date</th>
                                                        <th>Departure Time</th>
                                                        <th>Arrival Date</th>
                                                        <th>Arrival Time</th>                               
                                                        <th>Purpose of Work</th>
                                                     <!--    <th>Purpose of Travel</th> -->
                                                        <th>Mode of Travel</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Bang_Users as $key=>$station)
                                                        @php
                                                             $user = \App\User::find($station->user_id);
                                                             $branch = \App\Branch::find($station->branch);
                                                        @endphp
                                                        <tr>                                                            
                                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                            <td>{{$branch->name}}</td>
                                                            <td>{{$station->event_name}}</td>
                                                            <td>{{$station->event_location}}</td>
                                                            <td>{{$station->departure_date}}</td>
                                                            <td>{{$station->departure_time}}</td>
                                                            <td>{{$station->arrival_date}}</td>
                                                            <td>{{$station->arrival_time}}</td>
                                                            <td>{{$station->purpose_of_work}}</td>
                                                           <!--  <td>{{$station->purpose_of_travel}}</td> -->
                                                            <td>{{$station->travel_mode}}</td>
                                                            @if($station->admin_status == 'Approved')
                                                            <td>
                                                                 <button class="btn btn-success btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @elseif($station->admin_status == 'Rejected')
                                                            <td>
                                                                <button class="btn btn-danger btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @else
                                                            <td>
                                                                @if($station->level == '0')  
                                                                    @if($station->tl == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif                                    
                                                                @elseif($station->level == '1')
                                                                    @if($station->rm == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @elseif($station->level == '2')
                                                                    @if($station->rh == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @endif                                        
                                                            </td>
                                                            @endif
                                                            <td>{{$station->admin_comment}}</td>
                                                        </tr>
                                                    @endforeach
                                                   
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>  
                                <div role="tabpanel" class="tab-pane" id="mum">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>                                                        
                                                        <th>Employee Name</th>    
                                                        <th>Branch</th>                            
                                                        <th>Event Name</th>
                                                        <th>Event Location</th>                                
                                                        <th>Departure Date</th>
                                                        <th>Departure Time</th>
                                                        <th>Arrival Date</th>
                                                        <th>Arrival Time</th>                               
                                                        <th>Purpose of Work</th>
                                                      <!--   <th>Purpose of Travel</th> -->
                                                        <th>Mode of Travel</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Mum_Users as $key=>$station)
                                                        @php
                                                             $user = \App\User::find($station->user_id);
                                                             $branch = \App\Branch::find($station->branch);
                                                        @endphp
                                                        <tr>                                                           
                                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                            <td>{{$branch->name}}</td>
                                                            <td>{{$station->event_name}}</td>
                                                            <td>{{$station->event_location}}</td>
                                                            <td>{{$station->departure_date}}</td>
                                                            <td>{{$station->departure_time}}</td>
                                                            <td>{{$station->arrival_date}}</td>
                                                            <td>{{$station->arrival_time}}</td>
                                                            <td>{{$station->purpose_of_work}}</td>
                                                          <!--   <td>{{$station->purpose_of_travel}}</td> -->
                                                            <td>{{$station->travel_mode}}</td>
                                                            @if($station->admin_status == 'Approved')
                                                            <td>
                                                                 <button class="btn btn-success btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @elseif($station->admin_status == 'Rejected')
                                                            <td>
                                                                <button class="btn btn-danger btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @else
                                                            <td>
                                                                @if($station->level == '0') 
                                                                    @if($station->tl == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif                                     
                                                                @elseif($station->level == '1')
                                                                    @if($station->rm == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @elseif($station->level == '2')
                                                                    @if($station->rh == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @endif                                        
                                                            </td>
                                                            @endif
                                                            <td>{{$station->admin_comment}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                                <div role="tabpanel" class="tab-pane" id="del">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>                                                      
                                                        <th>Employee Name</th>  
                                                        <th>Branch</th>                              
                                                        <th>Event Name</th>
                                                        <th>Event Location</th>                                
                                                        <th>Departure Date</th>
                                                        <th>Departure Time</th>
                                                        <th>Arrival Date</th>
                                                        <th>Arrival Time</th>                               
                                                        <th>Purpose of Work</th>
                                                  <!--       <th>Purpose of Travel</th> -->
                                                        <th>Mode of Travel</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Del_Users as $key=>$station)
                                                        @php
                                                             $user = \App\User::find($station->user_id);
                                                             $branch = \App\Branch::find($station->branch);
                                                        @endphp
                                                        <tr>                                                           
                                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                            <td>{{$branch->name}}</td>
                                                            <td>{{$station->event_name}}</td>
                                                            <td>{{$station->event_location}}</td>
                                                            <td>{{$station->departure_date}}</td>
                                                            <td>{{$station->departure_time}}</td>
                                                            <td>{{$station->arrival_date}}</td>
                                                            <td>{{$station->arrival_time}}</td>
                                                            <td>{{$station->purpose_of_work}}</td>
                                                        <!--     <td>{{$station->purpose_of_travel}}</td> -->
                                                            <td>{{$station->travel_mode}}</td>
                                                            @if($station->admin_status == 'Approved')
                                                            <td>
                                                                 <button class="btn btn-success btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @elseif($station->admin_status == 'Rejected')
                                                            <td>
                                                                <button class="btn btn-danger btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @else
                                                            <td>
                                                                @if($station->level == '0')     
                                                                    @if($station->tl == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif                                     
                                                                @elseif($station->level == '1')
                                                                    @if($station->rm == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @elseif($station->level == '2')
                                                                    @if($station->rh == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @endif                                        
                                                            </td>
                                                            @endif
                                                            <td>{{$station->admin_comment}}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                   <div class="body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                                <thead>
                                                    <tr>                                                        
                                                        <th>Employee Name</th>  
                                                        <th>Branch</th>                              
                                                        <th>Event Name</th>
                                                        <th>Event Location</th>                                
                                                        <th>Departure Date</th>
                                                        <th>Departure Time</th>
                                                        <th>Arrival Date</th>
                                                        <th>Arrival Time</th>                               
                                                        <th>Purpose of Work</th>
                                                     <!--    <th>Purpose of Travel</th> -->
                                                        <th>Mode of Travel</th>
                                                        <th>Status</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach ($Hyd_Users as $key=>$station)
                                                        @php
                                                             $user = \App\User::find($station->user_id);
                                                             $branch = \App\Branch::find($station->branch);
                                                        @endphp
                                                        <tr>                                                           
                                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                            <td>{{$branch->name}}</td>
                                                            <td>{{$station->event_name}}</td>
                                                            <td>{{$station->event_location}}</td>
                                                            <td>{{$station->departure_date}}</td>
                                                            <td>{{$station->departure_time}}</td>
                                                            <td>{{$station->arrival_date}}</td>
                                                            <td>{{$station->arrival_time}}</td>
                                                            <td>{{$station->purpose_of_work}}</td>
                                                       <!--      <td>{{$station->purpose_of_travel}}</td> -->
                                                            <td>{{$station->travel_mode}}</td>
                                                            @if($station->admin_status == 'Approved')
                                                            <td>
                                                                 <button class="btn btn-success btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @elseif($station->admin_status == 'Rejected')
                                                            <td>
                                                                <button class="btn btn-danger btn-round">{{$station->admin_status}}</button>
                                                            </td>
                                                            @else
                                                            <td>
                                                                @if($station->level == '0')   
                                                                    @if($station->tl == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif                                     
                                                                @elseif($station->level == '1')
                                                                    @if($station->rm == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @elseif($station->level == '2')
                                                                    @if($station->rh == '1')
                                                                        <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-label="{{$station->event_name}}" data-id="{{$station->id}}" data-target="#Modal">{{$station->admin_status}}</button>
                                                                    @else
                                                                        <button class="btn btn-warning btn-round">{{$station->admin_status}}</button>
                                                                    @endif
                                                                @endif                                        
                                                            </td>
                                                            @endif
                                                            <td>{{$station->admin_comment}}</td>
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
            <form method="post" action="{{route('admin.update_out_of_station')}}"  enctype="multipart/form-data">
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
</script>
{!! Toastr::message() !!}
</body>
@endsection
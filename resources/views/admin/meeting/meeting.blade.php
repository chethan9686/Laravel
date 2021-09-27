@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Meetings List</title>

    @include('admin.layouts.css')
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
    <link rel="stylesheet" href="{{asset('admin/plugins/summernote/dist/summernote.css')}}"/>
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
                    <h2>Meeting List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Latest Meetings List</li>
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
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th>Name</th>
                                                        <!--<th>Branch</th>-->
                                                        <th>Company Name</th>
                                                        <th>Client Name</th>
                                                        <th>Client Email</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                        <th>ETA</th>
                                                        <th>Location</th>
                                                        <th>Purpose Of Meeting</th>
                                                        <th>Status</th>                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Bang_Users as $key=>$meeting)
                                                        @php
                                                             $user = \App\User::find($meeting->user_id);
                                                             $branch = \App\Branch::find($meeting->branch);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                            <!--<td>{{ $branch->name }}</td>-->
                                                            <td>{{ $meeting->company_name }}</td>
                                                            <td>{{ $meeting->client_name }}</td>
                                                            <td>{{ $meeting->client_email }}</td>
                                                            <td>{{ $meeting->date }}</td>
                                                            <td>{{ $meeting->time }}</td>
                                                            <td>{{ $meeting->duration }}</td>
                                                            <td>{{ $meeting->eta }}</td>
                                                            <td>{{ $meeting->location }}</td>
                                                            <td>{{ $meeting->purpose_of_meeting }}</td>
                                                            <td>
                                                                @if($meeting->meeting_status == NULL)                                                                   
                                                                    <button class="btn btn-round btn-warning">Pending</button>                                          
                                                                @elseif($meeting->meeting_status == 'Completed')                             
                                                                    <button type="button" class="btn btn-round btn-success Completed"  data-toggle="modal" data-id="{{ $meeting->id }}">Completed</button>
                                                                @elseif($meeting->meeting_status == 'Postponed')   
                                                                    <button  type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target="#viewPostponed" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Postoned</button>
                                                                @elseif($meeting->meeting_status == 'Canceled')   
                                                                    <button  type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#viewCanceled" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Canceled</button> 
                                                                @endif
                                                            </td>
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
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th>Name</th>
                                                        <!--<th>Branch</th>-->
                                                        <th>Company Name</th>
                                                        <th>Client Name</th>
                                                        <th>Client Email</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                        <th>ETA</th>
                                                        <th>Location</th>
                                                        <th>Purpose Of Meeting</th>
                                                        <th>Status</th>                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Mum_Users as $key=>$meeting)
                                                        @php
                                                             $user = \App\User::find($meeting->user_id);
                                                             $branch = \App\Branch::find($meeting->branch);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                           <!-- <td>{{ $branch->name }}</td>-->
                                                            <td>{{ $meeting->company_name }}</td>
                                                            <td>{{ $meeting->client_name }}</td>
                                                            <td>{{ $meeting->client_email }}</td>
                                                            <td>{{ $meeting->date }}</td>
                                                            <td>{{ $meeting->time }}</td>
                                                            <td>{{ $meeting->duration }}</td>
                                                            <td>{{ $meeting->eta }}</td>
                                                            <td>{{ $meeting->location }}</td>
                                                            <td>{{ $meeting->purpose_of_meeting }}</td>
                                                            <td>
                                                                @if($meeting->meeting_status == NULL)                                                                   
                                                                    <button class="btn btn-round btn-warning">Pending</button>                                           
                                                                @elseif($meeting->meeting_status == 'Completed')                             
                                                                    <button type="button" class="btn btn-round btn-success Completed"  data-toggle="modal" data-id="{{ $meeting->id }}">Completed</button>
                                                                @elseif($meeting->meeting_status == 'Postponed')   
                                                                    <button  type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target="#viewPostponed" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Postoned</button>
                                                                @elseif($meeting->meeting_status == 'Canceled')   
                                                                    <button  type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#viewCanceled" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Canceled</button> 
                                                                @endif
                                                            </td>
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
                                            <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length='250'>
                                                <thead>
                                                    <tr>
                                                        <th>Sl.no</th>
                                                        <th>Name</th>
                                                      <!--  <th>Branch</th>-->
                                                        <th>Company Name</th>
                                                        <th>Client Name</th>
                                                        <th>Client Email</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                        <th>ETA</th>
                                                        <th>Location</th>
                                                        <th>Purpose Of Meeting</th>
                                                        <th>Status</th>                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($Del_Users as $key=>$meeting)
                                                        @php
                                                             $user = \App\User::find($meeting->user_id);
                                                             $branch = \App\Branch::find($meeting->branch);
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                            <!--<td>{{ $branch->name }}</td>-->
                                                            <td>{{ $meeting->company_name }}</td>
                                                            <td>{{ $meeting->client_name }}</td>
                                                            <td>{{ $meeting->client_email }}</td>
                                                            <td>{{ $meeting->date }}</td>
                                                            <td>{{ $meeting->time }}</td>
                                                            <td>{{ $meeting->duration }}</td>
                                                            <td>{{ $meeting->eta }}</td>
                                                            <td>{{ $meeting->location }}</td>
                                                            <td>{{ $meeting->purpose_of_meeting }}</td>
                                                            <td>
                                                                @if($meeting->meeting_status == NULL)                                                                   
                                                                    <button class="btn btn-round btn-warning">Pending</button>                                          
                                                                @elseif($meeting->meeting_status == 'Completed')                             
                                                                   <button type="button" class="btn btn-round btn-success Completed"  data-toggle="modal" data-id="{{ $meeting->id }}">Completed</button>
                                                                @elseif($meeting->meeting_status == 'Postponed')   
                                                                    <button  type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target="#viewPostponed" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Postoned</button>
                                                                @elseif($meeting->meeting_status == 'Canceled')   
                                                                    <button  type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#viewCanceled" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Canceled</button> 
                                                                @endif
                                                            </td>
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
                                                        <th>Sl.no</th>
                                                        <th>Name</th>
                                                        <!--<th>Branch</th>-->
                                                        <th>Company Name</th>
                                                        <th>Client Name</th>
                                                        <th>Client Email</th>
                                                        <th>Date</th>
                                                        <th>Time</th>
                                                        <th>Duration</th>
                                                        <th>ETA</th>
                                                        <th>Location</th>
                                                        <th>Purpose Of Meeting</th>
                                                        <th>Status</th>                                                       
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   @foreach ($Hyd_Users as $key=>$meeting)
                                                        @php
                                                             $user = \App\User::find($meeting->user_id);
                                                             $branch = \App\Branch::find($meeting->branch);
                                                        @endphp
                                                         <tr>
                                                            <td>{{ $key+1 }}</td>
                                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                            <!--<td>{{ $branch->name }}</td>-->
                                                            <td>{{ $meeting->company_name }}</td>
                                                            <td>{{ $meeting->client_name }}</td>
                                                            <td>{{ $meeting->client_email }}</td>
                                                            <td>{{ $meeting->date }}</td>
                                                            <td>{{ $meeting->time }}</td>
                                                            <td>{{ $meeting->duration }}</td>
                                                            <td>{{ $meeting->eta }}</td>
                                                            <td>{{ $meeting->location }}</td>
                                                            <td>{{ $meeting->purpose_of_meeting }}</td>
                                                            <td>
                                                                @if($meeting->meeting_status == NULL)                                                                   
                                                                    <button class="btn btn-round btn-warning">Pending</button>                                          
                                                                @elseif($meeting->meeting_status == 'Completed')                             
                                                                     <button type="button" class="btn btn-round btn-success Completed"  data-toggle="modal" data-id="{{ $meeting->id }}">Completed</button>
                                                                @elseif($meeting->meeting_status == 'Postponed')   
                                                                    <button  type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target="#viewPostponed" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Postoned</button>
                                                                @elseif($meeting->meeting_status == 'Canceled')   
                                                                    <button  type="button" class="btn btn-round btn-danger" data-toggle="modal" data-target="#viewCanceled" data-heading="{{ $meeting->company_name }}" data-reason="{{ $meeting->reason }}">Canceled</button> 
                                                                @endif
                                                            </td>
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


<!-- Large Size -->
<div class="modal fade" id="viewCompleted" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg viewcomp" role="document">
       
    </div>
</div>


<!-- Large Size -->
<div class="modal fade" id="viewPostponed" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Postponed - <span class="heading"></span></h4>
            </div>
            <div class="modal-body"> 
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label>Reason For Postponed</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                            </div>
                            <textarea class="form-control reason" rows="3" name="postpone" placeholder="Reason For Postponed"></textarea>                                       
                        </div>                                               
                    </div>
                </div>
            </div>
            <div class="modal-footer">              
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>

<!-- Large Size -->
<div class="modal fade" id="viewCanceled" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="title" id="largeModalLabel">Canceled - <span class="heading"></span></h4>
            </div>
            <div class="modal-body"> 
                 <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
                        <label>Reason For Canceled</label>
                        <div class="input-group masked-input">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-comment-list"></i></span>
                            </div>
                            <textarea class="form-control reason" rows="3" name="cancel" placeholder="Reason For Canceled"></textarea>                                  
                        </div>                                               
                    </div>
                </div>
            </div>
            <div class="modal-footer">               
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">CLOSE</button>
            </div>
        </div>
    </div>
</div>


@include('admin.layouts.js')
<script src="{{asset('admin/plugins/summernote/dist/summernote.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
<script type="text/javascript">
   $('.summernote').summernote({
        height: 120,   
        width:1500,
        toolbar: [   
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        placeholder: 'Key Points / Discussion Details',    
    });

    $(document).ready(function () {
        $('#viewPostponed').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var reason = button.data('reason');           
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('.reason').val(reason);  
        });

        $('#viewCanceled').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');
           var reason = button.data('reason');           
        
           var modal = $(this);
           modal.find('.heading').text(heading);
           modal.find('.reason').val(reason);  
        });
    });

    $(document).on('click', '.Completed', function (e) {
        e.preventDefault();
        var id = $(this).data('id');       
        $.ajax({
            url: '{{ route('admin.view_completed') }}',
            type: "POST",
            dataType: "json",
            data: {"_token": "{{ csrf_token() }}","id" : id},
            success: function (data) 
                    {
                          $(".viewcomp").html(data);   
                          $(".summernote").summernote('code');
                          $('#viewCompleted').modal('show');           
                    }
            })         
    });     

</script>
{!! Toastr::message() !!}
</body>
@endsection
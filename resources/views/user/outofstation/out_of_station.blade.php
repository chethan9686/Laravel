@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Out Of Station</title>

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
                    <h2>Out Of Station</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Out Of Station</li>
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
                <div class="col-lg-1 col-md-1 col-sm-1">                    
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10">                           
                    <div class="card">    
                        <div class="header">
                            <h2>Add<strong> Out Of Station </strong></h2>
                        </div>                                  
                        <div class="body">  
                            <form method="post" action="{{route('add_out_of_station')}}" id="add_out_of_station">
                                @csrf
                                <div class="row">                     
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Purpose Of Work</label>
                                        <div class="form-group">                                                   
                                            <select class="form-control show-tick" name="work_purpose">
                                               <option value="">Purpose Of Work</option>
                                               <option value="Meeting">Meeting</option>
                                               <option value="Event">Event</option>
                                               <option value="Recce">Recce</option>                                            
                                            </select>  
                                            @if ($errors->has('work_purpose'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('work_purpose') }}</strong>
                                                </span>
                                            @endif                                                                                                
                                        </div>
                                    </div>
                                   <!--  <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label for="email_address">Purpose Of Travel</label>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-bus"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Purpose Of Travel" name="travel_purpose">
                                            </div>
                                            @if ($errors->has('travel_purpose'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('travel_purpose') }}</strong>
                                                </span>
                                            @endif  
                                        </div>
                                    </div> -->

                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Event/Meeting/Recce Name</label>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-explicit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Event/Meeting/Recce Name" name="event_name">
                                            </div>
                                            @if ($errors->has('event_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('event_name') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label for="email_address">Departure Date</label>
                                        <div class="form-group">                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" placeholder="Departure Date" name="departure_date">
                                            </div>
                                            @if ($errors->has('departure_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('departure_date') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label for="email_address">Departure Time</label>
                                        <div class="form-group">                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                                </div>
                                                <input type="text" class="form-control timepicker" placeholder="Departure Time" name="departure_time">
                                            </div>
                                            @if ($errors->has('departure_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('departure_time') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label for="email_address">Arrival Date</label>
                                        <div class="form-group">                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" placeholder="Arrival Date " name="arrival_date">
                                            </div>
                                            @if ($errors->has('arrival_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('arrival_date') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                        <label for="email_address">Arrival Time To Office</label>
                                        <div class="form-group">                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                                </div>
                                                <input type="text" class="form-control timepicker" placeholder="Arrival Time To Office" name="arrival_time">
                                            </div>
                                            @if ($errors->has('arrival_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('arrival_time') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label for="email_address">Date Of Event/Meeting/Recce</label>
                                        <div class="form-group">                            
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                                                </div>
                                                <input type="text" class="form-control datepicker" placeholder="Date Of Event/Meeting/Recce" name="event_date">
                                            </div>
                                            @if ($errors->has('event_date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('event_date') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label for="email_address">Location of Event/Meeting/Recce</label>
                                        <div class="form-group">                                
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-pin"></i></span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Location of Event/Meeting/Recce" name="location">
                                            </div>
                                            @if ($errors->has('location'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('location') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label for="email_address">Mode Of Travel</label>
                                        <div class="form-group">                                                   
                                           <select class="form-control show-tick" name="mode_of_travel">
                                                <option value="">Mode Of Travel</option>
                                                <option value="Bus">Bus</option>
                                                <option value="Car">Car</option>
                                                <option value="Train">Train</option>
                                                <option value="Flight">Flight</option>                            
                                            </select>   
                                            @if ($errors->has('mode_of_travel'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('mode_of_travel') }}</strong>
                                                </span>
                                            @endif                                                                                             
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>

                                </div>
                            </form>
                        </div>                               
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">                    
                </div>
            </div>

            <div class="row clearfix">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                        <thead>
                            <tr>
                                <th>Sl.no</th>
                                <th>Employee Name</th>                          
                                <th>Event Name</th>
                                <th>Event Location</th>                                
                                <th>Departure Date</th>
                                <th>Departure Time</th>
                                <th>Arrival Date</th>
                                <th>Arrival Time</th>                               
                                <th>Purpose of Work</th>
                                <!--<th>Purpose of Travel</th>-->
                                <th>Mode of Travel</th>
                                <th>Status</th>
                                <th>Comment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($OutStations as $key=>$OutStation)
                                @php
                                    $User = \App\User::find($OutStation->user_id);                                    
                                @endphp
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$User->first_name}} {{$User->last_name}}</td>
                                    <td>{{$OutStation->event_name}}</td>
                                    <td>{{$OutStation->event_location}}</td>
                                    <td>{{$OutStation->departure_date}}</td>
                                    <td>{{$OutStation->departure_time}}</td>
                                    <td>{{$OutStation->arrival_date}}</td>
                                    <td>{{$OutStation->arrival_time}}</td>
                                    <td>{{$OutStation->purpose_of_work}}</td>
                                    <!--<td>{{$OutStation->purpose_of_travel}}</td>-->
                                    <td>{{$OutStation->travel_mode}}</td>
                                    @if($OutStation->admin_status == 'Approved')
                                    <td>
                                         <button class="btn btn-success btn-round">{{$OutStation->admin_status}}</button>
                                    </td>
                                    @elseif($OutStation->admin_status == 'Rejected')
                                    <td>
                                        <button class="btn btn-danger btn-round">{{$OutStation->admin_status}}</button>
                                    </td>
                                    @else
                                    <td>
                                        @if($OutStation->level == '0')                                       
                                            @if($OutStation->tl == $user->id)
                                                <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$OutStation->id}}">{{$OutStation->admin_status}}</button>
                                            @else                                            
                                                <button class="btn btn-warning btn-round">{{$OutStation->admin_status}}</button>
                                            @endif
                                        @elseif($OutStation->level == '1')
                                            @if($OutStation->rm == $user->id)
                                                <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$OutStation->id}}">{{$OutStation->admin_status}}</button>
                                            @else
                                                <button class="btn btn-warning btn-round">{{$OutStation->admin_status}}</button>
                                            @endif
                                        @elseif($OutStation->level == '2')
                                            @if($OutStation->rh == $user->id)
                                                <button type="button" class="btn btn-warning btn-round" data-toggle="modal" data-target="#Modal{{$OutStation->id}}">{{$OutStation->admin_status}}</button>
                                            @else
                                                <button class="btn btn-warning btn-round">{{$OutStation->admin_status}}</button>
                                            @endif
                                        @endif                                        
                                    </td>
                                    @endif
                                    <td>{{$OutStation->admin_comment}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@foreach ($OutStations as $key=>$OutStation)
    <!-- For Material Design Colors -->
    <div class="modal fade" id="Modal{{$OutStation->id}}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="title " id="defaultModalLabel">{{$OutStation->event_name}}</h4>
                </div>
                <form method="post" action="{{route('update_out_of_station')}}"  enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="id" value="{{$OutStation->id}}">
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

<script type="text/javascript">   
   $('.datepicker').bootstrapMaterialDatePicker({minDate : new Date(),time: false });

   $("#add_out_of_station").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>

</body>

@endsection
   
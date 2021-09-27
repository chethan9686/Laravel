@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Lateworking</title>

@include('user.layouts.css')

 <!-- JQuery DataTable Css -->
  <link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <style type="text/css">
    .text-center-row>th, .text-center-row>td 
    {
      text-align: center;
      vertical-align:middle;
    } 
    .card-inside-title, h6{
      text-transform: none !important;
    }
     .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
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
                    <h2>Late Working</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Late Working</li>
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
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                       <div class="header">
                          <h2> <strong>Late Working</strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{ route('storelateworking') }}" id="storelateworking">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-6">
                                        <label>Branch Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-city-alt"></i></span>
                                            </div>                                                              
                                            <input type="text" name="branch" class="form-control mobile-phone-number" value="{{ $userbranch->name}}" readonly="">
                                            @if ($errors->has('branch'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('branch') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label>Date Of Work</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                            </div>
                                            <input type="text" name="date" class="form-control datetime" value="<?php echo date("d-m-Y");?>" readonly="">
                                            @if ($errors->has('date'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('date') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label>Time</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-time"></i></span>
                                            </div>
                                            <input type="text" name="time" class="form-control mobile-phone-number" value="<?php date_default_timezone_set('Asia/Calcutta'); echo date('H:i:s');?>" readonly="">
                                            @if ($errors->has('time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('time') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label>Client Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                                            </div>
                                            <input type="text" name="clientName" class="form-control mobile-phone-number" placeholder="Ex: Client Name">
                                            @if ($errors->has('clientName'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('clientName') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label>Event Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-panorama-horizontal"></i></span>
                                            </div>
                                            <input type="text" name="event_worked_on" class="form-control mobile-phone-number" placeholder="Ex: Event Name">
                                            @if ($errors->has('event_worked_on'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('event_worked_on') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <label>Purpose Of Work</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-airplay"></i></span>
                                            </div>
                                            <input type="text" name="purpose_of_work" class="form-control mobile-phone-number" placeholder="Ex: Text here..">
                                            @if ($errors->has('purpose_of_work'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('purpose_of_work') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">                                       
                                       
                                        @php                                      
                                        // Bangalore||Kolkata||Chennai at 9pm
                                        $Bang = \Carbon\Carbon::parse('today 9am');
                                        // Mumbai||Pune at 9.30pm
                                        $Mum = \Carbon\Carbon::parse('today 9.30pm');
                                        // Delhi at 9.30pm
                                        $Del = \Carbon\Carbon::parse('today 9.30pm');
                                        // Hyderabad at 9.30pm
                                        $Hyd = \Carbon\Carbon::parse('today 9.30pm');

                                        // tomorrow 6am
                                        $tomorrow = \Carbon\Carbon::parse('today 11am');

                                        // Now
                                        $now = \Carbon\Carbon::now();                                                                
                                        @endphp                                     
                                      
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        @if($user->branch == 1 || $user->branch == 6 || $user->branch == 7)
                                            @if ($now->gte($Bang) && $now->lte($tomorrow))
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            @else
                                                <button type="button" class="btn btn-primary btn-block" >Submit @ {{$Bang}}</button>
                                                <p style="margin-top: 20px;margin-bottom: 20px;font-size: 14px;"><b style="color:red;">Please Note :</b> Late working can be entered from <b style="color:red;">9:00 PM </b>to <b style="color:red;">6:00 AM</b> while still in the office/client site.</p>
                                            @endif
                                        @elseif($user->branch == 2 || $user->branch == 5)
                                            @if ($now->gte($Mum) && $now->lte($tomorrow))
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            @else
                                                <button type="button" class="btn btn-primary btn-block" >Submit @ {{$Mum}}</button>
                                                <p style="margin-top: 20px;margin-bottom: 20px;font-size: 14px;"><b style="color:red;">Please Note :</b> Late working can be entered from <b style="color:red;">9:30 PM </b>to <b style="color:red;">6:00 AM</b> while still in the office/client site.</p>
                                            @endif
                                        @elseif($user->branch == 3)
                                            @if ($now->gte($Del) && $now->lte($tomorrow))
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            @else
                                                <button type="button" class="btn btn-primary btn-block" >Submit @ {{$Del}}</button>
                                                <p style="margin-top: 20px;margin-bottom: 20px;font-size: 14px;"><b style="color:red;">Please Note :</b> Late working can be entered from <b style="color:red;">9:30 PM </b>to <b style="color:red;">6:00 AM</b> while still in the office/client site.</p>
                                            @endif
                                        @elseif($user->branch == 4)                                        
                                            @if ($now->gte($Hyd) && $now->lte($tomorrow))
                                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                            @else
                                                <button type="button" class="btn btn-primary btn-block" >Submit @ {{$Hyd}}</button>
                                                <p style="margin-top: 20px;margin-bottom: 20px;font-size: 14px;"><b style="color:red;">Please Note :</b> Late working can be entered from <b style="color:red;">9:00 PM </b>to <b style="color:red;">6:00 AM</b> while still in the office/client site.</p>
                                            @endif
                                        @endif 
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                    </div>
                                </div>        
                            </form>                                            
                        </div>
                    </div>
                </div>
            </div>
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Export</strong> Late Working </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th>Name</th>
                                            <th>Branch</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Client Name</th>
                                            <th>Event Name</th>
                                            <th>Purpose of Work</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                     
                                      @foreach($lateworkingdata as $key => $data)
                                      @php
                                      $user = \App\User::find($data->user_id);
                                      $branch = \App\Branch::find($data->branch);
                                      @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{$user->first_name }} {{$user->last_name }}</td>
                                            <td>{{ $branch->name }}</td>
                                            <td><?php echo date('d-m-Y', strtotime($data->date)) ?></td>
                                             <td><?php echo date("h:i A",strtotime($data->time)) ?></td>
                                            <td>{{ $data->clientName }}</td>
                                            <td>{{ $data->event_worked_on }}</td>
                                            <td>{{ $data->purpose_of_work }}</td>
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
</section>


@include('user.layouts.js')

<!-- Jquery DataTable Plugin Js --> 
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
   
  $("#storelateworking").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
   
</script>
</body>

@endsection
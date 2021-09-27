@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Vendor Meeting</title>

@include('user.layouts.css')

  <!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<!-- Bootstrap Material Datetime Picker Css -->
<link href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
<link href="{{asset('user/pastimepicker/css/jquery.datetimepicker.min.css')}}" rel="stylesheet" />
<script src="{{asset('user/pastimepicker/js/jquery.min.js')}}"></script>
<!-- Multi Select Css -->
<link href="{{asset('user/plugins/multi-select/css/multi-select.css')}}" rel="stylesheet" />
<link href="{{asset('user/plugins/select2/select2.css')}}" rel="stylesheet" />
<link rel="stylesheet" href="assets/" />
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
        .table-bordered thead{
            background: #00BCD4;
            color: #fff;
        }
       
         .select2-container-multi .select2-choices .select2-search-field input {
            padding: 0px !important; 
            margin: 0px 0 !important;
                font-family: sans-serif;
                font-size: 100%;
                color: #666;
                outline: 0;
                border: 0;
                -webkit-box-shadow: none;
                /* box-shadow: none; */
                background: #fff !important;
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
                    <h2>Vendor Meeting</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Work Schedule</li>
                        <li class="breadcrumb-item active">Vendor Meeting</li>
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
                          <h2> <strong>Vendor Meeting</strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{ route('vendormeetingcreate')}}" id="vendormeetingcreate" enctype="multipart/form-data" autocomplete="off">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4">
                                        <label>Vendor Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                                            </div>                                                              
                                            <input type="text" name="vendor_name" class="form-control mobile-phone-number">
                                            @if ($errors->has('vendor_name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_name') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Event Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-surround-sound"></i></span>
                                            </div>
                                            <input type="text" name="vendor_eventname" class="form-control datetime">
                                            @if ($errors->has('vendor_eventname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_eventname') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Meeting Location</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-google-maps"></i></span>
                                            </div>
                                            <input type="text" name="location" class="form-control" >
                                            @if ($errors->has('location'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('location') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Date Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                            </div>
                                            <input type="text" name="vendor_dateofmeeting" id="date" class="form-control">
                                            @if ($errors->has('vendor_dateofmeeting'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_dateofmeeting') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Scheduled Meeting Time</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-timer"></i></span>
                                            </div>
                                            <input type="text" name="vendor_time" class="form-control calendar">
                                            @if ($errors->has('vendor_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_time') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Expected Time Back To Office</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-city-alt"></i></span>
                                            </div>
                                            <input type="text" name="vendor_ERTW" class="form-control" id="time">
                                            @if ($errors->has('vendor_ERTW'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_ERTW') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label>Purpose Of Meeting</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-info-outline"></i></span>
                                            </div>
                                            <textarea rows="4" class="form-control no-resize" placeholder="Please type Purpose Of Meeting.." name="vendor_purpose"></textarea>
                                            @if ($errors->has('vendor_purpose'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('vendor_purpose') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label>Tag Team Member</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-male-female"></i></span>
                                            </div>
                                            <select class="form-control show-tick ms select2" multiple data-placeholder="Tag Team Member" name="references_id[]">
                                                @foreach($Bang_Employees as $data)
                                                    @if($data->id != Auth::user()->id)
                                                    <option value="{{$data->id}}">{{$data->first_name}} {{$data->last_name}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">   
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                    </div>
                                </div>        
                            </form>                                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1">
                </div>
            </div>
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Export</strong> Vendor Meeting </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th>Name</th>
                                            <th>Branch</th>
                                            <th>Vendor Name</th>
                                            <th>Date Of Meeting</th>
                                            <th>Event Name</th>
                                            <th>Time Of Meeting</th>
                                            <th>Location</th>
                                            <th>Reporting Time to Work</th>
                                            <th>Purpose of Work</th>
                                            <th>Tag Users</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach($Meetingsid as $key=>$data)
                                         @php                                            
                                           $user = \App\User::find($data->user_id);
                                           $branch = \App\Branch::find($data->branch);                                           
                                          @endphp
                                             <?php
                                          if($data->references_id != 0){
                                            $tag_users = \App\VendorMeeting::where('references_id','=',$data->references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->references_id)->get();
                                            foreach($tag_users as $key1=>$tag){
                                                    $users = \App\User::find($tag->user_id);                                               
                                                    $Res[$key1] = $users->first_name;
                                                }  
                                            }else{
                                                   $tag_users = \App\VendorMeeting::where('references_id','=',$data->id)->get();
                                            foreach($tag_users as $key1=>$tag){
                                                    $users = \App\User::find($tag->user_id);                                               
                                                    $Res[$key1] = $users->first_name;
                                                }   
                                            }
                                                                                
                                          ?>
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                <td>{{$branch->name}}</td>
                                                <td>{{$data->vendor_name}}</td>
                                                <td><?php echo date('d-m-Y', strtotime($data->vendor_dateofmeeting)) ?></td>
                                                <td>{{$data->vendor_eventname}}</td>
                                                <td><?php echo date("h:i A",strtotime($data->vendor_time)) ?></td>
                                                <td>{{$data->location}}</td>
                                                <td><?php echo date("h:i A",strtotime($data->vendor_ERTW)) ?></td>
                                                <td>{{$data->vendor_purpose }}</td>
                                                <td>@if(!empty($Res))<span class="badge badge-success">{{implode(',',$Res)}} </span>@endif</td>                                                
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
<!-- Moment Plugin Js --> 
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script>
<script src="{{asset('user/pastimepicker/js/jquery.datetimepicker.js')}}"></script>

<!-- Jquery Core Js --> 
<script src="{{asset('user/plugins/multi-select/js/jquery.multi-select.js')}}"></script>
<script src="{{asset('user/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/advanced-form-elements.js')}}"></script>
<script>
$(function() {
    $(".calendar").datetimepicker({
        minTime: 0,
        format:'H:i',
        step: 15,
        forceRoundTime: true,
        datepicker:false,
        minDate:'-1970/01/01', // today is minimum date
        onSelectDate: function(ct, $i) {
        var minTime, now = new Date;
        if(ct.getTime() > now){
            minTime = false;
        }else{
            var d = $i.val().substr(0, 11) + (Number(now.getHours()) + 1).toString() + ':00';
            $i.val(d);
            minTime = 0;
        }
          this.setOptions({
            minTime: minTime
          })
        }
    })
});

$(function () {
    $('#date').bootstrapMaterialDatePicker({
        time: false,
        format: 'DD-MM-YYYY',
        minDate : new Date()
    });
});

$(function () {
    $('#time').bootstrapMaterialDatePicker({
        date: false,
        format: 'HH:mm'
    });
});
$("#vendormeetingcreate").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>
{!! Toastr::message() !!}
</body>

@endsection
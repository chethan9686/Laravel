@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Event Setup</title>

@include('user.layouts.css')

<!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
<!-- Bootstrap Material Datetime Picker Css -->
<link href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}" rel="stylesheet" />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
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
                    <h2>Event - Setup</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Work Schedule</li>
                        <li class="breadcrumb-item active">Event Setup</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>      
        <div class="row clearfix">
            <div class="col-lg-1 col-md-1 col-sm-1">
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                    <div class="card">
                       <div class="header">
                          <h2> <strong>Event - Setup</strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{ route('eventsetupcreate')}}" id="eventsetup" enctype="multipart/form-data" autocomplete="off">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4">
                                        <label>Company Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                                            </div>                                                              
                                            <input type="text" class="form-control" name="setup_clientname" id="setup_clientname"  autocomplete="off" placeholder="Company Name">
                                            @if ($errors->has('setup_clientname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_clientname') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                     <div class="col-lg-4 col-md-4">
                                        <label>Setup Start Date </label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                            </div>
                                            <input type="text"  id="date" class="form-control date" name="setup_eventstartdate" id="setup_eventstartdate" autocomplete="off" placeholder="Setup Start Date">
                                            @if ($errors->has('setup_eventstartdate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_eventstartdate') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                     <div class="col-lg-4 col-md-4">
                                        <label>Setup End Date</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-calendar-note"></i></span>
                                            </div>
                                            <input type="text" class="form-control date" name="setup_eventenddate" id="setup_eventenddate" autocomplete="off" placeholder="Setup End Date">
                                            @if ($errors->has('setup_eventenddate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_eventenddate') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Setup Start Time</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-timer"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="time" name="setup_time" autocomplete="off" placeholder="Setup Start Time">
                                            @if ($errors->has('setup_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_time') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Location</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-google-maps"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="setup_eventlcation" id="setup_eventlcation" autocomplete="off" placeholder="Location">
                                            @if ($errors->has('setup_eventlcation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_eventlcation') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Expected Work Hours</label>
                                        <div class="input-group masked-input mb-3">                                           
                                            <select class="form-control show-tick " data-placeholder="Select" name="setup_EWH">
                                                <option value="">Select Expected Work Hours</option>
                                                <option value="00:30">00:30 </option>
                                                <option value="01:00">01:00 </option>
                                                <option value="01:30">01:30 </option>
                                                <option value="02:00">02:00 </option>
                                                <option value="02:30">02:30 </option>
                                                <option value="03:00">03:00 </option>
                                                <option value="03:30">03:30 </option>
                                                <option value="04:00">04:00 </option>
                                                <option value="04:30">04:30 </option>
                                                <option value="05:00">05:00 </option>
                                                <option value="05:30">05:30 </option>
                                                <option value="06:00">06:00 </option>
                                                <option value="06:30">06:30 </option>
                                                <option value="07:00">07:00 </option>
                                                <option value="07:30">07:30 </option>
                                                <option value="08:00">08:00 </option>
                                                <option value="08:30">08:30 </option>
                                                <option value="09:00">09:00 </option>
                                                <option value="09:30">09:30 </option>
                                                <option value="10:00">10:00 </option>
                                                <option value="10:30">10:30 </option>
                                                <option value="11:00">11:00 </option>
                                                <option value="11:30">11:30 </option>
                                                <option value="12:00">12:00 </option>
                                                <option value="12:30">12:30 </option>
                                                <option value="13.00">13:00 </option>
                                                <option value="13.30">13:30 </option>
                                                <option value="14.00">14:00 </option>
                                                <option value="14:30">14:30 </option>
                                                <option value="15.00">15:00 </option>
                                                <option value="15.30">15:30 </option>
                                                <option value="16.00">16:00 </option>
                                                <option value="16.30">16:30 </option>
                                                <option value="17.00">17:00 </option>
                                                <option value="17.30">17:30 </option>
                                                <option value="18.00">18:00 </option>
                                                <option value="18.30">18:30 </option>
                                                <option value="19.00">19:00 </option>
                                                <option value="19.30">19:30 </option>
                                                <option value="20.00">20:00 </option>
                                                <option value="20.30">20:30 </option>
                                                <option value="21.00">21:00 </option>
                                                <option value="21.30">21:30 </option>
                                                <option value="22.00">22:00 </option>
                                                <option value="22.30">22:30 </option>
                                                <option value="23.00">23:00 </option>
                                                <option value="23.30">23:30 </option>
                                                <option value="24.00">24:00 </option>
                                            </select>
                                             @if ($errors->has('setup_EWH'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('setup_EWH') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <label>Tag Team Member</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-male-female"></i></span>
                                            </div>
                                            <select class="form-control show-tick ms select2" multiple data-placeholder="Tag Team Member" name="setup_references_id[]">
                                                 @foreach($Employees as $data)
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
                        <h2><strong>Export</strong> Event Setup </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Company Name</th>
                                        <th>Setup Start Date</th>
                                        <th>Setup End Date</th>
                                        <th>Setup Start Time</th>
                                        <th>Location</th>
                                        <th>Expected Work Hours</th>
                                        <th>Tagged Employees</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($EventSetupid as $key=>$data)
                                     @php                                            
                                       $user = \App\User::find($data->user_id);
                                       $branch = \App\Branch::find($data->branch);                                           
                                      @endphp
                                         <?php
                                      if($data->setup_references_id != 0){
                                        $tag_users = \App\EventSetup::where('setup_references_id','=',$data->setup_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->setup_references_id)->get();
                                        foreach($tag_users as $key1=>$tag){
                                                $users = \App\User::find($tag->user_id);                                               
                                                $Res[$key1] = $users->first_name;
                                            }  
                                        }else{
                                               $tag_users = \App\EventSetup::where('setup_references_id','=',$data->id)->get();
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
                                            <td>{{$data->setup_clientname}}</td>
                                            <td><?php echo date('d-m-Y', strtotime($data->setup_eventstartdate)) ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($data->setup_eventenddate)) ?></td>
                                            <td><?php echo date("h:i A",strtotime($data->setup_time)) ?></td>
                                            <td>{{$data->setup_eventlcation}}</td>
                                            <td>{{ $data->setup_EWH }}</td>
                                            <td><sapn class="badge badge-success">@if(!empty($Res)){{implode(',',$Res)}} @endif</sapn></td>
                                            
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
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

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
        $('.date').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY',
            minDate : new Date()
        });
    });

    $(function () {
        $('#eventdate').bootstrapMaterialDatePicker({
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

    $("#eventsetup").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>
{!! Toastr::message() !!}
</body>

@endsection
@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Pre - Event Meeting</title>

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
                    <h2>Pre - Event Meeting</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Work Schedule</li>
                        <li class="breadcrumb-item active">Pre - Event Meeting</li>
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
                          <h2> <strong>Pre - Event Meeting</strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{ route('preeventmeetingcreate')}}" id="preeventmeetingcreate" enctype="multipart/form-data" autocomplete="off">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-4">
                                        <label>Client Name</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-face"></i></span>
                                            </div>                                                              
                                            <input type="text" class="form-control" name="pem_clientname" id="pem_clientname"  autocomplete="off" placeholder="Client Name">
                                            @if ($errors->has('pem_clientname'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_clientname') }}</strong>
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
                                            <input type="text"  id="date" class="form-control" name="pem_dateofmeeting" id="pem_dateofmeeting" autocomplete="off" placeholder="Date of Meeting">
                                            @if ($errors->has('pem_dateofmeeting'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_dateofmeeting') }}</strong>
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
                                            <input type="text" class="form-control calendar" name="pem_time" id="pem_time" autocomplete="off" placeholder="Time of Meeting" onkeydown="return false">
                                            @if ($errors->has('pem_time'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_time') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4">
                                        <label>Event Start Date</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-surround-sound"></i></span>
                                            </div>
                                            <input type="text" class="form-control" name="pem_eventstartdate" id="eventstartdate" autocomplete="off" placeholder="Event Start Date">
                                            @if ($errors->has('pem_eventstartdate'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_eventstartdate') }}</strong>
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
                                            <input type="text" class="form-control" name="pem_lcation" id="pem_lcation" autocomplete="off" placeholder="Meeting Location">
                                            @if ($errors->has('pem_lcation'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_lcation') }}</strong>
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
                                            <input type="text" class="form-control" id="time" name="pem_ERTW" autocomplete="off" placeholder="Expected Time Back To Office">
                                            @if ($errors->has('pem_ERTW'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('pem_ERTW') }}</strong>
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
                                            <select class="form-control show-tick ms select2" multiple data-placeholder="Tag Team Member" name="pem_references_id[]">
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
                        <h2><strong>Export</strong> Pre - Event Meetings </h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Sl.no</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Client Name</th>
                                        <th>Date Of Meeting</th>
                                        <th>Time Of Meeting</th>
                                        <th>Meeting Location</th>
                                        <th>Reporting Time to Work</th>
                                        <th>Tag Users</th>
                                    </tr>
                                </thead>
                                <tbody> 
                                    @foreach($Preeventmeetingsid as $key=>$data)
                                    @php                                            
                                        $user = \App\User::find($data->user_id);
                                        $branch = \App\Branch::find($data->branch);                                           
                                    @endphp
                                    <?php
                                        if($data->pem_references_id != 0)
                                        {
                                            $tag_users = \App\Preeventmeeting::where('pem_references_id','=',$data->pem_references_id)->where('user_id','!=',$user->id)->orwhere('id','=',$data->pem_references_id)->get();
                                            foreach($tag_users as $key1=>$tag)
                                            {
                                                $users = \App\User::find($tag->user_id);                                               
                                                $Res[$key1] = $users->first_name;
                                            }  
                                        }
                                        else
                                        {
                                            $tag_users = \App\Preeventmeeting::where('pem_references_id','=',$data->id)->get();
                                            foreach($tag_users as $key1=>$tag)
                                            {
                                                $users = \App\User::find($tag->user_id);                                               
                                                $Res[$key1] = $users->first_name;
                                            }   
                                        }
                                                                            
                                    ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$user->first_name}} {{$user->last_name}}</td>
                                            <td>{{$branch->name}}</td>
                                            <td>{{$data->pem_clientname}}</td>
                                            <td><?php echo date('d-m-Y', strtotime($data->pem_dateofmeeting)) ?></td>
                                            <td><?php echo date("h:i A",strtotime($data->pem_time)) ?></td>
                                            <td>{{$data->pem_lcation}}</td>
                                            <td><?php echo date("h:i A",strtotime($data->pem_ERTW)) ?></td>
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
        $('#eventstartdate').bootstrapMaterialDatePicker({
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

    $("#preeventmeetingcreate").on("submit", function(){
        $("#pageloader").fadeIn();
    });//submit
</script>
{!! Toastr::message() !!}
</body>

@endsection
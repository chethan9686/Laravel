@extends('user.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Employee List</title>

    @include('user.layouts.css')
    <link rel="stylesheet" href="{{ asset('admin//plugins/footable-bootstrap/css/footable.bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('admin/plugins/footable-bootstrap/css/footable.standalone.min.css')}}">
    <!-- JQuery DataTable Css -->
    <link  rel="stylesheet" href="{{asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" href="{{asset('user/css/font-awesome.min.css')}}">
    <!--- NEW CSS FOR CONFIRMATION DATE----->
    <link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
    
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
                    <h2>Employee List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Employees</li>
                        <li class="breadcrumb-item active">Employee Lists</li>
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
                        <div class="body clearfix">
                            <div class="tab-content">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped dataTable js-exportable" data-page-length="250">
                                         <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Employee Name</th>
                                            <th data-breakpoints="sm xs">Email ID</th>
                                            <th data-breakpoints="xs">Mobile No</th>   
                                            <th data-breakpoints="xs">Department</th>  
                                            <th data-breakpoints="xs">Remaining leaves</th>             
                                            <th data-breakpoints="xs">Active Status</th>                                                    
                                            <th data-breakpoints="sm xs">Confirm Status</th>
                                            <th data-breakpoints="sm xs md">Action</th>                                                  
                                        </tr>
                                    </thead>                                   
                                    <tbody>
                                        @foreach ($Users as $user)
                                            @php                                                       
                                                $Details = App\UserDetails::where('user_id',$user->id)->first();  
                                                $Dept = App\Department::where('id',$Details->department)->first();    
                                                $EncryptedUserID = \Illuminate\Support\Facades\Crypt::encrypt($user->id);  
                                                $emp_confirmedate = App\User::where('id',$user->id)->first(); 
                                                $Today = Carbon\Carbon::today();
                                            @endphp
                                            <?php
                                            if($user->branch == 1 || $user->branch == 4 || $user->branch == 6 || $user->branch == 7 )
                                            { 

                                                if($Today->month < 4)
                                                {
                                                    $Last = new Carbon\Carbon('first day of last year');
                                                    $bang_This_Year = App\BangaloreAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_Last_Year = App\BangaloreAttendence::where('user_id',$user->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                                                    $bangalore->all();

                                                }
                                                elseif(4 <= $Today->month)
                                                {
                                                    $Next = new Carbon\Carbon('first day of next year');
                                                    $bang_next_Year = App\BangaloreAttendence::where('user_id',$user->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_This_Year = App\BangaloreAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                                                    $bangalore->all();
                                                }

                                                $attend = array();
                                                foreach ($bangalore as $key ) {
                                                    array_push($attend, $key->paid_leave);
                                                }
                                            }
                                            elseif($user->branch == 2 || $user->branch == 5)
                                            {
                                                if($Today->month < 4)
                                                {
                                                    $Last = new Carbon\Carbon('first day of last year');
                                                    $bang_This_Year = App\MumbaiAttendence::where('user_id',$User->id)->where('year',$Today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_Last_Year = App\MumbaiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                                                    $bangalore->all();

                                                }
                                                elseif(4 <= $Today->month)
                                                {
                                                    $Next = new Carbon\Carbon('first day of next year');
                                                    $bang_next_Year = App\MumbaiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_This_Year = App\MumbaiAttendence::where('user_id',$User->id)->where('year',$Today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                                                    $bangalore->all();
                                                }

                                                $attend = array();

                                                foreach ($bangalore as $key ) {
                                                    array_push($attend, $key->paid_leave);
                                                }  
                                            }
                                            elseif($user->branch == 3)
                                            {
                                                if($Today->month < 4)
                                                {
                                                    $Last = new Carbon\Carbon('first day of last year');
                                                    $bang_This_Year = App\DelhiAttendence::where('user_id',$User->id)->where('year',$Today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_Last_Year = App\DelhiAttendence::where('user_id',$User->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                                                    $bangalore->all();

                                                }
                                                elseif(4 <= $Today->month)
                                                {
                                                    $Next = new Carbon\Carbon('first day of next year');
                                                    $bang_next_Year = App\DelhiAttendence::where('user_id',$User->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                    $bang_This_Year = App\DelhiAttendence::where('user_id',$User->id)->where('year',$Today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                    $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                                                    $bangalore->all();
                                                }

                                                $attend = array();

                                                foreach ($bangalore as $key ) {
                                                    array_push($attend, $key->paid_leave);
                                                }  
                                            }
                                            $Attendence = array_sum($attend);
                                            if(!is_null($emp_confirmedate->confirme_date))
                                            {
                                                $Date = Carbon\Carbon::parse($emp_confirmedate->confirme_date);

                                                $Current = Carbon\Carbon::now();    
                                                $Data = array();
                                                $i=0;

                                                if($Current->month < 4)
                                                {
                                                    $Last = new Carbon\Carbon('last year');
                                                    $Current = $Current->year.'-03';
                                                    $Last = $Last->year.'-04';
                                                    $period = Carbon\CarbonPeriod::create($Last, '1 month', $Current);
                                                    foreach ($period as $dt) {    
                                                        $Data[$i]=$dt->format("Y-m");
                                                        $i++;
                                                    }                        
                                                }
                                                else
                                                {
                                                    $Next = new Carbon\Carbon('next year');
                                                    $Current = $Current->year.'-04';
                                                    $Next = $Next->year.'-03';
                                                    $period = Carbon\CarbonPeriod::create($Current, '1 month', $Next);
                                                    foreach ($period as $dt) {
                                                        $Data[$i]=$dt->format("Y-m");
                                                        $i++;
                                                    }
                                                }

                                                if(in_array($Date->format("Y-m"), $Data))
                                                {
                                                   $Key = array_search($Date->format("Y-m"), $Data);
                                                   $Res = array_slice($Data,$Key);
                                                   $Days = count($Res) * 1.5;          
                                                }
                                                else
                                                {
                                                    $Days = 18;
                                                }
                                            }
                                            else
                                            {
                                                $Days = 0;
                                            } 
                                           ?>
                                           
                                           
                                            <tr>
                                                <td><img src="{{asset('public/'.$Details->profile_picture)}}" width="48" alt="Product img" class="rounded-circle img-raised"></td>
                                                <td>
                                                    <h5>{{$user->first_name}} {{$user->last_name}}</h5>
                                                    <small>{{$Details->designation}}</small>
                                                </td>
                                                <td><span class="text-muted">{{$user->email}}</span></td>
                                                <td>{{$user->phone}}</td>
                                                <td>    
                                                    @foreach($Departments as $Department) 
                                                        @if($Department->id == $Details->department)
                                                            {{$Department->dept_name}}
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td>{{$Days}} - {{$Attendence}} = {{$Days - $Attendence}} </td>
                                                <td>
                                                    @if($user->status == 'active')
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">InActive</span>
                                                    @endif
                                                </td>                                                       
                                                <td>
                                                    @if($user->confirm_status == 0)
                                                        <a class="btn btn-danger " data-toggle="modal" data-target="#confirmeModal{{$user->id}}" style="color: #ffffff;">Confirm ?</a>
                                                    @else
                                                        <span class="badge badge-success">Confirmed</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{route('hr.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                    <a class="btn btn-danger waves-effect waves-float btn-sm waves-red hr_block" data-id="{{$EncryptedUserID}}"><i class="zmdi zmdi-close-circle" style="color: #fff;"></i></a>
                                                </td>
                                            </tr>       
                                            <div class="modal fade" id="confirmeModal{{$user->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header justify-content-center">
                                                            <h4 class="title" id="largeModalLabel">Employeement Confirmation - Status</h4>
                                                        </div>
                                                       <form method="post" action="{{route('hr.confirm_user')}}"  enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="user_id" value="{{$user->id}}">
                                                            <div class="modal-body"> 
                                                                <div class="row clearfix">
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <label for="email_address">Employee Name</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                                </div>
                                                                               <input type="text" class="form-control" name="confirme_date" placeholder="Date Of Confirmed" value="{{$user->first_name}} {{$user->last_name}}" readonly="">
                                                                            </div>
                                                                        </div>                           
                                                                    </div>    
                                                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                                                        <label for="email_address">Select Confirme Date</label>
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                                                </div>
                                                                               <input type="text" class="form-control empconfirmedate" name="confirme_date" placeholder="Date Of Confirmed">
                                                                            </div>
                                                                        </div>                           
                                                                    </div>                                                                                                                 
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                                                                <button type="submit" class="btn btn-success waves-effect">Submit</button>               
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach                                                                                               
                                    </tbody>
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

@include('user.layouts.js')
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>
<!--- NEW JS FOR CONFIRMATION DATE----->
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script>
    $(document).on('click', '.hr_block', function (e) {      
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "Are you sure!",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Block it!",
                text: "You Will Be Marking Has Block and InActive Status For The Employee!",
                showCancelButton: true,
            },
            function() {
                $.ajax({
                    url: '{{ route('hr.block_user') }}',
                    type: "POST",
                    dataType: "json",
                    data: {"_token": "{{ csrf_token() }}","id" : id},
                    success: function (data) {
                                    
                                    if(data == "Success"){
                                    swal({
                                        title: "Success!",
                                        text: "You Have Successfully Updated Status For The Employee!.",
                                    });
                            }
                        }         
                });
        });
    });  

   /* $(document).on('click', '.hr_confirm', function (e) {      
        e.preventDefault();
        var id = $(this).data('id');
        swal({
                title: "Are you sure!",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes Confirm it!",
                text: "You Will Be Marking Has Confirmed Employee!",
                showCancelButton: true,
            },
            function() {
                $.ajax({
                    url: '{{ route('hr.confirm_user') }}',
                    type: "POST",
                    dataType: "json",
                    data: {"_token": "{{ csrf_token() }}","id" : id},
                    success: function (data) {
                                    
                                    if(data == "Success"){
                                    swal({
                                        title: "Success!",
                                        text: "You Have Successfully Updated Status For The Employee!.",
                                    });
                            }
                        }         
                });
        });
    }); */
    $(function () {
        $('.empconfirmedate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });
</script>
{!! Toastr::message() !!}
</body>
@endsection
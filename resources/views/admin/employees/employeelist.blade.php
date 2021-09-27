@extends('admin.layouts.master')

@section('content')

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="Responsive Bootstrap 4 and web Application ui kit.">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title> HRM | Employee List</title>

    @include('admin.layouts.css')
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
                    <h2>Employee List</h2>
                    <ul class="breadcrumb">
                         <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Employees</li>
                        <li class="breadcrumb-item active">Employees List</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>
    
        <div class="container-fluid">
            @if($User->id == 1)
                <div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <h6>BLR + HYD + CHN + KOK </h6>
                            <h2>{{$bangalorelist}} + {{$hydrabadlist}} = <span style="color:#2acbba;">{{$BangHyd}}</span></h2>
                            <small>Active Employees in South Region</small>
                            <div class="progress">
                                <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <h6>Mumbai</h6>
                            <h2 style="color:#46b6fe;">{{$mumpune}}</h2>
                            <small>Active Employee in Mumbai</small>
                            <div class="progress">
                                <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <h6>Delhi</h6>
                            <h2 style="color:#815ac8;">{{$delhilist}}</h2>
                            <small>Active Employee in Delhi</small>
                            <div class="progress">
                                <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <div class="card widget_2">
                        <div class="body">
                            <h6>Total Employees</h6>
                            <h2 style="color:#24c670;">{{$totalemployees}}</h2>
                            <small>Total Active Employees in all the cities</small>
                            <div class="progress">
                                <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">                       
                        <div class="body clearfix">
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
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped dataTable js-exportable" data-page-length="250">
                                            <thead>
                                                <tr> 
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th data-breakpoints="sm xs">Email ID</th>
                                                    <th data-breakpoints="xs">Mobile No</th>   
                                                    <th data-breakpoints="xs">Department</th>  
                                                    @if($User->id == 1)
                                                       
                                                        <th data-breakpoints="xs">Remaining leaves</th>                                                
                                                        <th data-breakpoints="xs">Active Status</th>                                                    
                                                        <th data-breakpoints="sm xs">Confirm Status</th>
                                                    @endif
                                                    @if($User->id == 1 || $User->id == 6)
                                                    <th data-breakpoints="sm xs md">Action</th>    
                                                    @endif
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @foreach ($Bang_Users as $user)
                                                    @php                                                       
                                                        $Details = App\UserDetails::where('user_id',$user->id)->first();  
                                                        $Dept = App\Department::where('id',$Details->department)->first();    
                                                        $EncryptedUserID = \Illuminate\Support\Facades\Crypt::encrypt($user->id);  
                                                        $emp_confirmedate = App\User::where('id',$user->id)->first();  
                                                    @endphp
                                                    <?php
                                                    $Today = Carbon\Carbon::today();
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
                                                        @if($User->id == 1)
                                                           
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
                                                        @endif
                                                        @if($User->id == 6)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-eye"></i></a>
                                                            </td>
                                                        @elseif($User->id == 1)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                                <a class="btn btn-danger waves-effect waves-float btn-sm waves-red admin_block" data-id="{{$EncryptedUserID}}"><i class="zmdi zmdi-close-circle" style="color: #fff;"></i></a>
                                                           </td>
                                                        @endif
                                                    </tr> 
                                                    <div class="modal fade" id="confirmeModal{{$user->id}}" tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header justify-content-center">
                                                                    <h4 class="title" id="largeModalLabel">Employeement Confirmation - Status</h4>
                                                                </div>
                                                               <form method="post" action="{{route('admin.confirm_user')}}"  enctype="multipart/form-data">
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
                                        </table>
                                    </div>
                                </div>  
                                <div role="tabpanel" class="tab-pane" id="mum">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped dataTable js-exportable" data-page-length="250">
                                            <thead>
                                               <tr>                                                    
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th data-breakpoints="sm xs">Email ID</th>
                                                    <th data-breakpoints="xs">Mobile No</th>   
                                                    <th data-breakpoints="xs">Department</th>  
                                                    @if($User->id == 1)
                                                        
                                                        <th data-breakpoints="xs">Remaining leaves</th>                                                  
                                                        <th data-breakpoints="xs">Active Status</th>                                                    
                                                        <th data-breakpoints="sm xs">Confirm Status</th>
                                                    @endif
                                                    @if($User->id == 1 || $User->id == 6)
                                                    <th data-breakpoints="sm xs md">Action</th>  
                                                    @endif
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @foreach ($Mum_Users as $user)
                                                    @php                                                       
                                                        $Details = App\UserDetails::where('user_id',$user->id)->first();  
                                                        $Dept = App\Department::where('id',$Details->department)->first();    
                                                        $EncryptedUserID = \Illuminate\Support\Facades\Crypt::encrypt($user->id); 
                                                        $emp_confirmedate = App\User::where('id',$user->id)->first();  
                                                    @endphp
                                                    <?php
                                                    $Today = Carbon\Carbon::today();
                                                    if($Today->month < 4)
                                                    {
                                                        $Last = new Carbon\Carbon('first day of last year');
                                                        $bang_This_Year = App\MumbaiAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                        $bang_Last_Year = App\MumbaiAttendence::where('user_id',$user->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                        $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                                                        $bangalore->all();

                                                    }
                                                    elseif(4 <= $Today->month)
                                                    {
                                                        $Next = new Carbon\Carbon('first day of next year');
                                                        $bang_next_Year = App\MumbaiAttendence::where('user_id',$user->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                        $bang_This_Year = App\MumbaiAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                        $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                                                        $bangalore->all();
                                                    }

                                                    $attend = array();
                                                    foreach ($bangalore as $key ) {
                                                        array_push($attend, $key->paid_leave);
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
                                                        @if($User->id == 1)
                                                            
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
                                                                    <a class="admin_confirm"  data-id="{{$EncryptedUserID}}" style="cursor: pointer;"><span class="badge badge-danger">Confirm ?</span></a>
                                                                @else
                                                                    <span class="badge badge-success">Confirmed</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if($User->id == 6)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-eye"></i></a>
                                                            </td>
                                                        @elseif($User->id == 1)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                                <a class="btn btn-danger waves-effect waves-float btn-sm waves-red admin_block" data-id="{{$EncryptedUserID}}"><i class="zmdi zmdi-close-circle" style="color: #fff;"></i></a>
                                                            </td>
                                                        @endif
                                                    </tr>                                                   
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>  
                                <div role="tabpanel" class="tab-pane" id="del">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length="250">
                                            <thead>
                                                <tr>                                                    
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th data-breakpoints="sm xs">Email ID</th>
                                                    <th data-breakpoints="xs">Mobile No</th>   
                                                    <th data-breakpoints="xs">Department</th>
                                                    @if($User->id == 1)
                                                        <th data-breakpoints="xs">Remaining leaves</th>                                                  
                                                        <th data-breakpoints="xs">Active Status</th>                                                    
                                                        <th data-breakpoints="sm xs">Confirm Status</th>
                                                    @endif
                                                    @if($User->id == 1 || $User->id == 6)
                                                    <th data-breakpoints="sm xs md">Action</th>    
                                                    @endif
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @foreach ($Del_Users as $user)
                                                    @php                                                       
                                                        $Details = App\UserDetails::where('user_id',$user->id)->first();  
                                                        $Dept = App\Department::where('id',$Details->department)->first();    
                                                        $EncryptedUserID = \Illuminate\Support\Facades\Crypt::encrypt($user->id);     
                                                        $emp_confirmedate = App\User::where('id',$user->id)->first();  
                                                    @endphp
                                                    <?php
                                                    $Today = Carbon\Carbon::today();
                                                    if($Today->month < 4)
                                                    {
                                                        $Last = new Carbon\Carbon('first day of last year');
                                                        $bang_This_Year = App\DelhiAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                        $bang_Last_Year = App\DelhiAttendence::where('user_id',$user->id)->where('year',$Last->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                        $bangalore = collect($bang_This_Year)->merge(collect($bang_Last_Year));
                                                        $bangalore->all();

                                                    }
                                                    elseif(4 <= $Today->month)
                                                    {
                                                        $Next = new Carbon\Carbon('first day of next year');
                                                        $bang_next_Year = App\DelhiAttendence::where('user_id',$user->id)->where('year',$Next->year)->whereIn('month',[1,2,3])->select('paid_leave')->get();
                                                        $bang_This_Year = App\DelhiAttendence::where('user_id',$user->id)->where('year',$Today->year)->whereIn('month',[4,5,6,7,8,9,10,11,12])->select('paid_leave')->get();
                                                        $bangalore = collect($bang_next_Year)->merge(collect($bang_This_Year));
                                                        $bangalore->all();
                                                    }

                                                    $attend = array();
                                                    foreach ($bangalore as $key ) {
                                                        array_push($attend, $key->paid_leave);
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
                                                        @if($User->id == 1)
                                                           
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
                                                                    <a class="admin_confirm"  data-id="{{$EncryptedUserID}}" style="cursor: pointer;"><span class="badge badge-danger">Confirm ?</span></a>
                                                                @else
                                                                    <span class="badge badge-success">Confirmed</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if($User->id == 6)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-eye"></i></a>
                                                            </td>
                                                        @elseif($User->id == 1)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                                <a class="btn btn-danger waves-effect waves-float btn-sm waves-red admin_block" data-id="{{$EncryptedUserID}}"><i class="zmdi zmdi-close-circle" style="color: #fff;"></i></a>
                                                            </td>
                                                        @endif
                                                    </tr>                                                   
                                                @endforeach                                                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>    
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                   <div class="table-responsive">                                    
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable" data-page-length="250">
                                            <thead>
                                               <tr>                                                    
                                                    <th>Image</th>
                                                    <th>Employee Name</th>
                                                    <th data-breakpoints="sm xs">Email ID</th>
                                                    <th data-breakpoints="xs">Mobile No</th>   
                                                    <th data-breakpoints="xs">Department</th>
                                                    @if($User->id == 1)
                                                       
                                                        <th data-breakpoints="xs">Remaining leaves</th>                                                  
                                                        <th data-breakpoints="xs">Active Status</th>                                                    
                                                        <th data-breakpoints="sm xs">Confirm Status</th>
                                                    @endif
                                                    @if($User->id == 1 || $User->id == 6)
                                                    <th data-breakpoints="sm xs md">Action</th>   
                                                    @endif
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                              @foreach ($Hyd_Users as $user)
                                                    @php                                                       
                                                        $Details = App\UserDetails::where('user_id',$user->id)->first();  
                                                        $Dept = App\Department::where('id',$Details->department)->first();    
                                                        $EncryptedUserID = \Illuminate\Support\Facades\Crypt::encrypt($user->id);  
                                                        $emp_confirmedate = App\User::where('id',$user->id)->first();  
                                                    @endphp
                                                    <?php
                                                    $Today = Carbon\Carbon::today();
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
                                                        @if($User->id == 1)
                                                           
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
                                                                    <a class="admin_confirm"  data-id="{{$EncryptedUserID}}" style="cursor: pointer;"><span class="badge badge-danger">Confirm ?</span></a>
                                                                @else
                                                                    <span class="badge badge-success">Confirmed</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        @if($User->id == 6)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-eye"></i></a>
                                                            </td>
                                                        @elseif($User->id == 1)
                                                            <td>
                                                                <a href="{{route('admin.user-view',[ 'EncryptedUserID' => $EncryptedUserID ])}}" class="btn btn-info waves-effect waves-float btn-sm waves-green"><i class="zmdi zmdi-edit"></i></a>
                                                                <a class="btn btn-danger waves-effect waves-float btn-sm waves-red admin_block" data-id="{{$EncryptedUserID}}"><i class="zmdi zmdi-close-circle" style="color: #fff;"></i></a>
                                                            </td>
                                                        @endif
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
</section>

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
<!--- NEW JS FOR CONFIRMATION DATE----->
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
{!! Toastr::message() !!}
</body>
<script>
    $(document).on('click', '.admin_block', function (e) {      
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
                    url: '{{ route('admin.block_user') }}',
                    type: "POST",
                    dataType: "json",
                    data: {"_token": "{{ csrf_token() }}","id" : id},
                    success: function (data) {
                                    $(window).load();
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

    $(document).on('click', '.admin_confirm', function (e) {      
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
                    url: '{{ route('admin.confirm_user') }}',
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
     $(function () {
        $('.empconfirmedate').bootstrapMaterialDatePicker({
            time: false,
            format: 'DD-MM-YYYY'
        });
    });
</script>
@endsection
@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Resigned Employees</title>

@include('admin.layouts.css')

<link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{ asset('admin/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

<style>   
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
                    <h2>Resigned Employees</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Employees</li>
                        <li class="breadcrumb-item active">Resigned Employees</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>

        <div class="container-fluid">

            <form method="POST" action="{{ route('admin.add_resigned_emp') }}" class="form-horizontal" role="form" enctype="multipart/form-data">
                {{ csrf_field() }}               
                <div class="row clearfix">
                    <div class="col-lg-4 col-md-6">
                        <label>Employee Name</label>
                        <div class="input-group masked-input mb-3">                                                                                     
                            <select class="form-control show-tick" data-placeholder="Select" name="emp_name">
                                <option value="">Select Employee</option>    
                                @foreach($Emps as $Emp)  
                                <option value="{{$Emp->id}}">{{$Emp->first_name}} {{$Emp->last_name}}</option>                                            
                                @endforeach
                            </select>
                            @if ($errors->has('emp_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('emp_name') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>Resigned Date</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-calendar"></i></span>
                            </div>                                         
                            <input type="text" class="form-control datepicker" placeholder="Resigned date" name="date">
                            @if ($errors->has('date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('date') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>Designation</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-laptop-mac"></i></span>
                            </div>
                            <input type="text" name="designation" class="form-control" placeholder="Employee Designation">
                            @if ($errors->has('designation'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('designation') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>Location</label>
                        <div class="input-group masked-input mb-3">                                           
                           <select class="form-control show-tick" data-placeholder="Select" name="location">
                                <option value="">Select Location</option>    
                                @foreach($Branches as $branch)  
                                <option value="{{$branch->id}}">{{$branch->name}}</option>                                            
                                @endforeach
                            </select>
                            @if ($errors->has('location'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('location') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label>Reason For Leaving</label>
                        <div class="input-group masked-input mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="zmdi zmdi-file-text"></i></span>
                            </div>
                           <textarea rows="2" class="form-control no-resize" name="reason" placeholder="Reason For Living."></textarea>
                            @if ($errors->has('reason'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('reason') }}</strong>
                                </span>
                            @endif 
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-6">
                        <label>Can Be Re-Hired?..</label>
                        <div class="input-group masked-input mb-3">
                            <div class="radio inlineblock m-r-20">                                                                    
                                <input type="radio" name="hired" id="male" class="with-gap" value="No" checked="">
                                <label for="male"><i class="zmdi zmdi-close-circle"></i> NO</label>
                                <input type="radio" name="hired" id="Female" class="with-gap" value="Yes">
                                <label for="Female"><i class="zmdi zmdi-check-circle"></i> Yes</label>
                            </div>   
                        </div>
                    </div>              
                    <div class="col-md-4">
                    </div>
                    <div class="col-md-4">
                      <button type="submit" class="btn btn-primary btn-round waves-effect btn-block">Submit</button>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </form>

            <div class="row clearfix">
                <div class="col-sm-12">
                    <div class="card">                       
                        <div class="body">
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
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Resigned Date</th>
                                                    <th>Employee Name</th>  
                                                    <th>Designation</th>                                                 
                                                    <th>Branch</th>                                                   
                                                    <th>Reason For Living</th>
                                                    <th>Can Be Rehired?</th>
                                                </tr>
                                            </thead>                                   
                                            <tbody>
                                                @forelse ($Bang_Users as $user)
                                                    @php
                                                        $User = App\User::find($user->user_id);
                                                        $Branch = App\Branch::find($user->branch);
                                                    @endphp
                                                     <tr>
                                                        <td>{{$user->resigned_date}}</td>
                                                        <td>{{$User->first_name}} {{$User->last_name}}</td>
                                                        <td>{{$user->designation}}</td>
                                                        <td>{{$Branch->name}}</td>
                                                        <td>{{$user->reason_for_leaving}}</td>
                                                        <td>
                                                            <span class="badge {{ $user->rehired == 'No' ? 'badge-danger' : 'badge-success'}}">{{$user->rehired}}</span>
                                                        </td>                                            
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" style="text-align: center">No Employees</td>
                                                    </tr>
                                                @endforelse                                                                                                           
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="mum">
                                  <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Resigned Date</th>
                                                    <th>Employee Name</th>  
                                                    <th>Designation</th>                                                 
                                                    <th>Branch</th>                                                   
                                                    <th>Reason For Living</th>
                                                    <th>Can Be Rehired?</th>
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @forelse ($Mum_Users as $user)
                                                    @php
                                                        $User = App\User::find($user->user_id);
                                                        $Branch = App\Branch::find($user->branch);
                                                    @endphp
                                                     <tr>
                                                        <td>{{$user->resigned_date}}</td>
                                                        <td>{{$User->first_name}} {{$User->last_name}}</td>
                                                        <td>{{$user->designation}}</td>
                                                        <td>{{$Branch->name}}</td>
                                                        <td>{{$user->reason_for_leaving}}</td>
                                                        <td>
                                                            <span class="badge {{ $user->rehired == 'No' ? 'badge-danger' : 'badge-success'}}">{{$user->rehired}}</span>
                                                        </td>                                             
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" style="text-align: center">No Employees</td>
                                                    </tr>
                                                @endforelse                                                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="del">
                                   <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Resigned Date</th>
                                                    <th>Employee Name</th>  
                                                    <th>Designation</th>                                                 
                                                    <th>Branch</th>                                                   
                                                    <th>Reason For Living</th>
                                                    <th>Can Be Rehired?</th>
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                @forelse ($Del_Users as $user)
                                                   @php
                                                        $User = App\User::find($user->user_id);
                                                        $Branch = App\Branch::find($user->branch);
                                                    @endphp
                                                     <tr>
                                                        <td>{{$user->resigned_date}}</td>
                                                        <td>{{$User->first_name}} {{$User->last_name}}</td>
                                                        <td>{{$user->designation}}</td>
                                                        <td>{{$Branch->name}}</td>
                                                        <td>{{$user->reason_for_leaving}}</td>
                                                        <td>
                                                            <span class="badge {{ $user->rehired == 'No' ? 'badge-danger' : 'badge-success'}}">{{$user->rehired}}</span>
                                                        </td>                                            
                                                    </tr>
                                                @empty
                                                    <tr>
                                                       <td colspan="6" style="text-align: center">No Employees</td>
                                                    </tr>
                                                @endforelse                                                                                 
                                            </tbody>
                                        </table>
                                    </div>
                                </div>     
                                <div role="tabpanel" class="tab-pane" id="hyd">
                                   <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                            <thead>
                                                <tr>
                                                    <th>Resigned Date</th>
                                                    <th>Employee Name</th>  
                                                    <th>Designation</th>                                                 
                                                    <th>Branch</th>                                                   
                                                    <th>Reason For Living</th>
                                                    <th>Can Be Rehired?</th>
                                                </tr>
                                            </thead>                                  
                                            <tbody>
                                                 @forelse ($Hyd_Users as $user)
                                                    @php
                                                        $User = App\User::find($user->user_id);
                                                        $Branch = App\Branch::find($user->branch);
                                                    @endphp
                                                    <tr>
                                                        <td>{{$user->resigned_date}}</td>
                                                        <td>{{$User->first_name}} {{$User->last_name}}</td>
                                                        <td>{{$user->designation}}</td>
                                                        <td>{{$Branch->name}}</td>
                                                        <td>{{$user->reason_for_leaving}}</td>
                                                        <td>
                                                            <span class="badge {{ $user->rehired == 'No' ? 'badge-danger' : 'badge-success'}}">{{$user->rehired}}</span>
                                                        </td>                                           
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" style="text-align: center">No Employees</td>
                                                    </tr>
                                                @endforelse                                                                                           
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
<!-- Moment Plugin Js --> 
<script src="{{asset('admin/plugins/momentjs/moment.js')}}"></script> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('admin/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('admin/js/pages/forms/basic-form-elements.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('admin/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('admin/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('admin/js/pages/tables/jquery-datatable.js')}}"></script>

{!! Toastr::message() !!}
</body>
@endsection
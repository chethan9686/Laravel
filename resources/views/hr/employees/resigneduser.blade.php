@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Resigned Employees</title>

@include('user.layouts.css')

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
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
                    <h2>Resigned Employees</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Employees</li>
                        <li class="breadcrumb-item active">Resigned Employees</li>
                    </ul>
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
                          <h2> <strong>Resigned </strong> Employees</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{ route('hr.add_resigned_emp') }}">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-4 col-md-6">
                                        <label>Employee Name</label>
                                        <div class="input-group masked-input mb-3">                                                                                     
                                            <select class="form-control show-tick ms select2" data-placeholder="Select" name="emp_name">
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
            </div>
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Export</strong> Resigned User </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th>Resigned Date</th>
                                            <th>Employee Name</th>
                                            <th>Designation</th>
                                            <th>Branch</th>                                            
                                            <th>Reason For Leaving</th>
                                            <th>Can Be Hired?</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                     
                                      @foreach($Users as $key => $data)
                                      @php
                                      $user = \App\User::find($data->user_id);
                                      $branch = \App\Branch::find($data->branch);
                                      @endphp
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{$data->resigned_date}}</td>
                                            <td>{{$user->first_name }} {{$user->last_name }}</td>
                                            <td>{{$data->designation}}</td>
                                            <td>{{ $branch->name }}</td>
                                            <td>{{ $data->reason_for_leaving }}</td>
                                            <td><span class="badge badge-danger">{{ $data->rehired }}</span></td>
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
<!-- Moment Plugin Js --> 
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
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
</body>

@endsection
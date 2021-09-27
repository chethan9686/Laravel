@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Employee Activation</title>

@include('user.layouts.css')

<!-- JQuery DataTable Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}">

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
                    <h2>Employee Activation</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Employees</li>
                        <li class="breadcrumb-item active">Employee Activation</li>
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
                        <div class="body">
                             <div class="table-responsive">                                    
                                <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Branch</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>User Position</th>
                                            <th>Mail</th>
                                        </tr>
                                    </thead>                                   
                                    <tbody>
                                        @forelse ($Users as $user)
                                            @php
                                                $Branch = App\Branch::find($user->branch);
                                            @endphp
                                             <tr>
                                                <td>{{$user->first_name}} {{$user->last_name}}</td>
                                                <td>
                                                    @if($user->gender == 'M')
                                                        Male
                                                    @else
                                                        Female
                                                    @endif
                                                </td>
                                                <td>{{$Branch->name}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->phone}}</td>
                                                <form method="post" action="{{route('hr.send_activate_link')}}">
                                                    @csrf
                                                    <td>
                                                       <div class=" form-control radio" style="border: none">
                                                            @foreach($Positions as $position)
                                                                <input type="radio" name="gender{{$user->id}}" id="radio{{$user->id}}{{$position->id}}" value="{{$position->id}}">
                                                                <label for="radio{{$user->id}}{{$position->id}}">{{$position->position_name}}</label>                                        
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>                                                    
                                                        <input type="hidden" name="emp_id" value="{{$user->id}}">
                                                        <button class="btn btn-primary btn-block waves-effect waves-light">Send Mail</button>                       
                                                    </td>
                                                </form>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" style="text-align: center">No Employees</td>
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
</body>
@endsection
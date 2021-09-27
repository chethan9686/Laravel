@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Notice List</title>

@include('user.layouts.css')

<link rel="stylesheet" href="{{ asset('user/plugins/footable-bootstrap/css/footable.bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('user/plugins/footable-bootstrap/css/footable.standalone.min.css')}}">

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
                    <h2>Notice List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Notice List</li>
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
                <div class="col-md-2 col-sm-2 col-xs-2"></div>
                <div class="col-md-8 col-sm-8 col-xs-8">
                    <div class="card project_list">
                        <div class="table-responsive">
                            <table class="table table-hover c_table theme-color">
                                <thead>
                                    <tr>                                       
                                        <th>#</th>
                                        <th data-breakpoints="xs">Notice Title</th>                              
                                        <th>View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($UserNotice as $key => $notice)      
                                    @php
                                    $EncryptedID = \Illuminate\Support\Facades\Crypt::encrypt($notice->id); 
                                    @endphp                                         
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$notice->title}}</td>                            
                                        <td>
                                           <a href="{{route('view_notice',[ 'EncryptedID' => $EncryptedID ])}}"> <button class="btn btn-success btn-round"><i class="zmdi zmdi-eye"></i> &nbsp;View More</button></a>
                                        </td>                               
                                    </tr>                                                 
                                    @endforeach                            
                                </tbody>
                            </table>
                        </div>
                        <ul class="pagination pagination-primary mt-4">
                          {{ $UserNotice->links() }}
                        </ul>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2 col-xs-2"></div>
            </div>    
        </div>
    </div>
</section>


@include('user.layouts.js')

<script src="{{asset('user/bundles/footable.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('user/js/pages/tables/footable.js')}}"></script><!-- Custom Js --> 

{!! Toastr::message() !!}
</body>
@endsection
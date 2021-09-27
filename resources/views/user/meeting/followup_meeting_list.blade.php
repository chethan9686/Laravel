@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>HRM | Follow Up Meeting List</title>

@include('user.layouts.css')

 <!-- JQuery DataTable Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>
  <!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{asset('user/plugins/summernote/dist/summernote.css')}}"/>
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
                    <h2>Follow Up Meeting List</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Meeting</li>
                        <li class="breadcrumb-item active">Follow Up Meetings</li>
                    </ul>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>                                
                </div>
            </div>
        </div>      
        <div class="container-fluid">          
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Follow Up</strong> Meeting List </h2>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>Sl.no</th>
                                            <th>Date Of Meeting</th>
                                            <th>Employee Name</th>
                                            <th>Company Name</th>                                  
                                            <th>Client Name</th>
                                            <th>Time Of Meeting</th>
                                            <th>Duration Of Meeting</th>
                                            <th>Location Of Meeting</th>
                                            <th>Purpose of Meeting</th>                                           
                                        </tr>
                                    </thead>
                                    <tbody>                                     
                                        @foreach($meetings as $key => $data)
                                            @php
                                                $user = \App\User::find($data->user_id);                                   
                                            @endphp
                                            <tr>
                                                <td>{{ $key+1 }}</td>
                                                <td>{{$data->date}}</td>
                                                <td>{{$user->first_name }} {{$user->last_name }}</td>                                           
                                                <td>{{$data->company_name}}</td>
                                                <td>{{$data->client_name}}</td>
                                                <td>{{$data->time}}</td>
                                                <td>{{$data->duration}}</td>
                                                <td>{{$data->location}}</td>
                                                <td>{{$data->purpose_of_meeting}}</td>                                               
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
<script src="{{asset('user/plugins/summernote/dist/summernote.js')}}"></script>
<!-- Jquery DataTable Plugin Js --> 
<script src="{{asset('user/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>

<script type="text/javascript">
    $('.summernote').summernote({
        height: 120,   
        width:1500,
        toolbar: [   
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ],
        placeholder: 'Key Points / Discussion Details',    
    });
</script>
{!! Toastr::message() !!}
</body>

@endsection
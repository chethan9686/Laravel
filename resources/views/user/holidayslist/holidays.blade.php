@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Holidays list</title>
<style type="text/css">
    .panel-table{
        background: #222;
    }
    .panel-title{
        color: #fff;
    }
</style>
@include('user.layouts.css')
  
<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">

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
                    <h2>Holiday</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active"> Holidays list</li>
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
                  <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="card widget_2">
                          <div class="body big_icon storage">
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                <h6>Holidays List</h6>
                              <h2><script>document.write(new Date().getFullYear())</script></h2>    
                              </div>                                                    
                              <div class="progress m-t-10">
                              <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-6 col-md-6 col-sm-12">
                      <div class="card widget_2">
                          <div class="body big_icon storage">
                              <div class="col-lg-4 col-md-4 col-sm-4">
                                <h6>Download List</h6>
                                @foreach($holidays as $day)
                                    @if($day->holidays_pdf)
                                    <h2><a href="{{asset('public/'.$day->holidays_pdf)}}" download="{{'public/'.$day->holidays_pdf}}">
                                          <script>document.write(new Date().getFullYear())</script> 
                                          <i class="zmdi zmdi-download" style="font-size:20px;"></i>
                                        </a>
                                    </h2> 
                                  @endif
                                @endforeach  
                              </div>                
                              <div class="progress m-t-10">
                              <div class="progress-bar bg-teal" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
              <div class="row">
                <div class="col-lg-1 col-sm-1 col-md-1">
                </div>
                <div class=" col-lg-10 col-sm-10 col-md-10">
                    <div class="panel panel-primary panel-table">
                       @foreach($holidays as $day)
                        @if($day->holidays_pdf)
                        <div class="panel-body">
                          <embed src="{{asset('public/'.$day->holidays_pdf)}}" frameborder="0" width="100%" height="650px">
                        </div>
                        @else
                        <p style="text-align:center;padding-top: 10px;">No Data Available</p>
                        @endif
                      @endforeach  
                      </div>
                </div>
                <div class="col-lg-1 col-sm-1 col-md-1">
                </div>
              </div>
          </div>        
    </div>
</section>


@include('user.layouts.js')

<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
{!! Toastr::message() !!}
</body>

@endsection
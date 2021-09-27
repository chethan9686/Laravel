@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | View Notice</title>

@include('admin.layouts.css')  
  
<style type="text/css">
  .comment-date{
    font-size: 12px;
    color:#777;
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
                    <h2>Notice</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="dashboard"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item">Notice</li>
                        <li class="breadcrumb-item active">View Notice</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
         <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="blogitem mb-5">                           
                            <div class="blogitem-content">                               
                                <div class="header">
                                    <h2><strong>{{$Notice->title}}</strong></h2>
                                    <span class="comment-date">{{\Carbon\Carbon::parse($Notice->created_at)->format('l jS \\of F Y \\@ h:i:s A')}}</span>
                                </div>                               
                                <blockquote class="blockquote">
                                    <p>{!! $Notice->description !!}</p>                                  
                                </blockquote>                             
                            </div>
                        </div>
                    </div>                   
                </div>               
            </div>
        </div>
    </div>  
</section>


@include('admin.layouts.js')

{!! Toastr::message() !!}
</body>

@endsection
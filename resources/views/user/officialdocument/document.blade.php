@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

<title> Employee | Official Document</title>

@include('user.layouts.css')

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

<link rel="stylesheet" href="{{asset('user/plugins/dropify/css/dropify.min.css')}}">

<style type="text/css">
    .card {
     margin-bottom: 0px; 
    }
    .card .body {
        font-size: 13px;
    }
    .gender-bottom{
        margin-bottom: 1.55rem;
    }    
    .dropdown-menu {   
        box-shadow: 0px 4px 10px 0px rgba(41,42,51,0.2);
    }
    .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
    }
    .download{
        float: right;
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
                    <h2>Official Document</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Official Document</li>
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
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#kra"> <i class="zmdi zmdi-accounts-list"></i> KRA </a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#commitment"> <i class="zmdi zmdi-accounts-list"></i> Commitment Letter </a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#offer_letter"> <i class="zmdi zmdi-balance"></i> Offer Letter</a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#yearly"><i class="zmdi zmdi-receipt"></i> Yearly Appraisal</a></li>    
                            </ul>

                            @include('user.error.error')                          
                            @php
                                $EncryptedId = \Illuminate\Support\Facades\Crypt::encrypt($user->id);
                            @endphp
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane in active" id="kra">
                                    <div class="container-fluid">
                                        <div class="row clearfix">                                 
                                            <div class="col-lg-1 col-md-1">                    
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">     
                                               <div class="header">
                                                    <h2 class="text-center"><strong>KRA </strong></h2>
                                                    <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'Kra'])}}"> <span class="input-group-text" ><i class="zmdi zmdi-download"></i></span></a></label>
                                                </div>                                                  
                                                <div class="panel panel-primary panel-table">  
                                                    <div class="panel-body">
                                                        @if($official_document->kra == "user/kra/default.png")
                                                           <b> <p class="text-center">We Will Updated It Soon</p> </b>
                                                        @else
                                                        <embed src="{{asset('public/'.$official_document->kra)}}" frameborder="0" width="100%" height="650px">
                                                        @endif
                                                     </div>                                 
                                                </div>               
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="commitment">
                                    <div class="container-fluid">
                                        <div class="row clearfix">                                 
                                            <div class="col-lg-1 col-md-1">                    
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">     
                                               <div class="header">
                                                    <h2 class="text-center"><strong>Commitment </strong></h2>
                                                    <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'commitment'])}}"> <span class="input-group-text" ><i class="zmdi zmdi-download"></i></span></a></label>
                                                </div>                                                  
                                                <div class="panel panel-primary panel-table">  
                                                    <div class="panel-body">
                                                        @if($official_document->commitment == "user/commitment/default.png")
                                                           <b> <p class="text-center">We Will Updated It Soon</p> </b>
                                                        @else
                                                        <embed src="{{asset('public/'.$official_document->commitment)}}" frameborder="0" width="100%" height="650px">
                                                        @endif
                                                     </div>                                 
                                                </div>               
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="offer_letter">     
                                    <div class="container-fluid">
                                        <div class="row clearfix"> 
                                            <div class="col-lg-1 col-md-1">                     
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">                     
                                                <div class="header">
                                                    <h2 class="text-center"><strong>Offer </strong> Letter</h2>
                                                    <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'offer_letter'])}}"> <span class="input-group-text" ><i class="zmdi zmdi-download"></i></span></a></label>
                                                </div>   
                                                <div class="panel panel-primary panel-table">  
                                                    <div class="panel-body">
                                                        @if($official_document->offer_letter == "user/offer_letter/default.png")
                                                           <b><p class="text-center">We Will Updated It Soon</p> </b>
                                                        @else
                                                            <embed src="{{asset('public/'.$official_document->offer_letter)}}" frameborder="0" width="100%" height="650px">
                                                        @endif
                                                     </div>                                 
                                                </div>                                      
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="yearly"> 
                                    <div class="container-fluid">
                                        <div class="row clearfix"> 
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                                                                   
                                            <div class="col-lg-10 col-md-10">
                                                <div class="header">
                                                    <h2 class="text-center"><strong>Yearly </strong> Appraisal</h2>
                                                    <label  class="download"><a  href="{{ route('download',[ 'EncryptedId' => $EncryptedId , 'EncryptedProof' => 'appraisal'])}}"> <span class="input-group-text" ><i class="zmdi zmdi-download"></i></span></a></label>
                                                </div>  
                                               <div class="panel panel-primary panel-table">  
                                                    <div class="panel-body">
                                                        @if($official_document->yearly_appraisal == "user/yearly_appraisal/default.png")
                                                           <b><p class="text-center">We Will Updated It Soon</p></b>
                                                        @else
                                                            <embed src="{{asset('public/'.$official_document->yearly_appraisal)}}" frameborder="0" width="100%" height="650px">
                                                        @endif
                                                     </div>                                 
                                                </div> 
                                            </div>
                                            <div class="col-lg-1 col-md-1">                                                     
                                            </div>                                           
                                        </div>
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
<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('user/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>

{!! Toastr::message() !!}


@include('user.scripts.scripts')

</body>

@endsection
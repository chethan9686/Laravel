@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>HRM | Business Revision</title>

<link rel="stylesheet" href="{{asset('user/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css')}}"  />
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
 <!-- JQuery DataTable Css -->
 <link  rel="stylesheet" href="{{asset('user/plugins/jquery-datatable/dataTables.bootstrap4.min.css')}}"/>

@include('user.layouts.css')
 
<style>
    .card .header{
        padding: 0px 0 10px 0;
    }
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

<div id="pageloader">
    <img src="{{ asset('loader.gif')}}" alt="processing..." />
</div>

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
                    <h2> Business Revision Request</h2>
                    <ul class="breadcrumb">
                       <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Signup Rectification Request</li>
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
                
                <div class="col-lg-12 col-md-12 col-sm-12">                           
                    <div class="card">    
                        <div class="header">
                            <h2><strong> Business Rectification Request </strong></h2>
                        </div>                                  
                        <div class="body">  
                           <div class="row">       
                                <div class="col-lg-4 col-md-4 col-sm-12">
                                    <form method="post" action="{{route('businessrevisioncreate')}}" id="businessrevisioncreate">
                                        @csrf 
                                        <label>Select BS Number</label>
                                        <div class="input-group masked-input mb-3">                                            
                                            <select class="form-control show-tick ms select2" data-placeholder="Event Signed up Employee" name="bs_number">
                                                <option value="">Select BS Number</option>
                                                 @foreach($bsnodatalist as $bslist)
                                                    <option value="{{$bslist->bs_number}}">{{$bslist->bs_number}}</option>
                                                 @endforeach
                                            </select>
                                        </div>
                                        <label>Select Business Revison Option</label>
                                        <div class="input-group masked-input mb-3">                                            
                                            <select class="form-control show-tick ms select2" data-placeholder="Select Revision Option" name="revision" id="revision">
                                                <option value="">Select Revision Option</option>
                                                <option value="1">Signup Revision</option>
                                                <option value="2">Billing Revision Before Invoice Raise</option>
                                                <option value="3">Billing Revision After Invoice Raised</option>
                                            </select>
                                        </div>
                                        <div id="invoice_no" style="display: none;">
                                            <label>Enter Invoice Number</label>
                                            <div class="input-group masked-input mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                </div>
                                                <input type="text" class="form-control" name="invoice_no"  placeholder="Enter Invoice Number" value="">                        
                                            </div>  
                                        </div>
                                        <label>Reson for Signup Rectification</label>
                                        <div class="input-group masked-input mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="zmdi zmdi-account-box-phone"></i></span>
                                            </div>
                                            <textarea class="form-control" name="revision_reason" rows="9" cols="50" placeholder="Type Complete Resoan for Business Rectification"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>  
                                    </form>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                            <thead>
                                                <tr>
                                                    <th>Sl.no</th>
                                                    <th>BS Number</th>
                                                    <th>Invoice No</th>
                                                    <th>Resoan</th>
                                                    <th>BS No Status</th>                                                                                 
                                                    <th>Revision Comment</th> 
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($BusinessRevionData as $key=>$List)
                                                        @php
                                                            $user = \App\User::find($List->user_id);                                                                          
                                                        @endphp
                                                    <tr>
                                                        <td>{{$key+1}}</td>
                                                        <td>{{$List->bs_number}}</td>
                                                        <td>
                                                            @if(is_null($List->invoice_no))
                                                                <p>No Invoice Number</p>
                                                            @else
                                                                <p>{{$List->invoice_no}}</p>
                                                            @endif
                                                        </td>
                                                        <td>{{$List->revision_reason}}</td>
                                                        <td>
                                                            @if($List->status == 1)
                                                                <span class="btn btn-round btn-warning">Pendding</span>
                                                            @elseif($List->status == 0)
                                                                <span class="btn btn-round btn-danger">Rejected</span>
                                                            @else
                                                                <span class="btn btn-round btn-success">Unlocked</span>
                                                            @endif
                                                        </td>
                                                        <td><p>{{$List->comment}}</p></td>
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

@include('user.layouts.js')

<script src="{{asset('user/plugins/momentjs/moment.js')}}"></script> <!-- Moment Plugin Js --> 
<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="{{asset('user/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js')}}"></script> 
<script src="{{asset('user/js/pages/forms/basic-form-elements.js')}}"></script>
<script src="{{asset('user/bundles/datatablescripts.bundle.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.colVis.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.flash.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.html5.min.js')}}"></script>
<script src="{{asset('user/plugins/jquery-datatable/buttons/buttons.print.min.js')}}"></script>
<script src="{{asset('user/js/pages/tables/jquery-datatable.js')}}"></script>
<!-----Signup and Billing Revision ------------->
<script type="text/javascript">
   $(document).ready(function(){
        $('#revision').on('change', function() {
          if ( this.value == '3')
          {
            $("#invoice_no").show();
          }
          else
          {
            $("#invoice_no").hide();
          }
        });
    });
</script>
{!! Toastr::message() !!}

</body>

@endsection
   
@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title> HRM | Events Monthy Billing Entry</title>

@include('admin.layouts.css')
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

</head>

<body class="theme-blush">

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

<section class="content">
    <div class="">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Events Billing</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Wings Events</a></li>
                        <li class="breadcrumb-item active">Events Billing Report</li>
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
                          <h2> <strong>Events Billing</strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{route('admin.createbilling')}}" id="eventbilling">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Branch Name</label>
                                        <div class="form-group">                                                   
                                           <select class="form-control show-tick" name="branch">
                                                <option value="">Select Branch Name</option>
                                                <option value="Bangalore">Bangalore</option>
                                                <option value="Mumbai">Mumbai</option>
                                                <option value="Delhi">Delhi</option>                        
                                            </select>                                                                                       
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Year</label>
                                        <div class="form-group">                                                   
                                           <select class="form-control" name="year">
                                                <option value="">Select Year</option>
                                                <option value="2014">2014</option>
                                                <option value="2015">2015</option>
                                                <option value="2016">2016</option> 
                                                <option value="2017">2017</option> 
                                                <option value="2018">2018</option> 
                                                <option value="2019">2019</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>                          
                                            </select>                                                                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Month</label>
                                        <div class="form-group">                                                   
                                           <select class="form-control" name="month">
                                                <option value="">Select Month</option>
                                                <option value="April">April</option>
                                                <option value="May">May</option>
                                                <option value="June">June</option>
                                                <option value="July">July</option>                            
                                                <option value="Agust">Agust</option>                            
                                                <option value="September">September</option>                            
                                                <option value="October">October</option>                            
                                                <option value="November">November</option>                            
                                                <option value="December">December</option>                            
                                                <option value="January">January</option>                            
                                                <option value="February">February</option>                            
                                                <option value="March">March</option>                            
                                            </select>                                                                                           
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Enter Ammount</label>
                                        <div class="form-group">
                                            <input type="text" name="ammount" class="form-control mobile-phone-number" value="" placeholder="Ex: 20000000">
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                    </div>
                                </div>        
                            </form>                                            
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
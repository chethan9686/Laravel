@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title> HRM | Events Monthy Billing Entry</title>

@include('user.layouts.css')
<!-- Bootstrap Select Css -->
<link  rel="stylesheet" href="{{asset('user/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>

</head>

<body class="theme-blush">

@include('user.layouts.search')

@include('user.layouts.menu_sidebar')

@include('user.layouts.left_sidebar')

@include('user.layouts.right_sidebar')

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
                            <form method="POST" action="{{route('createbilling')}}" id="eventbilling">
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


            <!--<div class="row clearfix">-->
            <!--    <div class="col-lg-12 col-md-12 col-sm-12">-->
            <!--        <div class="card">-->
            <!--           <div class="header">-->
            <!--              <h2> <strong>FE Amount </strong> Entry</h2>-->
            <!--           </div>-->
            <!--           <div class="body">                              -->
            <!--                <form method="POST" action="{{route('createfeamount')}}" id="feamount">-->
            <!--                {{csrf_field()}}-->
            <!--                    <div class="row clearfix">-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                            <label for="email_address">Year</label>-->
            <!--                            <div class="form-group">                                                   -->
            <!--                               <select class="form-control" name="year">-->
            <!--                                    <option value="">Select Year</option>-->
            <!--                                    <option value="2020">2020</option>-->
            <!--                                    <option value="2021">2021</option>                          -->
            <!--                                </select>                                                                                           -->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                            <label for="email_address">Month</label>-->
            <!--                            <div class="form-group">                                                   -->
            <!--                               <select class="form-control" name="month">-->
            <!--                                    <option value="">Select Month</option>-->
            <!--                                    <option value="April">April</option>-->
            <!--                                    <option value="May">May</option>-->
            <!--                                    <option value="June">June</option>-->
            <!--                                    <option value="July">July</option>                            -->
            <!--                                    <option value="Agust">Agust</option>                            -->
            <!--                                    <option value="September">September</option>               -->
            <!--                                    <option value="October">October</option>                            -->
            <!--                                    <option value="November">November</option>               -->
            <!--                                    <option value="December">December</option>               -->
            <!--                                    <option value="January">January</option>                            -->
            <!--                                    <option value="February">February</option>              -->
            <!--                                    <option value="March">March</option>                            -->
            <!--                                </select>                                                                                           -->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                            <label for="email_address">Enter FE Ammount</label>-->
            <!--                            <div class="form-group">-->
            <!--                                <input type="text" name="ammount" class="form-control mobile-phone-number" value="" placeholder="Ex: 20000000">-->
            <!--                            </div>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                            <button type="submit" class="btn btn-primary btn-block waves-effect waves-light">SUBMIT</button>-->
            <!--                        </div>-->
            <!--                        <div class="col-lg-4 col-md-4 col-sm-4">-->
            <!--                        </div>-->
            <!--                    </div>        -->
            <!--                </form>                                            -->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->

            <!--<div class="row clearfix">-->
            <!--    <div class="col-lg-12 col-md-12 col-sm-12">-->
            <!--        <div class="card">-->
            <!--           <div class="header">-->
            <!--              <h2> <strong>FE Amount </strong> Report</h2>-->
            <!--           </div>-->
            <!--           <div class="body">                              -->
            <!--                <table class="table table-bordered">-->
            <!--                    <thead>-->
            <!--                        <tr>-->
            <!--                            <th colspan="5" style="text-align: center;color:#e47297;">FE Amount</th>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <th>Year</th>-->
            <!--                            <th>Month</th>-->
            <!--                            <th>Amount</th>-->
            <!--                        </tr>-->
            <!--                    </thead>-->
            <!--                    <tbody>-->
            <!--                        @if(!is_null($Amount))-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>April</td>-->
            <!--                            <td>{{ $Amount->April == 0 ? '' : $Amount->April}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>May</td>-->
            <!--                            <td>{{ $Amount->May == 0 ? '' : $Amount->May}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>June</td>-->
            <!--                            <td>{{ $Amount->June == 0 ? '' : $Amount->June}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>July</td>-->
            <!--                            <td>{{ $Amount->July == 0 ? '' : $Amount->July}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>August</td>-->
            <!--                            <td>{{ $Amount->Agust == 0 ? '' : $Amount->Agust}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>September</td>-->
            <!--                            <td>{{ $Amount->September == 0 ? '' : $Amount->September}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>October</td>-->
            <!--                            <td>{{ $Amount->October == 0 ? '' : $Amount->October}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>November</td>-->
            <!--                            <td>{{ $Amount->November == 0 ? '' : $Amount->November}}</td>-->
            <!--                        </tr>-->
            <!--                        <tr>-->
            <!--                            <td>{{ $Amount->year == 0 ? '' : $Amount->year}}</td>-->
            <!--                            <td>December</td>-->
            <!--                            <td>{{ $Amount->December == 0 ? '' : $Amount->December}}</td>-->
            <!--                        </tr>-->
            <!--                        @else-->
            <!--                        <tr>-->
            <!--                            <td colspan="3" style="text-align: center;">No Data</td>-->
            <!--                        </tr>-->
            <!--                        @endif-->
            <!--                    </tbody>  -->
            <!--                    </table>                                        -->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
        </div>
    </div>
</section>

@include('user.layouts.js')
{!! Toastr::message() !!}
</body>

@endsection
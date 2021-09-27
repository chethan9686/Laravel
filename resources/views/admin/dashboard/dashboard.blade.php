@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Admin | Dashboard</title>

@include('admin.layouts.css')
<link  rel="stylesheet" href="{{asset('admin/plugins/bootstrap-select/css/bootstrap-select.css')}}"/>
<link rel="stylesheet" href="{{ asset('admin/plugins/charts-c3/plugin.css')}}"/>

<style>
    .l-amber{
     background: linear-gradient(0deg, #2acbba, rgb(43, 203, 186)) !important;
    }
    .big_icon.traffic::before{content:"\f211" !important;top: -5px;}
    .big_icon.domains::before{content:"\f132" !important;top: -5px;}
     .c3-axis{
            fill:#222 !important;
            font-size:12px;
        }
        .table td{
            text-align:right;
        }
        .table th{
            text-align:right;
        }
        .thead{
            text-align:center !important;
        }
</style>
</head>

<body class="theme-blush">

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

@php
use \App\Http\Controllers\AdminController;
@endphp

<section class="content">
    <div class="">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">Admin Dashboard</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
         
        <div class="container-fluid">
             @php
            $Ban_estimate_sum = $Ban_BusinessSignup->sum('estimate_amount') + $Ban_BusinessSignup->sum('actual_estimate_amount') + $Ban_BusinessSignup->sum('payment_estimate_amount');
            $Ban_budget_sum = $Ban_BusinessSignup->sum('budget_amount') + $Ban_BusinessSignup->sum('actual_budget_amount') + $Ban_BusinessSignup->sum('payment_budget_amount');
            $Mum_estimate_sum = $Mum_BusinessSignup->sum('estimate_amount') + $Mum_BusinessSignup->sum('actual_estimate_amount') + $Mum_BusinessSignup->sum('payment_estimate_amount');
            $Mum_budget_sum = $Mum_BusinessSignup->sum('budget_amount') + $Mum_BusinessSignup->sum('actual_budget_amount') + $Mum_BusinessSignup->sum('payment_budget_amount');
            $Del_estimate_sum = $Del_BusinessSignup->sum('estimate_amount') + $Del_BusinessSignup->sum('actual_estimate_amount') + $Del_BusinessSignup->sum('payment_estimate_amount');
            $Del_budget_sum = $Del_BusinessSignup->sum('budget_amount') + $Del_BusinessSignup->sum('actual_budget_amount') + $Del_BusinessSignup->sum('payment_budget_amount');

            $Profit_Ban = $Ban_estimate_sum - $Ban_budget_sum;
            $Profit_Mum = $Mum_estimate_sum - $Mum_budget_sum;
            $Profit_Del = $Del_estimate_sum - $Del_budget_sum;

            if($Profit_Ban > 0)
            {
                $Percentage_Ban = (($Profit_Ban * 100)/$Ban_estimate_sum);
            }
            else
            {
                $Percentage_Ban = 0;   
            }
            if($Profit_Mum > 0)
            {
                $Percentage_Mum = (($Profit_Mum * 100)/$Mum_estimate_sum);
            }
            else
            {
                $Percentage_Mum = 0;   
            }
            
            if($Profit_Del > 0)
            {
                $Percentage_Del = (($Profit_Del * 100)/$Del_estimate_sum);
            }
            else
            {
                $Percentage_Del = 0;   
            }
            
           
            $Sum_Of_Estimate = $Ban_estimate_sum + $Mum_estimate_sum + $Del_estimate_sum;
            $Sum_Of_Budget = $Ban_budget_sum + $Mum_budget_sum + $Del_budget_sum;

            $Profit_Sum = $Sum_Of_Estimate - $Sum_Of_Budget;
            
            if($Profit_Sum > 0)
            {
               $Percentage_Sum = (($Profit_Sum * 100)/$Sum_Of_Estimate);
            }
            else
            {
                $Percentage_Sum = 0;   
            }

            

            $Total_Ban_estimate_sum = $Total_Ban_BusinessSignup->sum('estimate_amount') + $Total_Ban_BusinessSignup->sum('actual_estimate_amount') + $Total_Ban_BusinessSignup->sum('payment_estimate_amount');
            $Total_Ban_budget_sum = $Total_Ban_BusinessSignup->sum('budget_amount') + $Total_Ban_BusinessSignup->sum('actual_budget_amount') + $Total_Ban_BusinessSignup->sum('payment_budget_amount');
            $Total_Mum_estimate_sum = $Total_Mum_BusinessSignup->sum('estimate_amount') + $Total_Mum_BusinessSignup->sum('actual_estimate_amount') + $Total_Mum_BusinessSignup->sum('payment_estimate_amount');
            $Total_Mum_budget_sum = $Total_Mum_BusinessSignup->sum('budget_amount') + $Total_Mum_BusinessSignup->sum('actual_budget_amount') + $Total_Mum_BusinessSignup->sum('payment_budget_amount');
            $Total_Del_estimate_sum = $Total_Del_BusinessSignup->sum('estimate_amount') + $Total_Del_BusinessSignup->sum('actual_estimate_amount') + $Total_Del_BusinessSignup->sum('payment_estimate_amount');
            $Total_Del_budget_sum = $Total_Del_BusinessSignup->sum('budget_amount') + $Total_Del_BusinessSignup->sum('actual_budget_amount') + $Total_Del_BusinessSignup->sum('payment_budget_amount');

            $Total_Profit_Ban = $Total_Ban_estimate_sum - $Total_Ban_budget_sum;
            $Total_Profit_Mum = $Total_Mum_estimate_sum - $Total_Mum_budget_sum;
            $Total_Profit_Del = $Total_Del_estimate_sum - $Total_Del_budget_sum;

            
            if($Total_Profit_Ban > 0)
            {
               $Total_Percentage_Ban = (($Total_Profit_Ban * 100)/$Total_Ban_estimate_sum);
            }
            else
            {
                $Total_Percentage_Ban = 0;   
            }
            
             if($Total_Profit_Mum > 0)
            {
                $Total_Percentage_Mum = (($Total_Profit_Mum * 100)/$Total_Mum_estimate_sum);
            }
            else
            {
                $Total_Percentage_Mum = 0;   
            }
            if($Total_Profit_Del > 0)
            {
                $Total_Percentage_Del = (($Total_Profit_Del * 100)/$Total_Del_estimate_sum);
            }
            else
            {
                $Total_Percentage_Del = 0;   
            }

            $Total_Sum_Of_Estimate = $Total_Ban_estimate_sum + $Total_Mum_estimate_sum + $Total_Del_estimate_sum;
            $Total_Sum_Of_Budget = $Total_Ban_budget_sum + $Total_Mum_budget_sum + $Total_Del_budget_sum;

            $Total_Profit_Sum = $Total_Sum_Of_Estimate - $Total_Sum_Of_Budget;
            
            if($Total_Profit_Sum > 0)
            {
                $Total_Percentage_Sum = (($Total_Profit_Sum * 100)/$Total_Sum_Of_Estimate);
            }
            else
            {
                $Total_Percentage_Sum = 0;   
            }

            
          @endphp
          @php
            $Ban_Bestimate_sum = $Ban_Billing->sum('estimate_amount') + $Ban_Billing->sum('actual_estimate_amount') + $Ban_Billing->sum('payment_estimate_amount');
            $Ban_Bbudget_sum = $Ban_Billing->sum('budget_amount') + $Ban_Billing->sum('actual_budget_amount') + $Ban_Billing->sum('payment_budget_amount');
            $Mum_Bestimate_sum = $Mum_Billing->sum('estimate_amount') + $Mum_Billing->sum('actual_estimate_amount') + $Mum_Billing->sum('payment_estimate_amount');
            $Mum_Bbudget_sum = $Mum_Billing->sum('budget_amount') + $Mum_Billing->sum('actual_budget_amount') + $Mum_Billing->sum('payment_budget_amount');
            $Del_Bestimate_sum = $Del_Billing->sum('estimate_amount') + $Del_Billing->sum('actual_estimate_amount') + $Del_Billing->sum('payment_estimate_amount');
            $Del_Bbudget_sum = $Del_Billing->sum('budget_amount') + $Del_Billing->sum('actual_budget_amount') + $Del_Billing->sum('payment_budget_amount');

            $Profit_Billing_Ban = $Ban_Bestimate_sum - $Ban_Bbudget_sum;
            $Profit_Billing_Mum = $Mum_Bestimate_sum - $Mum_Bbudget_sum;
            $Profit_Billing_Del = $Del_Bestimate_sum - $Del_Bbudget_sum;

            if($Profit_Billing_Ban > 0)
            {
                $Percentage_Billing_Ban = (($Profit_Billing_Ban * 100)/$Ban_Bestimate_sum);
            }
            else
            {
                $Percentage_Billing_Ban = 0;   
            }
            if($Profit_Billing_Mum > 0)
            {
                $Percentage_Billing_Mum = (($Profit_Billing_Mum * 100)/$Mum_Bestimate_sum);
            }
            else
            {
                $Percentage_Billing_Mum = 0;   
            }
            
            if($Profit_Billing_Del > 0)
            {
                $Percentage_Billing_Del = (($Profit_Billing_Del * 100)/$Del_Bestimate_sum);
            }
            else
            {
                $Percentage_Billing_Del = 0;   
            }
            
           
            $Sum_Of_Billing_Estimate = $Ban_Bestimate_sum + $Mum_Bestimate_sum + $Del_Bestimate_sum;
            $Sum_Of_Billing_Budget = $Ban_Bbudget_sum + $Mum_Bbudget_sum + $Del_Bbudget_sum;

            $Profit_Billing_Sum = $Sum_Of_Billing_Estimate - $Sum_Of_Billing_Budget;
            
            if($Profit_Billing_Sum > 0)
            {
                $Percentage_Billing_Sum = (($Profit_Billing_Sum * 100)/$Sum_Of_Billing_Estimate);
            }else
            {
                $Percentage_Billing_Sum = 0;
            }

            

            $Total_Ban_Bestimate_sum = $Total_Ban_Billing->sum('estimate_amount') + $Total_Ban_Billing->sum('actual_estimate_amount') + $Total_Ban_Billing->sum('payment_estimate_amount');
            $Total_Ban_Bbudget_sum = $Total_Ban_Billing->sum('budget_amount') + $Total_Ban_Billing->sum('actual_budget_amount') + $Total_Ban_Billing->sum('payment_budget_amount');
            $Total_Mum_Bestimate_sum = $Total_Mum_Billing->sum('estimate_amount') + $Total_Mum_Billing->sum('actual_estimate_amount') + $Total_Mum_Billing->sum('payment_estimate_amount');
            $Total_Mum_Bbudget_sum = $Total_Mum_Billing->sum('budget_amount') + $Total_Mum_Billing->sum('actual_budget_amount') + $Total_Mum_Billing->sum('payment_budget_amount');
            $Total_Del_Bestimate_sum = $Total_Del_Billing->sum('estimate_amount') + $Total_Del_Billing->sum('actual_estimate_amount') + $Total_Del_Billing->sum('payment_estimate_amount');
            $Total_Del_Bbudget_sum = $Total_Del_Billing->sum('budget_amount') + $Total_Del_Billing->sum('actual_budget_amount') + $Total_Del_Billing->sum('payment_budget_amount');

            $Total_Billing_Profit_Ban = $Total_Ban_Bestimate_sum - $Total_Ban_Bbudget_sum;
            $Total_Billing_Profit_Mum = $Total_Mum_Bestimate_sum - $Total_Mum_Bbudget_sum;
            $Total_Billing_Profit_Del = $Total_Del_Bestimate_sum - $Total_Del_Bbudget_sum;

            
            if($Total_Billing_Profit_Ban > 0)
            {
               $Total_Billing_Percentage_Ban = (($Total_Billing_Profit_Ban * 100)/$Total_Ban_Bestimate_sum);
            }
            else
            {
                $Total_Billing_Percentage_Ban = 0;   
            }
            
             if($Total_Billing_Profit_Mum > 0)
            {
                $Total_Billing_Percentage_Mum = (($Total_Billing_Profit_Mum * 100)/$Total_Mum_Bestimate_sum);
            }
            else
            {
                $Total_Billing_Percentage_Mum = 0;   
            }
            if($Total_Billing_Profit_Del > 0)
            {
                $Total_Billing_Percentage_Del = (($Total_Billing_Profit_Del * 100)/$Total_Del_Bestimate_sum);
            }
            else
            {
                $Total_Billing_Percentage_Del = 0;   
            }

            $Total_Billing_Sum_Of_Estimate = $Total_Ban_Bestimate_sum + $Total_Mum_Bestimate_sum + $Total_Del_Bestimate_sum;
            $Total_Billing_Sum_Of_Budget = $Total_Ban_Bbudget_sum + $Total_Mum_Bbudget_sum + $Total_Del_Bbudget_sum;

            $Total_Billing_Profit_Sum = $Total_Billing_Sum_Of_Estimate - $Total_Billing_Sum_Of_Budget;
            
            if($Total_Billing_Profit_Sum > 0)
            {
                $Total_Billing_Percentage_Sum = (($Total_Billing_Profit_Sum * 100)/$Total_Billing_Sum_Of_Estimate);
            }
            else
            {
                $Total_Billing_Percentage_Sum = 0;   
            }

           
          @endphp
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong><i class="zmdi zmdi-chart"></i> Sign Up</strong> Report <strong></strong></h2>
                        </div>
                         <div class="body mb-2">
                            <form method="get" action="{{route('admin.dashboard')}}" enctype="multipart/form-data">
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <select class="form-control show-tick" name="signup_month">
                                                    <option value=" ">Select Month</option>
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>
                                                    <option value="10">October</option>
                                                    <option value="11">November</option>
                                                    <option value="12">December</option>
                                                    <option value="01">January</option>
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>
                                                </select> 
                                            </div>
                                        </div>                           
                                    </div>                                                                             
                               
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                         <div class="form-group">
                                            <div class="input-group">
                                                <button type="submit" class="btn btn-success btn-round waves-effect" >SUBMIT</button>
                                            </div>
                                        </div>   
                                        
                                    </div>                                                                             
                                </div>                  
                            </form>
                        </div>
                        <div class="body mb-2">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">{{$MonthName->localeMonth}} - Month Signup Report</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Sign Up</th>
                                                <th>Expense</th>
                                                <th>Profit</th>
                                                <th>Profit %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
                                               <td class="thead">Bangalore</td>
                                               <td>{{$Ban_estimate_sum}}</td>
                                               <td>{{$Ban_budget_sum}}</td>
                                               <td>{{$Profit_Ban}}</td>
                                               <td>{{number_format($Percentage_Ban, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Mumbai</td>
                                               <td>{{$Mum_estimate_sum}}</td>
                                               <td>{{$Mum_budget_sum}}</td>
                                               <td>{{$Profit_Mum}}</td>
                                               <td>{{number_format($Percentage_Mum, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Delhi</td>
                                               <td>{{$Del_estimate_sum}}</td>
                                               <td>{{$Del_budget_sum}}</td>
                                               <td>{{$Profit_Del}}</td>
                                               <td>{{number_format($Percentage_Del, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{$Sum_Of_Estimate}}</td>
                                               <td>{{$Sum_Of_Budget}}</td>
                                               <td>{{$Profit_Sum}}</td>
                                               <td>{{number_format($Percentage_Sum, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{AdminController::currency($Sum_Of_Estimate)}}</td>
                                               <td>{{AdminController::currency($Sum_Of_Budget)}}</td>
                                               <td>{{AdminController::currency($Profit_Sum)}}</td>
                                               <td>{{number_format($Percentage_Sum, 2)}} %</td>
                                           </tr>
                                       </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Year To Date Signup Report</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Sign Up</th>
                                                <th>Expense</th>
                                                <th>Profit</th>
                                                <th>Profit %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                               <td class="thead">Bangalore</td>
                                               <td>{{$Total_Ban_estimate_sum}}</td>
                                               <td>{{$Total_Ban_budget_sum}}</td>
                                               <td>{{$Total_Profit_Ban}}</td>
                                               <td>{{number_format($Total_Percentage_Ban, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Mumbai</td>
                                               <td>{{$Total_Mum_estimate_sum}}</td>
                                               <td>{{$Total_Mum_budget_sum}}</td>
                                               <td>{{$Total_Profit_Mum}}</td>
                                               <td>{{number_format($Total_Percentage_Mum, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Delhi</td>
                                               <td>{{$Total_Del_estimate_sum}}</td>
                                               <td>{{$Total_Del_budget_sum}}</td>
                                               <td>{{$Total_Profit_Del}}</td>
                                               <td>{{number_format($Total_Percentage_Del, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{$Total_Sum_Of_Estimate}}</td>
                                               <td>{{$Total_Sum_Of_Budget}}</td>
                                               <td>{{$Total_Profit_Sum}}</td>
                                               <td>{{number_format($Total_Percentage_Sum, 2)}} %</td>                                        
                                            </tr>
                                            <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{AdminController::currency($Total_Sum_Of_Estimate)}}</td>
                                               <td>{{AdminController::currency($Total_Sum_Of_Budget)}}</td>
                                               <td>{{AdminController::currency($Total_Profit_Sum)}}</td>
                                               <td>{{number_format($Total_Percentage_Sum, 2)}} %</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="body mb-2">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">{{$MonthName->localeMonth}} - Month Billing Report</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Sales</th>
                                                <th>Expense</th>
                                                <th>Profit</th>
                                                <th>Profit %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           <tr>
                                               <td class="thead">Bangalore</td>
                                               <td>{{$Ban_Bestimate_sum}}</td>
                                               <td>{{$Ban_Bbudget_sum}}</td>
                                               <td>{{$Profit_Billing_Ban}}</td>
                                               <td>{{number_format($Percentage_Billing_Ban, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Mumbai</td>
                                               <td>{{$Mum_Bestimate_sum}}</td>
                                               <td>{{$Mum_Bbudget_sum}}</td>
                                               <td>{{$Profit_Billing_Mum}}</td>
                                               <td>{{number_format($Percentage_Billing_Mum, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Delhi</td>
                                               <td>{{$Del_Bestimate_sum}}</td>
                                               <td>{{$Del_Bbudget_sum}}</td>
                                               <td>{{$Profit_Billing_Del}}</td>
                                               <td>{{number_format($Percentage_Billing_Del, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{$Sum_Of_Billing_Estimate}}</td>
                                               <td>{{$Sum_Of_Billing_Budget}}</td>
                                               <td>{{$Profit_Billing_Sum}}</td>
                                               <td>{{number_format($Percentage_Billing_Sum, 2)}} %</td>
                                           </tr>
                                           <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{AdminController::currency($Sum_Of_Billing_Estimate)}}</td>
                                               <td>{{AdminController::currency($Sum_Of_Billing_Budget)}}</td>
                                               <td>{{AdminController::currency($Profit_Billing_Sum)}}</td>
                                               <td>{{number_format($Percentage_Billing_Sum, 2)}} %</td>
                                           </tr>
                                       </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Year To Date Billing Report</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Sales</th>
                                                <th>Expense</th>
                                                <th>Profit</th>
                                                <th>Profit %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                               <td class="thead">Bangalore</td>
                                               <td>{{$Total_Ban_Bestimate_sum}}</td>
                                               <td>{{$Total_Ban_Bbudget_sum}}</td>
                                               <td>{{$Total_Billing_Profit_Ban}}</td>
                                               <td>{{number_format($Total_Billing_Percentage_Ban, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Mumbai</td>
                                               <td>{{$Total_Mum_Bestimate_sum}}</td>
                                               <td>{{$Total_Mum_Bbudget_sum}}</td>
                                               <td>{{$Total_Billing_Profit_Mum}}</td>
                                               <td>{{number_format($Total_Billing_Percentage_Mum, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Delhi</td>
                                               <td>{{$Total_Del_Bestimate_sum}}</td>
                                               <td>{{$Total_Del_Bbudget_sum}}</td>
                                               <td>{{$Total_Billing_Profit_Del}}</td>
                                               <td>{{number_format($Total_Billing_Percentage_Del, 2)}} %</td>
                                            </tr>
                                            <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{$Total_Billing_Sum_Of_Estimate}}</td>
                                               <td>{{$Total_Billing_Sum_Of_Budget}}</td>
                                               <td>{{$Total_Billing_Profit_Sum}}</td>
                                               <td>{{number_format($Total_Billing_Percentage_Sum, 2)}} %</td>                                        
                                            </tr>
                                            <tr>
                                               <td class="thead">Grand Total</td>
                                               <td>{{AdminController::currency($Total_Billing_Sum_Of_Estimate)}}</td>
                                               <td>{{AdminController::currency($Total_Billing_Sum_Of_Budget)}}</td>
                                               <td>{{AdminController::currency($Total_Billing_Profit_Sum)}}</td>
                                               <td>{{number_format($Total_Billing_Percentage_Sum, 2)}} %</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                         <div class="body mb-2">
                            <div class="row clearfix">                                
                                
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="8" style="text-align: center;color:#e47297;">{{$MonthName->localeMonth}} - Monthly Billing Report - 2020 - 2021 </th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Billing</th>
                                                <th>Expense</th>
                                                <th>GP</th>
                                                <th>GP %</th>
                                                <th>FE</th>
                                                <th>NP</th>
                                                <th>NP %</th>
                                            </tr>
                                        </thead>
                                        @php
                                        $bng_np = $Profit_Billing_Ban - $bng_fe;
                                        
                                        $mum_np = $Profit_Billing_Mum - $mum_fe;
                                      
                                        $del_np = $Profit_Billing_Del - $del_fe;

                                        if($Profit_Billing_Ban > 0)
                                        {
                                            $Np_Percentage_Ban = (($bng_np * 100)/$Ban_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $Np_Percentage_Ban = 0;   
                                        }
                                        
                                        if($Profit_Billing_Mum > 0)
                                        {
                                            $Np_Percentage_Mum = (($mum_np * 100)/$Mum_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $Np_Percentage_Mum = 0;   
                                        }

                                        if($Profit_Billing_Del > 0)
                                        {
                                            $Np_Percentage_Del = (($del_np * 100)/$Del_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $Np_Percentage_Del = 0;   
                                        }
                                        $est_sum = $Ban_Bestimate_sum + $Mum_Bestimate_sum + $Del_Bestimate_sum;
                                        $bud_sum = $Ban_Bbudget_sum + $Mum_Bbudget_sum +$Del_Bbudget_sum;
                                        $profit_sum =  $Profit_Billing_Ban + $Profit_Billing_Mum +$Profit_Billing_Del;

                                        if($profit_sum > 0)
                                        {
                                            $Np_Percentage_pro = (($profit_sum * 100)/$est_sum);
                                        }
                                        else
                                        {
                                            $Np_Percentage_pro = 0;   
                                        }

                                        $sum_fe = $bng_fe + $mum_fe + $del_fe;
                                        $sum_np = $profit_sum - $sum_fe;

                                        if($profit_sum > 0)
                                        {
                                            $Np_Percentage_sum = (($sum_np * 100)/$est_sum);
                                        }
                                        else
                                        {
                                            $Np_Percentage_sum = 0;   
                                        }                                        
                                        @endphp 
                                        <tbody>                                            
                                            <tr>
                                                <td class="thead">Bangalore</td>
                                                <td>{{$Ban_Bestimate_sum}}</td>
                                                <td>{{$Ban_Bbudget_sum}}</td>
                                                <td>{{$Profit_Billing_Ban}}</td>
                                                <td>{{number_format($Percentage_Billing_Ban, 2)}} %</td>
                                                <td>{{$bng_fe}}</td>
                                                <td>{{$bng_np}}</td>
                                                <td>{{number_format($Np_Percentage_Ban, 2)}} %</td>
                                            </tr>                               
                                             <tr>
                                                <td class="thead">Mumbai</td>
                                                <td>{{$Mum_Bestimate_sum}}</td>
                                                <td>{{$Mum_Bbudget_sum}}</td>
                                                <td>{{$Profit_Billing_Mum}}</td>
                                                <td>{{number_format($Percentage_Billing_Mum, 2)}} %</td>
                                                <td>{{$mum_fe}}</td>
                                                <td>{{$mum_np}}</td>
                                                <td>{{number_format($Np_Percentage_Mum, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Delhi</td>
                                                <td>{{$Del_Bestimate_sum}}</td>
                                                <td>{{$Del_Bbudget_sum}}</td>
                                                <td>{{$Profit_Billing_Del}}</td>
                                                <td>{{number_format($Percentage_Billing_Del, 2)}} %</td>
                                                <td>{{$del_fe}}</td>
                                                <td>{{$del_np}}</td>
                                                <td>{{number_format($Np_Percentage_Del, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Grand Total</td>
                                                <td>{{$est_sum}}</td>
                                                <td>{{$bud_sum}}</td>
                                                <td>{{$profit_sum}}</td>
                                                <td>{{number_format($Np_Percentage_pro, 2)}} %</td>
                                                <td>{{$sum_fe}}</td>
                                                <td>{{$sum_np}}</td>
                                                <td>{{number_format($Np_Percentage_sum, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Grand Total</td>
                                                <td>{{AdminController::currency($est_sum)}}</td>
                                                <td>{{AdminController::currency($bud_sum)}}</td>
                                                <td>{{AdminController::currency($profit_sum)}}</td>
                                                <td>{{number_format($Np_Percentage_pro, 2)}} %</td>
                                                <td>{{AdminController::currency($sum_fe)}}</td>
                                                @if($sum_np > 0)
                                                    <td>{{AdminController::currency($sum_np)}}</td>
                                                @else
                                                    <td> -{{AdminController::currency($sum_np)}}</td>
                                                @endif
                                                <td>{{number_format($Np_Percentage_sum, 2)}} %</td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="8" style="text-align: center;color:#e47297;">Year To Date Billing Report - 2020 - 2021 </th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th>Billing</th>
                                                <th>Expense</th>
                                                <th>GP</th>
                                                <th>GP %</th>
                                                <th>FE</th>
                                                <th>NP</th>
                                                <th>NP %</th>
                                            </tr>
                                        </thead>
                                        @php
                                        $SUM_FE = $Total_Feamt + $Total_Mum_Feamt + $Total_Del_Feamt;

                                        $BNG_NP = $Total_Billing_Profit_Ban - $Total_Feamt;
                                        
                                        $MUM_NP = $Total_Billing_Profit_Mum - $Total_Mum_Feamt;
                                      
                                        $DEL_NP = $Total_Billing_Profit_Del - $Total_Del_Feamt;        

                                        if($Total_Billing_Profit_Ban > 0)
                                        {
                                            $NP_PER_BAN = (($BNG_NP * 100)/$Total_Ban_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $NP_PER_BAN = 0;   
                                        }
                                        
                                        if($Total_Billing_Profit_Mum > 0)
                                        {
                                            $NP_PER_MUM = (($MUM_NP * 100)/$Total_Mum_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $NP_PER_MUM = 0;   
                                        }

                                        if($Total_Billing_Profit_Del > 0)
                                        {
                                            $NP_PER_DEL = (($DEL_NP * 100)/$Total_Del_Bestimate_sum);
                                        }
                                        else
                                        {
                                            $NP_PER_DEL = 0;   
                                        }

                                        $PROFIT_SUM =  $Total_Billing_Profit_Ban + $Total_Billing_Profit_Mum + $Total_Billing_Profit_Del;                                        
                                      
                                        $SUM_NP = $PROFIT_SUM - $SUM_FE;

                                        if($PROFIT_SUM > 0)
                                        {
                                            $NP_PERCT = (($SUM_NP * 100)/$Total_Billing_Sum_Of_Estimate);
                                        }
                                        else
                                        {
                                            $NP_PERCT = 0;   
                                        }                                        
                                        @endphp 
                                        <tbody>                                            
                                            <tr>
                                                <td class="thead">Bangalore</td>
                                                <td>{{$Total_Ban_Bestimate_sum}}</td>
                                                <td>{{$Total_Ban_Bbudget_sum}}</td>
                                                <td>{{$Total_Billing_Profit_Ban}}</td>
                                                <td>{{number_format($Total_Billing_Percentage_Ban, 2)}} %</td>
                                                <td>{{$Total_Feamt}}</td>
                                                <td>{{$BNG_NP}}</td>
                                                <td>{{number_format($NP_PER_BAN, 2)}} %</td>
                                            </tr>                               
                                             <tr>
                                                <td class="thead">Mumbai</td>
                                                <td>{{$Total_Mum_Bestimate_sum}}</td>
                                                <td>{{$Total_Mum_Bbudget_sum}}</td>
                                                <td>{{$Total_Billing_Profit_Mum}}</td>
                                                <td>{{number_format($Total_Billing_Percentage_Mum, 2)}} %</td>
                                                <td>{{$Total_Mum_Feamt}}</td>
                                                <td>{{$MUM_NP}}</td>
                                                <td>{{number_format($NP_PER_MUM, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Delhi</td>
                                                <td>{{$Total_Del_Bestimate_sum}}</td>
                                                <td>{{$Total_Del_Bbudget_sum}}</td>
                                                <td>{{$Total_Billing_Profit_Del}}</td>
                                                <td>{{number_format($Total_Billing_Percentage_Del, 2)}} %</td>
                                                <td>{{$Total_Del_Feamt}}</td>
                                                <td>{{$DEL_NP}}</td>
                                                <td>{{number_format($NP_PER_DEL, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Grand Total</td>
                                                <td>{{$Total_Billing_Sum_Of_Estimate}}</td>
                                                <td>{{$Total_Billing_Sum_Of_Budget}}</td>
                                                <td>{{$Total_Billing_Profit_Sum}}</td>
                                                <td>{{number_format($Total_Billing_Percentage_Sum, 2)}} %</td> 
                                                <td>{{$SUM_FE}}</td>
                                                <td>{{$SUM_NP}}</td>
                                                <td>{{number_format($NP_PERCT, 2)}} %</td>
                                            </tr>
                                            <tr>
                                                <td class="thead">Grand Total</td>
                                                <td>{{AdminController::currency($Total_Billing_Sum_Of_Estimate)}}</td>
                                                <td>{{AdminController::currency($Total_Billing_Sum_Of_Budget)}}</td>
                                                <td>{{AdminController::currency($Total_Billing_Profit_Sum)}}</td>
                                                <td>{{number_format($Total_Billing_Percentage_Sum, 2)}} %</td> 
                                                <td>{{AdminController::currency($SUM_FE)}}</td>
                                                @if($SUM_NP > 0)
                                                    <td>{{AdminController::currency($SUM_NP)}}</td>
                                                @else
                                                    <td>-{{AdminController::currency($SUM_NP)}}</td>
                                                @endif
                                                <td>{{number_format($NP_PERCT, 2)}} %</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="body mb-2">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6">                             
                                    @php    
                                     $Sum = ($FeAmt['April'] + $Mum_FeAmt['April'] + $Del_FeAmt['April']) + ($FeAmt['May'] + $Mum_FeAmt['May'] + $Del_FeAmt['May']) + ($FeAmt['June'] + $Mum_FeAmt['June'] + $Del_FeAmt['June']) + ($FeAmt['July'] + $Mum_FeAmt['July'] + $Del_FeAmt['July']) + ($FeAmt['Agust'] + $Mum_FeAmt['Agust'] + $Del_FeAmt['Agust']) + ($FeAmt['September'] + $Mum_FeAmt['September'] + $Del_FeAmt['September']) + ($FeAmt['October'] + $Mum_FeAmt['October'] + $Del_FeAmt['October']) + ($FeAmt['November'] + $Mum_FeAmt['November'] + $Del_FeAmt['November']) + ($FeAmt['December'] + $Mum_FeAmt['December'] + $Del_FeAmt['December']) + ($FeAmt['January'] + $Mum_FeAmt['January'] + $Del_FeAmt['January']) + ($FeAmt['February'] + $Mum_FeAmt['February'] + $Del_FeAmt['February']) + ($FeAmt['March'] + $Mum_FeAmt
                                     ['March'] + $Del_FeAmt['March']);  

                                     $april = $FeAmt['April'] + $Mum_FeAmt['April'] + $Del_FeAmt['April']; 
                                     $may = $FeAmt['May'] + $Mum_FeAmt['May'] + $Del_FeAmt['May'];      
                                     $june = $FeAmt['June'] + $Mum_FeAmt['June'] + $Del_FeAmt['June'];   
                                     $july = $FeAmt['July'] + $Mum_FeAmt['July'] + $Del_FeAmt['July'];  
                                     $august = $FeAmt['Agust'] + $Mum_FeAmt['Agust'] + $Del_FeAmt['Agust'];     
                                     $sept = $FeAmt['September'] + $Mum_FeAmt['September'] + $Del_FeAmt['September'];   
                                     $oct = $FeAmt['October'] + $Mum_FeAmt['October'] + $Del_FeAmt['October'];   
                                     $nov = $FeAmt['November'] + $Mum_FeAmt['November'] + $Del_FeAmt['November']; 
                                     $dec = $FeAmt['December'] + $Mum_FeAmt['December'] + $Del_FeAmt['December'];   
                                    @endphp                    
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Total Events India FE Amount</th>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Amount</th>      
                                                <th>FE Sheet</th>                                  
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>April</td>
                                                <td>{{$april == 0 ? '' : $april}}</td>
                                                <td>@if(!is_null($Attachment['April']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'April'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>May</td>
                                                <td>{{$may == 0 ? '' : $may}}</td>
                                                <td>@if(!is_null($Attachment['May']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'May'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>June</td>
                                                <td>{{$june == 0 ? '' : $june}}</td>
                                                <td>@if(!is_null($Attachment['June']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'June'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>July</td>
                                                <td>{{$july == 0 ? '' : $july}}</td>
                                                <td>@if(!is_null($Attachment['July']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'July'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>August</td>
                                                <td>{{$august == 0 ? '' : $august}}</td>
                                                <td>@if(!is_null($Attachment['Agust']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'Agust'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>September</td>
                                                <td>{{$sept == 0 ? '' : $sept}}</td>
                                                <td>@if(!is_null($Attachment['September']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'September'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>October</td>
                                                <td>{{$oct == 0 ? '' : $oct}}</td>
                                                <td>@if(!is_null($Attachment['October']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'October'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>November</td>
                                                <td>{{$nov == 0 ? '' : $nov}}</td>
                                                <td>@if(!is_null($Attachment['November']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'November'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>December</td>
                                                <td>{{$dec == 0 ? '' : $dec}}</td>
                                                <td>@if(!is_null($Attachment['December']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'December'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                            </tr>
                                             <tr>
                                                <td colspan="2" style="text-align: center;">Grand Total</td>
                                                <td colspan="2" style="text-align: center;">{{$Sum}}</td>                                        
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Average</td>
                                                <td colspan="2" style="text-align: center;">{{number_format($Sum/$total_month, 2)}}</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>                      
                                </div>  
                                <div class="col-lg-6 col-md-6 col-sm-6">                                                         
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Bangalore FE Amount</th>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Amount</th>                                        
                                            </tr>
                                        </thead>
                                        @php
                                        $Total = $FeAmt['April'] + $FeAmt['May'] + $FeAmt['June'] + $FeAmt['July'] + $FeAmt['Agust'] + $FeAmt['September'] + $FeAmt['October'] + $FeAmt['November'] + $FeAmt['December'];
                                        @endphp
                                        <tbody>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>April</td>
                                                <td>{{$FeAmt['April'] == 0 ? '' : $FeAmt['April']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>May</td>
                                                <td>{{$FeAmt['May'] == 0 ? '' : $FeAmt['May']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>June</td>
                                                <td>{{$FeAmt['June'] == 0 ? '' : $FeAmt['June']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>July</td>
                                                <td>{{$FeAmt['July'] == 0 ? '' : $FeAmt['July']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>August</td>
                                                <td>{{$FeAmt['Agust'] == 0 ? '' : $FeAmt['Agust']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>September</td>
                                                <td>{{$FeAmt['September'] == 0 ? '' : $FeAmt['September']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>October</td>
                                                <td>{{$FeAmt['October'] == 0 ? '' : $FeAmt['October']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>November</td>
                                                <td>{{$FeAmt['November'] == 0 ? '' : $FeAmt['November']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$FeAmt['year']}}</td>
                                                <td>December</td>
                                                <td>{{$FeAmt['December'] == 0 ? '' : $FeAmt['December']}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Grand Total</td>
                                                <td style="text-align: center;">{{$Total}}</td>                                        
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Average</td>
                                                <td style="text-align: center;">{{number_format($Total/$total_month, 2)}}</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>                             
                                </div>
                               
                            </div>
                        </div>
                        <div class="body mb-2">
                            <div class="row clearfix">
                                 <div class="col-lg-6 col-md-6 col-sm-6">                              
                                    @php
                                        $Mum_Total = $Mum_FeAmt['April'] + $Mum_FeAmt['May'] + $Mum_FeAmt['June'] + $Mum_FeAmt['July'] + $Mum_FeAmt['Agust'] + $Mum_FeAmt['September'] + $Mum_FeAmt['October'] + $Mum_FeAmt['November'] + $Mum_FeAmt['December'];
                                    @endphp                       
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Mumbai FE Amount</th>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Amount</th>                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>April</td>
                                                <td>{{$Mum_FeAmt['April'] == 0 ? '' : $Mum_FeAmt['April']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>May</td>
                                                <td>{{$Mum_FeAmt['May'] == 0 ? '' : $Mum_FeAmt['May']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>June</td>
                                                <td>{{$Mum_FeAmt['June'] == 0 ? '' : $Mum_FeAmt['June']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>July</td>
                                                <td>{{$Mum_FeAmt['July'] == 0 ? '' : $Mum_FeAmt['July']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>August</td>
                                                <td>{{$Mum_FeAmt['Agust'] == 0 ? '' : $Mum_FeAmt['Agust']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>September</td>
                                                <td>{{$Mum_FeAmt['September'] == 0 ? '' : $Mum_FeAmt['September']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>October</td>
                                                <td>{{$Mum_FeAmt['October'] == 0 ? '' : $Mum_FeAmt['October']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>November</td>
                                                <td>{{$Mum_FeAmt['November'] == 0 ? '' : $Mum_FeAmt['November']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Mum_FeAmt['year']}}</td>
                                                <td>December</td>
                                                <td>{{$Mum_FeAmt['December'] == 0 ? '' : $Mum_FeAmt['December']}}</td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Grand Total</td>
                                                <td style="text-align: center;">{{$Mum_Total}}</td>                                        
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="text-align: center;">Average</td>
                                                <td style="text-align: center;">{{number_format($Mum_Total/$total_month, 2)}}</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>                          
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">                       
                                    @php
                                        $Del_Total = $Del_FeAmt['April'] + $Del_FeAmt['May'] + $Del_FeAmt['June'] + $Del_FeAmt['July'] + $Del_FeAmt['Agust'] + $Del_FeAmt['September'] + $Del_FeAmt['October'] + $Del_FeAmt['November'] + $Del_FeAmt['December'];
                                    @endphp                                 
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Delhi FE Amount</th>
                                            </tr>
                                            <tr>
                                                <th>Year</th>
                                                <th>Month</th>
                                                <th>Amount</th>                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>April</td>
                                                <td>{{$Del_FeAmt['April'] == 0 ? '' : $Del_FeAmt['April']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>May</td>
                                                <td>{{$Del_FeAmt['May'] == 0 ? '' : $Del_FeAmt['May']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>June</td>
                                                <td>{{$Del_FeAmt['June'] == 0 ? '' : $Del_FeAmt['June']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>July</td>
                                                <td>{{$Del_FeAmt['July'] == 0 ? '' : $Del_FeAmt['July']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>August</td>
                                                <td>{{$Del_FeAmt['Agust'] == 0 ? '' : $Del_FeAmt['Agust']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>September</td>
                                                <td>{{$Del_FeAmt['September'] == 0 ? '' : $Del_FeAmt['September']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>October</td>
                                                <td>{{$Del_FeAmt['October'] == 0 ? '' : $Del_FeAmt['October']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>November</td>
                                                <td>{{$Del_FeAmt['November'] == 0 ? '' : $Del_FeAmt['November']}}</td>
                                            </tr>
                                            <tr>
                                                <td>{{$Del_FeAmt['year']}}</td>
                                                <td>December</td>
                                                <td>{{$Del_FeAmt['December'] == 0 ? '' : $Del_FeAmt['December']}}</td>
                                            </tr>
                                             <tr>
                                                <td colspan="2" style="text-align: center;">Grand Total</td>
                                                <td style="text-align: center;">{{$Del_Total}}</td>                                        
                                            </tr>
                                             <tr>
                                                <td colspan="2" style="text-align: center;">Average</td>
                                                <td style="text-align: center;">{{number_format($Del_Total/$total_month, 2)}}</td>                                        
                                            </tr>
                                        </tbody>
                                    </table>                    
                                </div>  
                                           
                            </div>
                        </div>
                        
                        <div class="body mb-2">
                            <div class="row clearfix">                             
                                <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="15" style="text-align: center;color:#e47297;">Bangalore - Monthly Sales Report for the Financial year 2020-2021</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th style="text-align: center;font-size: 17px;">Year</th>
                                                <th>April</th>
                                                <th>May</th>
                                                <th>June</th>
                                                <th>July</th>
                                                <th>Aug</th>
                                                <th>Sep</th>
                                                <th>Oct</th>
                                                <th>Nov</th>
                                                <th>Dec</th>
                                                <th>Jan</th>
                                                <th>Feb</th>
                                                <th>March</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                            <tr>
                                               <td rowspan="6" class="blr" style='text-align:center;vertical-align:middle;font-size: 18px;'>BLR</td>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;" class="thead">2016-2017</td>        
                                                @php
                                                $Total_1617 = $bangalore_1617['April'] + $bangalore_1617['May'] + $bangalore_1617['June'] + $bangalore_1617['July'] + $bangalore_1617['Agust'] + $bangalore_1617['September'] + $bangalore_1617['October'] + $bangalore_1617['November'] + $bangalore_1617['December'] + $bangalore_1617['January'] +
                                                $bangalore_1617['February'] + $bangalore_1617['March'];
                                                $Total_1718 = $bangalore_1718['April'] + $bangalore_1718['May'] + $bangalore_1718['June'] + $bangalore_1718['July'] + $bangalore_1718['Agust'] + $bangalore_1718['September'] + $bangalore_1718['October'] + $bangalore_1718['November'] + $bangalore_1718['December'] + $bangalore_1718['January'] +
                                                $bangalore_1718['February'] + $bangalore_1718['March'];
                                                $Total_1819 = $bangalore_1819['April'] + $bangalore_1819['May'] + $bangalore_1819['June'] + $bangalore_1819['July'] + $bangalore_1819['Agust'] + $bangalore_1819['September'] + $bangalore_1819['October'] + $bangalore_1819['November'] + $bangalore_1819['December'] + $bangalore_1819['January'] +
                                                $bangalore_1819['February'] + $bangalore_1819['March'];
                                                $Total_1920 = $bangalore_1920['April'] + $bangalore_1920['May'] + $bangalore_1920['June'] + $bangalore_1920['July'] + $bangalore_1920['Agust'] + $bangalore_1920['September'] + $bangalore_1920['October'] + $bangalore_1920['November'] + $bangalore_1920['December'] + $bangalore_1920['January'] +
                                                $bangalore_1920['February'] + $bangalore_1920['March'];
                                                $Total_2021 = $bangalore['April'] + $bangalore['May'] + $bangalore['June'] + $bangalore['July'] + $bangalore['Agust'] + $bangalore['September'] + $bangalore['October'] + $bangalore['November'] + $bangalore['December'] + $bangalore['January'] +
                                                $bangalore['February'] + $bangalore['March'];
                                                @endphp                                        
                                                <td>{{  $bangalore_1617['April'] }}</td>
                                                <td>{{  $bangalore_1617['May'] }}</td>
                                                <td>{{  $bangalore_1617['June'] }}</td>
                                                <td>{{  $bangalore_1617['July'] }}</td>
                                                <td>{{  $bangalore_1617['Agust'] }}</td>
                                                <td>{{  $bangalore_1617['September'] }}</td>
                                                <td>{{  $bangalore_1617['October'] }}</td>
                                                <td>{{  $bangalore_1617['November'] }}</td>
                                                <td>{{  $bangalore_1617['December'] }}</td>
                                                <td>{{  $bangalore_1617['January'] }}</td>
                                                <td>{{  $bangalore_1617['February'] }}</td>
                                                <td>{{  $bangalore_1617['March'] }}</td>
                                                <td>{{  $Total_1617 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;" class="thead">2017-2018</td>
                                                <td>{{  $bangalore_1718['April'] }}</td>
                                                <td>{{  $bangalore_1718['May'] }}</td>
                                                <td>{{  $bangalore_1718['June'] }}</td>
                                                <td>{{  $bangalore_1718['July'] }}</td>
                                                <td>{{  $bangalore_1718['Agust'] }}</td>
                                                <td>{{  $bangalore_1718['September'] }}</td>
                                                <td>{{  $bangalore_1718['October'] }}</td>
                                                <td>{{  $bangalore_1718['November'] }}</td>
                                                <td>{{  $bangalore_1718['December'] }}</td>
                                                <td>{{  $bangalore_1718['January'] }}</td>
                                                <td>{{  $bangalore_1718['February'] }}</td>
                                                <td>{{  $bangalore_1718['March'] }}</td>
                                                <td>{{  $Total_1718 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;" class="thead">2018-2019</td>
                                                <td>{{  $bangalore_1819['April'] }}</td>
                                                <td>{{  $bangalore_1819['May'] }}</td>
                                                <td>{{  $bangalore_1819['June'] }}</td>
                                                <td>{{  $bangalore_1819['July'] }}</td>
                                                <td>{{  $bangalore_1819['Agust'] }}</td>
                                                <td>{{  $bangalore_1819['September'] }}</td>
                                                <td>{{  $bangalore_1819['October'] }}</td>
                                                <td>{{  $bangalore_1819['November'] }}</td>
                                                <td>{{  $bangalore_1819['December'] }}</td>
                                                <td>{{  $bangalore_1819['January'] }}</td>
                                                <td>{{  $bangalore_1819['February'] }}</td>
                                                <td>{{  $bangalore_1819['March'] }}</td>
                                                <td>{{  $Total_1819 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;" class="thead">2019-2020</td>
                                                <td>{{  $bangalore_1920['April'] }}</td>
                                                <td>{{  $bangalore_1920['May'] }}</td>
                                                <td>{{  $bangalore_1920['June'] }}</td>
                                                <td>{{  $bangalore_1920['July'] }}</td>
                                                <td>{{  $bangalore_1920['Agust'] }}</td>
                                                <td>{{  $bangalore_1920['September'] }}</td>
                                                <td>{{  $bangalore_1920['October'] }}</td>
                                                <td>{{  $bangalore_1920['November'] }}</td>
                                                <td>{{  $bangalore_1920['December'] }}</td>
                                                <td>{{  $bangalore_1920['January'] }}</td>
                                                <td>{{  $bangalore_1920['February'] }}</td>
                                                <td>{{  $bangalore_1920['March'] }}</td>
                                                <td>{{  $Total_1920 }}</td>
                                            </tr>
                                            
                                             <tr>                                              
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;" class="thead">2020-2021</td>

                                                @if($bangalore['April'] > $bangalore_1920['April'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['April']}}</td>
                                                @elseif($bangalore['April'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['April']}}</td>
                                                @endif

                                                @if($bangalore['May'] > $bangalore_1920['May'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['May']}}</td>
                                                @elseif($bangalore['May'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['May']}}</td>
                                                @endif

                                                @if($bangalore['June'] > $bangalore_1920['June'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['June']}}</td>
                                                @elseif($bangalore['June'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['June']}}</td>
                                                @endif

                                                @if($bangalore['July'] > $bangalore_1920['July'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['July']}}</td>
                                                @elseif($bangalore['July'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['July']}}</td>
                                                @endif

                                                @if($bangalore['Agust'] > $bangalore_1920['Agust'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['Agust']}}</td>
                                                @elseif($bangalore['Agust'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['Agust']}}</td>
                                                @endif

                                                @if($bangalore['September'] > $bangalore_1920['September'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['September']}}</td>
                                                @elseif($bangalore['September'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['September']}}</td>
                                                @endif

                                                @if($bangalore['October'] > $bangalore_1920['October'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['October']}}</td>
                                                @elseif($bangalore['October'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['October']}}</td>
                                                @endif

                                                @if($bangalore['November'] > $bangalore_1920['November'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['November']}}</td>
                                                @elseif($bangalore['November'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['November']}}</td>
                                                @endif

                                                @if($bangalore['December'] > $bangalore_1920['December'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['December']}}</td>
                                                @elseif($bangalore['December'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['December']}}</td>
                                                @endif

                                                @if($bangalore['January'] > $bangalore_1920['January'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['January']}}</td>
                                                @elseif($bangalore['January'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['January']}}</td>
                                                @endif

                                                @if($bangalore['February'] > $bangalore_1920['February'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['February']}}</td>
                                                @elseif($bangalore['February'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['February']}}</td>
                                                @endif


                                                @if($bangalore['March'] > $bangalore_1920['March'])
                                                  <td style="background:green;color:#fff;">{{  $bangalore['March']}}</td>
                                                @elseif($bangalore['March'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $bangalore['March']}}</td>
                                                @endif

                                                <td>{{  $Total_2021 }}</td>
                                            </tr> 
                                            <tr>
                                                <?php
                                                    $diff_Apr_2021 = $bangalore['April'] - $bangalore_1920['April'];
                                                    $diff_May_2021 = $bangalore['May'] - $bangalore_1920['May'];
                                                    $diff_June_2021 = $bangalore['June'] - $bangalore_1920['June'];
                                                    $diff_July_2021 = $bangalore['July'] - $bangalore_1920['July'];
                                                    $diff_Agust_2021 = $bangalore['Agust'] - $bangalore_1920['Agust'];
                                                    $diff_September_2021 = $bangalore['September'] - $bangalore_1920['September'];
                                                    $diff_October_2021 = $bangalore['October'] - $bangalore_1920['October'];
                                                    $diff_November_2021 = $bangalore['November'] - $bangalore_1920['November'];
                                                    $diff_December_2021 = $bangalore['December'] - $bangalore_1920['December'];
                                                    $diff_January_2021 = $bangalore['January'] - $bangalore_1920['January'];
                                                    $diff_February_2021 = $bangalore['February'] - $bangalore_1920['February'];
                                                    $diff_March_2021 = $bangalore['March'] - $bangalore_1920['March'];
                                                ?>
                                                <td style="color: blue;font-weight: bold;font-size: 17px;">Difference</td>
                                                  @if($bangalore['April'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Apr_2021 > 0)
                                                          <td>{{$diff_Apr_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Apr_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['May'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_May_2021 > 0)
                                                          <td>{{$diff_May_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_May_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['June'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_June_2021 > 0)
                                                          <td>{{$diff_June_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_June_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['July'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_July_2021 > 0)
                                                          <td>{{$diff_July_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_July_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['Agust'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Agust_2021 > 0)
                                                          <td>{{$diff_Agust_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Agust_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['September'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_September_2021 > 0)
                                                          <td>{{$diff_September_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_September_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['October'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_October_2021 > 0)
                                                          <td>{{$diff_October_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_October_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['November'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_November_2021 > 0)
                                                          <td>{{$diff_November_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_November_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['December'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_December_2021 > 0)
                                                          <td>{{$diff_December_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_December_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['January'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_January_2021 > 0)
                                                          <td>{{$diff_January_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_January_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['February'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_February_2021 > 0)
                                                          <td>{{$diff_February_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_February_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($bangalore['March'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_March_2021 > 0)
                                                          <td>{{$diff_March_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_March_2021}}</span></td>
                                                       @endif
                                                  @endif
                                                  <td></td>
                                            </tr>                                                                     
                                       </tbody>
                                    </table>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="15" style="text-align: center;color:#e47297;">Mumbai - Monthly Sales Report for the Financial year 2020-2021</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th style="text-align: center;font-size: 17px;">Year</th>
                                                <th>April</th>
                                                <th>May</th>
                                                <th>June</th>
                                                <th>July</th>
                                                <th>Aug</th>
                                                <th>Sep</th>
                                                <th>Oct</th>
                                                <th>Nov</th>
                                                <th>Dec</th>
                                                <th>Jan</th>
                                                <th>Feb</th>
                                                <th>March</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                            @php
                                                $Mumbai_Total_1617 = $mumbai_1617['April'] + $mumbai_1617['May'] + $mumbai_1617['June'] + $mumbai_1617['July'] + $mumbai_1617['Agust'] + $mumbai_1617['September'] + $mumbai_1617['October'] + $mumbai_1617['November'] + $mumbai_1617['December'] + $mumbai_1617['January'] +
                                                $mumbai_1617['February'] + $mumbai_1617['March'];
                                                $Mumbai_Total_1718 = $mumbai_1718['April'] + $mumbai_1718['May'] + $mumbai_1718['June'] + $mumbai_1718['July'] + $mumbai_1718['Agust'] + $mumbai_1718['September'] + $mumbai_1718['October'] + $mumbai_1718['November'] + $mumbai_1718['December'] + $mumbai_1718['January'] +
                                                $mumbai_1718['February'] + $mumbai_1718['March'];
                                                $Mumbai_Total_1819 = $mumbai_1819['April'] + $mumbai_1819['May'] + $mumbai_1819['June'] + $mumbai_1819['July'] + $mumbai_1819['Agust'] + $mumbai_1819['September'] + $mumbai_1819['October'] + $mumbai_1819['November'] + $mumbai_1819['December'] + $mumbai_1819['January'] +
                                                $mumbai_1819['February'] + $mumbai_1819['March'];
                                                $Mumbai_Total_1920 = $mumbai_1920['April'] + $mumbai_1920['May'] + $mumbai_1920['June'] + $mumbai_1920['July'] + $mumbai_1920['Agust'] + $mumbai_1920['September'] + $mumbai_1920['October'] + $mumbai_1920['November'] + $mumbai_1920['December'] + $mumbai_1920['January'] +
                                                $mumbai_1920['February'] + $mumbai_1920['March'];
                                                $Mumbai_Total_2021 = $mumbai['April'] + $mumbai['May'] + $mumbai['June'] + $mumbai['July'] + $mumbai['Agust'] + $mumbai['September'] + $mumbai['October'] + $mumbai['November'] + $mumbai['December'] + $mumbai['January'] +
                                                $mumbai['February'] + $mumbai['March'];
                                            @endphp        
                                            <tr>
                                               <td rowspan="6" class="mum" style='text-align:center;vertical-align:middle;font-size: 18px;'>MUM</td>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2016-2017</td>                                               
                                                <td>{{  $mumbai_1617['April'] }}</td>
                                                <td>{{  $mumbai_1617['May'] }}</td>
                                                <td>{{  $mumbai_1617['June'] }}</td>
                                                <td>{{  $mumbai_1617['July'] }}</td>
                                                <td>{{  $mumbai_1617['Agust'] }}</td>
                                                <td>{{  $mumbai_1617['September'] }}</td>
                                                <td>{{  $mumbai_1617['October'] }}</td>
                                                <td>{{  $mumbai_1617['November'] }}</td>
                                                <td>{{  $mumbai_1617['December'] }}</td>
                                                <td>{{  $mumbai_1617['January'] }}</td>
                                                <td>{{  $mumbai_1617['February'] }}</td>
                                                <td>{{  $mumbai_1617['March'] }}</td>
                                                <td> {{ $Mumbai_Total_1617}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2017-2018</td>                                               
                                                <td>{{  $mumbai_1718['April'] }}</td>
                                                <td>{{  $mumbai_1718['May'] }}</td>
                                                <td>{{  $mumbai_1718['June'] }}</td>
                                                <td>{{  $mumbai_1718['July'] }}</td>
                                                <td>{{  $mumbai_1718['Agust'] }}</td>
                                                <td>{{  $mumbai_1718['September'] }}</td>
                                                <td>{{  $mumbai_1718['October'] }}</td>
                                                <td>{{  $mumbai_1718['November'] }}</td>
                                                <td>{{  $mumbai_1718['December'] }}</td>
                                                <td>{{  $mumbai_1718['January'] }}</td>
                                                <td>{{  $mumbai_1718['February'] }}</td>
                                                <td>{{  $mumbai_1718['March'] }}</td>
                                                <td> {{ $Mumbai_Total_1718}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2018-2019</td>
                                                <td>{{  $mumbai_1819['April'] }}</td>
                                                <td>{{  $mumbai_1819['May'] }}</td>
                                                <td>{{  $mumbai_1819['June'] }}</td>
                                                <td>{{  $mumbai_1819['July'] }}</td>
                                                <td>{{  $mumbai_1819['Agust'] }}</td>
                                                <td>{{  $mumbai_1819['September'] }}</td>
                                                <td>{{  $mumbai_1819['October'] }}</td>
                                                <td>{{  $mumbai_1819['November'] }}</td>
                                                <td>{{  $mumbai_1819['December'] }}</td>
                                                <td>{{  $mumbai_1819['January'] }}</td>
                                                <td>{{  $mumbai_1819['February'] }}</td>
                                                <td>{{  $mumbai_1819['March'] }}</td>
                                                <td> {{ $Mumbai_Total_1819}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2019-2020
                                                </td>
                                                <td>{{  $mumbai_1920['April'] }}</td>
                                                <td>{{  $mumbai_1920['May'] }}</td>
                                                <td>{{  $mumbai_1920['June'] }}</td>
                                                <td>{{  $mumbai_1920['July'] }}</td>
                                                <td>{{  $mumbai_1920['Agust'] }}</td>
                                                <td>{{  $mumbai_1920['September'] }}</td>
                                                <td>{{  $mumbai_1920['October'] }}</td>
                                                <td>{{  $mumbai_1920['November'] }}</td>
                                                <td>{{  $mumbai_1920['December'] }}</td>
                                                <td>{{  $mumbai_1920['January'] }}</td>
                                                <td>{{  $mumbai_1920['February'] }}</td>
                                                <td>{{  $mumbai_1920['March'] }}</td>
                                                <td> {{ $Mumbai_Total_1920}}</td>
                                            </tr>
                                            <tr>                                              
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2020-2021</td> 

                                                @if($mumbai['April'] > $mumbai_1920['April'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['April']}}</td>
                                                @elseif($mumbai['April'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['April']}}</td>
                                                @endif

                                                @if($mumbai['May'] > $mumbai_1920['May'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['May']}}</td>
                                                @elseif($mumbai['May'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['May']}}</td>
                                                @endif

                                                @if($mumbai['June'] > $mumbai_1920['June'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['June']}}</td>
                                                @elseif($mumbai['June'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['June']}}</td>
                                                @endif

                                                @if($mumbai['July'] > $mumbai_1920['July'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['July']}}</td>
                                                @elseif($mumbai['July'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['July']}}</td>
                                                @endif

                                                @if($mumbai['Agust'] > $mumbai_1920['Agust'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['Agust']}}</td>
                                                @elseif($mumbai['Agust'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['Agust']}}</td>
                                                @endif

                                                @if($mumbai['September'] > $mumbai_1920['September'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['September']}}</td>
                                                @elseif($mumbai['September'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['September']}}</td>
                                                @endif

                                                @if($mumbai['October'] > $mumbai_1920['October'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['October']}}</td>
                                                @elseif($mumbai['October'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['October']}}</td>
                                                @endif

                                                @if($mumbai['November'] > $mumbai_1920['November'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['November']}}</td>
                                                @elseif($mumbai['November'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['November']}}</td>
                                                @endif

                                                @if($mumbai['December'] > $mumbai_1920['December'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['December']}}</td>
                                                @elseif($mumbai['December'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['December']}}</td>
                                                @endif

                                                @if($mumbai['January'] > $mumbai_1920['January'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['January']}}</td>
                                                @elseif($mumbai['January'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['January']}}</td>
                                                @endif

                                                @if($mumbai['February'] > $mumbai_1920['February'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['February']}}</td>
                                                @elseif($mumbai['February'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['February']}}</td>
                                                @endif

                                                @if($mumbai['March'] > $mumbai_1920['March'])
                                                  <td style="background:green;color:#fff;">{{  $mumbai['March']}}</td>
                                                @elseif($mumbai['March'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $mumbai['March']}}</td>
                                                @endif

                                                <td> {{ $Mumbai_Total_2021}}</td>
                                            </tr>         
                                            <tr>
                                                <?php
                                                    $diff_Apr_2021 = $mumbai['April'] - $mumbai_1920['April'];
                                                    $diff_May_2021 = $mumbai['May'] - $mumbai_1920['May'];
                                                    $diff_June_2021 = $mumbai['June'] - $mumbai_1920['June'];
                                                    $diff_July_2021 = $mumbai['July'] - $mumbai_1920['July'];
                                                    $diff_Agust_2021 = $mumbai['Agust'] - $mumbai_1920['Agust'];
                                                    $diff_September_2021 = $mumbai['September'] - $mumbai_1920['September'];
                                                    $diff_October_2021 = $mumbai['October'] - $mumbai_1920['October'];
                                                    $diff_November_2021 = $mumbai['November'] - $mumbai_1920['November'];
                                                    $diff_December_2021 = $mumbai['December'] - $mumbai_1920['December'];
                                                    $diff_January_2021 = $mumbai['January'] - $mumbai_1920['January'];
                                                    $diff_February_2021 = $mumbai['February'] - $mumbai_1920['February'];
                                                    $diff_March_2021 = $mumbai['March'] - $mumbai_1920['March'];
                                                ?>
                                                <td style="color: blue;font-weight: bold;font-size: 17px;text-align:center;">Difference</td>
                                                  @if($mumbai['April'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Apr_2021 > 0)
                                                          <td>{{$diff_Apr_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Apr_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['May'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_May_2021 > 0)
                                                          <td>{{$diff_May_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_May_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['June'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_June_2021 > 0)
                                                          <td>{{$diff_June_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_June_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['July'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_July_2021 > 0)
                                                          <td>{{$diff_July_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_July_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['Agust'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Agust_2021 > 0)
                                                          <td>{{$diff_Agust_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Agust_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['September'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_September_2021 > 0)
                                                          <td>{{$diff_September_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_September_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['October'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_October_2021 > 0)
                                                          <td>{{$diff_October_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_October_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['November'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_November_2021 > 0)
                                                          <td>{{$diff_November_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_November_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['December'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_December_2021 > 0)
                                                          <td>{{$diff_December_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_December_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['January'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_January_2021 > 0)
                                                          <td>{{$diff_January_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_January_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['February'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_February_2021 > 0)
                                                          <td>{{$diff_February_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_February_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($mumbai['March'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_March_2021 > 0)
                                                          <td>{{$diff_March_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_March_2021}}</span></td>
                                                       @endif
                                                  @endif
                                                  <td></td>
                                            </tr>                                                                     
                                       </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="15" style="text-align: center;color:#e47297;">Delhi - Monthly Sales Report for the Financial year 2020-2021</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th style="text-align: center;font-size: 17px;">Year</th>
                                                <th>April</th>
                                                <th>May</th>
                                                <th>June</th>
                                                <th>July</th>
                                                <th>Aug</th>
                                                <th>Sep</th>
                                                <th>Oct</th>
                                                <th>Nov</th>
                                                <th>Dec</th>
                                                <th>Jan</th>
                                                <th>Feb</th>
                                                <th>March</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                            @php
                                                $Delhi_Total_1617 = $delhi_1617['April'] + $delhi_1617['May'] + $delhi_1617['June'] + $delhi_1617['July'] + $delhi_1617['Agust'] + $delhi_1617['September'] + $delhi_1617['October'] + $delhi_1617['November'] + $delhi_1617['December'] + $delhi_1617['January'] +
                                                $delhi_1617['February'] + $delhi_1617['March'];
                                                $Delhi_Total_1718 = $delhi_1718['April'] + $delhi_1718['May'] + $delhi_1718['June'] + $delhi_1718['July'] + $delhi_1718['Agust'] + $delhi_1718['September'] + $delhi_1718['October'] + $delhi_1718['November'] + $delhi_1718['December'] + $delhi_1718['January'] +
                                                $delhi_1718['February'] + $delhi_1718['March'];
                                                $Delhi_Total_1819 = $delhi_1819['April'] + $delhi_1819['May'] + $delhi_1819['June'] + $delhi_1819['July'] + $delhi_1819['Agust'] + $delhi_1819['September'] + $delhi_1819['October'] + $delhi_1819['November'] + $delhi_1819['December'] + $delhi_1819['January'] +
                                                $delhi_1819['February'] + $delhi_1819['March'];
                                                $Delhi_Total_1920 = $delhi_1920['April'] + $delhi_1920['May'] + $delhi_1920['June'] + $delhi_1920['July'] + $delhi_1920['Agust'] + $delhi_1920['September'] + $delhi_1920['October'] + $delhi_1920['November'] + $delhi_1920['December'] + $delhi_1920['January'] +
                                                $delhi_1920['February'] + $delhi_1920['March'];
                                                $Delhi_Total_2021 = $delhi['April'] + $delhi['May'] + $delhi['June'] + $delhi['July'] + $delhi['Agust'] + $delhi['September'] + $delhi['October'] + $delhi['November'] + $delhi['December'] + $delhi['January'] +
                                                $delhi['February'] + $delhi['March'];
                                            @endphp        
                                            <tr>
                                               <td rowspan="6" class="mum" style='text-align:center;vertical-align:middle;font-size: 18px;'>DEL</td>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2016-2017</td>
                                                <td>{{  $delhi_1617['April'] }}</td>
                                                <td>{{  $delhi_1617['May'] }}</td>
                                                <td>{{  $delhi_1617['June'] }}</td>
                                                <td>{{  $delhi_1617['July'] }}</td>
                                                <td>{{  $delhi_1617['Agust'] }}</td>
                                                <td>{{  $delhi_1617['September'] }}</td>
                                                <td>{{  $delhi_1617['October'] }}</td>
                                                <td>{{  $delhi_1617['November'] }}</td>
                                                <td>{{  $delhi_1617['December'] }}</td>
                                                <td>{{  $delhi_1617['January'] }}</td>
                                                <td>{{  $delhi_1617['February'] }}</td>
                                                <td>{{  $delhi_1617['March'] }}</td>
                                                <td>{{ $Delhi_Total_1617}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2017-2018</td>
                                                <td>{{  $delhi_1718['April'] }}</td>
                                                <td>{{  $delhi_1718['May'] }}</td>
                                                <td>{{  $delhi_1718['June'] }}</td>
                                                <td>{{  $delhi_1718['July'] }}</td>
                                                <td>{{  $delhi_1718['Agust'] }}</td>
                                                <td>{{  $delhi_1718['September'] }}</td>
                                                <td>{{  $delhi_1718['October'] }}</td>
                                                <td>{{  $delhi_1718['November'] }}</td>
                                                <td>{{  $delhi_1718['December'] }}</td>
                                                <td>{{  $delhi_1718['January'] }}</td>
                                                <td>{{  $delhi_1718['February'] }}</td>
                                                <td>{{  $delhi_1718['March'] }}</td>
                                                <td>{{ $Delhi_Total_1718}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2018-2019</td>
                                                <td>{{  $delhi_1819['April'] }}</td>
                                                <td>{{  $delhi_1819['May'] }}</td>
                                                <td>{{  $delhi_1819['June'] }}</td>
                                                <td>{{  $delhi_1819['July'] }}</td>
                                                <td>{{  $delhi_1819['Agust'] }}</td>
                                                <td>{{  $delhi_1819['September'] }}</td>
                                                <td>{{  $delhi_1819['October'] }}</td>
                                                <td>{{  $delhi_1819['November'] }}</td>
                                                <td>{{  $delhi_1819['December'] }}</td>
                                                <td>{{  $delhi_1819['January'] }}</td>
                                                <td>{{  $delhi_1819['February'] }}</td>
                                                <td>{{  $delhi_1819['March'] }}</td>
                                                <td>{{ $Delhi_Total_1819}}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2019-2020</td>
                                                <td>{{  $delhi_1920['April'] }}</td>
                                                <td>{{  $delhi_1920['May'] }}</td>
                                                <td>{{  $delhi_1920['June'] }}</td>
                                                <td>{{  $delhi_1920['July'] }}</td>
                                                <td>{{  $delhi_1920['Agust'] }}</td>
                                                <td>{{  $delhi_1920['September'] }}</td>
                                                <td>{{  $delhi_1920['October'] }}</td>
                                                <td>{{  $delhi_1920['November'] }}</td>
                                                <td>{{  $delhi_1920['December'] }}</td>
                                                <td>{{  $delhi_1920['January'] }}</td>
                                                <td>{{  $delhi_1920['February'] }}</td>
                                                <td>{{  $delhi_1920['March'] }}</td>
                                                <td>{{ $Delhi_Total_1920}}</td>
                                            </tr>
                                            <tr>                                              
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2020-2021</td>

                                                @if($delhi['April'] > $delhi_1920['April'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['April']}}</td>
                                                @elseif($delhi['April'] == 0)
                                                    <td>0</td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['April']}}</td>
                                                @endif

                                                @if($delhi['May'] > $delhi_1920['May'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['May']}}</td>
                                                @elseif($delhi['May'] == 0)
                                                    <td>0</td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['May']}}</td>
                                                @endif

                                                @if($delhi['June'] > $delhi_1920['June'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['June']}}</td>
                                                @elseif($delhi['June'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['June']}}</td>
                                                @endif

                                                @if($delhi['July'] > $delhi_1920['July'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['July']}}</td>
                                                @elseif($delhi['July'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['July']}}</td>
                                                @endif

                                                @if($delhi['Agust'] > $delhi_1920['Agust'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['Agust']}}</td>
                                                @elseif($delhi['Agust'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['Agust']}}</td>
                                                @endif

                                                @if($delhi['September'] > $delhi_1920['September'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['September']}}</td>
                                                @elseif($delhi['September'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['September']}}</td>
                                                @endif

                                                @if($delhi['October'] > $delhi_1920['October'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['October']}}</td>
                                                @elseif($delhi['October'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['October']}}</td>
                                                @endif

                                                @if($delhi['November'] > $delhi_1920['November'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['November']}}</td>
                                                @elseif($delhi['November'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['November']}}</td>
                                                @endif

                                                @if($delhi['December'] > $delhi_1920['December'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['December']}}</td>
                                                @elseif($delhi['December'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['December']}}</td>
                                                @endif

                                                @if($delhi['January'] > $delhi_1920['January'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['January']}}</td>
                                                @elseif($delhi['January'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['January']}}</td>
                                                @endif

                                                @if($delhi['February'] > $delhi_1920['February'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['February']}}</td>
                                                @elseif($delhi['February'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['February']}}</td>
                                                @endif

                                                @if($delhi['March'] > $delhi_1920['March'])
                                                  <td style="background:green;color:#fff;">{{  $delhi['March']}}</td>
                                                @elseif($delhi['March'] == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{  $delhi['March']}}</td>
                                                @endif

                                                <td>{{ $Delhi_Total_2021}}</td>
                                            </tr>       
                                            <tr>
                                                <?php
                                                    $diff_Apr_2021 = $delhi['April'] - $delhi_1920['April'];
                                                    $diff_May_2021 = $delhi['May'] - $delhi_1920['May'];
                                                    $diff_June_2021 = $delhi['June'] - $delhi_1920['June'];
                                                    $diff_July_2021 = $delhi['July'] - $delhi_1920['July'];
                                                    $diff_Agust_2021 = $delhi['Agust'] - $delhi_1920['Agust'];
                                                    $diff_September_2021 = $delhi['September'] - $delhi_1920['September'];
                                                    $diff_October_2021 = $delhi['October'] - $delhi_1920['October'];
                                                    $diff_November_2021 = $delhi['November'] - $delhi_1920['November'];
                                                    $diff_December_2021 = $delhi['December'] - $delhi_1920['December'];
                                                    $diff_January_2021 = $delhi['January'] - $delhi_1920['January'];
                                                    $diff_February_2021 = $delhi['February'] - $delhi_1920['February'];
                                                    $diff_March_2021 = $delhi['March'] - $delhi_1920['March'];
                                                ?>
                                                <td style="color: blue;font-weight: bold;font-size: 17px;text-align:center;">Difference</td>
                                                  @if($delhi['April'] == 0)
                                                    <td>{{$diff_Apr_2021}}</td>
                                                  @else
                                                       @if($diff_Apr_2021 > 0)
                                                          <td>{{$diff_Apr_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Apr_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['May'] == 0)
                                                    <td>{{$diff_May_2021}}</td>
                                                  @else
                                                       @if($diff_May_2021 > 0)
                                                          <td>{{$diff_May_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_May_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['June'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_June_2021 > 0)
                                                          <td>{{$diff_June_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_June_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['July'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_July_2021 > 0)
                                                          <td>{{$diff_July_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_July_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['Agust'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Agust_2021 > 0)
                                                          <td>{{$diff_Agust_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Agust_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['September'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_September_2021 > 0)
                                                          <td>{{$diff_September_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_September_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['October'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_October_2021 > 0)
                                                          <td>{{$diff_October_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_October_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['November'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_November_2021 > 0)
                                                          <td>{{$diff_November_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_November_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['December'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_December_2021 > 0)
                                                          <td>{{$diff_December_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_December_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['January'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_January_2021 > 0)
                                                          <td>{{$diff_January_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_January_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['February'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_February_2021 > 0)
                                                          <td>{{$diff_February_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_February_2021}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if($delhi['March'] == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_March_2021 > 0)
                                                          <td>{{$diff_March_2021}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_March_2021}}</span></td>
                                                       @endif
                                                  @endif
                                                  <td></td>
                                            </tr>                                                                     
                                       </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th colspan="15" style="text-align: center;color:#e47297;">Events India - Monthly Sales Report for the Financial year 2020-2021</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center;font-size: 17px;">Branch</th>
                                                <th style="text-align: center;font-size: 17px;">Year</th>
                                                <th>April</th>
                                                <th>May</th>
                                                <th>June</th>
                                                <th>July</th>
                                                <th>Aug</th>
                                                <th>Sep</th>
                                                <th>Oct</th>
                                                <th>Nov</th>
                                                <th>Dec</th>
                                                <th>Jan</th>
                                                <th>Feb</th>
                                                <th>March</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                       <tbody>
                                            @php
                                               $Sum_1617 = ($bangalore_1617['April'] + $mumbai_1617['April'] + $delhi_1617['April']) + ($bangalore_1617['May'] + $mumbai_1617['May'] + $delhi_1617['May']) + ($bangalore_1617['June'] + $mumbai_1617['June'] + $delhi_1617['June']) + ($bangalore_1617['July'] + $mumbai_1617['July'] + $delhi_1617['July']) + ($bangalore_1617['Agust'] + $mumbai_1617['Agust'] + $delhi_1617['Agust']) + ($bangalore_1617['September'] + $mumbai_1617['September'] + $delhi_1617['September']) + ($bangalore_1617['October'] + $mumbai_1617['October'] + $delhi_1617['October']) + ($bangalore_1617['November'] + $mumbai_1617['November'] + $delhi_1617['November']) + ($bangalore_1617['December'] + $mumbai_1617['December'] + $delhi_1617['December']) + ($bangalore_1617['January'] + $mumbai_1617['January'] + $delhi_1617['January']) + ($bangalore_1617['February'] + $mumbai_1617['February'] + $delhi_1617['February']) + ($bangalore_1617['March'] + $mumbai_1617['March'] + $delhi_1617['March']);

                                               $Sum_1718 = ($bangalore_1718['April'] + $mumbai_1718['April'] + $delhi_1718['April']) + ($bangalore_1718['May'] + $mumbai_1718['May'] + $delhi_1718['May']) + ($bangalore_1718['June'] + $mumbai_1718['June'] + $delhi_1718['June']) + ($bangalore_1718['July'] + $mumbai_1718['July'] + $delhi_1718['July']) + ($bangalore_1718['Agust'] + $mumbai_1718['Agust'] + $delhi_1718['Agust']) + ($bangalore_1718['September'] + $mumbai_1718['September'] + $delhi_1718['September']) + ($bangalore_1718['October'] + $mumbai_1718['October'] + $delhi_1718['October']) + ($bangalore_1718['November'] + $mumbai_1718['November'] + $delhi_1718['November']) + ($bangalore_1718['December'] + $mumbai_1718['December'] + $delhi_1718['December']) + ($bangalore_1718['January'] + $mumbai_1718['January'] + $delhi_1718['January']) + ($bangalore_1718['February'] + $mumbai_1718['February'] + $delhi_1718['February']) + ($bangalore_1718['March'] + $mumbai_1718['March'] + $delhi_1718['March']);

                                               $Sum_1819 = ($bangalore_1819['April'] + $mumbai_1819['April'] + $delhi_1819['April']) + ($bangalore_1819['May'] + $mumbai_1819['May'] + $delhi_1819['May']) + ($bangalore_1819['June'] + $mumbai_1819['June'] + $delhi_1819['June']) + ($bangalore_1819['July'] + $mumbai_1819['July'] + $delhi_1819['July']) + ($bangalore_1819['Agust'] + $mumbai_1819['Agust'] + $delhi_1819['Agust']) + ($bangalore_1819['September'] + $mumbai_1819['September'] + $delhi_1819['September']) + ($bangalore_1819['October'] + $mumbai_1819['October'] + $delhi_1819['October']) + ($bangalore_1819['November'] + $mumbai_1819['November'] + $delhi_1819['November']) + ($bangalore_1819['December'] + $mumbai_1819['December'] + $delhi_1819['December']) + ($bangalore_1819['January'] + $mumbai_1819['January'] + $delhi_1819['January']) + ($bangalore_1819['February'] + $mumbai_1819['February'] + $delhi_1819['February']) + ($bangalore_1819['March'] + $mumbai_1819['March'] + $delhi_1819['March']);

                                                $Sum_1920 = ($bangalore_1920['April'] + $mumbai_1920['April'] + $delhi_1920['April']) + ($bangalore_1920['May'] + $mumbai_1920['May'] + $delhi_1920['May']) + ($bangalore_1920['June'] + $mumbai_1920['June'] + $delhi_1920['June']) + ($bangalore_1920['July'] + $mumbai_1920['July'] + $delhi_1920['July']) + ($bangalore_1920['Agust'] + $mumbai_1920['Agust'] + $delhi_1920['Agust']) + ($bangalore_1920['September'] + $mumbai_1920['September'] + $delhi_1920['September']) + ($bangalore_1920['October'] + $mumbai_1920['October'] + $delhi_1920['October']) + ($bangalore_1920['November'] + $mumbai_1920['November'] + $delhi_1920['November']) + ($bangalore_1920['December'] + $mumbai_1920['December'] + $delhi_1920['December']) + ($bangalore_1920['January'] + $mumbai_1920['January'] + $delhi_1920['January']) + ($bangalore_1920['February'] + $mumbai_1920['February'] + $delhi_1920['February']) + ($bangalore_1920['March'] + $mumbai_1920['March'] + $delhi_1920['March']);

                                                $Sum_2021 = ($bangalore['April'] + $mumbai['April'] + $delhi['April']) + ($bangalore['May'] + $mumbai['May'] + $delhi['May']) + ($bangalore['June'] + $mumbai['June'] + $delhi['June']) + ($bangalore['July'] + $mumbai['July'] + $delhi['July']) + ($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust']) + ($bangalore['September'] + $mumbai['September'] + $delhi['September']) + ($bangalore['October'] + $mumbai['October'] + $delhi['October']) + ($bangalore['November'] + $mumbai['November'] + $delhi['November']) + ($bangalore['December'] + $mumbai['December'] + $delhi['December']) + ($bangalore['January'] + $mumbai['January'] + $delhi['January']) + ($bangalore['February'] + $mumbai['February'] + $delhi['February']) + ($bangalore['March'] + $mumbai['March'] + $delhi['March']);

                                            @endphp        
                                            <tr>
                                               <td rowspan="6" class="mum" style='text-align:center;vertical-align:middle;font-size: 18px;'>INDIA</td>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2016-2017</td>
                                                <td>{{  $bangalore_1617['April'] + $mumbai_1617['April'] + $delhi_1617['April'] }}</td>
                                                <td>{{  $bangalore_1617['May'] + $mumbai_1617['May'] + $delhi_1617['May'] }}</td>
                                                <td>{{  $bangalore_1617['June'] + $mumbai_1617['June'] + $delhi_1617['June'] }}</td>
                                                <td>{{  $bangalore_1617['July'] + $mumbai_1617['July'] + $delhi_1617['July'] }}</td>
                                                <td>{{  $bangalore_1617['Agust'] + $mumbai_1617['Agust'] + $delhi_1617['Agust'] }}</td>
                                                <td>{{  $bangalore_1617['September'] + $mumbai_1617['September'] + $delhi_1617['September'] }}</td>
                                                <td>{{  $bangalore_1617['October'] + $mumbai_1617['October'] + $delhi_1617['October'] }}</td>
                                                <td>{{  $bangalore_1617['November'] + $mumbai_1617['November'] + $delhi_1617['November'] }}</td>
                                                <td>{{  $bangalore_1617['December'] + $mumbai_1617['December'] + $delhi_1617['December'] }}</td>
                                                <td>{{  $bangalore_1617['January'] + $mumbai_1617['January'] + $delhi_1617['January'] }}</td>
                                                <td>{{  $bangalore_1617['February'] + $mumbai_1617['February'] + $delhi_1617['February']  }}</td>
                                                <td>{{  $bangalore_1617['March'] + $mumbai_1617['March'] + $delhi_1617['March'] }}</td>
                                                <td>{{ $Sum_1617 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2017-2018</td>
                                                <td>{{  $bangalore_1718['April'] + $mumbai_1718['April'] + $delhi_1718['April'] }}</td>
                                                <td>{{  $bangalore_1718['May'] + $mumbai_1718['May'] + $delhi_1718['May'] }}</td>
                                                <td>{{  $bangalore_1718['June'] + $mumbai_1718['June'] + $delhi_1718['June'] }}</td>
                                                <td>{{  $bangalore_1718['July'] + $mumbai_1718['July'] + $delhi_1718['July'] }}</td>
                                                <td>{{  $bangalore_1718['Agust'] + $mumbai_1718['Agust'] + $delhi_1718['Agust'] }}</td>
                                                <td>{{  $bangalore_1718['September'] + $mumbai_1718['September'] + $delhi_1718['September'] }}</td>
                                                <td>{{  $bangalore_1718['October'] + $mumbai_1718['October'] + $delhi_1718['October'] }}</td>
                                                <td>{{  $bangalore_1718['November'] + $mumbai_1718['November'] + $delhi_1718['November'] }}</td>
                                                <td>{{  $bangalore_1718['December'] + $mumbai_1718['December'] + $delhi_1718['December'] }}</td>
                                                <td>{{  $bangalore_1718['January'] + $mumbai_1718['January'] + $delhi_1718['January'] }}</td>
                                                <td>{{  $bangalore_1718['February'] + $mumbai_1718['February'] + $delhi_1718['February']  }}</td>
                                                <td>{{  $bangalore_1718['March'] + $mumbai_1718['March'] + $delhi_1718['March'] }}</td>
                                                <td>{{ $Sum_1718 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2018-2019</td>
                                                <td>{{  $bangalore_1819['April'] + $mumbai_1819['April'] + $delhi_1819['April'] }}</td>
                                                <td>{{  $bangalore_1819['May'] + $mumbai_1819['May'] + $delhi_1819['May'] }}</td>
                                                <td>{{  $bangalore_1819['June'] + $mumbai_1819['June'] + $delhi_1819['June'] }}</td>
                                                <td>{{  $bangalore_1819['July'] + $mumbai_1819['July'] + $delhi_1819['July'] }}</td>
                                                <td>{{  $bangalore_1819['Agust'] + $mumbai_1819['Agust'] + $delhi_1819['Agust'] }}</td>
                                                <td>{{  $bangalore_1819['September'] + $mumbai_1819['September'] + $delhi_1819['September'] }}</td>
                                                <td>{{  $bangalore_1819['October'] + $mumbai_1819['October'] + $delhi_1819['October'] }}</td>
                                                <td>{{  $bangalore_1819['November'] + $mumbai_1819['November'] + $delhi_1819['November'] }}</td>
                                                <td>{{  $bangalore_1819['December'] + $mumbai_1819['December'] + $delhi_1819['December'] }}</td>
                                                <td>{{  $bangalore_1819['January'] + $mumbai_1819['January'] + $delhi_1819['January'] }}</td>
                                                <td>{{  $bangalore_1819['February'] + $mumbai_1819['February'] + $delhi_1819['February']  }}</td>
                                                <td>{{  $bangalore_1819['March'] + $mumbai_1819['March'] + $delhi_1819['March'] }}</td>
                                                <td>{{ $Sum_1819 }}</td>
                                            </tr>     
                                            <tr>
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2019-2020</td>
                                                <td>{{  $bangalore_1920['April'] + $mumbai_1920['April'] + $delhi_1920['April'] }}</td>
                                                <td>{{  $bangalore_1920['May'] + $mumbai_1920['May'] + $delhi_1920['May'] }}</td>
                                                <td>{{  $bangalore_1920['June'] + $mumbai_1920['June'] + $delhi_1920['June'] }}</td>
                                                <td>{{  $bangalore_1920['July'] + $mumbai_1920['July'] + $delhi_1920['July'] }}</td>
                                                <td>{{  $bangalore_1920['Agust'] + $mumbai_1920['Agust'] + $delhi_1920['Agust'] }}</td>
                                                <td>{{  $bangalore_1920['September'] + $mumbai_1920['September'] + $delhi_1920['September'] }}</td>
                                                <td>{{  $bangalore_1920['October'] + $mumbai_1920['October'] + $delhi_1920['October'] }}</td>
                                                <td>{{  $bangalore_1920['November'] + $mumbai_1920['November'] + $delhi_1920['November'] }}</td>
                                                <td>{{  $bangalore_1920['December'] + $mumbai_1920['December'] + $delhi_1920['December'] }}</td>
                                                <td>{{  $bangalore_1920['January'] + $mumbai_1920['January'] + $delhi_1920['January'] }}</td>
                                                <td>{{  $bangalore_1920['February'] + $mumbai_1920['February'] + $delhi_1920['February']  }}</td>
                                                <td>{{  $bangalore_1920['March'] + $mumbai_1920['March'] + $delhi_1920['March'] }}</td>
                                                <td>{{ $Sum_1920 }}</td>
                                            </tr>
                                             <tr>                                              
                                                <td style="color: #e47297;font-weight: bold;font-size: 17px;text-align:center;">2020-2021</td>

                                                @if(($bangalore['April'] + $mumbai['April'] + $delhi['April']) > ($bangalore_1920['April'] + $mumbai_1920['April'] + $delhi_1920['April']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['April'] + $mumbai['April'] + $delhi['April'])}}</td>
                                                @elseif(($bangalore['April'] + $mumbai['April'] + $delhi['April']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['April'] + $mumbai['April'] + $delhi['April'])}}</td>
                                                @endif

                                                @if(($bangalore['May'] + $mumbai['May'] + $delhi['May']) > ($bangalore_1920['May'] + $mumbai_1920['May'] + $delhi_1920['May']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['May'] + $mumbai['May'] + $delhi['May'])}}</td>
                                                @elseif(($bangalore['May'] + $mumbai['May'] + $delhi['May']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['May'] + $mumbai['May'] + $delhi['May'])}}</td>
                                                @endif

                                                @if(($bangalore['June'] + $mumbai['June'] + $delhi['June']) > ($bangalore_1920['June'] + $mumbai_1920['June'] + $delhi_1920['June']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['June'] + $mumbai['June'] + $delhi['June'])}}</td>
                                                @elseif(($bangalore['June'] + $mumbai['June'] + $delhi['June']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['June'] + $mumbai['June'] + $delhi['June'])}}</td>
                                                @endif

                                                @if(($bangalore['July'] + $mumbai['July'] + $delhi['July']) > ($bangalore_1920['July'] + $mumbai_1920['July'] + $delhi_1920['July']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['July'] + $mumbai['July'] + $delhi['July'])}}</td>
                                                @elseif(($bangalore['July'] + $mumbai['July'] + $delhi['July']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['July'] + $mumbai['July'] + $delhi['July'])}}</td>
                                                @endif

                                                @if(($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust']) > ($bangalore_1920['Agust'] + $mumbai_1920['Agust'] + $delhi_1920['Agust']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust'])}}</td>
                                                @elseif(($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust'])}}</td>
                                                @endif

                                                @if(($bangalore['September'] + $mumbai['September'] + $delhi['September']) > ($bangalore_1920['September'] + $mumbai_1920['September'] + $delhi_1920['September']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['September'] + $mumbai['September'] + $delhi['September'])}}</td>
                                                @elseif(($bangalore['September'] + $mumbai['September'] + $delhi['September']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['September'] + $mumbai['September'] + $delhi['September'])}}</td>
                                                @endif

                                                @if(($bangalore['October'] + $mumbai['October'] + $delhi['October']) > ($bangalore_1920['October'] + $mumbai_1920['October'] + $delhi_1920['October']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['October'] + $mumbai['October'] + $delhi['October'])}}</td>
                                                @elseif(($bangalore['October'] + $mumbai['October'] + $delhi['October']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['October'] + $mumbai['October'] + $delhi['October'])}}</td>
                                                @endif

                                                @if(($bangalore['November'] + $mumbai['November'] + $delhi['November']) > ($bangalore_1920['November'] + $mumbai_1920['November'] + $delhi_1920['November']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['November'] + $mumbai['November'] + $delhi['November'])}}</td>
                                                @elseif(($bangalore['November'] + $mumbai['November'] + $delhi['November']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['November'] + $mumbai['November'] + $delhi['November'])}}</td>
                                                @endif

                                                @if(($bangalore['December'] + $mumbai['December'] + $delhi['December']) > ($bangalore_1920['December'] + $mumbai_1920['December'] + $delhi_1920['December']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['December'] + $mumbai['December'] + $delhi['December'])}}</td>
                                                @elseif(($bangalore['December'] + $mumbai['December'] + $delhi['December']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['December'] + $mumbai['December'] + $delhi['December'])}}</td>
                                                @endif

                                                @if(($bangalore['January'] + $mumbai['January'] + $delhi['January']) > ($bangalore_1920['January'] + $mumbai_1920['January'] + $delhi_1920['January']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['January'] + $mumbai['January'] + $delhi['January'])}}</td>
                                                @elseif(($bangalore['January'] + $mumbai['January'] + $delhi['January']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['January'] + $mumbai['January'] + $delhi['January'])}}</td>
                                                @endif

                                                @if(($bangalore['February'] + $mumbai['February'] + $delhi['February']) > ($bangalore_1920['February'] + $mumbai_1920['February'] + $delhi_1920['February']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['February'] + $mumbai['February'] + $delhi['February'])}}</td>
                                                @elseif(($bangalore['February'] + $mumbai['February'] + $delhi['February']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['February'] + $mumbai['February'] + $delhi['February'])}}</td>
                                                @endif

                                                @if(($bangalore['March'] + $mumbai['March'] + $delhi['March']) > ($bangalore_1920['March'] + $mumbai_1920['March'] + $delhi_1920['March']))
                                                  <td style="background:green;color:#fff;">{{($bangalore['March'] + $mumbai['March'] + $delhi['March'])}}</td>
                                                @elseif(($bangalore['March'] + $mumbai['March'] + $delhi['March']) == 0)
                                                    <td></td>
                                                @else
                                                    <td style="background:red;color:#fff;">{{($bangalore['March'] + $mumbai['March'] + $delhi['March'])}}</td>
                                                @endif
                                                
                                                <td>{{ $Sum_2021 }}</td>
                                            </tr>           
                                            <tr>
                                                <?php
                                                    $diff_Apr = ($bangalore['April'] + $mumbai['April'] + $delhi['April']) - ($bangalore_1920['April'] + $mumbai_1920['April'] + $delhi_1920['April']);
                                                    $diff_May = ($bangalore['May'] + $mumbai['May'] + $delhi['May']) - ($bangalore_1920['May'] + $mumbai_1920['May'] + $delhi_1920['May']);
                                                    $diff_June = ($bangalore['June'] + $mumbai['June'] + $delhi['June']) - ($bangalore_1920['June'] + $mumbai_1920['June'] + $delhi_1920['June']);
                                                    $diff_July = ($bangalore['July'] + $mumbai['July'] + $delhi['July']) - ($bangalore_1920['July'] + $mumbai_1920['July'] + $delhi_1920['July']);
                                                    $diff_Agust = ($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust']) - ($bangalore_1920['Agust'] + $mumbai_1920['Agust'] + $delhi_1920['Agust']);
                                                    $diff_September = ($bangalore['September'] + $mumbai['September'] + $delhi['September']) - ($bangalore_1920['September'] + $mumbai_1920['September'] + $delhi_1920['September']);
                                                    $diff_October = ($bangalore['October'] + $mumbai['October'] + $delhi['October']) - ($bangalore_1920['October'] + $mumbai_1920['October'] + $delhi_1920['October']);
                                                    $diff_November = ($bangalore['November'] + $mumbai['November'] + $delhi['November']) - ($bangalore_1920['November'] + $mumbai_1920['November'] + $delhi_1920['November']);
                                                    $diff_December = ($bangalore['December'] + $mumbai['December'] + $delhi['December']) - ($bangalore_1920['December'] + $mumbai_1920['December'] + $delhi_1920['December']);
                                                    $diff_January = ($bangalore['January'] + $mumbai['January'] + $delhi['January']) - ($bangalore_1920['January'] + $mumbai_1920['January'] + $delhi_1920['January']);
                                                    $diff_February = ($bangalore['February'] + $mumbai['February'] + $delhi['February']) - ($bangalore_1920['February'] + $mumbai_1920['February'] + $delhi_1920['February']);
                                                    $diff_March = ($bangalore['March'] + $mumbai['March'] + $delhi['March']) - ($bangalore_1920['March'] + $mumbai_1920['March'] + $delhi_1920['March']);
                                                ?>
                                                <td style="color: blue;font-weight: bold;font-size: 17px;text-align:center;">Difference</td>
                                                  @if(($bangalore['April'] + $mumbai['April'] + $delhi['April']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Apr > 0)
                                                          <td>{{$diff_Apr}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Apr}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['May'] + $mumbai['May'] + $delhi['May']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_May > 0)
                                                          <td>{{$diff_May }}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_May}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['June'] + $mumbai['June'] + $delhi['June']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_June > 0)
                                                          <td>{{$diff_June}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_June}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['July'] + $mumbai['July'] + $delhi['July']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_July > 0)
                                                          <td>{{$diff_July}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_July}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['Agust'] + $mumbai['Agust'] + $delhi['Agust']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_Agust > 0)
                                                          <td>{{$diff_Agust}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_Agust}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['September'] + $mumbai['September'] + $delhi['September']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_September > 0)
                                                          <td>{{$diff_September}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_September}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['October'] + $mumbai['October'] + $delhi['October']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_October > 0)
                                                          <td>{{$diff_October}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_October}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['November'] + $mumbai['November'] + $delhi['November']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_November > 0)
                                                          <td>{{$diff_November}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_November}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['December'] + $mumbai['December'] + $delhi['December']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_December > 0)
                                                          <td>{{$diff_December}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_December}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['January'] + $mumbai['January'] + $delhi['January'])  == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_January > 0)
                                                          <td>{{$diff_January}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_January}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['February'] + $mumbai['February'] + $delhi['February']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_February > 0)
                                                          <td>{{$diff_February}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_February}}</span></td>
                                                       @endif
                                                  @endif

                                                  @if(($bangalore['March'] + $mumbai['March'] + $delhi['March']) == 0)
                                                    <td></td>
                                                  @else
                                                       @if($diff_March > 0)
                                                          <td>{{$diff_March}}</td>
                                                       @else
                                                          <td><span style="color:red;">{{$diff_March}}</span></td>
                                                       @endif
                                                  @endif
                                                <td></td>
                                            </tr>                                                                     
                                       </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                         <div class="body mb-2">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Bangalore Billing</th>
                                            </tr>
                                            <tr>
                                                <th class="thead">Sl.No</th>
                                                <th class="thead">Month</th>
                                                <th>2019 - 2020</th>
                                                <th>2020 - 2021</th>
                                                <th>Diff</th>
                                            </tr>
                                        </thead>
                                            <?php
                                                $Ban_Apr = !is_null($bangalore['April']) ? $bangalore['April'] : 0 ;
                                                $Ban_May = !is_null($bangalore['May']) ? $bangalore['May'] : 0 ;
                                                $Ban_Jun = !is_null($bangalore['June']) ? $bangalore['June'] : 0  ;
                                                $Ban_Jly = !is_null($bangalore['July']) ? $bangalore['July'] : 0 ;
                                                $Ban_Aug = !is_null($bangalore['Agust']) ? $bangalore['Agust'] : 0  ;
                                                $Ban_Sep = !is_null($bangalore['September']) ? $bangalore['September'] : 0  ;
                                                $Ban_Oct = !is_null($bangalore['October']) ? $bangalore['October'] : 0  ;
                                                $Ban_Nov = !is_null($bangalore['November']) ? $bangalore['November'] : 0  ;
                                                $Ban_Dec = !is_null($bangalore['December']) ? $bangalore['December'] : 0  ;
                                                $Ban_Jan = !is_null($bangalore['January']) ? $bangalore['January'] : 0  ;
                                                $Ban_Feb = !is_null($bangalore['February']) ? $bangalore['February'] : 0  ;
                                                $Ban_Mar = !is_null($bangalore['March']) ? $bangalore['March'] : 0  ;
                                                $bangalore = ($Ban_Apr + $Ban_May + $Ban_Jun + $Ban_Jly + $Ban_Aug + $Ban_Sep + $Ban_Oct + $Ban_Nov + $Ban_Dec + $Ban_Jan + $Ban_Feb + $Ban_Mar);
                                                
                                                $bangalore_total = $bangalore;
                                                
                                                $Ban_Apr_1920 = !is_null($bangalore_1920['April']) ? $bangalore_1920['April'] : 0 ;
                                                $Ban_May_1920 = !is_null($bangalore_1920['May']) ? $bangalore_1920['May'] : 0 ;
                                                $Ban_Jun_1920 = !is_null($bangalore_1920['June']) ? $bangalore_1920['June'] : 0 ;
                                                $Ban_Jly_1920 = !is_null($bangalore_1920['July']) ? $bangalore_1920['July'] : 0 ;
                                                $Ban_Aug_1920 = !is_null($bangalore_1920['Agust']) ? $bangalore_1920['Agust'] : 0 ;
                                                $Ban_Sep_1920 = !is_null($bangalore_1920['September']) ? $bangalore_1920['September'] : 0  ;
                                                $Ban_Oct_1920 = !is_null($bangalore_1920['October']) ? $bangalore_1920['October'] : 0  ;
                                                $Ban_Nov_1920 = !is_null($bangalore_1920['November']) ? $bangalore_1920['November'] : 0  ;
                                                $Ban_Dec_1920 = !is_null($bangalore_1920['December']) ? $bangalore_1920['December'] : 0  ;
                                                $Ban_Jan_1920 = !is_null($bangalore_1920['January']) ? $bangalore_1920['January'] : 0  ;
                                                $Ban_Feb_1920 = !is_null($bangalore_1920['February']) ? $bangalore_1920['February'] : 0  ;
                                                $Ban_Mar_1920 = !is_null($bangalore_1920['March']) ? $bangalore_1920['March'] : 0  ;
                                                
                                                $bangalore1920total = $Ban_Apr_1920 + $Ban_May_1920 + $Ban_Jun_1920 + $Ban_Jly_1920 + $Ban_Aug_1920 + $Ban_Sep_1920 + $Ban_Oct_1920 + $Ban_Nov_1920 + $Ban_Dec_1920 + $Ban_Jan_1920 + $Ban_Feb_1920 + $Ban_Mar_1920;
                                                
                                                $Ban_Apr_diff = $Ban_Apr-$Ban_Apr_1920;
                                                $Ban_May_diff = $Ban_May-$Ban_May_1920;
                                                $Ban_Jun_diff = $Ban_Jun-$Ban_Jun_1920;
                                                $Ban_Jly_diff = $Ban_Jly-$Ban_Jly_1920;
                                                $Ban_Aug_diff = $Ban_Aug-$Ban_Aug_1920;
                                                $Ban_Sep_diff = $Ban_Sep-$Ban_Sep_1920;
                                                $Ban_Oct_diff = $Ban_Oct-$Ban_Oct_1920;
                                                $Ban_Nov_diff = $Ban_Nov-$Ban_Nov_1920;
                                                $Ban_Dec_diff = $Ban_Dec-$Ban_Dec_1920;
                                                $Ban_Jan_diff = $Ban_Jan-$Ban_Jan_1920;
                                                $Ban_Feb_diff = $Ban_Feb-$Ban_Feb_1920;
                                                $Ban_Mar_diff = $Ban_Mar-$Ban_Mar_1920;
                                                
                                                $bang_dif_total = $bangalore-$bangalore1920total;

                                                
                                            ?>
                                        <tbody>
                                            
                                             <tr>
                                                <th scope="row" class="thead">1</th>
                                                <td class="thead">April</td>
                                                <th>{{$Ban_Apr_1920}}</th>
                                                @if($Ban_Apr == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Apr}}</th>
                                                @endif

                                                @if($Ban_Apr == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Apr_diff > 0)
                                                        <th>{{$Ban_Apr_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Apr_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            
                                            <tr>
                                                <th scope="row" class="thead">2</th>
                                                <td class="thead">May</td>
                                                <th>{{$Ban_May_1920}}</th>
                                                @if($Ban_May == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_May}}</th>
                                                @endif

                                                 @if($Ban_May == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_May_diff > 0)
                                                        <th>{{$Ban_May_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_May_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">3</th>
                                                <td class="thead">June</td>
                                                <th>{{$Ban_Jun_1920}}</th>
                                                @if($Ban_Jun == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Jun}}</th>
                                                @endif

                                                @if($Ban_Jun == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Jun_diff > 0)
                                                        <th>{{$Ban_Jun_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Jun_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">4</th>
                                                <td class="thead">July</td>
                                                <th>{{$Ban_Jly_1920}}</th>
                                                @if($Ban_Jly == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Jly}}</th>
                                                @endif
                                                @if($Ban_Jly == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Jly_diff > 0)
                                                        <th>{{$Ban_Jly_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Jly_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">5</th>
                                                <td class="thead">Agust</td>
                                                <th>{{$Ban_Aug_1920}}</th>
                                                @if($Ban_Aug == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Aug}}</th>
                                                @endif
                                                @if($Ban_Aug == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Aug_diff > 0)
                                                        <th>{{$Ban_Aug_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Aug_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">6</th>
                                                <td class="thead">September</td>
                                                <th>{{$Ban_Sep_1920}}</th>
                                                @if($Ban_Sep == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Sep}}</th>
                                                @endif
                                                @if($Ban_Sep == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Sep_diff > 0)
                                                        <th>{{$Ban_Sep_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Sep_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">7</th>
                                                <td class="thead">October</td>
                                                <th>{{$Ban_Oct_1920}}</th>
                                                @if($Ban_Oct == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Oct}}</th>
                                                @endif
                                                @if($Ban_Oct == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Oct_diff > 0)
                                                        <th>{{$Ban_Oct_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Oct_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">8</th>
                                                <td class="thead">November</td>
                                                <th>{{$Ban_Nov_1920}}</th>
                                                 @if($Ban_Nov == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Nov}}</th>
                                                @endif
                                                @if($Ban_Nov == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Nov_diff > 0)
                                                        <th>{{$Ban_Nov_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Nov_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">9</th>
                                                <td class="thead">December</td>
                                                <th>{{$Ban_Dec_1920}}</th>
                                                @if($Ban_Dec == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Dec}}</th>
                                                @endif
                                                @if($Ban_Dec == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Jan_diff > 0)
                                                        <th>{{$Ban_Dec_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Dec_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">10</th>
                                                <td class="thead">January</td>
                                                <th>{{$Ban_Jan_1920}}</th>
                                                 @if($Ban_Jan == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Jan}}</th>
                                                @endif
                                                @if($Ban_Jan == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Jan_diff > 0)
                                                        <th>{{$Ban_Jan_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Jan_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">11</th>
                                                <td class="thead">February</td>
                                                <th>{{$Ban_Feb_1920}}</th>
                                                @if($Ban_Feb == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Feb}}</th>
                                                @endif
                                                @if($Ban_Feb == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Feb_diff > 0)
                                                        <th>{{$Ban_Feb_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Feb_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">12</th>
                                                <td class="thead">March</td>
                                                <th>{{$Ban_Mar_1920}}</th>
                                                @if($Ban_Mar == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Ban_Mar}}</th>
                                                @endif
                                                @if($Ban_Mar == 0)
                                                    <th></th>
                                                @else
                                                     @if($Ban_Mar_diff > 0)
                                                        <th>{{$Ban_Mar_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Ban_Mar_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                           
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Bangalore Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$bangalore1920total}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$bangalore_total}}</th>
                                                @if($bang_dif_total < 0)
                                                    <th  style="color: red;font-weight: bold;">{{$bang_dif_total}}</th>
                                                @else
                                                    <th  style="color: #222;font-weight: bold;">{{$bang_dif_total}}</th>
                                                @endif
                                            </tr>
                                           
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Bangalore Total</th>
                                                <th  style=";color: #3f43cb;font-weight: bold;">{{AdminController::currency($bangalore1920total)}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($bangalore_total)}}</th>
                                                @if($bang_dif_total < 0)
                                                    <th  style="color: red;font-weight: bold;">{{AdminController::currency($bang_dif_total)}}</th>
                                                @else
                                                    <th  style="color: #222;font-weight: bold;">{{AdminController::currency($bang_dif_total)}}</th>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Mumbai Billing</th>
                                            </tr>
                                            <tr>
                                                <th class="thead">Sl.No</th>
                                                <th class="thead">Month</th>
                                                <th>2019 - 2020</th>
                                                <th>2020 - 2021</th>
                                                <th>Diff</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $Mum_Apr =  !is_null($mumbai['April']) ? $mumbai['April'] : 0  ;
                                                $Mum_May =  !is_null($mumbai['May']) ? $mumbai['May'] : 0  ;
                                                $Mum_Jun =  !is_null($mumbai['June']) ? $mumbai['June'] : 0 ;
                                                $Mum_Jly =  !is_null($mumbai['July']) ? $mumbai['July'] : 0 ;
                                                $Mum_Aug =  !is_null($mumbai['Agust']) ? $mumbai['Agust'] : 0 ;
                                                $Mum_Sep =  !is_null($mumbai['September']) ? $mumbai['September'] : 0 ;
                                                $Mum_Oct =  !is_null($mumbai['October']) ? $mumbai['October'] : 0 ;
                                                $Mum_Nov =  !is_null($mumbai['November']) ? $mumbai['November'] : 0 ;
                                                $Mum_Dec =  !is_null($mumbai['December']) ? $mumbai['December'] : 0 ;
                                                $Mum_Jan =  !is_null($mumbai['January']) ? $mumbai['January'] : 0 ;
                                                $Mum_Feb =  !is_null($mumbai['February']) ? $mumbai['February'] : 0 ;
                                                $Mum_Mar =  !is_null($mumbai['March']) ? $mumbai['March'] : 0 ;

                                                $mumbai = ($Mum_Apr + $Mum_May + $Mum_Jun + $Mum_Jly + $Mum_Aug + $Mum_Sep + $Mum_Oct + $Mum_Nov + $Mum_Dec + $Mum_Jan + $Mum_Feb + $Mum_Mar);
                                                
                                                $mumbai_total = $mumbai;
                                                
                                                $mumbai_Apr_1920 = !is_null($mumbai_1920['April']) ? $mumbai_1920['April'] : 0 ;
                                                $mumbai_May_1920 = !is_null($mumbai_1920['May']) ? $mumbai_1920['May'] : 0 ;
                                                $mumbai_Jun_1920 = !is_null($mumbai_1920['June']) ? $mumbai_1920['June'] : 0 ;
                                                $mumbai_Jly_1920 = !is_null($mumbai_1920['July']) ? $mumbai_1920['July'] : 0 ;
                                                $mumbai_Aug_1920 = !is_null($mumbai_1920['Agust']) ? $mumbai_1920['Agust'] : 0 ;
                                                $mumbai_Sep_1920 = !is_null($mumbai_1920['September']) ? $mumbai_1920['September'] : 0  ;
                                                $mumbai_Oct_1920 = !is_null($mumbai_1920['October']) ? $mumbai_1920['October'] : 0  ;
                                                $mumbai_Nov_1920 = !is_null($mumbai_1920['November']) ? $mumbai_1920['November'] : 0  ;
                                                $mumbai_Dec_1920 = !is_null($mumbai_1920['December']) ? $mumbai_1920['December'] : 0  ;
                                                $mumbai_Jan_1920 = !is_null($mumbai_1920['January']) ? $mumbai_1920['January'] : 0  ;
                                                $mumbai_Feb_1920 = !is_null($mumbai_1920['February']) ? $mumbai_1920['February'] : 0  ;
                                                $mumbai_Mar_1920 = !is_null($mumbai_1920['March']) ? $mumbai_1920['March'] : 0  ;
                                                
                                                $mumbai1920total = $mumbai_Apr_1920 + $mumbai_May_1920 + $mumbai_Jun_1920 + $mumbai_Jly_1920 + $mumbai_Aug_1920 + $mumbai_Sep_1920 + $mumbai_Oct_1920 + $mumbai_Nov_1920 + $mumbai_Dec_1920 + $mumbai_Jan_1920 + $mumbai_Feb_1920 + $mumbai_Mar_1920;
                                                $mumbai_total_1920 = $mumbai1920total;
                                                
                                                $Mum_Apr_diff = $Mum_Apr-$mumbai_Apr_1920;
                                                $Mum_May_diff = $Mum_May-$mumbai_May_1920;
                                                $Mum_Jun_diff = $Mum_Jun-$mumbai_Jun_1920;
                                                $Mum_Jly_diff = $Mum_Jly-$mumbai_Jly_1920;
                                                $Mum_Aug_diff = $Mum_Aug-$mumbai_Aug_1920;
                                                $Mum_Sep_diff = $Mum_Sep-$mumbai_Sep_1920;
                                                $Mum_Oct_diff = $Mum_Oct-$mumbai_Oct_1920;
                                                $Mum_Nov_diff = $Mum_Nov-$mumbai_Nov_1920;
                                                $Mum_Dec_diff = $Mum_Dec-$mumbai_Dec_1920;
                                                $Mum_Jan_diff = $Mum_Jan-$mumbai_Jan_1920;
                                                $Mum_Feb_diff = $Mum_Feb-$mumbai_Feb_1920;
                                                $Mum_Mar_diff = $Mum_Mar-$mumbai_Mar_1920;
                                                
                                                $Mum_Apr_gt = $mumbai - $mumbai1920total;
                                            ?>
                                            
                                             <tr>
                                                <th scope="row" class="thead">1</th>
                                                <td class="thead">April</td>
                                                <th>{{$mumbai_Apr_1920}}</th>
                                               @if($Mum_Apr == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Apr}}</th>
                                                @endif

                                                @if($Mum_Apr == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Apr_diff > 0)
                                                        <th>{{$Mum_Apr_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Apr_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            
                                            <tr>
                                                <th scope="row" class="thead">2</th>
                                                <td class="thead">May</td>
                                                <th>{{$mumbai_May_1920}}</th>
                                                 @if($Mum_May == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_May}}</th>
                                                @endif

                                                @if($Mum_May == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_May_diff > 0)
                                                        <th>{{$Mum_May_dif}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_May_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">3</th>
                                                <td class="thead">June</td>
                                                <th>{{$mumbai_Jun_1920}}</th>
                                                @if($Mum_Jun == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Jun}}</th>
                                                @endif
                                                @if($Mum_Jun == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_May_diff > 0)
                                                        <th>{{$Mum_Jun_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Jun_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">4</th>
                                                <td class="thead">July</td>
                                                <th>{{$mumbai_Jly_1920}}</th>
                                                @if($Mum_Jly == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Jly}}</th>
                                                @endif
                                                @if($Mum_Jly == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Jly_diff > 0)
                                                        <th>{{$Mum_Jly_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Jly_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">5</th>
                                                <td class="thead">Agust</td>
                                                <th>{{$mumbai_Aug_1920}}</th>
                                                @if($Mum_Aug == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Aug}}</th>
                                                @endif
                                                @if($Mum_Aug == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Aug_diff > 0)
                                                        <th>{{$Mum_Aug_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Aug_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">6</th>
                                                <td class="thead">September</td>
                                                <th>{{$mumbai_Sep_1920}}</th>
                                                 @if($Mum_Sep == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Sep}}</th>
                                                @endif
                                                @if($Mum_Sep == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Sep_diff > 0)
                                                        <th>{{$Mum_Sep_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Sep_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">7</th>
                                                <td class="thead">October</td>
                                                <th>{{$mumbai_Oct_1920}}</th>
                                                @if($Mum_Oct == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Oct}}</th>
                                                @endif
                                                @if($Mum_Oct == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Oct_diff > 0)
                                                        <th>{{$Mum_Oct_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Oct_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">8</th>
                                                <td class="thead">November</td>
                                                <th>{{$mumbai_Nov_1920}}</th>
                                                 @if($Mum_Nov == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Nov}}</th>
                                                @endif
                                                @if($Mum_Nov == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Nov_diff > 0)
                                                        <th>{{$Mum_Nov_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Nov_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">9</th>
                                                <td class="thead">December</td>
                                                <th>{{$mumbai_Dec_1920}}</th>
                                                 @if($Mum_Dec == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Dec}}</th>
                                                @endif
                                                @if($Mum_Dec == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Dec_diff > 0)
                                                        <th>{{$Mum_Dec_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Dec_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">10</th>
                                                <td class="thead">January</td>
                                                <th>{{$mumbai_Jan_1920}}</th>
                                                @if($Mum_Jan == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Jan}}</th>
                                                @endif
                                                @if($Mum_Jan_diff > 0)
                                                    <th><span style="color:red;">{{$Mum_Jan_diff}}</span></th>
                                                @else
                                                    @if($Mum_Jan == 0)
                                                    <th></th>
                                                    @else
                                                        <th>{{$Mum_Jan_diff}}</th>
                                                    @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">11</th>
                                                <td class="thead">February</td>
                                                <th>{{$mumbai_Feb_1920}}</th>
                                                 @if($Mum_Feb == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Feb}}</th>
                                                @endif
                                                @if($Mum_Feb == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Feb_diff > 0)
                                                        <th>{{$Mum_Dec_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Feb_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">12</th>
                                                <td class="thead">March</td>
                                                <th>{{$mumbai_Mar_1920}}</th>
                                                @if($Mum_Mar == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Mum_Mar}}</th>
                                                @endif
                                                @if($Mum_Mar == 0)
                                                    <th></th>
                                                @else
                                                     @if($Mum_Mar_diff > 0)
                                                        <th>{{$Mum_Mar_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$Mum_Mar_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Mumbai Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$mumbai_total_1920}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$mumbai_total}}</th>
                                                @if($Mum_Apr_gt < 0)
                                                <th  style="color: red;font-weight: bold;"> {{$mumbai-$mumbai1920total}}</th>
                                                @else
                                                <th  style="color: #222;font-weight: bold;">{{$mumbai-$mumbai1920total}}</th>
                                                @endif
                                            </tr>
                                            
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Mumbai Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($mumbai_total_1920)}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($mumbai_total)}}</th>
                                                @if($Mum_Apr_gt < 0)
                                                <th  style="color: red;font-weight: bold;"> -{{AdminController::currency($mumbai-$mumbai1920total)}}</th>
                                                @else
                                                <th  style="color: #222;font-weight: bold;">{{AdminController::currency($mumbai-$mumbai1920total)}}</th>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">Delhi Billing</th>
                                            </tr>
                                            <tr>
                                                <th class="thead">Sl.No</th>
                                                <th class="thead">Month</th>
                                                <th>2019 - 2020</th>
                                                <th>2020 - 2021</th>
                                                <th>Diff</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $Del_Apr =  !is_null($delhi['April']) ? $delhi['April'] : 0 ;
                                                $Del_May =  !is_null($delhi['May']) ? $delhi['May'] : 0 ;
                                                $Del_Jun =  !is_null($delhi['June']) ? $delhi['June'] : 0 ;
                                                $Del_Jly =  !is_null($delhi['July']) ? $delhi['July'] : 0 ;
                                                $Del_Aug =  !is_null($delhi['Agust']) ? $delhi['Agust'] : 0 ;
                                                $Del_Sep =  !is_null($delhi['September']) ? $delhi['September'] : 0 ;
                                                $Del_Oct =  !is_null($delhi['October']) ? $delhi['October'] : 0 ;
                                                $Del_Nov =  !is_null($delhi['November']) ? $delhi['November'] : 0 ;
                                                $Del_Dec =  !is_null($delhi['December']) ? $delhi['December'] : 0 ;
                                                $Del_Jan =  !is_null($delhi['January']) ? $delhi['January'] : 0 ;
                                                $Del_Feb =  !is_null($delhi['February']) ? $delhi['February'] : 0 ;
                                                $Del_Mar =  !is_null($delhi['March']) ? $delhi['March'] : 0 ;

                                                $delhi = ($Del_Apr + $Del_May + $Del_Jun + $Del_Jly + $Del_Aug + $Del_Sep + $Del_Oct + $Del_Nov + $Del_Dec + $Del_Jan + $Del_Feb + $Del_Mar);
                                                
                                                $delhi_total = $delhi;
                                                
                                                $delhi_Apr_1920 = !is_null($delhi_1920['April']) ? $delhi_1920['April'] : 0 ;
                                                $delhi_May_1920 = !is_null($delhi_1920['May']) ? $delhi_1920['May'] : 0 ;
                                                $delhi_Jun_1920 = !is_null($delhi_1920['June']) ? $delhi_1920['June'] : 0 ;
                                                $delhi_Jly_1920 = !is_null($delhi_1920['July']) ? $delhi_1920['July'] : 0 ;
                                                $delhi_Aug_1920 = !is_null($delhi_1920['Agust']) ? $delhi_1920['Agust'] : 0 ;
                                                $delhi_Sep_1920 = !is_null($delhi_1920['September']) ? $delhi_1920['September'] : 0  ;
                                                $delhi_Oct_1920 = !is_null($delhi_1920['October']) ? $delhi_1920['October'] : 0  ;
                                                $delhi_Nov_1920 = !is_null($delhi_1920['November']) ? $delhi_1920['November'] : 0  ;
                                                $delhi_Dec_1920 = !is_null($delhi_1920['December']) ? $delhi_1920['December'] : 0  ;
                                                $delhi_Jan_1920 = !is_null($delhi_1920['January']) ? $delhi_1920['January'] : 0  ;
                                                $delhi_Feb_1920 = !is_null($delhi_1920['February']) ? $delhi_1920['February'] : 0  ;
                                                $delhi_Mar_1920 = !is_null($delhi_1920['March']) ? $delhi_1920['March'] : 0  ;
                                                
                                                $delhi1920total = $delhi_Apr_1920+$delhi_May_1920+$delhi_Jun_1920+$delhi_Jly_1920+$delhi_Aug_1920+$delhi_Sep_1920+$delhi_Oct_1920+$delhi_Nov_1920+$delhi_Dec_1920+$delhi_Jan_1920+$delhi_Feb_1920+$delhi_Mar_1920;
                                                
                                                $delhi_Apr_diff = $Del_Apr-$delhi_Apr_1920;
                                                $delhi_May_diff = $Del_May-$delhi_May_1920;
                                                $delhi_Jun_diff = $Del_Jun-$delhi_Jun_1920;
                                                $delhi_Jly_diff = $Del_Jly-$delhi_Jly_1920;
                                                $delhi_Aug_diff = $Del_Aug-$delhi_Aug_1920;
                                                $delhi_Sep_diff = $Del_Sep-$delhi_Sep_1920;
                                                $delhi_Oct_diff = $Del_Oct-$delhi_Oct_1920;
                                                $delhi_Nov_diff = $Del_Nov-$delhi_Nov_1920;
                                                $delhi_Dec_diff = $Del_Dec-$delhi_Dec_1920;
                                                $delhi_Jan_diff = $Del_Jan-$delhi_Jan_1920;
                                                $delhi_Feb_diff = $Del_Feb-$delhi_Feb_1920;
                                                $delhi_Mar_diff = $Del_Mar-$delhi_Mar_1920;
                                                
                                                $delhi_dif_total = $delhi-$delhi1920total;
                                                
                                                
                                            ?>
                                            
                                             <tr>
                                                <th scope="row" class="thead">1</th>
                                                <td class="thead">April</td>
                                                <th>{{$delhi_Apr_1920}}</th>
                                                <th>{{$Del_Apr}}</th>
                                                @if($Del_Apr < 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Apr_diff < 0)
                                                        <th>{{$delhi_Apr_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Apr_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">2</th>
                                                <td class="thead">May</td>
                                                <th>{{$delhi_May_1920}}</th>
                                                @if($Del_May == 0)
                                                        <th>{{$delhi_Apr_diff}}</th>
                                                     @else
                                                        <th>{{$Del_May}}</th>
                                                @endif
                                                @if($Del_May < 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_May_diff > 0)
                                                        <th>{{$delhi_May_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_May_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">3</th>
                                                <td class="thead">June</td>
                                                <th>{{$delhi_Jun_1920}}</th>
                                                @if($Del_Jun == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Jun}}</th>
                                                @endif
                                                @if($Del_Jun <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Jun_diff > 0)
                                                        <th>{{$delhi_Jun_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Jun_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">4</th>
                                                <td class="thead">July</td>
                                                <th>{{$delhi_Jly_1920}}</th>
                                                @if($Del_Jly == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Jly}}</th>
                                                @endif
                                                @if($Del_Jly <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Jly_diff > 0)
                                                        <th>{{$delhi_Jly_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Jly_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">5</th>
                                                <td class="thead">Agust</td>
                                                <th>{{$delhi_Aug_1920}}</th>
                                                @if($Del_Aug == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Aug}}</th>
                                                @endif
                                                @if($Del_Aug <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Aug_diff > 0)
                                                        <th>{{$delhi_Aug_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Aug_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">6</th>
                                                <td class="thead">September</td>
                                                <th>{{$delhi_Sep_1920}}</th>
                                                @if($Del_Sep == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Sep}}</th>
                                                @endif
                                                @if($Del_Sep <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Sep_diff > 0)
                                                        <th>{{$delhi_Sep_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Sep_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">7</th>
                                                <td class="thead">October</td>
                                                <th>{{$delhi_Oct_1920}}</th>
                                                @if($Del_Oct == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Oct}}</th>
                                                @endif
                                                @if($Del_Oct <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Oct_diff > 0)
                                                        <th>{{$delhi_Oct_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Oct_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">8</th>
                                                <td class="thead">November</td>
                                                <th>{{$delhi_Nov_1920}}</th>
                                                 @if($Del_Nov == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Nov}}</th>
                                                @endif
                                                @if($Del_Nov <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Nov_diff > 0)
                                                        <th>{{$delhi_Nov_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Nov_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">9</th>
                                                <td class="thead">December</td>
                                                <th>{{$delhi_Dec_1920}}</th>
                                                @if($Del_Dec == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Dec}}</th>
                                                @endif
                                                @if($Del_Dec <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Dec_diff > 0)
                                                        <th>{{$delhi_Dec_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Dec_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">10</th>
                                                <td class="thead">January</td>
                                                <th>{{$delhi_Jan_1920}}</th>
                                                @if($Del_Jan == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Jan}}</th>
                                                @endif
                                                @if($Del_Jan <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Jan_diff > 0)
                                                        <th>{{$delhi_Jan_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Jan_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">11</th>
                                                <td class="thead">February</td>
                                                <th>{{$delhi_Feb_1920}}</th>
                                                 @if($Del_Feb == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Feb}}</th>
                                                @endif
                                                @if($Del_Feb <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Feb_diff >= 0)
                                                        <th>{{$delhi_Feb_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Feb_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">12</th>
                                                <td class="thead">March</td>
                                                <th>{{$delhi_Mar_1920}}</th>
                                                 @if($Del_Mar == 0)
                                                        <th></th>
                                                     @else
                                                        <th>{{$Del_Mar}}</th>
                                                @endif
                                                @if($Del_Mar <= 0)
                                                    <th></th>
                                                @else
                                                     @if($delhi_Mar_diff > 0)
                                                        <th>{{$delhi_Mar_diff}}</th>
                                                     @else
                                                        <th><span style="color:red;">{{$delhi_Mar_diff}}</span></th>
                                                     @endif
                                                @endif
                                            </tr>
                                           
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Delhi Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$delhi1920total}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$delhi_total}}</th>
                                                @if($delhi_dif_total < 0)
                                                <th  style="color: red;font-weight: bold;"> {{$delhi_dif_total}}</th>
                                                @else
                                                <th  style="color: #222;font-weight: bold;">{{$delhi_dif_total}}</th>
                                                @endif
                                            </tr>
                                           
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Delhi Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($delhi1920total)}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($delhi_total)}}</th>
                                                @if($delhi_dif_total < 0)
                                                <th  style="color: red;font-weight: bold;"> -{{AdminController::currency($delhi_dif_total)}}</th>
                                                @else
                                                <th  style="color: #222;font-weight: bold;">{{AdminController::currency($delhi_dif_total)}}</th>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6">
                                    <table class="table table-bordered table-responsive-md table-responsive-sm table-responsive-lg">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center;color:#e47297;">2020 - 2021 Total Monthly Billing</th>
                                            </tr>
                                            <tr>
                                                <th class="thead">Sl.No</th>
                                                <th class="thead">Month</th>
                                                <th>2019 - 2020</th>
                                                <th>2020 - 2021</th>
                                                <th>Diff</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $April2021 =  $Ban_Apr + $Mum_Apr + $Del_Apr;
                                                $May2021 =  $Ban_May + $Mum_May + $Del_May;
                                                $Jun2021 =  $Ban_Jun + $Mum_Jun + $Del_Jun;
                                                $Jly2021 =  $Ban_Jly + $Mum_Jly + $Del_Jly;
                                                $Aug2021 =  $Ban_Aug + $Mum_Aug + $Del_Aug;
                                                $Sep2021 =  $Ban_Sep + $Mum_Sep + $Del_Sep;
                                                $Oct2021 =  $Ban_Oct + $Mum_Oct + $Del_Oct;
                                                $Nov2021 =  $Ban_Nov + $Mum_Nov + $Del_Nov;
                                                $Dec2021 =  $Ban_Dec + $Mum_Dec + $Del_Dec;
                                                $Jan2021 =  $Ban_Jan + $Mum_Jan + $Del_Jan;
                                                $Feb2021 =  $Ban_Feb + $Mum_Feb + $Del_Feb;
                                                $Mar2021 =  $Ban_Mar + $Mum_Mar + $Del_Mar;

                                                $grand_total_2021 = $April2021+$May2021+$Jun2021+$Jly2021+$Aug2021+$Sep2021+$Oct2021+$Nov2021+$Dec2021+$Jan2021+$Feb2021+$Mar2021;

                                                $April1920 = $Ban_Apr_1920+$mumbai_Apr_1920+$delhi_Apr_1920;
                                                $May1920 = $Ban_May_1920+$mumbai_May_1920+$delhi_May_1920;
                                                $Jun1920 = $Ban_Jun_1920+$mumbai_Jun_1920+$delhi_Jun_1920;
                                                $Jly1920 = $Ban_Jly_1920+$mumbai_Jly_1920+$delhi_Jly_1920;
                                                $Aug1920 = $Ban_Aug_1920+$mumbai_Aug_1920+$delhi_Aug_1920;
                                                $Sep1920 = $Ban_Sep_1920+$mumbai_Sep_1920+$delhi_Sep_1920;
                                                $Oct1920 = $Ban_Oct_1920+$mumbai_Oct_1920+$delhi_Oct_1920;
                                                $Nov1920 = $Ban_Nov_1920+$mumbai_Nov_1920+$delhi_Nov_1920;
                                                $Dec1920 = $Ban_Dec_1920+$mumbai_Dec_1920+$delhi_Dec_1920;
                                                $Jan1920 = $Ban_Jan_1920+$mumbai_Jan_1920+$delhi_Jan_1920;
                                                $Feb1920 = $Ban_Feb_1920+$mumbai_Feb_1920+$delhi_Feb_1920;
                                                $Mar1920 = $Ban_Mar_1920+$mumbai_Mar_1920+$delhi_Mar_1920;

                                                $grand_total_1920 = $April1920+$May1920+$Jun1920+$Jly1920+$Aug1920+$Sep1920+ $Oct1920+$Nov1920+$Dec1920+$Jan1920+$Feb1920+$Mar1920;
                                                
                                                $April_diff_21_20 =$April2021 - $April1920;
                                                $May_diff_21_20 = $May2021 - $May1920;
                                                $Jun_diff_21_20 = $Jun2021 - $Jun1920;
                                                $Jly_diff_21_20 = $Jly2021 - $Jly1920;
                                                $Aug_diff_21_20 = $Aug2021 - $Aug1920;
                                                $Sep_diff_21_20 = $Sep2021 - $Sep1920;
                                                $Oct_diff_21_20 = $Oct2021 - $Oct1920;
                                                $Nov_diff_21_20 = $Nov2021 - $Nov1920;
                                                $Dec_diff_21_20 = $Dec2021 - $Dec1920;
                                                $Jan_diff_21_20 = $Jan2021 - $Jan1920;
                                                $Feb_diff_21_20 = $Feb2021 - $Feb1920;
                                                $Mar_diff_21_20 = $Mar2021 - $Mar1920;

                                                $grand_total_diff_2021_1920 = $April_diff_21_20+$May_diff_21_20+$Jun_diff_21_20+$Jly_diff_21_20+$Aug_diff_21_20+$Sep_diff_21_20+$Oct_diff_21_20+$Nov_diff_21_20+$Dec_diff_21_20+$Jan_diff_21_20+$Feb_diff_21_20+$Mar_diff_21_20;

                                                $grand_total_diff = $grand_total_2021 - $grand_total_1920;
                                            ?>
                                             <tr>
                                                <th scope="row" class="thead">1</th>
                                                <td class="thead">April</td>
                                                <td>{{$April1920}}</td>
                                                @if($April2021 > 0)
                                                    <th>{{$April2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif
                                                
                                                @if($April2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($April_diff_21_20 > 0)
                                                       <td>{{$April_diff_21_20}}</td>>
                                                    @else
                                                        <td style="color: red;">{{$April_diff_21_20}}</td>
                                                    @endif
                                                @endif
                                            </tr>
                                            
                                            <tr>
                                                <th scope="row" class="thead">2</th>
                                                <td class="thead">May</td>
                                                <td>{{ $May1920 }}</td>
                                                @if($May2021 > 0)
                                                    <th>{{$May2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                               
                                                @if($May2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($May_diff_21_20 > 0)
                                                        <td>{{$May_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$May_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">3</th>
                                                <td class="thead">June</td>
                                                <td>{{$Jun1920}}</td>
                                                @if($Jun2021 < 0)
                                                    <th>{{$Jun2021}}</th>
                                                @else
                                                    <th></th>
                                                @endif

                                                @if($Jun2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Jun_diff_21_20 > 0)
                                                        <td>{{$Jun_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Jun_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">3</th>
                                                <td class="thead">July</td>
                                                <td>{{$Jly1920}}</td>
                                                @if($Jly2021 < 0)
                                                    <th>{{$Jly2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Jly2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Jly_diff_21_20 > 0)
                                                        <td>{{$Jly_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Jly_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">5</th>
                                                <td class="thead">Agust</td>
                                                <td>{{$Aug1920}}</td>
                                                @if($Aug2021 > 0)
                                                    <th>{{$Aug2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Aug2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Aug_diff_21_20 > 0)
                                                        <td>{{$Aug_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Aug_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">6</th>
                                                <td class="thead">September</td>
                                                <td>{{$Sep1920}}</td>
                                                @if($Sep2021 > 0)
                                                    <th>{{$Sep2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Sep2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Sep_diff_21_20 > 0)
                                                        <td>{{$Sep_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Sep_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">7</th>
                                                <td class="thead">October</td>
                                                <td>{{ $Oct1920 }}</td>
                                                @if($Oct2021 > 0)
                                                    <th>{{$Oct2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Oct2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Oct_diff_21_20 > 0)
                                                        <td>{{$Oct_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Oct_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">8</th>
                                                <td class="thead">November</td>
                                                <td>{{ $Nov1920 }}</td>
                                                @if($Nov2021 > 0)
                                                   <th>{{$Nov2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Nov2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Nov_diff_21_20 > 0)
                                                        <td>{{$Nov_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Nov_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">9</th>
                                                <td class="thead">December</td>
                                                <td>{{$Dec1920}}</td>
                                                @if($Dec2021 > 0)
                                                    <th>{{$Dec2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Dec2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Dec_diff_21_20 > 0)
                                                        <td>{{$Dec_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Dec_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">10</th>
                                                <td class="thead">January</td>
                                                <td>{{$Jan1920}}</td>
                                                @if($Jan2021 > 0)
                                                    <th>{{$Jan2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Jan2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Jan_diff_21_20 > 0)
                                                        <td>{{$Jan_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Jan_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">11</th>
                                                <td class="thead">February</td>
                                                <td>{{$Feb1920}}</td>
                                                @if($Feb2021 > 0)
                                                    <th>{{$Feb2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Feb2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Feb_diff_21_20 > 0)
                                                        <td>{{$Feb_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Feb_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            <tr>
                                                <th scope="row" class="thead">12</th>
                                                <td class="thead">March</td>
                                                <td>{{$Mar1920}}</td>
                                                @if($Mar2021 > 0)
                                                    <th>{{$Mar2021}}</th>
                                                @else
                                                    <td></td>
                                                @endif

                                                @if($Mar2021 == 0)
                                                    <th></th>
                                                @else
                                                    @if($Mar_diff_21_20 > 0)
                                                        <td>{{$Mar_diff_21_20}}</td>>
                                                    @else
                                                       <td style="color: red;">{{$Mar_diff_21_20}}</td>
                                                   @endif
                                                @endif
                                            </tr>
                                            @php
                                                $total = ($Ban_Apr + $Mum_Apr + $Del_Apr + $Ban_May + $Mum_May + $Del_May + $Ban_Jun + $Mum_Jun + $Del_Jun + $Ban_Jly + $Mum_Jly + $Del_Jly + $Ban_Aug + $Mum_Aug + $Del_Aug + $Ban_Sep + $Mum_Sep + $Del_Sep + $Ban_Oct + $Mum_Oct + $Del_Oct  + $Ban_Nov + $Mum_Nov + $Del_Nov  + $Ban_Dec + $Mum_Dec + $Del_Dec + $Ban_Jan + $Mum_Jan + $Del_Jan + $Ban_Feb + $Mum_Feb + $Del_Feb + $Ban_Mar + $Mum_Mar + $Del_Mar);

                                                $grand_total = $total;
                                            @endphp
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Grand Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$grand_total_1920 }}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{$grand_total_2021}}</th>
                                                
                                                @if($grand_total_diff > 0)
                                                    <th  style="color: #222;font-weight: bold;">{{$grand_total_diff}} </th>
                                                @else
                                                    <th  style="color: red ;font-weight: bold;">{{$grand_total_diff}} </th>
                                                @endif
                                            </tr>
                                            <tr>
                                                <th colspan="2" style="color:#222;font-weight: bold;text-align: center;">Grand Total</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($grand_total_1920)}}</th>
                                                <th  style="color: #3f43cb;font-weight: bold;">{{AdminController::currency($grand_total_2021)}}</th>
                                                 @if($grand_total_diff > 0)
                                                    <th  style="color: #222;font-weight: bold;">{{AdminController::currency($grand_total_diff)}} </th>
                                                @else
                                                    <th  style="color: red ;font-weight: bold;">{{AdminController::currency($grand_total_diff)}} </th>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong><i class="zmdi zmdi-chart"></i> Events - Billing</strong> Report <strong></strong></h2>
                        </div> 
                        <div class="body">
                            <h6>Bangalore</h6>
                            <div id="chart-bar1" class="c3_chart"></div>
                            <h6>Mumbai</h6>
                            <div id="chart-bar2" class="c3_chart"></div>
                            <h6>Delhi</h6>
                            <div id="chart-bar3" class="c3_chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('admin.layouts.js')
<script src="{{ asset('admin/js/pages/charts/c3.js')}}"></script>
<script src="{{ asset('admin/bundles/c3.bundle.js')}}"></script>

<script type="text/javascript">
    $(document).ready(function(){
            var chart = c3.generate({
                bindto: '#chart-bar1', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        //['2015-2016', {{$bangalore_1516['April']}},{{$bangalore_1516['May']}}, {{$bangalore_1516['June']}}, {{$bangalore_1516['July']}},{{$bangalore_1516['Agust']}}, {{$bangalore_1516['September']}}, {{$bangalore_1516['October']}}, {{$bangalore_1516['November']}}, {{$bangalore_1516['December']}}, {{$bangalore_1516['January']}}, {{$bangalore_1516['February']}}, {{$bangalore_1516['March']}}],
                        ['2016-2017', {{$bangalore_1617['April']}},{{$bangalore_1617['May']}}, {{$bangalore_1617['June']}}, {{$bangalore_1617['July']}},{{$bangalore_1617['Agust']}}, {{$bangalore_1617['September']}}, {{$bangalore_1617['October']}}, {{$bangalore_1617['November']}}, {{$bangalore_1617['December']}}, {{$bangalore_1617['January']}}, {{$bangalore_1617['February']}}, {{$bangalore_1617['March']}}],
                        ['2017-2018', {{$bangalore_1718['April']}},{{$bangalore_1718['May']}}, {{$bangalore_1718['June']}}, {{$bangalore_1718['July']}},{{$bangalore_1718['Agust']}}, {{$bangalore_1718['September']}}, {{$bangalore_1718['October']}}, {{$bangalore_1718['November']}}, {{$bangalore_1718['December']}}, {{$bangalore_1718['January']}}, {{$bangalore_1718['February']}}, {{$bangalore_1718['March']}}],
                        ['2018-2019', {{$bangalore_1819['April']}},{{$bangalore_1819['May']}}, {{$bangalore_1819['June']}}, {{$bangalore_1819['July']}},{{$bangalore_1819['Agust']}}, {{$bangalore_1819['September']}}, {{$bangalore_1819['October']}}, {{$bangalore_1819['November']}}, {{$bangalore_1819['December']}}, {{$bangalore_1819['January']}}, {{$bangalore_1819['February']}}, {{$bangalore_1819['March']}}],
                        ['2019-2020', {{$bangalore_1920['April']}},{{$bangalore_1920['May']}}, {{$bangalore_1920['June']}}, {{$bangalore_1920['July']}},{{$bangalore_1920['Agust']}}, {{$bangalore_1920['September']}}, {{$bangalore_1920['October']}}, {{$bangalore_1920['November']}}, {{$bangalore_1920['December']}}, {{$bangalore_1920['January']}}, {{$bangalore_1920['February']}}, {{$bangalore_1920['March']}}], 
                        ['2020-2021', {{$bangalore_2021['April']}},{{$bangalore_2021['May']}}, {{$bangalore_2021['June']}}, {{$bangalore_2021['July']}},{{$bangalore_2021['Agust']}}, {{$bangalore_2021['September']}}, {{$bangalore_2021['October']}}, {{$bangalore_2021['November']}}, {{$bangalore_2021['December']}}, {{$bangalore_2021['January']}}, {{$bangalore_2021['February']}}, {{$bangalore_2021['March']}}], 
                    ],
                    type: 'bar', // default type of chart
                    colors: {
                        'data1': Aero.colors["blue"],
                        'data2': Aero.colors["cyan"],
                        'data3': Aero.colors["red"],
                        'data4': Aero.colors["green"],      
                        'data5': Aero.colors["purple"], 
                    },
                    names: {
                        // name of each serie
                        'data1': '2016-2017',
                        'data2': '2017-2018',
                        'data3': '2018-2019',
                        'data4': '2019-2020',                        
                        'data5': '2020-2021',                        
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        // name of each category
                        categories: ['Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar']
                    },
                },
                bar: {
                    width: 15
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });

            var chart = c3.generate({
                bindto: '#chart-bar2', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        //['2015-2016', {{$mumbai_1516['April']}},{{$mumbai_1516['May']}},{{$mumbai_1516['June']}},{{$mumbai_1516['July']}},{{$mumbai_1516['Agust']}},{{$mumbai_1516['September']}},{{$mumbai_1516['October']}},{{$mumbai_1516['November']}},{{$mumbai_1516['December']}},{{$mumbai_1516['January']}},{{$mumbai_1516['February']}},{{$mumbai_1516['March']}}],
                        ['2016-2017', {{$mumbai_1617['April']}},{{$mumbai_1617['May']}},{{$mumbai_1617['June']}},{{$mumbai_1617['July']}},{{$mumbai_1617['Agust']}},{{$mumbai_1617['September']}},{{$mumbai_1617['October']}},{{$mumbai_1617['November']}},{{$mumbai_1617['December']}},{{$mumbai_1617['January']}},{{$mumbai_1617['February']}},{{$mumbai_1617['March']}}],
                        ['2017-2018', {{$mumbai_1718['April']}},{{$mumbai_1718['May']}},{{$mumbai_1718['June']}},{{$mumbai_1718['July']}},{{$mumbai_1718['Agust']}},{{$mumbai_1718['September']}},{{$mumbai_1718['October']}},{{$mumbai_1718['November']}},{{$mumbai_1718['December']}},{{$mumbai_1718['January']}},{{$mumbai_1718['February']}},{{$mumbai_1718['March']}}],
                        ['2018-2019', {{$mumbai_1819['April']}},{{$mumbai_1819['May']}},{{$mumbai_1819['June']}},{{$mumbai_1819['July']}},{{$mumbai_1819['Agust']}},{{$mumbai_1819['September']}},{{$mumbai_1819['October']}},{{$mumbai_1819['November']}},{{$mumbai_1819['December']}},{{$mumbai_1819['January']}},{{$mumbai_1819['February']}},{{$mumbai_1819['March']}}],
                        ['2019-2020', {{$mumbai_1920['April']}},{{$mumbai_1920['May']}},{{$mumbai_1920['June']}},{{$mumbai_1920['July']}},{{$mumbai_1920['Agust']}},{{$mumbai_1920['September']}},{{$mumbai_1920['October']}},{{$mumbai_1920['November']}},{{$mumbai_1920['December']}},{{$mumbai_1920['January']}},{{$mumbai_1920['February']}},{{$mumbai_1920['March']}}], 
                        ['2020-2021', {{$mumbai_2021['April']}},{{$mumbai_2021['May']}},{{$mumbai_2021['June']}},{{$mumbai_2021['July']}},{{$mumbai_2021['Agust']}},{{$mumbai_2021['September']}},{{$mumbai_2021['October']}},{{$mumbai_2021['November']}},{{$mumbai_2021['December']}},{{$mumbai_2021['January']}},{{$mumbai_2021['February']}},{{$mumbai_2021['March']}}], 
                    ],
                    type: 'bar', // default type of chart
                    colors: {
                        'data1': Aero.colors["blue"],
                        'data2': Aero.colors["cyan"],
                        'data3': Aero.colors["red"],
                        'data4': Aero.colors["green"],      
                        'data5': Aero.colors["purple"], 
                    },
                    names: {
                        // name of each serie
                        'data1': '2016-2017',
                        'data2': '2017-2018',
                        'data3': '2018-2019',
                        'data4': '2019-2020',                        
                        'data5': '2020-2021',                         
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        // name of each category
                        categories: ['Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar']
                    },
                },
                bar: {
                    width: 15
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });

            var chart = c3.generate({
                bindto: '#chart-bar3', // id of chart wrapper
                data: {
                    columns: [
                        // each columns data
                        //['2015-2016', {{$delhi_1516['April']}},{{$delhi_1516['May']}}, {{$delhi_1516['June']}}, {{$delhi_1516['July']}},{{$delhi_1516['Agust']}}, {{$delhi_1516['September']}},{{$delhi_1516['October']}}, {{$delhi_1516['November']}}, {{$delhi_1516['December']}}, {{$delhi_1516['January']}}, {{$delhi_1516['February']}}, {{$delhi_1516['March']}}],
                        ['2016-2017', {{$delhi_1617['April']}},{{$delhi_1617['May']}}, {{$delhi_1617['June']}}, {{$delhi_1617['July']}},{{$delhi_1617['Agust']}}, {{$delhi_1617['September']}}, 
                        {{$delhi_1617['October']}}, {{$delhi_1617['November']}}, {{$delhi_1617['December']}}, {{$delhi_1617['January']}}, {{$delhi_1617['February']}}, {{$delhi_1617['March']}}],
                        ['2017-2018', {{$delhi_1718['April']}},{{$delhi_1718['May']}}, {{$delhi_1718['June']}}, {{$delhi_1718['July']}},{{$delhi_1718['Agust']}}, {{$delhi_1718['September']}}, 
                        {{$delhi_1718['October']}}, {{$delhi_1718['November']}}, {{$delhi_1718['December']}}, {{$delhi_1718['January']}}, {{$delhi_1718['February']}}, {{$delhi_1718['March']}}],
                        ['2018-2019', {{$delhi_1819['April']}},{{$delhi_1819['May']}}, {{$delhi_1819['June']}}, {{$delhi_1819['July']}},{{$delhi_1819['Agust']}}, {{$delhi_1819['September']}}, 
                        {{$delhi_1819['October']}}, {{$delhi_1819['November']}}, {{$delhi_1819['December']}}, {{$delhi_1819['January']}}, {{$delhi_1819['February']}}, {{$delhi_1819['March']}}],
                        ['2019-2020', {{$delhi_1920['April']}},{{$delhi_1920['May']}}, {{$delhi_1920['June']}}, {{$delhi_1920['July']}},{{$delhi_1920['Agust']}}, {{$delhi_1920['September']}}, {{$delhi_1920['October']}}, {{$delhi_1920['November']}}, {{$delhi_1920['December']}}, {{$delhi_1920['January']}}, {{$delhi_1920['February']}}, {{$delhi_1920['March']}}],
                        ['2020-2021', {{$delhi_2021['April']}},{{$delhi_2021['May']}}, {{$delhi_2021['June']}}, {{$delhi_2021['July']}},{{$delhi_2021['Agust']}}, {{$delhi_2021['September']}}, {{$delhi_2021['October']}}, {{$delhi_2021['November']}}, {{$delhi_2021['December']}}, {{$delhi_2021['January']}}, {{$delhi_2021['February']}}, {{$delhi_2021['March']}}],
                    ],
                    type: 'bar', // default type of chart
                    colors: {
                        'data1': Aero.colors["blue"],
                        'data2': Aero.colors["cyan"],
                        'data3': Aero.colors["red"],
                        'data4': Aero.colors["green"],      
                        'data5': Aero.colors["purple"], 
                    },
                    names: {
                        // name of each serie
                        'data1': '2016-2017',
                        'data2': '2017-2018',
                        'data3': '2018-2019',
                        'data4': '2019-2020',                        
                        'data5': '2020-2021',                        
                    }
                },
                axis: {
                    x: {
                        type: 'category',
                        // name of each category
                        categories: ['Apr', 'May', 'Jun', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar']
                    },
                },
                bar: {
                    width: 15
                },
                legend: {
                    show: true, //hide legend
                },
                padding: {
                    bottom: 0,
                    top: 0
                },
            });

        });
</script>

</body>

@endsection
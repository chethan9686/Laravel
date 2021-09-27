@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title> Employee | Dashboard</title>

@include('user.layouts.css')
<!-- Light Gallery Plugin Css -->
<link rel="stylesheet" href="{{ asset('user/plugins/light-gallery/css/lightgallery.css')}}">
<link rel="stylesheet" href="{{ asset('user/plugins/fullcalendar/fullcalendar.min.css')}}">
<link rel="stylesheet" href="{{ asset('user/plugins/jvectormap/jquery-jvectormap-2.0.3.min.css')}}"/>
<link rel="stylesheet" href="{{ asset('user/plugins/charts-c3/plugin.css')}}"/>
<link rel="stylesheet" href="{{ asset('user/plugins/morrisjs/morris.min.css')}}" />
<style>
    th, td  {   width:400px; 
                text-align:center; 
                border:1px solid black; 
                padding:15px 
            } 
            
        th{
            background: #f3f3f3;
        }
        td.P{
            background:#008000;
            color:#ffffff;
        }
        td.AB{
            background:#f00;
            color:#ffffff;
        }
        td.OS{
            background:#795548;
            color:#ffffff;
        }
        td.NOS{
            background:#e47297;
            color:#ffffff;
        }
        td.ROS{
            background:#f00;
            color:#ffffff;
        }
        td.FDL{
            background:#0000ff;
            color:#ffffff;
        }
        td.NFDL{
            background:#e47297;
            color:#ffffff;
        }
        td.RFDL{
            background:#f00;
            color:#ffffff;
        }
        td.HDL{
            background:#0000ff;
            color:#ffffff;
        }
        td.NHDL{
            background:#e47297;
            color:#ffffff;
        }
        td.RHDL{
            background:#f00;
            color:#ffffff;
        }
        td.M{
            background:#65c565;
            color:#ffffff;
        }
        td.E{
            background:#800080;
            color:#ffffff;
        }
        td.FDCO{
            background:#222;
            color:#ffffff;
        }
        td.NFDCO{
            background:#e47297;
            color:#ffffff;
        }
        td.RFDCO{
            background:#f00;
            color:#ffffff;
        }
        td.HDCO{
            background:#222;
            color:#ffffff;
        }
        td.NHDCO{
            background:#e47297;
            color:#ffffff;
        }
        td.RHDCO{
            background:#f00;
            color:#ffffff;
        }
        td.HD{
            background:#0000ff;
            color:#ffffff;
        }
        td.NHD{
            background:#f00;
            color:#ffffff;
        }
        td.NJ{
            background:#189bd8;
            color:#ffffff;
        }
        td.ABM{
            background:#f00;
            color:#ffffff;
        }
        td.SUN{
            background:#ffa500;
            color:#ffffff;
        }
        td.H{
            background:#ffa500;
            color:#ffffff;
        }
        .l-amber{
            background:#0000ff !important;
        }
        .l-blue{
            background:#f00 !important;
        }
        .l-purple{
            background:#65c565 !important;
        }
        .l-green{
            background:#008000 !important;
        }
        .big_icon.email::before{
            content: "\f331" !important;
            top: -5px !important;
        }
        .big_icon.domains::before{
            content: "\f108" !important;
            top: -5px !important;
        }
        .big_icon.sales::before{
            content: "\f330" !important;
            top: -5px !important;
        }
        .big_icon.traffic::before{
            content: "\f32e" !important;
            top: -5px !important;
        }
        h2{
            color:#222 !important;
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
    <div class="">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>Dashboard</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM </a></li>
                        <li class="breadcrumb-item active">Emplyee Dashboard</li>
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
                          <h2> <strong>Flash News</strong></h2>
                       </div>
                        <div class="body">
                           <marquee attribute_name = "attribute_value"....more attributes style="margin-top:8px;">
                                <b style="font-size:20px;">KRA for <span style="color:#e47297;">2020-2021</span> has been updated please click on official documents to know more!</b>
                            </marquee> 
                        </div>
                    </div>
                </div>
            </div>
              <div class="row clearfix"> 
                @if($Birthday->isNotEmpty())              
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header text-center" style="background:#e47297;color:#fff;font-size:18px;">
                            BIRTHDAY'S
                        </div>
                        <div class="chat_window body" style="margin-left: 0px">
                            <div class="row">
                            @foreach($Birthday as $Bday)
                            @php
                            $user = App\User::find($Bday->user_id);
                            @endphp                            
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="chat-header">
                                        <div class="user">
                                            <img src="{{asset('public/'.$Bday->profile_picture)}}" alt="avatar" style="width: 45px; height: 45px;"/>
                                            <div class="chat-about" style="padding-bottom: 10px;">
                                                <div class="chat-with">{{$user->first_name}} {{$user->last_name}}</div>
                                                <div class="chat-num-messages">{{$Bday->designation}}</div>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                            
                            @endforeach
                            </div>
                            <hr>
                            <ul class="chat-history" style="overflow-y: scroll; max-height:250px;">
                                @foreach($Wishes as $wish)
                                    @php
                                        $WishUser = App\User::find($wish->user_id);
                                    @endphp                                
                                    @if($wish->user_id != $User->id)
                                    <li class="clearfix">
                                        <div class="status message-data text-right">
                                            <span class="time">{{Carbon\Carbon::parse($wish->created_at)->diffForHumans()}}</span>
                                            <span class="name">{{$WishUser->first_name}} {{$WishUser->last_name}}</span>                                                                 
                                        </div>
                                        <div class="message other-message float-right">{{$wish->comment}}</div>
                                    </li>
                                    @else
                                    <li>
                                        <div class="status message-data">
                                            <span class="name">{{$WishUser->first_name}} {{$WishUser->last_name}}</span>
                                            <span class="time">{{Carbon\Carbon::parse($wish->created_at)->diffForHumans()}}</span>
                                        </div>
                                        <div class="message my-message">
                                           {{$wish->comment}}                                   
                                        </div>
                                    </li>   
                                    @endif
                                @endforeach                        
                            </ul>
                            <div class="chat-box">
                                <form method="post" action="{{route('wishes')}}">
                                    @csrf
                                    <input type="hidden" name="wish" value="Bday">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-mail-send"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="comment" placeholder="Enter text here..." required>
                                    </div>  
                                </form>                                                          
                            </div>
                        </div>
                    </div>
                </div>   
                @endif
                @if($Work->isNotEmpty())
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header text-center" style="background:#e47297;color:#fff;font-size:18px;">
                           WORK ANNIVERSARY'S
                        </div>
                        <div class="chat_window body" style="margin-left: 0px">
                            <div class="row">
                            @foreach($Work as $Bday)
                            @php
                            $user = App\User::find($Bday->user_id);
                            $doj = Carbon\Carbon::parse($Bday->doj);
                            $now = Carbon\Carbon::now();
                            @endphp                            
                                <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="chat-header">
                                        <div class="user">
                                            <div class="chat-with" style="color:#e47297;font-size: 18px;padding-bottom: 10px"><i class="zmdi zmdi-cake"></i> Cheers on completing {{$doj->diffInYears($now)}} year's</div>
                                            <img src="{{asset('public/'.$Bday->profile_picture)}}" alt="avatar" style="width: 45px; height: 45px;">
                                            <div class="chat-about" style="padding-bottom: 10px;">
                                                <div class="chat-with">{{$user->first_name}} {{$user->last_name}}</div>
                                                <div class="chat-num-messages">{{$Bday->designation}}</div>                                                
                                            </div>
                                        </div>                                
                                    </div>
                                </div>                            
                            @endforeach
                            </div>
                            <hr>
                            <ul class="chat-history" style="overflow-y: scroll; max-height:250px;">
                                @foreach($WorkWishes as $wish)
                                    @php
                                        $WishUser = App\User::find($wish->user_id);
                                    @endphp                                
                                    @if($wish->user_id != $User->id)
                                    <li class="clearfix">
                                        <div class="status message-data text-right">
                                            <span class="time">{{Carbon\Carbon::parse($wish->created_at)->diffForHumans()}}</span>
                                            <span class="name">{{$WishUser->first_name}} {{$WishUser->last_name}}</span>                                                                 
                                        </div>
                                        <div class="message other-message float-right">{{$wish->comment}}</div>
                                    </li>
                                    @else
                                    <li>
                                        <div class="status message-data">
                                            <span class="name">{{$WishUser->first_name}} {{$WishUser->last_name}}</span>
                                            <span class="time">{{Carbon\Carbon::parse($wish->created_at)->diffForHumans()}}</span>
                                        </div>
                                        <div class="message my-message">
                                           {{$wish->comment}}                                   
                                        </div>
                                    </li>   
                                    @endif
                                @endforeach                        
                            </ul>
                            <div class="chat-box">
                                <form method="post" action="{{route('wishes')}}">
                                    @csrf
                                    <input type="hidden" name="wish" value="Workday">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="zmdi zmdi-mail-send"></i></span>
                                        </div>
                                        <input type="text" class="form-control" name="comment" placeholder="Enter text here..." required>
                                    </div>  
                                </form>                                                          
                            </div>
                        </div>
                    </div>
                </div>  
                @endif              
            </div>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card widget_2 big_icon traffic">
                        <div class="body">
                            <h6>Number of Paid Leavs</h6>
                            <h2>{{$Data->paid_leave}}</h2>
                            <div class="progress">
                                <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card widget_2 big_icon sales">
                        <div class="body">
                            <h6>Number of Absent</h6>
                            <h2>{{$Data->cut_leave}}</h2>
                            <div class="progress">
                                <div class="progress-bar l-blue" role="progressbar" aria-valuenow="38" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card widget_2 big_icon email">
                        <div class="body">
                            <h6>REMAINING LEAVES</h6>
                            <h2>{{$Days}} - {{$Attendence}} = {{$Days - $Attendence}}</h2>
                            <div class="progress">
                                <div class="progress-bar l-purple" role="progressbar" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card widget_2 big_icon domains">
                        <div class="body">
                            <h6>Number of working Days</h6>
                            <h2>{{$Data->working}}</h2>
                            <div class="progress">
                                <div class="progress-bar l-green" role="progressbar" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="table-responsive">
                                <table>                                   
                                    <tr> 
                                        <th colspan="7" style="text-transform: uppercase;background:#e47297;color:#fff;font-size:18px;">{{$today->format('F')}}</th>                                        
                                    </tr> 
                                    <tr> 
                                        <th>1</th> 
                                        <th>2</th> 
                                        <th>3</th> 
                                        <th>4</th> 
                                        <th>5</th> 
                                        <th>6</th> 
                                        <th>7</th> 
                                    </tr> 
                                    <tr> 
                                        <td class="{{$Data->one}}">{{$Data->one}}</td> 
                                        <td class="{{$Data->two}}">{{$Data->two}}</td> 
                                        <td class="{{$Data->three}}">{{$Data->three}}</td> 
                                        <td class="{{$Data->four}}">{{$Data->four}}</td> 
                                        <td class="{{$Data->five}}">{{$Data->five}}</td> 
                                        <td class="{{$Data->six}}">{{$Data->six}}</td> 
                                        <td class="{{$Data->seven}}">{{$Data->seven}}</td> 
                                    </tr> 
                                    <tr> 
                                        <th>8</th> 
                                        <th>9</th> 
                                        <th>10</th> 
                                        <th>11</th> 
                                        <th>12</th> 
                                        <th>13</th> 
                                        <th>14</th> 
                                    </tr> 
                                    <tr> 
                                        <td class="{{$Data->eight}}">{{$Data->eight}}</td> 
                                        <td class="{{$Data->nine}}">{{$Data->nine}}</td> 
                                        <td class="{{$Data->ten}}">{{$Data->ten}}</td> 
                                        <td class="{{$Data->eleven}}">{{$Data->eleven}}</td> 
                                        <td class="{{$Data->twelve}}">{{$Data->twelve}}</td> 
                                        <td class="{{$Data->thirteen}}">{{$Data->thirteen}}</td> 
                                        <td class="{{$Data->fourteen}}">{{$Data->fourteen}}</td> 
                                    </tr> 
                                    <tr> 
                                        <th>15</th> 
                                        <th>16</th> 
                                        <th>17</th> 
                                        <th>18</th> 
                                        <th>19</th> 
                                        <th>20</th> 
                                        <th>21</th> 
                                    </tr> 
                                    <tr> 
                                        <td class="{{$Data->fifteen}}">{{$Data->fifteen}}</td> 
                                        <td class="{{$Data->sixteen}}">{{$Data->sixteen}}</td> 
                                        <td class="{{$Data->seventeen}}">{{$Data->seventeen}}</td> 
                                        <td class="{{$Data->eighteen}}">{{$Data->eighteen}}</td> 
                                        <td class="{{$Data->nineteen}}">{{$Data->nineteen}}</td> 
                                        <td class="{{$Data->twenty}}">{{$Data->twenty}}</td> 
                                        <td class="{{$Data->twentyone}}">{{$Data->twentyone}}</td> 
                                    </tr> 
                                    <tr> 
                                        <th>22</th> 
                                        <th>23</th> 
                                        <th>24</th> 
                                        <th>25</th> 
                                        <th<?php if (false !== $key = array_search(26, $dates)) { }else{?> style="display: none" <?php } ?>>26</th> 
                                        <th<?php if (false !== $key = array_search(27, $dates)) { }else{?> style="display: none" <?php } ?>>27</th> 
                                        <th<?php if (false !== $key = array_search(28, $dates)) { }else{?> style="display: none" <?php } ?>>28</th> 
                                    </tr> 
                                    <tr> 
                                        <td class="{{$Data->twentytwo}}">{{$Data->twentytwo}}</td> 
                                        <td class="{{$Data->twentythree}}">{{$Data->twentythree}}</td> 
                                        <td class="{{$Data->twentyfour}}">{{$Data->twentyfour}}</td> 
                                        <td class="{{$Data->twentyfive}}">{{$Data->twentyfive}}</td> 
                                        <td class="{{$Data->twentysix}}"   <?php if (false !== $key = array_search(26, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->twentysix}}</td> 
                                        <td class="{{$Data->twentyseven}}" <?php if (false !== $key = array_search(27, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->twentyseven}}</td> 
                                        <td class="{{$Data->twentyeight}}" <?php if (false !== $key = array_search(28, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->twentyeight}}</td> 
                                    </tr> 
                                     <tr> 
                                        <th <?php if (false !== $key = array_search(29, $dates)) { }else{?> style="display: none" <?php } ?>>29</th> 
                                        <th <?php if (false !== $key = array_search(30, $dates)) { }else{?> style="display: none" <?php } ?>>30</th> 
                                        <th <?php if (false !== $key = array_search(31, $dates)) { }else{?> style="display: none" <?php } ?>>31</th>                                        
                                    </tr> 
                                    <tr> 
                                        <td class="{{$Data->twentynine}}" <?php if (false !== $key = array_search(29, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->twentynine}}</td> 
                                        <td class="{{$Data->thirty}}" <?php if (false !== $key = array_search(30, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->thirty}}</td> 
                                        <td class="{{$Data->thirtyone}}" <?php if (false !== $key = array_search(31, $dates)) { }else{?> style="display: none" <?php } ?>>{{$Data->thirtyone}}</td>                                        
                                    </tr> 
                                </table>
                            </div>
                       </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    
                </div>
            </div>
            <!--<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong><i class="zmdi zmdi-chart"></i> Sales</strong> Report</h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Edit</a></li>
                                        <li><a href="javascript:void(0);">Delete</a></li>
                                        <li><a href="javascript:void(0);">Report</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body mb-2">
                            <div class="row clearfix">
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="state_w1 mb-1 mt-1">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>2,365</h5>
                                                <span><i class="zmdi zmdi-balance"></i> Number of paid leave</span>
                                            </div>
                                            <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#868e96">5,2,3,7,6,4,8,1</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="state_w1 mb-1 mt-1">
                                        <div class="d-flex justify-content-between">
                                            <div>                                
                                                <h5>365</h5>
                                                <span><i class="zmdi zmdi-turning-sign"></i> Returns</span>
                                            </div>
                                            <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#2bcbba">8,2,6,5,1,4,4,3</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="state_w1 mb-1 mt-1">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <h5>65</h5>
                                                <span><i class="zmdi zmdi-alert-circle-o"></i> Queries</span>
                                            </div>
                                            <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#82c885">4,4,3,9,2,1,5,7</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-6">
                                    <div class="state_w1 mb-1 mt-1">
                                        <div class="d-flex justify-content-between">
                                            <div>                            
                                                <h5>2,055</h5>
                                                <span><i class="zmdi zmdi-print"></i> Invoices</span>
                                            </div>
                                            <div class="sparkline" data-type="bar" data-width="97%" data-height="55px" data-bar-Width="3" data-bar-Spacing="5" data-bar-Color="#45aaf2">7,5,3,8,4,6,2,9</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="body">
                            <div id="chart-area-spline-sracked" class="c3_chart d_sales"></div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!--<div class="row clearfix">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card mcard_4">
                        <div class="body">
                            <ul class="header-dropdown list-unstyled">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-menu"></i> </a>
                                    <ul class="dropdown-menu slideUp">
                                        <li><a href="javascript:void(0);">Edit</a></li>
                                        <li><a href="javascript:void(0);">Delete</a></li>
                                        <li><a href="javascript:void(0);">Report</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <div class="img">
                                <img src="assets/images/lg/avatar1.jpg" class="rounded-circle" alt="profile-image">
                            </div>
                            <div class="user">
                                <h5 class="mt-3 mb-1">Eliana Smith</h5>
                                <small class="text-muted">UI/UX Desiger</small>
                            </div>
                            <ul class="list-unstyled social-links">
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-dribbble"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-behance"></i></a></li>
                                <li><a href="javascript:void(0);"><i class="zmdi zmdi-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card w_data_1">
                       <div class="body">
                            <div class="w_icon pink"><i class="zmdi zmdi-bug"></i></div>
                            <h4 class="mt-3 mb-0">12.1k</h4>
                            <span class="text-muted">Bugs Fixed</span>
                            <div class="w_description text-success">
                                <i class="zmdi zmdi-trending-up"></i>
                                <span>15.5%</span>
                            </div>
                       </div>
                    </div>
                    <div class="card w_data_1">
                        <div class="body">
                            <div class="w_icon cyan"><i class="zmdi zmdi-ticket-star"></i></div>
                            <h4 class="mt-3 mb-1">01.8k</h4>
                            <span class="text-muted">Submitted Tickers</span>
                            <div class="w_description text-success">
                                <i class="zmdi zmdi-trending-up"></i>
                                <span>95.5%</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="body">
                            <div class="chat-widget">
                                <ul class="list-unstyled">
                                    <li class="left">
                                        <img src="assets/images/xs/avatar3.jpg" class="rounded-circle" alt="">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>Frank 11:00AM</small></li>
                                            <li><span class="message bg-blue">Hello, Michael</span></li>
                                            <li><span class="message bg-blue">How are you!</span></li>
                                        </ul>
                                    </li>
                                    <li class="right">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>11:10AM</small></li>
                                            <li><span class="message">Hello, Frank</span></li>
                                        </ul>
                                    </li>
                                    <li class="right">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>11:11AM</small></li>
                                            <li><span class="message">I'm fine what about you?</span></li>
                                        </ul>
                                    </li>
                                    <li class="left">
                                        <img src="assets/images/xs/avatar2.jpg" class="rounded-circle" alt="">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>Gary 11:13AM</small></li>
                                            <li><span class="message bg-indigo">Hello, Michael and Frank</span></li>
                                        </ul>
                                    </li>
                                    <li class="left">
                                        <img src="assets/images/xs/avatar5.jpg" class="rounded-circle" alt="">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>Hossein 11:14AM</small></li>
                                            <li><span class="message bg-amber">Hello, team</span></li>
                                            <li><span class="message bg-amber">Please let me know your requirements.</span></li>
                                            <li><span class="message bg-amber">How would like to connect with us?</span></li>
                                        </ul>
                                    </li>
                                    <li class="right">
                                        <ul class="list-unstyled chat_info">
                                            <li><small>11:15AM</small></li>
                                            <li><span class="message">Hello, Hossein</span></li>
                                            <li><span class="message">Meeting on conference room at 12:00PM</span></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="input-group mt-3">
                                <div class="input-group-prepend">                                    
                                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add</button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="javascript:void(0);">Tim Hank</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Hossein Shams</a>
                                        <a class="dropdown-item" href="javascript:void(0);">John Smith</a>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Enter text here..." aria-label="Text input with dropdown button">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="zmdi zmdi-mail-send"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
            <!--<div class="row clearfix">
                <div class="col-md-12 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Visitors</strong> Statistics</h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>                        
                        </div>
                        <div class="body">
                            <div id="world-map-markers" class="jvector-map"></div>                            
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Distribution</strong></h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Edit</a></li>
                                        <li><a href="javascript:void(0);">Delete</a></li>
                                        <li><a href="javascript:void(0);">Report</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body text-center">
                            <div id="chart-pie" class="c3_chart d_distribution"></div>
                            <button class="btn btn-primary mt-4 mb-4">View More</button>                            
                        </div>
                    </div>
                </div>
            </div>-->
            <!--<div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Traffic</strong> Source</h2>
                            <ul class="header-dropdown">
                                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                                    <ul class="dropdown-menu dropdown-menu-right slideUp">
                                        <li><a href="javascript:void(0);">Edit</a></li>
                                        <li><a href="javascript:void(0);">Delete</a></li>
                                        <li><a href="javascript:void(0);">Report</a></li>
                                    </ul>
                                </li>
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="row">
                                <div class="col-lg-8 col-md-6 col-sm-12">
                                    <div id="chart-area-step" class="c3_chart d_traffic"></div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <span> More than 30% percent of users come from direct links. Check details page for more information.</span>
                                    <div class="progress mt-4">
                                        <div class="progress-bar l-amber" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 45%;"></div>
                                    </div>
                                    <div class="d-flex bd-highlight mt-4">                                
                                        <div class="flex-fill bd-highlight">
                                            <h5 class="mb-0">21,521 <i class="zmdi zmdi-long-arrow-up"></i></h5>
                                            <small>Today</small>
                                        </div>
                                        <div class="flex-fill bd-highlight">
                                            <h5 class="mb-0">%12.35 <i class="zmdi zmdi-long-arrow-down"></i></h5>
                                            <small>Last month %</small>
                                        </div>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>-->
        </div>
    </div>
</section>

@include('user.layouts.js')

<script src="{{ asset('user/plugins/light-gallery/js/lightgallery-all.min.js')}}"></script> <!-- Light Gallery Plugin Js --> 
<script src="{{ asset('user/bundles/fullcalendarscripts.bundle.js')}}"></script><!--/ calender javascripts --> 
<script src="{{ asset('user/js/pages/medias/image-gallery.js')}}"></script>
<script src="{{ asset('user/js/pages/calendar/calendar.js')}}"></script>
<script src="{{ asset('user/bundles/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
<script src="{{ asset('user/bundles/sparkline.bundle.js')}}"></script> <!-- Sparkline Plugin Js -->
<script src="{{ asset('user/bundles/c3.bundle.js')}}"></script>
<script src="{{ asset('user/js/pages/index.js')}}"></script>
{!! Toastr::message() !!}
</body>

@endsection
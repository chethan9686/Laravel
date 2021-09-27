@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>Monthly Attendance</title>

@include('user.layouts.css')

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
        td.LC{
            background:yellow;
            color:#222;
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
                    <h2>Monthly Attendance</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Monthly Attendance</a></li>
                        <li class="breadcrumb-item active">{{$today->format('F')}} Attendance</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-5 col-sm-5 col-lg-5 col-xl-5">
                    <div class="card">
                        <div class="body">
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#0000ff;border:1px solid #0000ff;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Paid Leave" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Data->paid_leave}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div> 
                             <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:red;border:1px solid red;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Loss of Pay" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Data->cut_leave}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                            
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#222;border:1px solid #222;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Comp-Off" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Data->comp}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#4169E1;border:1px solid #4169E1;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Total Paid Leaves" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Attendence}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>

                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#008000;border:1px solid #008000;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Allocated Leaves" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Days}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#FFA500;border:1px solid #FFA500;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Remaining Leaves" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Days - $Attendence}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#65c565;border:1px solid #65c565;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Meeting" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Data->meeting}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#008000;border:1px solid #008000;">
                                        <span class="input-group-text"><i class="zmdi zmdi-mood" style="visibility: hidden;"></i></span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Number of Working Days" readonly="readonly" style="background:#fff;text-align:center;border-right:none;">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="zmdi" >{{$Data->working}}</i></span>
                                    </div>
                                </div>                                                                                   
                            </div>
                          
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-sm-7 col-lg-7 col-xl-7">
                    <div class="card">
                        <div class="header" style="padding-top: 0px;">
                            @if(!is_null($LastMonth))
                                <a href="{{route('previous_attendence')}}"><button type="button" class="btn btn-primary" style="text-transform: uppercase;color:#fff;font-size:14px;">{{$LastMonth}} Attendance</button></a>
                            @else
                                <a href="{{route('own_attendence')}}"><button type="button" class="btn btn-primary" style="text-transform: uppercase;color:#fff;font-size:14px;">{{$Current->format('F')}} Attendance</button></a>
                            @endif
                        </div>
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
            <div class="row">  
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-6"> 
                     <div class="card">
                        <div class="body"> 
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#008000;border:1px solid #008000;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;text-align:center;">P</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Present" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">AB</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Absent" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#795548;border:1px solid #795548;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">OS</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Approved Out Of Station" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#e47297;border:1px solid #e47297;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">NOS</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Not Approved Out Of Station" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">ROS</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Rejected Out Of Station" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#0000ff;border:1px solid #0000ff;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">FDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Approved Full Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#e47297;border:1px solid #e47297;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">NFDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Not Approved Full Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">RFDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Rejected Full Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#0000ff;border:1px solid #0000ff;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">HDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Approved Half Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                             <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#e47297;border:1px solid #e47297;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">NHDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Not Approved Half Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                           <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:65px !important;">RHDL</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Rejected Half Day Leave" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                        </div>
                    </div>
                </div>   
                
                <div class="col-md-6 col-md-6 col-lg-6 col-xl-6"> 
                     <div class="card">
                        <div class="body">
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#65c565;border:1px solid #65c565;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">M</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Meeting" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div> 
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#800080;border:1px solid #800080;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">E</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Event" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>  
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#222;border:1px solid #222;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">FDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Approved Full Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#e47297;border:1px solid #e47297;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">NFDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Not Approved Full Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">RFDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Rejected Full Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#222;border:1px solid #222;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">HDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Approved Half Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#e47297;border:1px solid #e47297;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">NHDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Not Approved Half Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">RHDCO</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Rejected Half Day Comp-Off" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">NHD</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Half Day Arrival" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#f00;border:1px solid #f00;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">ABM</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Failed To Send MOM" readonly="readonly" style="background:#fff;text-align:center;">
                                </div>                                                                                   
                            </div>
                            <div class="form-group">                                                   
                                <div class="input-group">
                                    <div class="input-group-prepend" style="background:#ffa500;border:1px solid #ffa500;">
                                        <span class="input-group-text" style="font-size: 13px;color:#fff;min-width:81px !important;">SUN / H</span>
                                    </div>
                                    <input type="text" class="form-control" placeholder="Employee Name" name="emp_name" value="Sunday / Holiday" readonly="readonly" style="background:#fff;text-align:center;">
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

</body>

@endsection
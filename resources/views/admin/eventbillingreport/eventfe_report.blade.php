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

<link rel="stylesheet" href="{{asset('admin/plugins/dropify/css/dropify.min.css')}}">

<style type="text/css">
    
    .invalid-feedback {  
        display: block;  
        width: 100%;
        margin-top: .25rem;
        font-size: 95%;
        color: #dc3545;
    }
</style>
 

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
                    <h2>Events FE Amount</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="zmdi zmdi-home"></i> Wings Events</a></li>
                        <li class="breadcrumb-item active">Events FE Amount Report</li>
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
                <div   @if($Auth->id == 1) style="display:none;" @else class="col-lg-12 col-md-12 col-sm-12" @endif>
                    <div class="card">
                       <div class="header">
                          <h2> <strong>FE Amount </strong> Entry</h2>
                       </div>
                       <div class="body">                              
                            <form method="POST" action="{{route('admin.createfeamount')}}" id="feamount" enctype="multipart/form-data" autocomplete="off">
                            {{csrf_field()}}
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Year</label>
                                        <div class="form-group">                                                   
                                           <select class="form-control" name="year">
                                                <option value="">Select Year</option>
                                                <option value="2020">2020</option>
                                                <option value="2021">2021</option>                          
                                            </select>
                                            @if ($errors->has('year'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('year') }}</strong>
                                                </span>
                                            @endif                                                                                            
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
                                            @if ($errors->has('month'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('month') }}</strong>
                                                </span>
                                            @endif                                                                                         
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Bangalore FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch1" value="Bangalore">
                                            <input type="text" name="bng_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">
                                            @if ($errors->has('bng_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bng_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Mumbai FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch2" value="Mumbai">
                                            <input type="text" name="mum_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">
                                            @if ($errors->has('mum_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('mum_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Delhi FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch3" value="Delhi">
                                            <input type="text" name="del_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">
                                            @if ($errors->has('del_amount'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('del_amount') }}</strong>
                                                </span>
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="co-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">FE Attachment</label>
                                        <div class="form-group">
                                            <input type="file" id="dropify-event" name="fe_sheet">
                                            @if ($errors->has('fe_sheet'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('fe_sheet') }}</strong>
                                                </span>
                                            @endif 
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
                <div class="col-lg-12 col-md-12 col-sm-12"> 
                    <div class="card">  
                        <div class="header">
                          <h2></h2>
                        </div>                    
                        <div class="body">     
                            @php    
                             $Sum = ($Bng_Amount['April'] + $Mum_Amount['April'] + $Del_Amount['April']) + ($Bng_Amount['May'] + $Mum_Amount['May'] + $Del_Amount['May']) + ($Bng_Amount['June'] + $Mum_Amount['June'] + $Del_Amount['June']) + ($Bng_Amount['July'] + $Mum_Amount['July'] + $Del_Amount['July']) + ($Bng_Amount['Agust'] + $Mum_Amount['Agust'] + $Del_Amount['Agust']) + ($Bng_Amount['September'] + $Mum_Amount['September'] + $Del_Amount['September']) + ($Bng_Amount['October'] + $Mum_Amount['October'] + $Del_Amount['October']) + ($Bng_Amount['November'] + $Mum_Amount['November'] + $Del_Amount['November']) + ($Bng_Amount['December'] + $Mum_Amount['December'] + $Del_Amount['December']) + ($Bng_Amount['January'] + $Mum_Amount['January'] + $Del_Amount['January']) + ($Bng_Amount['February'] + $Mum_Amount['February'] + $Del_Amount['February']) + ($Bng_Amount['March'] + $Mum_Amount
                             ['March'] + $Del_Amount['March']);  

                             $april = $Bng_Amount['April'] + $Mum_Amount['April'] + $Del_Amount['April']; 
                             $may = $Bng_Amount['May'] + $Mum_Amount['May'] + $Del_Amount['May'];      
                             $june = $Bng_Amount['June'] + $Mum_Amount['June'] + $Del_Amount['June'];   
                             $july = $Bng_Amount['July'] + $Mum_Amount['July'] + $Del_Amount['July'];  
                             $august = $Bng_Amount['Agust'] + $Mum_Amount['Agust'] + $Del_Amount['Agust'];     
                             $sept = $Bng_Amount['September'] + $Mum_Amount['September'] + $Del_Amount['September'];   
                             $oct = $Bng_Amount['October'] + $Mum_Amount['October'] + $Del_Amount['October'];   
                             $nov = $Bng_Amount['November'] + $Mum_Amount['November'] + $Del_Amount['November']; 
                             $dec = $Bng_Amount['December'] + $Mum_Amount['December'] + $Del_Amount['December'];   
                            @endphp                    
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="6" style="text-align: center;color:#e47297;">Total Events India FE Amount</th>
                                    </tr>
                                    <tr>
                                        <th>Year</th>
                                        <th>Month</th>
                                        <th>Amount</th>      
                                        <th>FE Sheet</th>     
                                        <th>Edit Status</th>
                                        <th>Comment</th>                             
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>April</td>
                                        <td>{{$april == 0 ? '' : $april}}</td>
                                        <td>@if(!is_null($Attachment['April']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'April'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['April_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="April" data-heading="April" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['April_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['April_Comment'])) {{$Attachment['April_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['April_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="April" data-heading="April" data-bng="{{$Bng_Amount['April']}}" data-mum="{{$Mum_Amount['April']}}" data-del="{{$Del_Amount['April']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['April_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['April_Comment'])) {{$Attachment['April_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>May</td>
                                        <td>{{$may == 0 ? '' : $may}}</td>
                                        <td>@if(!is_null($Attachment['May']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'May'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['May_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="May" data-heading="May" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['May_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['May_Comment'])) {{$Attachment['May_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['May_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="May" data-heading="May" data-bng="{{$Bng_Amount['May']}}" data-mum="{{$Mum_Amount['May']}}" data-del="{{$Del_Amount['May']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>@elseif($Attachment['May_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['May_Comment'])) {{$Attachment['May_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>June</td>
                                        <td>{{$june == 0 ? '' : $june}}</td>
                                        <td>@if(!is_null($Attachment['June']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'June'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['June_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}"  data-month="June" data-heading="June" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['June_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['June_Comment'])) {{$Attachment['June_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['June_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="June" data-heading="June" data-bng="{{$Bng_Amount['June']}}" data-mum="{{$Mum_Amount['June']}}" data-del="{{$Del_Amount['June']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>@elseif($Attachment['June_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['June_Comment'])) {{$Attachment['June_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>July</td>
                                        <td>{{$july == 0 ? '' : $july}}</td>
                                        <td>@if(!is_null($Attachment['July']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'July'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['July_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="July" data-heading="July" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['July_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['July_Comment'])) {{$Attachment['July_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['July_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="July" data-heading="July" data-bng="{{$Bng_Amount['July']}}" data-mum="{{$Mum_Amount['July']}}" data-del="{{$Del_Amount['July']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>@elseif($Attachment['July_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['July_Comment'])) {{$Attachment['July_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>August</td>
                                        <td>{{$august == 0 ? '' : $august}}</td>
                                        <td>@if(!is_null($Attachment['Agust']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'Agust'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['Agust_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="Agust" data-heading="Agust" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['Agust_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['Agust_Comment'])) {{$Attachment['Agust_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['Agust_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="Agust" data-heading="August" data-bng="{{$Bng_Amount['Agust']}}" data-mum="{{$Mum_Amount['Agust']}}" data-del="{{$Del_Amount['Agust']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['Agust_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['Agust_Comment'])) {{$Attachment['Agust_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>September</td>
                                        <td>{{$sept == 0 ? '' : $sept}}</td>
                                        <td>@if(!is_null($Attachment['September']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'September'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['September_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="September" data-heading="September" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                            @elseif($Attachment['September_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['September_Comment'])) {{$Attachment['September_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['September_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="September" data-heading="September" data-bng="{{$Bng_Amount['September']}}" data-mum="{{$Mum_Amount['September']}}" data-del="{{$Del_Amount['September']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['September_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['September_Comment'])) {{$Attachment['September_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>October</td>
                                        <td>{{$oct == 0 ? '' : $oct}}</td>
                                        <td>@if(!is_null($Attachment['October']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'October'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['October_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="October" data-heading="October" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['October_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['October_Comment'])) {{$Attachment['October_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['October_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="October" data-heading="October" data-bng="{{$Bng_Amount['October']}}" data-mum="{{$Mum_Amount['October']}}" data-del="{{$Del_Amount['October']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['October_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['October_Comment'])) {{$Attachment['October_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>November</td>
                                        <td>{{$nov == 0 ? '' : $nov}}</td>
                                        <td>@if(!is_null($Attachment['November']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'November'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['November_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}" data-month="November" data-heading="November" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['November_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['November_Comment'])) {{$Attachment['November_Comment']}} >@endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['November_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="November" data-heading="November" data-bng="{{$Bng_Amount['November']}}" data-mum="{{$Mum_Amount['November']}}" data-del="{{$Del_Amount['November']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['November_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif
                                        </td>
                                        <td>@if(!is_null($Attachment['November_Comment'])) {{$Attachment['November_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>December</td>
                                        <td>{{$dec == 0 ? '' : $dec}}</td>
                                        <td>@if(!is_null($Attachment['December']))<a href="{{route('admin.fe_sheet',[ 'year' => $Attachment['year'], 'month' => 'December'])}}" class="btn btn-primary" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-download"></i></a>@endif</td>
                                        @if($Auth->id == "1")
                                        <td>@if($Attachment['December_Status'] == "1" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#approveModal" data-year="{{$Del_Amount['year']}}"  data-month="December" data-heading="December" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['December_Status'] == "2") <span class="btn btn-round btn-success"> Commented </span> @endif</td>
                                         <td>@if(!is_null($Attachment['December_Comment'])) {{$Attachment['December_Comment']}} @endif</td>
                                        @elseif($Auth->id == "2")
                                        <td>@if($Attachment['December_Status'] == "2" )<a type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal" data-year="{{$Del_Amount['year']}}" data-month="December" data-heading="December" data-bng="{{$Bng_Amount['December']}}" data-mum="{{$Mum_Amount['December']}}" data-del="{{$Del_Amount['December']}}" style="color:#fff;padding: 5px 10px;margin:0px;"><i class="zmdi zmdi-edit"></i></a>
                                        @elseif($Attachment['December_Status'] == "1") <span class="btn btn-round btn-success"> Uploaded</span> @endif</td>
                                        <td>@if(!is_null($Attachment['December_Comment'])) {{$Attachment['December_Comment']}} @endif</td>
                                        @endif
                                    </tr>
                                     <tr>
                                        <td colspan="2" style="text-align: center;">Grand Total</td>
                                        <td colspan="4" >{{$Sum}}</td>                                        
                                    </tr>
                                </tbody>
                            </table>                                        
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="approveModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h4 class="title" id="largeModalLabel"><span class="heading"></span> - FE Amount</h4>
                        </div>
                       <form method="post" action="{{route('admin.approve_fesheet')}}"  enctype="multipart/form-data">
                        @csrf                    
                        <input type="hidden" name="year" id="year" value="">
                        <input type="hidden" name="month" id="month" value="">
                            <div class="modal-body"> 
                                <div class="row clearfix">
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <label for="email_address">Comments</label>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="zmdi zmdi-assignment-account"></i></span>
                                                </div>
                                               <textarea rows="4" class="form-control no-resize" placeholder="Comments" name="comment"></textarea>
                                            </div>
                                        </div>                           
                                    </div>                                                                                                                 
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-danger btn-round waves-effect" style="float: left" data-dismiss="modal">CLOSE</button>
                                <button type="submit" class="btn btn-success btn-round waves-effect">SAVE</button>               
                            </div>
                        </form>
                    </div>
                </div>
            </div>

             <div class="modal fade" id="editModal" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center">
                            <h4 class="title" id="largeModalLabel"><span class="heading"></span> - FE Amount</h4>
                        </div>
                       <form method="post" action="{{route('admin.editfeamount')}}"  enctype="multipart/form-data">
                        @csrf               
                            <div class="modal-body"> 
                                <div class="row clearfix">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Year</label>
                                        <div class="form-group">                         
                                            <input type="text" name="year" id="year" class="form-control" readonly="readonly">                                     
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Month</label>
                                        <div class="form-group">                              
                                            <input type="text" name="month" id="month" class="form-control" readonly="readonly">                                       
                                        </div>
                                    </div>                                   
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Bangalore FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch1" value="Bangalore">
                                            <input type="text" name="bng_amount" id="bng_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Mumbai FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch2" value="Mumbai">
                                            <input type="text" name="mum_amount" id="mum_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">                 
                                        </div>
                                    </div>                                    
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">Delhi FE Amount</label>
                                        <div class="form-group">
                                            <input type="hidden" name="branch3" value="Delhi">
                                            <input type="text" name="del_amount" id="del_amount" class="form-control mobile-phone-number" placeholder="Ex: 20000000">  
                                        </div>
                                    </div>
                                    <div class="co-lg-6 col-md-6 col-sm-6">
                                        <label for="email_address">FE Attachment</label>
                                        <div class="form-group">
                                            <input type="file" id="dropify-event1" name="fe_sheet">                                      
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
                            </div>                           
                        </form>
                    </div>
                </div>
            </div>

            <div class="row clearfix">
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card">
                       <div class="header">
                          <h2></h2>
                       </div>
                       <div class="body">                              
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
                                $Total = $Bng_Amount['April'] + $Bng_Amount['May'] + $Bng_Amount['June'] + $Bng_Amount['July'] + $Bng_Amount['Agust'] + $Bng_Amount['September'] + $Bng_Amount['October'] + $Bng_Amount['November'] + $Bng_Amount['December'];
                                @endphp
                                <tbody>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>April</td>
                                        <td>{{$Bng_Amount['April'] == 0 ? '' : $Bng_Amount['April']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>May</td>
                                        <td>{{$Bng_Amount['May'] == 0 ? '' : $Bng_Amount['May']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>June</td>
                                        <td>{{$Bng_Amount['June'] == 0 ? '' : $Bng_Amount['June']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>July</td>
                                        <td>{{$Bng_Amount['July'] == 0 ? '' : $Bng_Amount['July']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>August</td>
                                        <td>{{$Bng_Amount['Agust'] == 0 ? '' : $Bng_Amount['Agust']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>September</td>
                                        <td>{{$Bng_Amount['September'] == 0 ? '' : $Bng_Amount['September']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>October</td>
                                        <td>{{$Bng_Amount['October'] == 0 ? '' : $Bng_Amount['October']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>November</td>
                                        <td>{{$Bng_Amount['November'] == 0 ? '' : $Bng_Amount['November']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Bng_Amount['year']}}</td>
                                        <td>December</td>
                                        <td>{{$Bng_Amount['December'] == 0 ? '' : $Bng_Amount['December']}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Grand Total</td>
                                        <td>{{$Total}}</td>                                        
                                    </tr>
                                </tbody>
                            </table>                                        
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card">   
                        <div class="header">
                          <h2></h2>
                        </div>                    
                        <div class="body">       
                            @php
                                $Mum_Total = $Mum_Amount['April'] + $Mum_Amount['May'] + $Mum_Amount['June'] + $Mum_Amount['July'] + $Mum_Amount['Agust'] + $Mum_Amount['September'] + $Mum_Amount['October'] + $Mum_Amount['November'] + $Mum_Amount['December'];
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
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>April</td>
                                        <td>{{$Mum_Amount['April'] == 0 ? '' : $Mum_Amount['April']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>May</td>
                                        <td>{{$Mum_Amount['May'] == 0 ? '' : $Mum_Amount['May']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>June</td>
                                        <td>{{$Mum_Amount['June'] == 0 ? '' : $Mum_Amount['June']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>July</td>
                                        <td>{{$Mum_Amount['July'] == 0 ? '' : $Mum_Amount['July']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>August</td>
                                        <td>{{$Mum_Amount['Agust'] == 0 ? '' : $Mum_Amount['Agust']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>September</td>
                                        <td>{{$Mum_Amount['September'] == 0 ? '' : $Mum_Amount['September']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>October</td>
                                        <td>{{$Mum_Amount['October'] == 0 ? '' : $Mum_Amount['October']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>November</td>
                                        <td>{{$Mum_Amount['November'] == 0 ? '' : $Mum_Amount['November']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Mum_Amount['year']}}</td>
                                        <td>December</td>
                                        <td>{{$Mum_Amount['December'] == 0 ? '' : $Mum_Amount['December']}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">Grand Total</td>
                                        <td>{{$Mum_Total}}</td>                                        
                                    </tr>
                                </tbody>
                            </table>                                        
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4">
                    <div class="card">  
                        <div class="header">
                          <h2></h2>
                        </div>                    
                        <div class="body">
                            @php
                                $Del_Total = $Del_Amount['April'] + $Del_Amount['May'] + $Del_Amount['June'] + $Del_Amount['July'] + $Del_Amount['Agust'] + $Del_Amount['September'] + $Del_Amount['October'] + $Del_Amount['November'] + $Del_Amount['December'];
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
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>April</td>
                                        <td>{{$Del_Amount['April'] == 0 ? '' : $Del_Amount['April']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>May</td>
                                        <td>{{$Del_Amount['May'] == 0 ? '' : $Del_Amount['May']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>June</td>
                                        <td>{{$Del_Amount['June'] == 0 ? '' : $Del_Amount['June']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>July</td>
                                        <td>{{$Del_Amount['July'] == 0 ? '' : $Del_Amount['July']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>August</td>
                                        <td>{{$Del_Amount['Agust'] == 0 ? '' : $Del_Amount['Agust']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>September</td>
                                        <td>{{$Del_Amount['September'] == 0 ? '' : $Del_Amount['September']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>October</td>
                                        <td>{{$Del_Amount['October'] == 0 ? '' : $Del_Amount['October']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>November</td>
                                        <td>{{$Del_Amount['November'] == 0 ? '' : $Del_Amount['November']}}</td>
                                    </tr>
                                    <tr>
                                        <td>{{$Del_Amount['year']}}</td>
                                        <td>December</td>
                                        <td>{{$Del_Amount['December'] == 0 ? '' : $Del_Amount['December']}}</td>
                                    </tr>
                                     <tr>
                                        <td colspan="2" style="text-align: center;">Grand Total</td>
                                        <td>{{$Del_Total}}</td>                                        
                                    </tr>
                                </tbody>
                            </table>                                        
                        </div>
                    </div>
                </div>               
            </div>

           
        </div>
    </div>
</section>

@include('admin.layouts.js')
<script src="{{asset('admin/plugins/dropify/js/dropify.min.js')}}"></script>
<script src="{{asset('admin/js/pages/forms/dropify.js')}}"></script>
<script src="{{asset('admin/js/pages/forms/basic-form-elements.js')}}"></script>
{!! Toastr::message() !!}
</body>
<script>
   
    $(document).ready(function () {
        $('#approveModal').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');    
           var year = button.data('year');    
           var month = button.data('month');          
        
           var modal = $(this);
           modal.find('.heading').text(heading);   
           modal.find('#year').val(year);  
           modal.find('#month').val(month);         
        });     

        $('#editModal').on('show.bs.modal', function (event) {            
           var button = $(event.relatedTarget); 
           var heading = button.data('heading');    
           var year = button.data('year');    
           var month = button.data('month');  
           var bng_amt = button.data('bng');    
           var mum_amt = button.data('mum');    
           var del_amt = button.data('del');          
        
           var modal = $(this);
           modal.find('.heading').text(heading);   
           modal.find('#year').val(year);  
           modal.find('#month').val(month);  
           modal.find('#bng_amount').val(bng_amt);  
           modal.find('#mum_amount').val(mum_amt);   
           modal.find('#del_amount').val(del_amt);           
        });     

    });    
</script>
@endsection
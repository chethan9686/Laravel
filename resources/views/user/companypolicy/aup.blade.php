@extends('user.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HRM | AUP</title>

@include('user.layouts.css')

<style type="text/css">    
    p{
        font-weight: bold;
        font-size: 15px;
        padding-bottom: 0px !important;
        padding-top: 0px !important;
    }
    .nav-tabs>.nav-item>.nav-link{
        color: #607d8b !important;
    }
    .zmdi.zmdi-long-arrow-right{
        color: #e47297 !important;
    }
    .list-group-item{
        color: #222 !important;
    }
    .list-group .active{
        color: #fff !important;
    }
    .aup{
        text-align: left;
        font-size: 15px;
    }
    .pricing.pricing-item .pricing-deco{
        padding: 20px 0 20px;
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
                    <h2>AUP</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">AUP</li>
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
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="body">
                            <div class="header">
                                <h2><strong>ACCEPTABLE USAGE POLICY</strong> (AUP)</h2>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item active">E-Mail Usage</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  E-mail systems must be used for business purposes only.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Each Employee is responsible for the contents of his / her E-mail.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  User must use only “MS Outlook or Web Browser” as the E-mail client.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not open attachments from an unknown or untrusted source.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not send sensitive information like Credit Card numbers / SSN / Passwords etc.</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="body">
                            <div class="header">
                                <h2><strong>ACCEPTABLE USAGE POLICY</strong> (AUP)</h2>
                            </div>
                            <div class="list-group">
                                <a href="#" class="list-group-item active">Computer Resources Usage</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not access the Internet for personal use from any computer at any time.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not change any security / Anti Virus settings.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not share or use other’s password / ID.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Log off / Shut down as appropriate when not using the computers.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>   Do not use any desktop or screen saver apart from the ones set by the Wings IT team.</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body">
                            <div class="list-group">
                                <a href="#" class="list-group-item active">Internet Usage</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not access websites that potentially contain offensive material.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not use any form of Internet Chat from workstation without authorization / approval.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not download any file or attachment from the Internet authorization / approval.</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="body">
                            <div class="list-group">
                                <a href="#" class="list-group-item active">General</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i> Do not scribble / write down sensitive data.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i> Handle all Wings equipment and infrastructure with due care and attention.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not take out any equipment belonging to Wings without the written permission of the Division/ Department Head.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not get any equipment into Wings premises without the written permission of the Division/ Department Head.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not permit any outside person into Wings premises or allow access to any computer/equipment without the written permission of the Division/ Department Head.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i> Do not access unauthorized areas / bays.</a>
                                <a href="#" class="list-group-item"><i class="zmdi zmdi-long-arrow-right"></i>  Do not disclose company / customer sensitive information to anyone.</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12">
                    <div class="card pricing pricing-item">
                        <div class="pricing-deco l-blue">
                            </svg>
                            <h3 class="pricing-title">CONFIRMATION OF ACCEPTABLE USAGE POLICY</h3>
                        </div>
                        <div class="body text-body" style="background: #fff;">
                            <h4 class="aup">To,</h4>
                            <p class="aup">Human Resources Department</p>
                            <p class="aup">WINGS GROUP OF COMPANIES</p>
                            <p class="aup">Wings House, No. 5M-236, 5th Main, 2nd Block,</p>
                            <p class="aup">HRBR layout, Bangalore-560 043, India</p>
                            <h4 style="text-align: center;font-weight: bold;">Sub: Confirmation of Acceptable Usage Policy</h4>
                            <p class="bold" style="text-align: justify;">I state that I have read and completely understood the Acceptable Usage Policy of the Company. I further acknowledge that any changes in the future in the Acceptable Usage Policy / Any other policy will be communicated to me by displaying the same on Wings notice board(s) and/or by email.</p>
                            <p class="bold" style="text-align: justify;">I hereby confirm that I shall abide by the same in its true letter and spirit.</p>
                            <p style="text-align: left;">Thanking you,</p>
                            <p style="text-align: left;">Yours faithfully,</p>
                            <p style="text-align: left;font-weight: bold;">Employee Name : <span style="color:#be533b;font-weight:bold;border-bottom:1px solid black;">{{$user->first_name}} {{$user->last_name}}</span></p>
                            <p style="text-align: left;font-weight: bold;">Designation : <span style="color:#be533b;font-weight:bold;border-bottom:1px solid black;">{{$confirmationemp->designation}}</span></p>
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
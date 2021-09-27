@extends('admin.layouts.master')

@section('content')

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HRM | HR Policy</title>

@include('admin.layouts.css')

<style type="text/css">
    .card .body{
        background: #ecf0f5 !important;
    }
    p{
        font-weight: bold;
        font-size: 15px;
    }
    .nav-tabs>.nav-item>.nav-link{
        color: #607d8b !important;
    }
</style>

</head>

<body class="theme-blush">

@include('admin.layouts.search')

@include('admin.layouts.menu_sidebar')

@include('admin.layouts.left_sidebar')

@include('admin.layouts.right_sidebar')

<section class="content">
    <div class="body_scroll">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-7 col-md-6 col-sm-12">
                    <h2>HR Policy</h2>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{'dashboard'}}"><i class="zmdi zmdi-home"></i> HRM</a></li>
                        <li class="breadcrumb-item active">HR Policy</li>
                    </ul>
                    <button class="btn btn-primary btn-icon mobile_menu" type="button"><i class="zmdi zmdi-sort-amount-desc"></i></button>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12">                
                    <button class="btn btn-primary btn-icon float-right right_icon_toggle_btn" type="button"><i class="zmdi zmdi-arrow-right"></i></button>
                </div>
            </div>
        </div>

        <div class="row clearfix">
            <div class="col-lg-1 col-md-1 col-sm-1">
            </div>
            <div class="col-lg-10 col-md-10 col-sm-10">
                <div class="card" style="background: #222 !important;">
                    <div class="body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs p-0 mb-3 nav-tabs-success" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#home_with_icon_title"> <i class="zmdi zmdi-city-alt"></i> Bangalore </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#profile_with_icon_title"><i class="zmdi zmdi-city-alt"></i> Mumbai </a></li>
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#messages_with_icon_title"><i class="zmdi zmdi-city-alt"></i> Delhi </a></li>
                        </ul>
                        
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane in active" id="home_with_icon_title">
                                <br/>
                                <br/>
                                <h6 style="color:#be533b;font-weight:bold;">All employees need to strictly adhere to the following:</h6><br/>
                                <p>The reporting time to office is 9:30 am from the date of joining. A 15-minute buffer is allowed. Anyone punching in after 9:45 am will be marked as late arrival for the day.</p>
                                <p>Three late arrivals between 9:45 am and 10:15 am in a month are allowed post which any late arrival will result in you being marked absent for half a day.</p>
                                <p>Any late arrival between 10:15 am & 2:00 pm will be marked as half a day absent.  Any late arrival after 2:00 pm, will be marked as absent for the day.</p>
                                <p>You get 45 minutes for lunch break and two 15-minute short breaks for the day. Lunch time is generally from 1:00 pm to 1:45 pm.</p>
                                <p>From the date of Joining, the attendance will be marked upon punching in only. Please do not enter the office without punching in with the access card and do not exit the office without punching out.</p>
                                <p>You need to punch in at the first floor access door only, in order for the attendance to be marked as present for the day. Punching in at the access doors on the other floors is not acceptable.</p>
                                <p>In case you forget or lose your ID card, you will be marked absent for the day. No reasons will be entertained.</p>
                                <p>In case you forget to punch in, you will be marked absent for the day. No reasons will be entertained, unless you punched in and the punch in card turns out to be faulty. In which case, a mail will have to be sent to your reporting manager/director, updating about the faulty card, for your attendance to be marked as present.</p>
                                <p>In case of loss of ID card, immediately report the same via mail to the HR, marking your reporting manager/director. A fee will be charged for re-issue of the new card and you may collect the access card from the HR on an immediate basis. In case the old ID card is found, it will no longer work for access and you will have to continue using the re-issued access card.</p>
                                <p>No changes to the attendance already marked on the HR application tool will be made at any cost. Hence you are requested to please make sure that meetings, work schedule and leaves in the HR tool are logged in advance, with the necessary approvals. </p>
                                <p>Going for meetings with clients from home directly is permissible for meetings before 11 am. Any meeting after 11 am would require employees to report to office by 9:30 am and then proceed for the meeting. Failure to do so will result in you being marked absent for the day.</p>
                                <p>You are expected to return to work, if the meetings for the day end before 5 pm. Failure to do so will result in you being marked absent for the day.</p>
                                <p>M.O.M. (Minutes of Meet) needs to be uploaded within 24 hours of completion of each meeting. Failure in uploading the same will result in you being marked absent for the day.</p>
                                <p>You are expected to keep your official mobile number switched on and with you at all times during work hours. This includes you carrying the number to meetings and work schedules.</p>
                                <p>Your phone being switched off (including battery dead situation), not being at the meeting or work schedule location within 15 minutes from the scheduled time, will result in you being marked absent for the day. No reasons will be entertained.</p>
                                <p>In case of loss of SIM, immediately write a mail to the HR marking your reporting manager/director in the mail, requesting for a new SIM.</p>
                                <p>If you stay back for work after 9:00 pm, then you can punch in by 11:30 am the next day.  Punching in later than 11:30 am will result in you being marked absent for half a day.</p>
                                <p>Please enter your late working status on the HR Tool between 9:00 pm to 6:00 am, post which the entry will not be accepted and you will not be eligible for late login.</p>
                                <p>Working from home is not allowed.</p>
                                <p>You are requested to take proper permission & approval for comp-offs and any leaves. Comp-off can be claimed only in the same month.</p>
                                <p>2nd and 4th Saturdays are a holiday for the marketing team only. However, if a situation arises where you are expected to come to work, your attendance will be mandatory and this cannot be availed as a comp-off.</p>
                                <p>Saturdays will be regular working days for the Creative, Production and Finance team.</p>
                                <p>If you plan to end your employment with the organisation, then you are required to send a mail to your respective head(s), marking the HR and Bjorn, to get an approval for the same.</p>
                                <p>Full & Final settlement will be completed, only after 45 days from the last working day, once a thorough audit and data verification of the laptop is completed without any violations.</p>
                                <p>If the company data is tampered with in anyway, then you are liable to face legal consequences. The legal team will get in touch with you regarding the same, and Full & Final Settlement will not be completed, pending any penalties owed by you to the company.</p>
                                <p>Hence please ensure that data integrity and privacy is maintained at all times and not violated.</p>
                                <p>Please note that the above mentioned policies are an integral part of the terms of employment with Wings Events. You are expected to adhere to them, and any failure to do so, shall result in prompt disciplinary action.</p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="profile_with_icon_title">
                                <br/>
                                <br/>
                                <h6 style="color:#be533b;font-weight:bold;">All employees need to strictly adhere to the following:</h6><br/>
                                <p>The reporting time to office is 10:00 am from the date of joining. A 15-minute buffer is allowed. Anyone punching in after 10:15 am will be marked as late arrival for the day.</p>
                                <p>Three late arrivals between 10:15 am and 10:30 am in a month are allowed post which any late arrival will result in you being marked absent for half a day.</p>
                                <p>Any late arrival between 10:30 am & 2:30 pm will be marked as half a day absent.  Any late arrival after 2:30 pm, will be marked as absent for the day.</p>
                                <p>You get 45 minutes for lunch break and two 15-minute short breaks for the day. Lunch time is generally from 1:30 pm to 2:15 pm.</p>
                                <p>From the date of Joining, the attendance will be marked upon punching in only. Please do not enter the office without punching in with the access card and do not exit the office without punching out.</p>
                                <p>In case you forget or lose your ID card, you will be marked absent for the day. No reasons will be entertained.</p>
                                <p>In case you forget to punch in, you will be marked absent for the day. No reasons will be entertained, unless you punched in and the punch in card turns out to be faulty. In which case, a mail will have to be sent to your reporting manager/director, updating about the faulty card, for your attendance to be marked as present.</p>
                                <p>In case of loss of ID card, immediately report the same via mail to the HR, marking your reporting manager/director. A fee will be charged for re-issue of the new card and you may collect the access card from the HR on an immediate basis. In case the old ID card is found, it will no longer work for access and you will have to continue using the re-issued access card.</p>
                                <p>No changes to the attendance already marked on the HR application tool will be made at any cost. Hence you are requested to please make sure that meetings, work schedule and leaves in the HR tool are logged in advance, with the necessary approvals.</p>
                                <p>Going for meetings with clients from home directly is permissible for meetings before 11:30 am. Any meeting after 11:30 am would require employees to report to office by 10:00 am and then proceed for the meeting. Failure to do so will result in you being marked absent for the day.</p>
                                <p>You are expected to return to work, if the meetings for the day end before 5:30 pm. Failure to do so will result in you being marked absent for the day.</p>
                                <p>M.O.M. (Minutes of Meet) needs to be uploaded within 24 hours of completion of each meeting. Failure in uploading the same will result in you being marked absent for the day.</p>
                                <p>You are expected to keep your official mobile number switched on and with you at all times during work hours. This includes you carrying the number to meetings and work schedules.</p>
                                <p>Your phone being switched off (including battery dead situation), not being at the meeting or work schedule location within 15 minutes from the scheduled time, will result in you being marked absent for the day. No reasons will be entertained.</p>
                                <p>In case of loss of SIM, immediately write a mail to the HR marking your reporting manager/director in the mail, requesting for a new SIM.</p>
                                <p>If you stay back for work after 9:30 pm, then you can punch in by 12:00 pm the next day. Punching in later than 12:00 pm will result in you being marked absent for half a day.</p>
                                <p>Please enter your late working status on the HR Tool between 9:00 pm to 6:00 am, post which the entry will not be accepted and you will not be eligible for late login.</p>
                                <p>Working from home is not allowed.</p>
                                <p>You are requested to take proper permission & approval for comp-offs and any leaves. Comp-off can be claimed only in the same month.</p>
                                <p>2nd and 4th Saturdays are a holiday for the marketing team only. However, if a situation arises where you are expected to come to work, your attendance will be mandatory and this cannot be availed as a comp-off.
Saturdays will be regular working days for the Creative, Production and Finance team.</p>
                                <p>If you plan to end your employment with the organisation, then you are required to send a mail to your respective head(s), marking the HR and Bjorn, to get an approval for the same.</p>
                                <p>Full & Final settlement will be completed, only after 45 days from the last working day, once a thorough audit and data verification of the laptop is completed without any violations.</p>
                                <p>If the company data is tampered with in anyway, then you are liable to face legal consequences. The legal team will get in touch with you regarding the same, and Full & Final Settlement will not be completed, pending any penalties owed by you to the company.</p>
                                <p>Hence please ensure that data integrity and privacy is maintained at all times and not violated.</p>
                                <p>Please note that the above mentioned policies are an integral part of the terms of employment with Wings Events. You are expected to adhere to them, and any failure to do so, shall result in prompt disciplinary action.</p>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="messages_with_icon_title">
                                <br/>
                                <br/>
                                <h6 style="color:#be533b;font-weight:bold;">All employees need to strictly adhere to the following:</h6><br/>
                                <p>The reporting time to office is 10:00 am from the date of joining. A 15-minute buffer is allowed. Anyone punching in after 10:15 am will be marked as late arrival for the day.</p>
                                <p>Three late arrivals between 10:15 am and 10:30 am in a month are allowed post which any late arrival will result in you being marked absent for half a day.</p>
                                <p>Any late arrival between 10:30 am & 2:30 pm will be marked as half a day absent.  Any late arrival after 2:30 pm, will be marked as absent for the day.</p>
                                <p>You get 45 minutes for lunch break and two 15-minute short breaks for the day. Lunch time is generally from 1:30 pm to 2:15 pm.</p>
                                <p>From the date of Joining, the attendance will be marked upon punching in only. Please do not enter the office without punching in with the access card and do not exit the office without punching out.</p>
                                <p>In case you forget or lose your ID card, you will be marked absent for the day. No reasons will be entertained.</p>
                                <p>In case you forget to punch in, you will be marked absent for the day. No reasons will be entertained, unless you punched in and the punch in card turns out to be faulty. In which case, a mail will have to be sent to your reporting manager/director, updating about the faulty card, for your attendance to be marked as present.</p>
                                <p>In case of loss of ID card, immediately report the same via mail to the HR, marking your reporting manager/director. A fee will be charged for re-issue of the new card and you may collect the access card from the HR on an immediate basis. In case the old ID card is found, it will no longer work for access and you will have to continue using the re-issued access card.</p>
                                <p>No changes to the attendance already marked on the HR application tool will be made at any cost. Hence you are requested to please make sure that meetings, work schedule and leaves in the HR tool are logged in advance, with the necessary approvals.</p>
                                <p>Going for meetings with clients from home directly is permissible for meetings before 11:30 am. Any meeting after 11:30 am would require employees to report to office by 10:00 am and then proceed for the meeting. Failure to do so will result in you being marked absent for the day.</p>
                                <p>You are expected to return to work, if the meetings for the day end before 5:30 pm. Failure to do so will result in you being marked absent for the day.</p>
                                <p>M.O.M. (Minutes of Meet) needs to be uploaded within 24 hours of completion of each meeting. Failure in uploading the same will result in you being marked absent for the day.</p>
                                <p>You are expected to keep your official mobile number switched on and with you at all times during work hours. This includes you carrying the number to meetings and work schedules.</p>
                                <p>Your phone being switched off (including battery dead situation), not being at the meeting or work schedule location within 15 minutes from the scheduled time, will result in you being marked absent for the day. No reasons will be entertained.</p>
                                <p>In case of loss of SIM, immediately write a mail to the HR marking your reporting manager/director in the mail, requesting for a new SIM.</p>
                                <p>If you stay back for work after 9:30 pm, then you can punch in by 12:00 pm the next day. Punching in later than 12:00 pm will result in you being marked absent for half a day.</p>
                                <p>Please enter your late working status on the HR Tool between 9:00 pm to 6:00 am, post which the entry will not be accepted and you will not be eligible for late login.</p>
                                <p>Working from home is not allowed.</p>
                                <p>You are requested to take proper permission & approval for comp-offs and any leaves. Comp-off can be claimed only in the same month.</p>
                                <p>2nd and 4th Saturdays are a holiday for the marketing team only. However, if a situation arises where you are expected to come to work, your attendance will be mandatory and this cannot be availed as a comp-off.
Saturdays will be regular working days for the Creative, Production and Finance team.</p>
                                <p>If you plan to end your employment with the organisation, then you are required to send a mail to your respective head(s), marking the HR and Bjorn, to get an approval for the same.</p>
                                <p>Full & Final settlement will be completed, only after 45 days from the last working day, once a thorough audit and data verification of the laptop is completed without any violations.</p>
                                <p>If the company data is tampered with in anyway, then you are liable to face legal consequences. The legal team will get in touch with you regarding the same, and Full & Final Settlement will not be completed, pending any penalties owed by you to the company.</p>
                                <p>Hence please ensure that data integrity and privacy is maintained at all times and not violated.</p>
                                <p>Please note that the above mentioned policies are an integral part of the terms of employment with Wings Events. You are expected to adhere to them, and any failure to do so, shall result in prompt disciplinary action.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-1">
            </div>
        </div>
    </div>

            
</section>

@include('admin.layouts.js')

</body>

@endsection
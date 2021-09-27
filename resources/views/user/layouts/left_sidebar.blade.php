@php
$User = Auth::user();
$Details = App\UserDetails::where('user_id','=',$User->id)->first();
@endphp
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        <a href="{{'dashboard'}}"><span class="m-l-10" style="color: #be533b;font-weight:bold;">WINGS</span> <span  style="color: #222;font-weight:bold;">EVENTS</span></a>
    </div>
    <div class="menu dropdown">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="#"><img src="{{asset('public/'.$Details->profile_picture)}}" alt="User Logo"></a>
                    <div class="detail">
                        <h4 style="font-size:16px;">{{$User->first_name}} {{$User->last_name}}</h4>
                        <small>{{$Details->designation}}</small>                        
                    </div>
                </div>
            </li>
            <li><a href="{{route('dashboard')}}"><i class="zmdi zmdi-apps"></i><span>Dashboard</span></a></li>
            <li><a href="{{route('profile')}}"><i class="zmdi zmdi-mood"></i><span>Profile</span></a></li>  
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-case"></i><span>Business</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('signupclient')}}">Enter Sign Up</a></li>
                    <li><a href="{{route('additional_signup')}}">Additional Signup</a></li>
                    <li><a href="{{route('signup_list')}}">Total SignUp List</a></li>
                    <li><a href="{{route('billing_list')}}">Total Billing List</a></li>    
                    <li><a href="{{route('split_percentage')}}">Sign Up Percentage List</a></li>
                    <li><a href="{{route('businessrevision')}}">Business Revision</a></li>
                </ul>
            </li>  
            @if($Details->emp_id == 'WEB055')
            <li><a href="{{route('eventbilling')}}"><i class="zmdi zmdi-receipt"></i><span>Billing Report</span></a></li>
            @endif 
            @if($User->user_position == 5)
            <!-- <li><a href="{{route('hr.send_mail')}}"><i class="zmdi zmdi-email"></i><span>Send Mail</span></a> </li>-->
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Employees</span></a>
                <ul class="ml-menu">
                     <li><a href="{{route('hr.user_activation')}}">Employee Activation</a></li>
                    <li><a href="{{route('hr.employeelist')}}">Employees List</a></li>
                    <li><a href="{{route('hr.new_employee_list')}}">Newly Joined List</a></li>
                    <li><a href="{{route('hr.resigned_employee_list')}}">Resigned Employees</a></li>                                      
                </ul>
            </li> 
            @endif  
            @if($Details->emp_id == 'WEB164')
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Upload Attendance</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('attendence')}}">Upload Bangalore Sheet</a></li>
                    <li><a href="{{route('attendence_list')}}">Bangalore Attendance List</a></li>  
                    <li><a href="{{route('bang_mail_attendence')}}">Bangalore Mail Attendance</a></li>  
                    <li><a href="{{route('mumb_attendence')}}">Upload Mumbai Sheet</a></li>
                    <li><a href="{{route('mumb_attendence_list')}}">Mumbai Attendance List</a></li> 
                    <li><a href="{{route('mumb_mail_attendence')}}">Mumbai Mail Attendance</a></li>  
                    <li><a href="{{route('delh_attendence')}}">Upload Delhi Sheet</a></li>
                    <li><a href="{{route('delh_attendence_list')}}">Delhi Attendance List</a></li>    
                    <li><a href="{{route('delh_mail_attendence')}}">Delhi Mail Attendance</a></li>  
                </ul>
            </li> 
            @endif 
            @if($User->user_position == 5 && ($User->branch == 1 || $User->branch == 4 || $User->branch == 6 || $User->branch == 7))   
            <li><a href="{{route('hr.attendence_list')}}"><i class="zmdi zmdi-group-work"></i><span>All Attendance List</span></a></li> 
            @endif   
            @if($User->user_position == 5 && ($User->branch == 2 || $User->branch == 3 || $User->branch == 5 ))
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>All Attendance List</span></a>
                <ul class="ml-menu">
                   <!--  <li><a href="{{route('hr.mum_attendence')}}">Upload Mumbai Sheet</a></li> -->
                    <li><a href="{{route('hr.mum_attendence_list')}}">Mumbai Attendance List</a></li>  
                    <!-- <li><a href="{{route('hr.del_attendence')}}">Upload Delhi Sheet</a></li> -->
                    <li><a href="{{route('hr.del_attendence_list')}}">Delhi Attendance List</a></li>                                                    
                </ul>
            </li>               
            @endif  
            <li><a href="{{route('own_attendence')}}"><i class="zmdi zmdi-group-work"></i><span>Attendance</span></a></li>   
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment"></i><span>Meeting</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('meeting')}}">Add Meeting</a></li>
                    <li><a href="{{route('meeting_list')}}">Meeting History</a></li>     
                    <li><a href="{{route('followup_meeting_list')}}">Followup-Meeting History</a></li>
                    <li><a href="{{route('networking_meeting')}}">Add Networking Meeting</a></li> 
                    <li><a href="{{route('networking_meeting_list')}}">Networking Meeting </a></li>      
                </ul>
            </li>
            <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-folder"></i><span>Work Schedule</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('vendormeeting')}}">Vendor Meeting</a></li>
                    <li><a href="{{route('eventsetup')}}">Event Setup</a></li>
                    <li><a href="{{route('event')}}">Event</a></li>
                    <li><a href="{{route('recce')}}">Recce</a></li>
                    <li><a href="{{route('preeventmeeting')}}">Pre-Event Meeting</a></li>
                    <li><a href="{{ route('delivery') }}">Delivery</a></li>
                    <li><a href="{{ route('dismantle')}}">Dismantle</a></li>
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-walk"></i><span>Leaves</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('leave')}}">Add Leave</a></li>
                    <li><a href="{{route('leave_list')}}">Leave History</a></li>                  
                </ul>
            </li>
            <li><a href="{{route('lateworking')}}"><i class="zmdi zmdi-lamp"></i><span>Late Working</span></a> </li>
            <li><a href="{{route('out_of_station')}}"><i class="zmdi zmdi-car-wash"></i><span>Out Of Station</span></a> </li>   
            <li><a href="{{route('official_document')}}"><i class="zmdi zmdi-labels"></i><span>Official Documents</span></a> </li> 
            @if($User->user_position == 5)      
            <li><a href="{{route('hr.notice')}}"><i class="zmdi zmdi-alert-polygon"></i><span>Notices</span></a> </li>
            <li><a href="{{route('hr.appreciation')}}"><i class="zmdi zmdi-email-open"></i><span>Appreciation Mails</span></a> </li>
            <li><a href="{{route('hr.holiday')}}"><i class="zmdi zmdi-calendar-note"></i><span>Holidays</span></a> </li> 
            @endif
            @if($User->user_position != 5)   
            <li><a href="{{route('notice_list')}}"><i class="zmdi zmdi-alert-polygon"></i><span>Notices</span></a> </li>
            <li><a href="{{route('newappriciation')}}"><i class="zmdi zmdi-email-open"></i><span>Appreciation Mails</span></a> </li>
            <li><a href="{{route('wings_holidayslist')}}"><i class="zmdi zmdi-calendar-note"></i><span>Holidays</span></a> </li>  
            @endif         
            <li><a href="{{route('hr_policy')}}"><i class="zmdi zmdi-labels"></i><span>HR Policies</span></a> </li>
            <li><a href="{{route('aup')}}"><i class="zmdi zmdi-dns"></i><span>AUP</span></a> </li>    
        </ul>
    </div>
</aside>
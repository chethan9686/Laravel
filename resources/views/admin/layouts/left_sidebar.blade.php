@php
$User = Auth::user();
@endphp
<!-- Left Sidebar -->
<aside id="leftsidebar" class="sidebar">
    <div class="navbar-brand">
        <button class="btn-menu ls-toggle-btn" type="button"><i class="zmdi zmdi-menu"></i></button>
        @if($User->id == 1 || $User->id == 2 || $User->id == 3)
        <a href="{{'dashboard'}}"><span class="m-l-10" style="color: #be533b;font-weight:bold;">WINGS</span> <span  style="color: #222;font-weight:bold;">EVENTS</span></a>
        @else
        <a href="{{'#'}}"><span class="m-l-10" style="color: #be533b;font-weight:bold;">WINGS</span> <span  style="color: #222;font-weight:bold;">EVENTS</span></a>
        @endif
    </div>
    <div class="menu dropdown">
        <ul class="list">
            <li>
                <div class="user-info">
                    <a class="image" href="#"><img src="{{ asset('public/'.$User->profile_picture)}}" alt="User"></a>
                    <div class="detail">
                        <h4>{{$User->name}}</h4>
                        @if($User->id == 1)
                        <small>Cheif Operating Officer</small>  
                        @elseif($User->id == 2)
                        <small>Chief Financial Officer</small> 
                        @elseif($User->id == 3)
                        <small>Chairman & Managing Director</small> 
                        @endif
                    </div>
                </div>
            </li>
            @if($User->id == 1)
            <li><a href="{{route('admin.dashboard')}}"><i class="zmdi zmdi-apps"></i><span>Dashboard</span></a></li>
            <li><a href="{{route('admin.profile')}}"><i class="zmdi zmdi-mood"></i><span>Profile</span></a></li>
            <li><a href="{{route('admin.eventfeamount')}}"><i class="zmdi zmdi-receipt"></i><span>FE Amount</span></a></li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-case"></i><span>Business</span></a>
                <ul class="ml-menu">                     
                    <li><a href="{{route('admin.view_business')}}">Total Sign Up History</a></li>
                    <li><a href="{{route('admin.view_billing')}}">Total Billing History</a></li>  
                    <li><a href="{{route('admin.view-businessrevision')}}">Business Revision History</a></li>    
                                                                 
                </ul>
            </li>     
           
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Employees</span></a>
                <ul class="ml-menu">
                     <li><a href="{{route('admin.user_activation')}}">Employee Activation</a></li>
                    <li><a href="{{route('admin.employeelist')}}">Employees List</a></li>
                    <li><a href="{{route('admin.new_employee_list')}}">Newly Joined List</a></li>
                    <li><a href="{{route('admin.resigned_employee_list')}}">Resigned Employees</a></li>                                      
                </ul>
            </li>
            <!--<li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Attendance</span></a>
                <ul class="ml-menu">
                     <li><a href="{{route('admin.bangalore_attendence_list')}}">Bangalore Attendance</a></li>
                    <li><a href="{{route('admin.mumbai_attendence_list')}}">Mumbai Attendance</a></li>
                    <li><a href="{{route('admin.delhi_attendence_list')}}">Delhi Attendance</a></li>                                                        
                </ul>
            </li>-->
             <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-bookmark"></i><span>Meeting</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('admin.meeting')}}">Meeting History</a></li>
                    <li><a href="{{route('admin.networking_meeting')}}">Networking Meeting </a></li>      
                    <li><a href="{{route('admin.followup_meeting')}}">Follow-Up Meeting </a></li>                                                             
                </ul>
            </li>
            <!--<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-view-list"></i><span>Work Schedule</span></a>
                <ul class="ml-menu">
                    <li><a href="{{ route('admin.vendormeeting')}}">Vendor Meeting</a></li>
                    <li><a href="{{ route('admin.eventsetup')}}">Event Setup</a></li>
                    <li><a href="{{ route('admin.event') }}">Event</a></li>
                    <li><a href="{{ route('admin.recce')}}">Recce</a></li>
                    <li><a href="{{ route('admin.preeventmeeting')}}">Pre-Event Meeting</a></li>
                    <li><a href="{{ route('admin.delivery')}}">Delivery</a></li>
                    <li><a href="{{ route('admin.dismantle')}}">Dismantle</a></li>
                </ul>
            </li>-->
            <li> <a href="{{route('admin.leaves_list')}}"><i class="zmdi zmdi-walk"></i><span>Leaves</span></a> </li>
            <!--<li><a href="{{route('admin.lateworking')}}"><i class="zmdi zmdi-lamp"></i><span>Late Working</span></a> </li>-->
            <li><a href="{{route('admin.out_of_station')}}"><i class="zmdi zmdi-car-wash"></i><span>Out Of Station</span></a> </li>
            <li><a href="{{route('admin.department')}}"><i class="zmdi zmdi-assignment"></i><span>Departments</span></a> </li>
            <li><a href="{{route('admin.notice')}}"><i class="zmdi zmdi-alert-polygon"></i><span>Notices</span></a> </li>
            <li><a href="{{route('admin.appreciation')}}"><i class="zmdi zmdi-email"></i><span>Appreciation Mail's</span></a> </li>
            <li><a href="{{route('admin.holiday')}}"><i class="zmdi zmdi-calendar-note"></i><span>Holiday's</span></a> </li>           
            <li><a href="{{route('admin.hr_policy')}}"><i class="zmdi zmdi-labels"></i><span>HR Policy</span></a> </li>
            <li><a href="{{route('admin.aup')}}"><i class="zmdi zmdi-dns"></i><span>AUP</span></a> </li>  
            @elseif($User->id == 2 || $User->id == 3)  
            <li><a href="{{route('admin.dashboard')}}"><i class="zmdi zmdi-apps"></i><span>Dashboard</span></a></li>
            @if($User->id == 2)
            <li><a href="{{route('admin.eventfeamount')}}"><i class="zmdi zmdi-receipt"></i><span>FE Entry</span></a></li>
            @endif
            <li><a href="{{route('admin.profile')}}"><i class="zmdi zmdi-mood"></i><span>Profile</span></a></li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-case"></i><span>Business</span></a>
                <ul class="ml-menu">                     
                    <li><a href="{{route('admin.view_business')}}">Total Sign Up History</a></li>
                    <li><a href="{{route('admin.view_billing')}}">Total Billing History</a></li>                                                    
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Employees</span></a>
                <ul class="ml-menu">                   
                    <li><a href="{{route('admin.employeelist')}}">Employees List</a></li>                                                      
                </ul>
            </li>
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-bookmark"></i><span>Meeting</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('admin.meeting')}}">Meeting History</a></li>
                    <li><a href="{{route('admin.networking_meeting')}}">Networking Meeting </a></li>                                                               
                </ul>
            </li>
            @elseif($User->id == 6)
             <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-group-work"></i><span>Employees</span></a>
                <ul class="ml-menu">
                    <li><a href="{{route('admin.employeelist')}}">Employees List</a></li>                                   
                </ul>
            </li>  
            @else
            <li><a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-case"></i><span>Business</span></a>
                <ul class="ml-menu">                     
                    <li><a href="{{route('admin.view_business')}}">Sign Up History</a></li>
                    <li><a href="{{route('admin.view_billing')}}">Billing History</a></li>                                                    
                </ul>
            </li>
            @endif
    </div>
</aside>
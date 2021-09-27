<!-- Right Icon menu Sidebar -->
<div class="navbar-right">
    <ul class="navbar-nav">
        <li style="visibility:hidden;"><a href="#search" class="main_search" title="Search..."><i class="zmdi zmdi-search"></i></a></li>
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="App" data-toggle="dropdown" role="button"><i class="zmdi zmdi-apps"></i></a>
            <ul class="dropdown-menu slideUp2">
                <li class="header" style="text-align:center;">App Shortcut</li>
                <li class="body">
                    <ul class="menu app_sortcut list-unstyled">
                        <li>
                            <a href="{{'profile'}}">
                                <div class="icon-circle mb-2 bg-blue"><i class="zmdi zmdi-pin-account"></i></div>
                                <p class="mb-0">Profile</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{'dashboard'}}">
                                <div class="icon-circle mb-2 bg-amber"><i class="zmdi zmdi-view-dashboard"></i></div>
                                <p class="mb-0">Dashboard</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{'meeting-list'}}">
                                <div class="icon-circle mb-2 bg-pink"><i class="zmdi zmdi-calendar-check"></i></div>
                                <p class="mb-0">Meetings</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{'leave-list'}}">
                                <div class="icon-circle mb-2 bg-green"><i class="zmdi zmdi-calendar"></i></div>
                                <p class="mb-0">Leaves</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{'out-of-station'}}">
                                <div class="icon-circle mb-2 bg-purple"><i class="zmdi zmdi-flight-takeoff"></i></div>
                                <p class="mb-0">OS</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{'attendence'}}">
                                <div class="icon-circle mb-2 bg-red"><i class="zmdi zmdi-male-female"></i></div>
                                <p class="mb-0">Attendance</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li class="dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle" title="Notifications" data-toggle="dropdown" role="button"><i class="zmdi zmdi-notifications"></i>
                <div class="notify"><span class="heartbit"></span><span class="point"></span></div>
            </a>
            <ul class="dropdown-menu slideUp2">
                <li class="header">Notifications</li>
                <li class="body">
                    <ul class="menu list-unstyled">
                        <li>
                            <a href="javascript:void(0);">
                                <div class="icon-circle bg-blue"><i class="zmdi zmdi-account"></i></div>
                                <div class="menu-info">
                                    <h4>8 New Members joined</h4>
                                    <p><i class="zmdi zmdi-time"></i> 14 mins ago </p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="footer"> <a href="javascript:void(0);">View All Notifications</a> </li>
            </ul>
        </li>
        <li>
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();" class="btn btn-danger btn-flat btn-danger-logout" style="background: #e47297;color: #fff;"><i class="zmdi zmdi-power"></i></a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
        </li>
    </ul>
</div>
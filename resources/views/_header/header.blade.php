<header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a id="menuToggle" class="menutoggle"><i class="fas fa-bars"></i></a>
                    <a class="navbar-brand" href="{{ route('dashboard') }}">
                        @isset (Session::get('user_info')->userGym->gym_logo)
                            <img src="{{asset('assets/gym_logo') .'/'. Session::get('user_info')->userGym->gym_logo}}" alt="Logo" class="rounded-circle">
                        @endisset
                        <span class="title_name align-middle ml-2">{{ ucfirst(Session::get('user_info')->userGym->gym_name) }}</span>
                    </a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    
                <!--
                	<div class="header_middle">
                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('enquiry_add', Session::get('app_features')))
                                <span><a href="{{ route('add_enquiry') }}" class="btn btn-info btn-sm mr-2">Enquiry</a></span> 
                            @endif
                        @else
                            <span><a href="{{ route('add_enquiry') }}" class="btn btn-info btn-sm mr-2">Enquiry</a></span> 
                        @endif

                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('enquiry_add', Session::get('app_features')))
                                <span><a href="{{ route('add_customer') }}" class="btn btn-info btn-sm mr-2">Member</a></span>
                            @endif
                        @else
                            <span><a href="{{ route('add_customer') }}" class="btn btn-info btn-sm mr-2">Member</a></span>
                        @endif

                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('enquiry_add', Session::get('app_features')))
                                <span><a href="{{ route('customer_attendance') }}" class="btn btn-info btn-sm mr-2">Attendance</a></span> 
                            @endif
                        @else
                            <span><a href="{{ route('customer_attendance') }}" class="btn btn-info btn-sm mr-2">Attendance</a></span>
                        @endif

                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('enquiry_add', Session::get('app_features')))
                                <span><a href="{{ route('customer_payment') }}" class="btn btn-info btn-sm mr-2">Payment</a></span> 
                            @endif
                        @else
                            <span><a href="{{ route('customer_payment') }}" class="btn btn-info btn-sm mr-2">Payment</a></span>
                        @endif

                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('enquiry_add', Session::get('app_features')))
                                <span><a href="{{ route('create_package') }}" class="btn btn-info btn-sm mr-2">Packages</a></span> 
                            @endif
                        @else
                            <span><a href="{{ route('create_package') }}" class="btn btn-info btn-sm mr-2">Packages</a></span>
                	    @endif
                    </div> 
                -->

                    <div class="header-left">

                        <ul class="list-unstyled topbar-right-menu float-right mb-0">
                            <li class="dropdown notification-list d-sm-inline-block">
                                <a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="fas fa-th" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated dropdown-lg p-0" style="min-width: 20rem">

                                    <div class="p-2">
                                        <div class="row no-gutters">
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{route('showall_enquiry')}}">
                                                    <i class="fas fa-hands-helping" aria-hidden="true">
                                                    </i>
                                                    <span>Enquiry</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{route('customer_list')}}">
                                                    <i class="fas fa-users"></i>
                                                    <span>Member</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{route('customer_attendance')}}">
                                                    <i class="menu-icon fas fa-calendar-alt"></i>
                                                    <span>Attendance</span>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row no-gutters">
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{route('customer_payment')}}">
                                                    <i class="fas fa-money-bill-wave"></i>
                                                    <span>Payments</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="{{route('create_package')}}">
                                                    <i class="menu-icon fas fa-cubes"></i>
                                                    <span>Package</span>
                                                </a>
                                            </div>
                                            <div class="col">
                                                <a class="dropdown-icon-item" href="#">
                                                    <i class="fas fa-file-alt"></i>
                                                    <span>Reports</span>
                                                </a>
                                            </div>
            
                                        </div>
                                    </div>

                                </div>
                            </li>

                            <li class="dropdown notification-list">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell"></i>
                                    <span class="count bg-danger">@if(Auth::check()) {{Auth::user()->notifications->count()}} @endif</span>
                                </button>
                                @php
                                    $date = date_create(NULL, timezone_open('Asia/Kolkata'));
                                    $day = date_format($date, 'Y-m-d H:i:s');
                                    $timestamp = strtotime($day);
                                    $currentDate = date('Y-m-d', $timestamp);
                                @endphp
    
                                @if (Auth::user()->notifications->count() > 0)
                                    <div class="dropdown-menu" aria-labelledby="notification">
                                        @foreach (Auth::user()->notifications as $element)
                                             <a class="dropdown-item media" href="#">
                                                @if ($element->data['exp'] == 'expiring')
    
                                                    <i class="fa fa-check"></i>
                                                    <p>{!! ucfirst($element->data['name'])."'s Membership is expiring in 5 days. <br>Username: ".$element->data['username']." and Phone no: ".$element->data['phone'] !!}</p>
    
                                                @elseif($element->data['exp'] == 'expired')
    
                                                    <i class="fa fa-check"></i>
                                                    <p>{!! ucfirst($element->data['name'])."'s Membership is expired. <br>Username: ".$element->data['username']." and Phone no: ".$element->data['phone'] !!}</p>
    
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                                
    
                            </li>
                        </ul>





                        {{-- <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-th" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" id="menus_list">
                                <div class="d-flex justify-content-between bg-secondary mb-3">
                                    <div class="p-2 bg-info">Flex</div>
                                    <div class="p-2 bg-warning">Flex</div>
                                    <div class="p-2 bg-primary">Flex</div>
                                </div>
                                <div class="d-flex justify-content-between bg-secondary mb-3">
                                    <div class="p-2 bg-info">Flex</div>
                                    <div class="p-2 bg-warning">Flex</div>
                                    <div class="p-2 bg-primary">Flex</div>
                                </div>
                                <div class="d-flex justify-content-between bg-secondary mb-3">
                                    <div class="p-2 bg-info">Flex</div>
                                    <div class="p-2 bg-warning">Flex</div>
                                    <div class="p-2 bg-primary">Flex</div>
                                </div>
                            </div>
                        </div> --}}

                        

                        
                    </div>

                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @php
                                $pImg = auth()->user()->profile_image;
                            @endphp
                            @if (isset($pImg))
                                <img class="user-avatar rounded-circle" src="{{asset('assets/user_image') .'/'. $pImg}}" alt="User Avatar">
                            @else
                                <img class="user-avatar rounded-circle" src="{{asset('assets/images/avatar/avatar_2.png')}}" alt="User Avatar">
                            @endif
                        </a>

                        <div class="user-menu dropdown-menu">
                            <a class="nav-link" href="{{ route('add_gym') }}"><i class="fa fa- user"></i>My Profile</a>
                            <a class="nav-link" href="{{ route('setting_page') }}"><i class="fa fa- user"></i>Settings</a>

                            {{-- <a class="nav-link" href="#"><i class="fa fa- user"></i>Notifications <span class="count">13</span></a> --}}

                            {{-- <a class="nav-link" href="#"><i class="fa fa -cog"></i>Settings</a> --}}

                            {{-- <a class="nav-link" href="{{ route('logout') }}"><i class="fa fa-power -off"></i>Logout</a> --}}
                            <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-power -off"></i>Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
</header>

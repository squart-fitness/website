<header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
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

                    <div class="header-left">
                       {{--  <button class="search-trigger"><i class="fa fa-search"></i></button>
                        <div class="form-inline">
                            <form class="search-form">
                                <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                                <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                            </form>
                        </div> --}}

                        <div class="dropdown">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-th" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" id="menus_list">
                                {{-- <a class="dropdown-item" href="#">Link 1</a>
                                <a class="dropdown-item" href="#">Link 2</a>
                                <a class="dropdown-item" href="#">Link 3</a> --}}
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
                        </div>

                        <div class="dropdown for-notification">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-bell"></i>
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
                                            <p>
                                                Due date of {{ucfirst($element->data['name'])}} is {{date("Y-m-d", strtotime($element->data['package_end_date']))}}. <br>Having phone {{$element->data['phone']}}
                                            </p>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                            

                        </div>
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

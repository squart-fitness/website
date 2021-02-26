<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('dashboard', Session::get('app_features')))
                                <a href="{{ route('dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a> 
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
                        @endif
                    </li>

                    {{-- <li><a href="{{ route('add_gym') }}"><i class="menu-icon fa fa-table"></i>My GYM</a></li> --}}
                    


                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-question-circle-o" aria-hidden="true"></i>Enquiry</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            {{-- <li><i class="fa fa-table"></i><a href="{{ route('add_gym') }}">Add GYM</a></li> --}}
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('add_enquiry') }}">Add Enquiry</a></li>
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('showall_enquiry') }}">Enquiry Detail</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-cogs"></i>Member</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('add_customer') }}">Add Member</a></li>
                            <li><i class="fa fa-id-badge"></i><a href="{{ route('customer_list') }}">Member List</a></li>
                            <li><i class="fa fa-bars"></i><a href="{{ route('customer_attendance') }}">Attendance</a></li>

                            <li><i class="fa fa-id-card-o"></i><a href="{{ route('customer_payment') }}">Make Payment</a></li>
                            <li><i class="fa fa-id-card-o"></i><a href="{{ route('customer_payment_details') }}">Payment Details</a></li>

                            {{-- <li><i class="fa fa-exclamation-triangle"></i><a href="ui-alerts.html">Alerts</a></li>
                            <li><i class="fa fa-spinner"></i><a href="ui-progressbar.html">Progress Bars</a></li>
                            <li><i class="fa fa-fire"></i><a href="ui-modals.html">Modals</a></li>
                            <li><i class="fa fa-book"></i><a href="ui-switches.html">Switches</a></li>
                            <li><i class="fa fa-th"></i><a href="ui-grids.html">Grids</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="ui-typgraphy.html">Typography</a></li> --}}
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-question-circle-o" aria-hidden="true"></i>Diets</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('assign_diet') }}">Assign Diet</a></li>
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('show_assigned_diet') }}">Show Assigned Diet</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fa fa-question-circle-o" aria-hidden="true"></i>Workout</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('assign_workout') }}">Assign Workout</a></li>
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('show_assigned_workout') }}">Show Assigned Workout</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Employee</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="{{ route('add_employee') }}">Add Employee</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ route('employee_list') }}">Employee List</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ route('employee_salary') }}">Employee Salary</a></li>
                            <li><i class="fa fa-table"></i><a href="{{ route('employee_salary_details') }}">Salary Details</a></li>

                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Create</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="{{ route('create_diet_plan') }}">Diet Plan</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="{{ route('create_workout_plan') }}">Create Workout Plan</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="{{ route('create_package') }}">Packages</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="{{ route('batch') }}">Batch</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Reports</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="{{ route('enquiry_convergence_report') }}">Convergence</a></li>
                        </ul>
                    </li>

                    {{-- <li class="menu-title">Icons</li><!-- /.menu-title --> --}}

                    {{-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Post</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="{{ route('make_post') }}">Make Post</a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="{{ route('view_post') }}">View Post</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Listing</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-line-chart"></i><a href="{{ route('create_listing') }}">Make Listing</a></li>
                            <li><i class="menu-icon fa fa-area-chart"></i><a href="{{ route('listing_offer') }}">Create Offer</a></li>
                            <li><i class="menu-icon fa fa-pie-chart"></i><a href="{{ route('listing_machine_types') }}">Add machines types</a></li>
                        </ul>
                    </li> --}}
                    {{-- <li>
                        <a href="widgets.html"> <i class="menu-icon ti-email"></i>Widgets </a>
                    </li> --}}
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
</aside>
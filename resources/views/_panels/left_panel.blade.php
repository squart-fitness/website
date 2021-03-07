<aside id="left-panel" class="left-panel">
        <nav class="navbar navbar-expand-sm navbar-default">
            <div id="main-menu" class="main-menu collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        {{-- checking employee auth and permission for routes --}}
                        @if (auth('employee')->check())
                            @if (Session::has('app_features') && in_array('dashboard', Session::get('app_features')))
                                <a href="{{ route('dashboard') }}"><i class="menu-icon fas fa-home"></i>Dashboard </a> 
                            @endif
                        @else
                            <a href="{{ route('dashboard') }}"><i class="menu-icon fas fa-home"></i>Dashboard </a>
                        @endif
                    </li>

                    {{-- <li><a href="{{ route('add_gym') }}"><i class="menu-icon fa fa-table"></i>My GYM</a></li> --}}
                    


                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fas fa-hands-helping" aria-hidden="true"></i>Enquiry</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            {{-- <li><i class="fa fa-table"></i><a href="{{ route('add_gym') }}">Add GYM</a></li> --}}
                            <li><i class="fas fa-user-plus"></i><a href="{{ route('add_enquiry') }}">Add Enquiry</a></li>
                            <li><i class="fas fa-list-ol"></i><a href="{{ route('showall_enquiry') }}">Enquiry Detail</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-users"></i>Members</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="fas fa-user-plus"></i><a href="{{ route('add_customer') }}">Add Member</a></li>
                            <li><i class="fas fa-id-badge"></i><a href="{{ route('customer_list') }}">Member List</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-calendar-alt"></i>Attendance</a>
                        <ul class="sub-menu children dropdown-menu">                            
                            <li><i class="menu-icon fas fa-calendar-plus"></i><a href="{{ route('customer_attendance') }}">Create Attendance</a></li>
                            <li><i class="menu-icon fas fa-calendar-minus"></i><a href="{{ route('customer_attendance') }}">Attendance List</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fas fa-utensils" aria-hidden="true"></i>Diets</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            <li><i class="menu-icon fas fa-folder-plus"></i><a href="{{ route('create_diet_plan') }}">Create Diet Plan</a></li>
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('assign_diet') }}">Assign Diet</a></li>
                            <li><i class="fa fa-puzzle-piece"></i><a href="{{ route('show_assigned_diet') }}">Show Assigned Diet</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="menu-icon fas fa-running" aria-hidden="true"></i>Workout</a>
                        <ul class="sub-menu children dropdown-menu" style="background-color: transparent;">
                            <li><i class="menu-icon fas fa-dumbbell"></i><a href="{{ route('create_workout_plan') }}">Create Workout Plan</a></li>
                            <li><i class="fas fa-puzzle-piece"></i><a href="{{ route('assign_workout') }}">Assign Workout</a></li>
                            <li><i class="fas fa-hockey-puck"></i><a href="{{ route('show_assigned_workout') }}">Show Assigned Workout</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-user-tie"></i>Employee</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fas fa-user-plus"></i><a href="{{ route('add_employee') }}">Add Employee</a></li>
                            <li><i class="fas fa-clipboard-list"></i><a href="{{ route('employee_list') }}">Employee List</a></li>
                            <li><i class="fas fa-wallet"></i><a href="{{ route('employee_salary') }}">Employee Salary</a></li>
                            <li><i class="fas fa-coins"></i><a href="{{ route('employee_salary_details') }}">Salary Details</a></li>

                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-money-bill-wave"></i>Payments</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fas fa-hand-holding-usd"></i><a href="{{ route('customer_payment') }}">Make Payment</a></li>
                            <li><i class="fas fa-receipt"></i><a href="{{ route('customer_payment_details') }}">Payment Details</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-cubes"></i>Packages</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fas fa-archive"></i><a href="{{ route('create_package') }}">Create Packages</a></li>
                            <li><i class="menu-icon fas fa-user-plus"></i><a href="{{ route('assign_package') }}">Package Assign</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-object-ungroup"></i>Batches</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fas fa-plus-circle"></i><a href="{{ route('batch') }}">Create Batch</a></li>
                            <li><i class="menu-icon fas fa-user-plus"></i><a href="{{ route('assign_batch') }}">Batch Assign</a></li>
                            {{-- <li><i class="menu-icon fas fa-list-ul"></i><a href="{{ route('batch') }}">Batch List</a></li> --}}
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fas fa-chart-pie"></i>Reports</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fas fa-chart-bar"></i><a href="{{ route('enquiry_convergence_report') }}">Convergence</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
</aside>
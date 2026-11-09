<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
        </li>

        <li class="nav-header">Manage Department</li>
        <li class="nav-item {{ request()->is('departments') || request()->is('staffs*')|| request()->is('staff/attendance*')  ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('departments') || request()->is('staffs*')|| request()->is('staff/attendance*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-building"></i>
                <p>

                    Department

                    <i class="right fas fa-angle-left"></i>
                    {{--                        <span class="right badge badge-info">2</span>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('departments.index') }}" class="nav-link {{ request()->is('departments') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Department List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staffs.index') }}" class="nav-link {{ request()->is('staffs') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Staff List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staffAttendance.index') }}" class="nav-link {{ request()->is('staff/attendance') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Staff Attendance</p>
                    </a>
                </li>
            </ul>

        </li>


        <li class="nav-header">{{ __('Accounting Section') }}</li>
        @php
            $isAccountingActive = request()->is('accounting*') || 
                                 request()->is('fee_receipt*') || request()->is('fee-receipt*') || 
                                 request()->is('purchase_req*') || request()->is('purchase-req*');
        @endphp
        <li class="nav-item {{ $isAccountingActive ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ $isAccountingActive ? 'active' : '' }}">
                <i class="nav-icon fas fa-file-invoice-dollar"></i>
                <p>
                    {{ __('Accounting') }}
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('accounting.index') }}" class="nav-link {{ request()->is('accounting') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Accounting Hub') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fee_receipt.index') }}" class="nav-link {{ request()->is('fee_receipt*') || request()->is('fee-receipt*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Fee Receipts & Billing') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('purchase_req.index') }}" class="nav-link {{ request()->is('purchase_req*') || request()->is('purchase-req*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Purchase Requests') }}</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">Manage Class</li>
        <li class="nav-item {{ request()->is('class') || request()->is('sections') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('class') || request()->is('sections') ? 'active' : '' }}">
                <i class="nav-icon fas fa-university"></i>
                <p>

                    Class

                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('class.index') }}" class="nav-link {{ request()->is('class') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manage Classes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('sections.index') }}" class="nav-link {{ request()->is('sections') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manage Sections</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('classesSubject') }}" class="nav-link {{ request()->is('classes-subject') ? 'active' : '' }}" onclick="showOverlay()">
                <i class="nav-icon fas fa-book-open"></i>
                <p>
                    Subject
                </p>
            </a>
        </li>

        <li class="nav-item {{ request()->is('class-routines') || request()->is('class-routines/*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="{{ route('class_routines.show_classes') }}" class="nav-link {{ request()->is('class-routines') || request()->is('class-routines/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-calendar-alt"></i>
                <p>
                    Class Routine
                </p>
            </a>
        </li>

        <li class="nav-header">Student Section</li>
        <li class="nav-item {{ Request::is('sessions') || Request::is('students*')|| Request::is('marks*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('sessions') || Request::is('students*') || Request::is('marks*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>

                    Student Section

                    <i class="right fas fa-angle-left"></i>
                    {{--                                <span class="right badge badge-info">5</span>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admissions.list') }}" class="nav-link {{ Request::is('admissions*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Admissions List') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('students.index')}}" class="nav-link {{ Request::is('students') || Request::is('students/create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Admit Student') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('students.info') }}" class="nav-link {{ Request::is('students/info*') || Request::is('students/information*') || Request::is('students/class/*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ __('Student Information') }}</p>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-header">Notifications</li>
        <li class="nav-item {{ request()->is('Userinbox') || request()->is('inbox') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('Userinbox') || request()->is('inbox') ? 'active' : '' }}">
                <i class="nav-icon far fa-envelope"></i>
                <p>
                    Message
                    <i class="right fas fa-angle-left"></i>
                    <span id="notification-badge" class="right badge badge-info navbar-badge" style="display: none">0</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('message.inbox') }}" class="nav-link {{ request()->is('inbox') || request()->is('Userinbox') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inbox</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header text-uppercase mt-2" style="font-size: 0.68rem; letter-spacing: 0.08em; opacity: 0.7;">{{ __('Account & Settings') }}</li>
        <li class="nav-item">
            <a href="{{ route('user.profile') }}" class="nav-link {{ request()->is('user-profile*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-circle"></i>
                <p>{{ __('My Profile') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="/logout" class="nav-link logout-btn">
                <i class="fas fa-sign-out-alt nav-icon text-danger"></i>
                <p class="font-weight-bold">{{ __('Logout') }}</p>
            </a>
        </li>

    </ul>
</nav>

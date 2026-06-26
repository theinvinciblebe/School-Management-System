<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" onclick="showOverlay()">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <span class="right badge badge-danger">New</span>
                </p>
            </a>
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
            <a href="{{ route('classesSubject') }}" class="nav-link {{ request()->is('classes-subject') || request()->is('subjects/*') ? 'active' : '' }}" onclick="showOverlay()">
                <i class="nav-icon fas fa-book-open"></i>
                <p>
                    Subject
                    <span class="right badge badge-danger">New</span>
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
        <li class="nav-item {{ request()->is('myClass*') || request()->is('getSubject/*') || request()->is('class/materials/*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="{{ route('myClass.index') }}" class="nav-link {{ request()->is('myClass*') || request()->is('getSubject/*')|| request()->is('class/materials/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                    Class Material
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

        <li class="nav-header">Accounting Section</li>
        <li class="nav-item {{ request()->is('accounting') ? 'menu-is-opening menu-open' : '' }}">
            <a href="/accounting" class="nav-link {{ request()->is('accounting') || request()->is('purchase_req*')|| request()->is('fee_receipt*') ? 'active' : '' }}" onclick="showOverlay()">
                <i class="nav-icon fas fa-newspaper"></i>
                <p>
                    Accounting
                </p>
            </a>
        </li>


        <li class="nav-header">Parent Infomation</li>
        <li class="nav-item" >
            <a href="{{ route('parents.index') }}" class="nav-link {{ request()->is('parents') ? 'active' : '' }}">
                <i class="nav-icon fas fa-house-user"></i>
                <p>
                    Parents

                </p>
            </a>
        </li>
        <li class="nav-header">Manage Student</li>
        <li class="nav-item {{ Request::is('sessions') || Request::is('students*')|| Request::is('admissions')|| Request::is('marks*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('sessions') || Request::is('students*') || Request::is('marks*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>

                    Student Section

                    <i class="right fas fa-angle-left"></i>
                    {{--                        <span class="right badge badge-info">5</span>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('sessions.index')}}" class="nav-link {{ Request::is('sessions') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>

                        <p>Academic Session</p>

                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admissions.list')}}" class="nav-link {{ Request::is('admissions') || Request::is('admissions/store') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Student Admission List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('students.index')}}" class="nav-link {{ Request::is('students') || Request::is('students/create') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Admit Student</p>
                    </a>
                </li>
                <li class="nav-item {{ Request::is('students/class/*') ? 'menu-is-opening menu-open' : ''}}">
                    <a href="#" class="nav-link {{ Request::is('students/class/*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Student Information
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($classes as $class)
                            <li class="nav-item">
                                <a href="{{ route('students.byClass', ['class_id' => $class->class_id]) }}"
                                   class="nav-link {{ request()->is('students/class/'.$class->class_id) ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>{{ $class->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>


                <li class="nav-item {{ Request::is('marks/class/*') ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('marks/class/*') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>
                            Student Marksheet
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @foreach($classes as $class)
                            <li class="nav-item">
                                <a href="{{ route('marks.byClass', ['class_id' => $class->class_id]) }}"
                                   class="nav-link {{ request()->is('marks/class/'.$class->class_id) ? 'active' : '' }}">
                                    <i class="far fa-dot-circle nav-icon"></i>
                                    <p>{{ $class->name }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

            </ul>
        </li>
        <li class="nav-header">Manage Teacher</li>
        <li class="nav-item">
            <a href="{{route('teachers.index')}}" class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>
                    Teacher Section
                </p>
            </a>
        </li>

        <li class="nav-header">Attendance Manage</li>
        <li class="nav-item">
            <a href="{{ route('attendance.requestList')}}"
               class="nav-link {{ Request::is('attendance/request-list*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                    Request from Teacher
                </p>
            </a>
        </li>
        @if (!empty($defaultClassId))
            <li class="nav-item">
                <a href="{{ route('attendance.show', $defaultClassId) }}"
                   class="nav-link {{ Request::is('attendance/class*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-poll"></i>
                    <p>Daily Attendance</p>
                </a>
            </li>
        @endif

        <li class="nav-header">Exam Manage</li>
        <li class="nav-item {{ Request::is('exams*') ||Request::is('grades*')||Request::is('manage-exam-marks*') ? 'menu-is-opening menu-open' : '' }}">
        <li class="nav-item {{ Request::is('exams*') ||Request::is('grades*')||Request::is('manage-exam-marks*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('exams*') ||Request::is('grades*')||Request::is('manage-exam-marks*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>

                    Exam Section

                    <i class="right fas fa-angle-left"></i>
                    {{--                        <span class="right badge badge-info">3</span>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('exams_list.index')}}" class="nav-link {{ Request::is('exams*')? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>

                        <p>Exam List</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('exams_grade.index')}}" class="nav-link {{ Request::is('grades*')? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Exam Grades</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('exam_marks.index') }}" class="nav-link {{ Request::is('manage-exam-marks*')? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>

                        <p>Manage Marks</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">Messages</li>
        <li class="nav-item {{ request()->is('inbox') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->is('inbox') ? 'active' : '' }}">
                <i class="nav-icon far fa-envelope"></i>
                <p>

                    Message

                    <i class="right fas fa-angle-left"></i>
                    <span id="notification-badge" class="right badge badge-info" style="display: none;">0</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{ route('message.inbox') }}" class="nav-link {{ request()->is('inbox') ? 'active' : '' }}" onclick="showOverlay()">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Inbox</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">Upload & Access File</li>
        <li class="nav-item ">
            <a href="https://mediafile.mawaridtech.com/" class="nav-link ">
                <i class="nav-icon fas fa-cloud-upload-alt" aria-hidden="true"></i>

                <p>
                    MediaFile
                </p>
            </a>
        </li>

        <li class="nav-header">Setting</li>
        <li class="nav-item {{ Request::is('activity-logs') || Request::is('user-management')|| Request::is('customize') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('activity-logs') || Request::is('user-management')|| Request::is('customize') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cog"></i>
                <p>

                    Setting

                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">

                <li class="nav-item">
                    <a href="{{ route('customize.index') }}" class="nav-link {{ Request::is('customize')? 'active' : '' }}">
                        <i class="fas fa-puzzle-piece nav-icon"></i>
                        <p>Customizes</p>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-image nav-icon" aria-hidden="true"></i><p>Theme Mode :</p>
                        <input type="checkbox" id="themeSwitch" name="theme-switch" data-bootstrap-switch>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="{{ route('user.index') }}" class="nav-link {{ Request::is('user-management')? 'active' : '' }}">
                        <i class="fas fa-users nav-icon" aria-hidden="true"></i>
                        <p>User Management</p>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="{{ route('activity.logs') }}" class="nav-link {{ Request::is('activity-logs')? 'active' : '' }}">
                        <i class="fas fa-podcast nav-icon" aria-hidden="true"></i>
                        <p>Activity Log Page</p>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="/logout" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt nav-icon" aria-hidden="true"></i>

                        <p >Logout</p>
                    </a>
                </li>

            </ul>
        </li>

    </ul>
</nav>

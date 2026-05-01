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
        <li class="nav-item {{ request()->is('myClass*') || request()->is('getSubject/*') || request()->is('class/materials/*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="{{ route('myClass.index') }}" class="nav-link {{ request()->is('myClass*') || request()->is('getSubject/*')|| request()->is('class/materials/*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-cubes"></i>
                <p>
                    Class Material
                </p>
            </a>
        </li>
        <li class="nav-item" >
            <a href="{{ route('parents.index') }}" class="nav-link {{ request()->is('parents') ? 'active' : '' }}">
                <i class="nav-icon fas fa-house-user"></i>
                <p>
                    Parents

                </p>
            </a>
        </li>
        <li class="nav-item {{ Request::is('sessions') || Request::is('students*')|| Request::is('marks*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('sessions') || Request::is('students*') || Request::is('marks*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-graduate"></i>
                <p>

                    Student Section

                    <i class="right fas fa-angle-left"></i>
                    {{--                                <span class="right badge badge-info">4</span>--}}
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{route('sessions.index')}}" class="nav-link {{ Request::is('sessions') ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>

                        <p>Academic Session</p>

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
        <li class="nav-item">
            <a href="{{route('teachers.index')}}" class="nav-link {{ Request::is('teachers*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>
                    Teacher Section
                </p>
            </a>
        </li>

        <li class="nav-item {{ Request::is('exams*') ||Request::is('grades*')||Request::is('manage-exam-marks*') ? 'menu-is-opening menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('exams*') ||Request::is('grades*')||Request::is('manage-exam-marks*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-layer-group"></i>
                <p>

                    Exam Section

                    <i class="right fas fa-angle-left"></i>
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
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cog"></i>
                <p>

                    Setting

                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-image nav-icon"></i>Theme Mode :
                        <input type="checkbox" id="themeSwitch" name="theme-switch" data-bootstrap-switch>
                    </a>
                </li>
                <div class="dropdown-divider"></div>
                <li class="nav-item">
                    <a href="/logout" class="nav-link logout-btn">
                        <i class="fas fa-sign-out-alt nav-icon"></i>

                        <p >Logout</p>
                    </a>
                </li>

            </ul>
        </li>

    </ul>
</nav>

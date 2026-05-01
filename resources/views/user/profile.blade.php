@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                             @if($user->role == 0)
                                 src="{{ asset('admin_image/' . ($additionalData->photo ?? 'noimg.jpg')) }}"
                             @elseif($user->role == 1)
                                 src="{{ asset('teachers_image/' . ($additionalData->photo ?? 'noimg.jpg')) }}"
                             @elseif($user->role == 2)
                                 src="{{ asset('students_image/' . ($additionalData->photo ?? 'noimg.jpg')) }}"
                             @elseif($user->role == 3)
                                 src="{{ asset('staffs_image/' . ($additionalData->photo ?? 'noimg.jpg')) }}"
                             @elseif($user->role == 4)
                                 src="{{ asset('staffs_image/' . ($additionalData->photo ?? 'noimg.jpg')) }}"
                             @endif
                             alt="User profile picture">
                    </div>

                    <h3 class="user-name text-center">{{ $user->name }}</h3>
                    <p class="class-name text-muted text-center">
                        @if($user->role == 0)
                            Admin
                        @elseif($user->role == 1)
                            Teacher
                        @elseif($user->role == 2)
                            Student
                        @elseif($user->role == 3)
                            Accountant
                        @elseif($user->role == 4)
                            Receptionist
                        @endif
                    </p>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="user-name list-group-item">
                            <b>Name</b> <a class="float-right">{{ $user->name }}</a>
                        </li>
                        <li class="user-email list-group-item">
                            <b>Email</b> <a class="float-right">{{ $user->email }}</a>
                        </li>
                        <li class="user-role list-group-item">
                            <b>Role</b> <a class="float-right">
                                @if($user->role == 0)
                                    Admin
                                @elseif($user->role == 1)
                                    Teacher
                                @elseif($user->role == 2)
                                    Student
                                @elseif($user->role == 3)
                                    Accountant
                                @elseif($user->role == 4)
                                    Receptionist
                                @endif
                            </a>
                        </li>
                    </ul>

                    <a href="#" class="btn btn-primary btn-block" id="edit-profile-btn"
                       data-toggle="modal" data-target="#editProfileModal">
                       <i class="fas fa-cog"></i> <b>Setting</b>
                    </a>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.card -->
        </div>
        <div class="col-md-9">
            <!-- About Me Box -->
            @if($additionalData)
                @if($user->role == 1)
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">About Me</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
{{--                    @if($additionalData)--}}
{{--                        @if($user->role == 1)--}}
{{--                            <li class="list-group-item">--}}
{{--                                <b>Subject</b> <a class="float-right">{{ $additionalData->subject }}</a>--}}
{{--                            </li>--}}
{{--                        @elseif($user->role == 2)--}}
{{--                            <li class="list-group-item">--}}
{{--                                <b>Class</b> <a class="float-right">{{ $additionalData->class }}</a>--}}
{{--                            </li>--}}
{{--                            <li class="list-group-item">--}}
{{--                                <b>Roll</b> <a class="float-right">{{ $additionalData->roll }}</a>--}}
{{--                            </li>--}}
{{--                        @endif--}}
{{--                    @endif--}}

                    <strong><i class="fas fa-book mr-1"></i> Education</strong>

                    <p class="text-muted">
                        B.S. in Computer Science from the University of Tennessee at Knoxville
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                    <p class="text-muted">{{ $additionalData->address }}</p>

                    <hr>

                    <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                    <p class="text-muted">
                        <span class="tag tag-danger">UI Design</span>
                        <span class="tag tag-success">Coding</span>
                        <span class="tag tag-info">Javascript</span>
                        <span class="tag tag-warning">PHP</span>
                        <span class="tag tag-primary">Node.js</span>
                    </p>

                    <hr>

                    <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                    <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
                </div>
                <!-- /.card-body -->
            </div>
                @endif
            @endif
        </div>
    </div>


<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="edit-profile-form" method="POST" action="{{ route('user_profile.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-user-id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit-user-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edit-user-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-user-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit-user-email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user-role" class="form-label">Role</label>
                        <p class="form-control" id="edit-user-role">
                            @if($user->role == 0) Admin
                            @elseif($user->role == 1) Teacher
                            @elseif($user->role == 2) Student
                            @elseif($user->role == 3) Accountant
                            @elseif($user->role == 4) Receptionist
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="edit-user-password" class="form-label">Password (Leave empty to keep unchanged)</label>
                        <input type="password" class="form-control" id="edit-user-password" name="password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('edit-profile-btn');
            const userEmail = document.getElementById('user-email');
            const userRole = document.getElementById('user-role');

            editButton.addEventListener('click', function () {
                fetch('/user-profile/data')
                    .then(response => response.json())
                    .then(user => {
                        // Populate fields in the modal
                        document.getElementById('edit-user-id').value = user.id;
                        document.getElementById('edit-user-name').value = user.name;
                        document.getElementById('edit-user-email').value = user.email;
                        document.getElementById('edit-user-role').value = user.role;

                        // Update the profile card
                        userEmail.textContent = user.email;
                        userRole.textContent = user.role === 0 ? 'Admin' : user.role === 1 ? 'Teacher' : 'Student';
                    })
                    // .catch(error => {
                    //     console.error('Error fetching user data:', error);
                    //     alert('Failed to load user data.');
                    // });
            });
            document.getElementById('user-panel').addEventListener('click', function () {
                fetch('/user-profile')
                    .then(response => response.json())
                    .then(user => {
                        // Populate modal fields
                        document.getElementById('user-id').value = user.id;
                        document.getElementById('user-name').value = user.name;
                        document.getElementById('user-email').value = user.email;
                        document.getElementById('user-role').value = user.role;
                    })
                    // .catch(error => {
                    //     console.error('Error loading user data:', error);
                    //     alert('Failed to load user data.');
                    // });
            });
        });

    </script>

@endsection

@extends('layout.main')

@section('content')

    <div class="row">
        <div class="col-md-3">
            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle shadow-sm border"
                             src="{{ $user->photo_url }}"
                             alt="User profile picture"
                             style="width: 100px; height: 100px; object-fit: cover;"
                             onerror="this.src='{{ asset('user-profile-default.png') }}';">
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
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editProfileModalLabel">
                    <i class="fas fa-user-edit mr-1"></i> Edit Profile
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-profile-form" method="POST" action="{{ route('user_profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit-user-id" value="{{ $user->id }}">
                <div class="modal-body">
                    <!-- Profile Picture Upload -->
                    <div class="form-group text-center mb-3">
                        <label class="d-block font-weight-bold mb-2">Profile Photo</label>
                        <div class="position-relative d-inline-block" style="width: 100px; height: 100px;">
                            <img id="profile-photo-preview" src="{{ $user->photo_url }}" alt="Profile Photo"
                                 class="rounded-circle shadow-sm border"
                                 style="width: 100%; height: 100%; object-fit: cover; background: #f8f9fa;">
                            <label for="profile-photo-input" class="btn btn-sm btn-primary rounded-circle shadow position-absolute"
                                   style="bottom: 0; right: 0; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                   title="Change profile picture">
                                <i class="fas fa-camera text-white" style="font-size: 13px;"></i>
                            </label>
                            <input type="file" id="profile-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewProfilePhoto(this)">
                        </div>
                        <small class="form-text text-muted">Click camera icon to change photo (Max 3MB)</small>
                    </div>

                    <div class="mb-3">
                        <label for="edit-user-name" class="form-label font-weight-bold">Name</label>
                        <input type="text" class="form-control" id="edit-user-name" name="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-user-email" class="form-label font-weight-bold">Email</label>
                        <input type="email" class="form-control" id="edit-user-email" name="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="user-role" class="form-label font-weight-bold">Role</label>
                        <p class="form-control bg-light" id="edit-user-role">
                            @if($user->role == 0) Admin
                            @elseif($user->role == 1) Teacher
                            @elseif($user->role == 2) Student
                            @elseif($user->role == 3) Accountant
                            @elseif($user->role == 4) Receptionist
                            @endif
                        </p>
                    </div>

                    <div class="mb-3">
                        <label for="edit-user-password" class="form-label font-weight-bold">Password (Leave empty to keep unchanged)</label>
                        <input type="password" class="form-control" id="edit-user-password" name="password" placeholder="New password">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary font-weight-bold">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

    <script>
        function previewProfilePhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-photo-preview').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const editButton = document.getElementById('edit-profile-btn');
            const userEmail = document.getElementById('user-email');
            const userRole = document.getElementById('user-role');

            if (editButton) {
                editButton.addEventListener('click', function () {
                    fetch('/user-profile/data')
                        .then(response => response.json())
                        .then(user => {
                            if (document.getElementById('edit-user-id')) document.getElementById('edit-user-id').value = user.id;
                            if (document.getElementById('edit-user-name')) document.getElementById('edit-user-name').value = user.name;
                            if (document.getElementById('edit-user-email')) document.getElementById('edit-user-email').value = user.email;
                            if (user.photo_url && document.getElementById('profile-photo-preview')) {
                                document.getElementById('profile-photo-preview').src = user.photo_url;
                            }
                            if (userEmail) userEmail.textContent = user.email;
                            if (userRole) userRole.textContent = user.role === 0 ? 'Admin' : (user.role === 1 ? 'Teacher' : (user.role === 2 ? 'Student' : (user.role === 3 ? 'Accountant' : 'Receptionist')));
                        })
                        .catch(err => console.log('Profile data load:', err));
                });
            }
        });
    </script>

@endsection

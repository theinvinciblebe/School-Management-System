@extends('layout.main')

@section('content')
    <style>
        .user-table-avatar {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #e9ecef;
            transition: all 0.25s ease-in-out;
            cursor: pointer;
        }
        .user-table-avatar:hover {
            transform: scale(1.15);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.18);
            border-color: #007bff;
        }
        .avatar-upload-frame {
            position: relative;
            width: 105px;
            height: 105px;
            margin: 0 auto;
        }
        .avatar-upload-frame img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            border: 3px solid #dee2e6;
            background-color: #f8f9fa;
        }
        .avatar-upload-btn {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
            margin: 0;
            padding: 0;
            transition: transform 0.2s;
        }
        .avatar-upload-btn:hover {
            transform: scale(1.1);
        }
    </style>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card card-primary card-outline">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title font-weight-bold">
                <i class="fas fa-users-cog mr-1"></i> User Management
            </h3>
            <div class="card-tools ml-auto">
                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal">
                    <i class="fas fa-user-plus mr-1"></i> Add New User
                </a>
            </div>
        </div>
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped table-hover dataTable dtr-inline" aria-describedby="example1_info">
                <thead>
                <tr class="text-center">
                    <th style="width: 50px;">#</th>
                    <th style="width: 70px;">Profile</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 110px;">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $index => $user)
                    <tr>
                        <td class="align-middle text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                        <td class="align-middle text-center">
                            <img src="{{ $user->photo_url }}"
                                 alt="{{ $user->name }}"
                                 class="user-table-avatar shadow-sm"
                                 onclick="viewEnlargedImage('{{ $user->photo_url }}', '{{ addslashes($user->name) }}')"
                                 onerror="this.src='{{ asset('user-profile-default.png') }}';"
                                 title="Click to view full photo">
                        </td>
                        <td class="align-middle font-weight-bold text-dark">{{ $user->name }}</td>
                        <td class="align-middle text-muted">{{ $user->email }}</td>
                        <td class="align-middle text-center">
                            @if($user->role == 0)
                                <span class="badge badge-danger px-2 py-1"><i class="fas fa-user-shield mr-1"></i> Admin</span>
                            @elseif($user->role == 1)
                                <span class="badge badge-info px-2 py-1"><i class="fas fa-chalkboard-teacher mr-1"></i> Teacher</span>
                            @elseif($user->role == 2)
                                <span class="badge badge-success px-2 py-1"><i class="fas fa-user-graduate mr-1"></i> Student</span>
                            @elseif($user->role == 3)
                                <span class="badge badge-warning px-2 py-1"><i class="fas fa-calculator mr-1"></i> Accountant</span>
                            @elseif($user->role == 4)
                                <span class="badge badge-secondary px-2 py-1"><i class="fas fa-headset mr-1"></i> Receptionist</span>
                            @else
                                <span class="badge badge-light px-2 py-1">User</span>
                            @endif
                        </td>
                        <td class="align-middle text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-success">Action</button>
                                <button type="button" class="btn btn-sm btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow" role="menu">
                                    <button type="button" class="dropdown-item text-primary" onclick="showEditModal({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', {{ $user->role }}, '{{ $user->photo_url }}')">
                                        <i class="fas fa-edit mr-2"></i> Edit
                                    </button>
                                    <div class="dropdown-divider"></div>
                                    <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="fas fa-trash-alt mr-2"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('user.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="addUserModalLabel">
                            <i class="fas fa-user-plus mr-1"></i> Add New User
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Profile Image Section -->
                        <div class="form-group text-center mb-3">
                            <label class="d-block font-weight-bold mb-2">Profile Image</label>
                            <div class="avatar-upload-frame">
                                <img id="add-user-photo-preview" src="{{ asset('user-profile-default.png') }}" alt="Profile Preview">
                                <label for="add-user-photo-input" class="btn btn-primary avatar-upload-btn" title="Choose photo">
                                    <i class="fas fa-camera text-white" style="font-size: 13px;"></i>
                                </label>
                                <input type="file" id="add-user-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewAddUserPhoto(this)">
                            </div>
                            <div class="mt-2">
                                <button type="button" id="add-user-photo-remove" class="btn btn-xs btn-outline-danger" style="display: none;" onclick="removeAddUserPhoto()">
                                    <i class="fas fa-times mr-1"></i> Remove Image
                                </button>
                            </div>
                            <small class="form-text text-muted">JPG, PNG, WEBP or GIF (Max 3MB)</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" name="email" class="form-control" placeholder="user@example.com" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="password" class="form-control" placeholder="Minimum 6 characters" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold">Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                </div>
                                <select name="role" class="form-control" required>
                                    <option value="0">Admin</option>
                                    <option value="1">Teacher</option>
                                    <option value="2">Student</option>
                                    <option value="3">Accountant</option>
                                    <option value="4">Receptionist</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary font-weight-bold">
                            <i class="fas fa-check mr-1"></i> Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="edit-user-form" method="POST" action="{{ route('user.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-user-id">
                    <input type="hidden" name="remove_photo" id="edit-user-remove-photo" value="0">

                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title" id="editUserModalLabel">
                            <i class="fas fa-user-edit mr-1"></i> Edit User
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Profile Image Section -->
                        <div class="form-group text-center mb-3">
                            <label class="d-block font-weight-bold mb-2">Profile Image</label>
                            <div class="avatar-upload-frame">
                                <img id="edit-user-photo-preview" src="{{ asset('user-profile-default.png') }}" alt="Profile Preview">
                                <label for="edit-user-photo-input" class="btn btn-info avatar-upload-btn" title="Change photo">
                                    <i class="fas fa-camera text-white" style="font-size: 13px;"></i>
                                </label>
                                <input type="file" id="edit-user-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewEditUserPhoto(this)">
                            </div>
                            <div class="mt-2">
                                <button type="button" id="edit-user-photo-reset-btn" class="btn btn-xs btn-outline-secondary mr-1" style="display: none;" onclick="resetEditUserPhoto()">
                                    <i class="fas fa-undo mr-1"></i> Revert
                                </button>
                                <button type="button" id="edit-user-photo-remove-btn" class="btn btn-xs btn-outline-danger" onclick="removeEditUserPhoto()">
                                    <i class="fas fa-trash-alt mr-1"></i> Remove Photo
                                </button>
                            </div>
                            <small class="form-text text-muted">Click camera icon to change photo (Max 3MB)</small>
                        </div>

                        <div class="form-group">
                            <label for="edit-user-name" class="font-weight-bold">Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                </div>
                                <input type="text" class="form-control" id="edit-user-name" name="name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit-user-email" class="font-weight-bold">Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                </div>
                                <input type="email" class="form-control" id="edit-user-email" name="email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit-user-password" class="font-weight-bold">Password</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control" id="edit-user-password" name="password" placeholder="Leave blank to keep current password">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit-user-role" class="font-weight-bold">Role <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                </div>
                                <select class="form-control" id="edit-user-role" name="role" required>
                                    <option value="0">Admin</option>
                                    <option value="1">Teacher</option>
                                    <option value="2">Student</option>
                                    <option value="3">Accountant</option>
                                    <option value="4">Receptionist</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-info font-weight-bold">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Enlarged Image Modal -->
    <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header bg-dark text-white py-2">
                    <h6 class="modal-title font-weight-bold mb-0" id="imagePreviewModalTitle">User Profile Photo</h6>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" onclick="closeImagePreviewModal()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-3 bg-light text-center">
                    <img id="enlargedUserImage" src="" alt="Enlarged Profile" class="img-fluid rounded shadow-sm" style="max-height: 420px; object-fit: contain;">
                </div>
            </div>
        </div>
    </div>

    <script>
        const DEFAULT_AVATAR = '{{ asset('user-profile-default.png') }}';
        let originalEditPhotoUrl = DEFAULT_AVATAR;

        function showEditModal(id, name, email, role, photoUrl) {
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-user-name').value = name;
            document.getElementById('edit-user-email').value = email;
            document.getElementById('edit-user-password').value = '';
            document.getElementById('edit-user-role').value = role;

            document.getElementById('edit-user-remove-photo').value = '0';
            document.getElementById('edit-user-photo-input').value = '';
            document.getElementById('edit-user-photo-reset-btn').style.display = 'none';

            originalEditPhotoUrl = photoUrl || DEFAULT_AVATAR;
            document.getElementById('edit-user-photo-preview').src = originalEditPhotoUrl;

            openModal('editUserModal');
        }

        function previewAddUserPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('add-user-photo-preview').src = e.target.result;
                    document.getElementById('add-user-photo-remove').style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeAddUserPhoto() {
            document.getElementById('add-user-photo-input').value = '';
            document.getElementById('add-user-photo-preview').src = DEFAULT_AVATAR;
            document.getElementById('add-user-photo-remove').style.display = 'none';
        }

        function previewEditUserPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('edit-user-photo-preview').src = e.target.result;
                    document.getElementById('edit-user-remove-photo').value = '0';
                    document.getElementById('edit-user-photo-reset-btn').style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function resetEditUserPhoto() {
            document.getElementById('edit-user-photo-input').value = '';
            document.getElementById('edit-user-photo-preview').src = originalEditPhotoUrl;
            document.getElementById('edit-user-remove-photo').value = '0';
            document.getElementById('edit-user-photo-reset-btn').style.display = 'none';
        }

        function removeEditUserPhoto() {
            document.getElementById('edit-user-photo-input').value = '';
            document.getElementById('edit-user-photo-preview').src = DEFAULT_AVATAR;
            document.getElementById('edit-user-remove-photo').value = '1';
            document.getElementById('edit-user-photo-reset-btn').style.display = 'inline-block';
        }

        function viewEnlargedImage(url, name) {
            document.getElementById('enlargedUserImage').src = url;
            document.getElementById('imagePreviewModalTitle').textContent = (name || 'User') + ' - Profile Photo';
            openModal('imagePreviewModal');
        }

        function closeImagePreviewModal() {
            closeModal('imagePreviewModal');
        }

        function openModal(modalId) {
            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;

            if (typeof $ !== 'undefined' && typeof $('#' + modalId).modal === 'function') {
                $('#' + modalId).modal('show');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let instance = bootstrap.Modal.getInstance(modalEl);
                if (!instance) {
                    instance = new bootstrap.Modal(modalEl);
                }
                instance.show();
            }
        }

        function closeModal(modalId) {
            const modalEl = document.getElementById(modalId);
            if (!modalEl) return;

            if (typeof $ !== 'undefined' && typeof $('#' + modalId).modal === 'function') {
                $('#' + modalId).modal('hide');
            } else if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                let instance = bootstrap.Modal.getInstance(modalEl);
                if (instance) {
                    instance.hide();
                }
            }
        }
    </script>
@endsection

@extends('layout.main')

@section('content')
    <style>
        /* Baseline Card Styles */
        .profile-card,
        .form-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .profile-card {
            overflow: hidden;
        }
        .profile-card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            border-top-left-radius: 12px !important;
            border-top-right-radius: 12px !important;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }
        .profile-header-banner {
            height: 90px;
            background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #4a90e2 100%);
            position: relative;
        }
        .profile-avatar-container {
            position: relative;
            margin-top: -55px;
            display: inline-block;
        }
        .profile-avatar-img {
            width: 110px;
            height: 110px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            background-color: #f8f9fa;
            transition: border-color 0.25s ease, background-color 0.25s ease;
        }
        .profile-avatar-badge {
            position: absolute;
            bottom: 4px;
            right: 4px;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
            transition: all 0.2s ease;
        }
        .profile-avatar-badge:hover {
            transform: scale(1.1);
            background-color: #0056b3;
        }
        .profile-preview-img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            transition: border-color 0.25s ease, background-color 0.25s ease;
        }
        .profile-nav-pills .nav-link {
            border-radius: 8px;
            font-weight: 600;
            padding: 10px 18px;
            color: #495057;
            transition: all 0.2s ease;
        }
        .profile-nav-pills .nav-link:hover {
            background-color: #f1f3f5;
            color: #007bff;
        }
        .profile-nav-pills .nav-link.active {
            background-color: #007bff;
            color: #fff;
            box-shadow: 0 3px 8px rgba(0, 123, 255, 0.3);
        }
        .input-group-text {
            background-color: #f8f9fa;
            border-color: #ced4da;
            transition: background-color 0.25s ease, border-color 0.25s ease;
        }
        .custom-file-upload-box {
            border: 2px dashed #007bff;
            border-radius: 12px;
            padding: 16px;
            background-color: #f8fafd;
            transition: all 0.25s ease;
        }
        .custom-file-upload-box:hover {
            background-color: #eef5ff;
            border-color: #0056b3;
        }
        .toggle-password {
            cursor: pointer;
        }
        .toggle-password:hover {
            color: #007bff;
        }

        /* =========================================================
           Dark Mode Overrides for User Profile
           ========================================================= */
        .dark-mode .profile-card,
        .dark-mode .form-card {
            background-color: #343a40 !important;
            color: #f8f9fa !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3) !important;
        }
        .dark-mode .profile-card-header {
            background-color: #2b3035 !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .dark-mode .profile-avatar-img {
            border-color: #343a40 !important;
            background-color: #2b3035 !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
        }
        .dark-mode .profile-avatar-badge {
            border-color: #343a40 !important;
        }
        .dark-mode .profile-preview-img {
            background-color: #2b3035 !important;
            border-color: rgba(255, 255, 255, 0.15) !important;
        }
        .dark-mode .profile-nav-pills .nav-link {
            color: #cbd5e1 !important;
        }
        .dark-mode .profile-nav-pills .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #60a5fa !important;
        }
        .dark-mode .profile-nav-pills .nav-link.active {
            background-color: #007bff !important;
            color: #ffffff !important;
            box-shadow: 0 3px 12px rgba(0, 123, 255, 0.5) !important;
        }
        .dark-mode .custom-file-upload-box {
            background-color: rgba(0, 123, 255, 0.08) !important;
            border-color: rgba(0, 123, 255, 0.4) !important;
        }
        .dark-mode .custom-file-upload-box:hover {
            background-color: rgba(0, 123, 255, 0.14) !important;
            border-color: #38bdf8 !important;
        }
        .dark-mode .text-dark {
            color: #f8f9fa !important;
        }
        .dark-mode .text-muted {
            color: #94a3b8 !important;
        }
        .dark-mode .list-group-item {
            background-color: transparent !important;
            color: #f8f9fa !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark-mode .list-group-flush {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark-mode .badge-light {
            background-color: rgba(255, 255, 255, 0.08) !important;
            color: #4ade80 !important;
            border-color: rgba(74, 222, 128, 0.4) !important;
        }
        .dark-mode .btn-outline-secondary {
            color: #cbd5e1 !important;
            border-color: #64748b !important;
        }
        .dark-mode .btn-outline-secondary:hover {
            background-color: #64748b !important;
            color: #ffffff !important;
        }
        .dark-mode .btn-light {
            background-color: #2b3035 !important;
            border-color: #4b545c !important;
            color: #cbd5e1 !important;
        }
        .dark-mode .btn-light:hover {
            background-color: #3e444a !important;
            color: #ffffff !important;
        }
        .dark-mode .input-group-text {
            background-color: #2b3035 !important;
            border-color: #4b545c !important;
            color: #94a3b8 !important;
        }
        .dark-mode .form-control {
            background-color: #2c3238 !important;
            border-color: #4b545c !important;
            color: #ffffff !important;
        }
        .dark-mode .form-control:focus {
            background-color: #2c3238 !important;
            border-color: #007bff !important;
            color: #ffffff !important;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25) !important;
        }
        .dark-mode .form-control::placeholder {
            color: #6c757d !important;
        }
        .dark-mode .form-control.bg-light,
        .dark-mode .form-control[readonly],
        .dark-mode .form-control:disabled {
            background-color: #23272b !important;
            border-color: #3e444a !important;
            color: #cbd5e1 !important;
        }
        .dark-mode .border-top,
        .dark-mode .border-bottom {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark-mode .alert-info {
            background-color: rgba(23, 162, 184, 0.15) !important;
            color: #7dd3fc !important;
            border: 1px solid rgba(23, 162, 184, 0.3) !important;
        }
        .dark-mode .toggle-password {
            color: #94a3b8 !important;
        }
        .dark-mode .toggle-password:hover {
            color: #38bdf8 !important;
        }
        .dark-mode .table {
            color: #e2e8f0 !important;
        }
        .dark-mode .table-bordered,
        .dark-mode .table-bordered th,
        .dark-mode .table-bordered td {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
        .dark-mode .table th.bg-light,
        .dark-mode th.bg-light {
            background-color: #2b3035 !important;
            color: #f1f5f9 !important;
        }
        .dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255, 255, 255, 0.02) !important;
        }
        .dark-mode .table-striped tbody tr:nth-of-type(even) {
            background-color: transparent !important;
        }
        .dark-mode .modal-content {
            background-color: #343a40 !important;
            color: #f8f9fa !important;
            border: 1px solid rgba(255, 255, 255, 0.12) !important;
        }
        .dark-mode .modal-footer.bg-light {
            background-color: #2b3035 !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1) !important;
        }
        .dark-mode .breadcrumb-item.active {
            color: #94a3b8 !important;
        }
        .dark-mode .breadcrumb-item + .breadcrumb-item::before {
            color: #64748b !important;
        }
    </style>

    <div class="content-header p-0 mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="m-0 font-weight-bold text-dark">
                    <i class="fas fa-id-card text-primary mr-2"></i> User Profile
                </h2>
                <small class="text-muted">Manage your personal information, profile photo, and account security</small>
            </div>
            <ol class="breadcrumb m-0 bg-transparent p-0">
                <li class="breadcrumb-item"><a href="/"><i class="fas fa-home mr-1"></i> Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="fas fa-check-circle mr-2"></i> <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" style="border-radius: 10px;">
            <i class="fas fa-exclamation-triangle mr-2"></i> <strong>Please fix the errors below:</strong>
            <ul class="mb-0 mt-1 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Left Column: Identity Summary Card -->
        <div class="col-lg-4 col-md-5 mb-4">
            <div class="card profile-card border-0">
                <div class="profile-header-banner"></div>
                <div class="card-body text-center pt-0 pb-4">
                    <div class="profile-avatar-container">
                        <img id="card-avatar-img"
                             src="{{ $user->photo_url }}"
                             alt="{{ $user->name }}"
                             class="profile-avatar-img"
                             onerror="this.src='{{ asset('user-profile-default.png') }}';">
                        <label for="form-photo-input" class="profile-avatar-badge" title="Change profile photo">
                            <i class="fas fa-camera" style="font-size: 13px;"></i>
                        </label>
                    </div>

                    <h4 class="font-weight-bold text-dark mt-2 mb-1">{{ $user->name }}</h4>
                    <p class="text-muted small mb-2">{{ $user->email }}</p>

                    <div class="mb-3">
                        @if($user->role == 0)
                            <span class="badge badge-danger px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                                <i class="fas fa-user-shield mr-1"></i> Administrator
                            </span>
                        @elseif($user->role == 1)
                            <span class="badge badge-info px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                                <i class="fas fa-chalkboard-teacher mr-1"></i> Teacher
                            </span>
                        @elseif($user->role == 2)
                            <span class="badge badge-success px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                                <i class="fas fa-user-graduate mr-1"></i> Student
                            </span>
                        @elseif($user->role == 3)
                            <span class="badge badge-warning px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                                <i class="fas fa-calculator mr-1"></i> Accountant
                            </span>
                        @elseif($user->role == 4)
                            <span class="badge badge-secondary px-3 py-2" style="font-size: 13px; border-radius: 20px;">
                                <i class="fas fa-headset mr-1"></i> Receptionist
                            </span>
                        @endif
                    </div>

                    <ul class="list-group list-group-flush text-left border-top border-bottom mb-3" style="font-size: 14px;">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted"><i class="fas fa-hashtag mr-2 text-primary"></i> Account ID</span>
                            <span class="font-weight-bold text-dark">#{{ $user->id }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted"><i class="fas fa-check-circle mr-2 text-success"></i> Status</span>
                            <span class="badge badge-light text-success font-weight-bold border border-success px-2 py-1">Active</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                            <span class="text-muted"><i class="far fa-calendar-alt mr-2 text-info"></i> Member Since</span>
                            <span class="font-weight-bold text-dark">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </span>
                        </li>
                        @if($additionalData && !empty($additionalData->phone))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="fas fa-phone mr-2 text-warning"></i> Phone</span>
                                <span class="font-weight-bold text-dark">{{ $additionalData->phone }}</span>
                            </li>
                        @endif
                        @if($additionalData && !empty($additionalData->address))
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0 py-2">
                                <span class="text-muted"><i class="fas fa-map-marker-alt mr-2 text-danger"></i> Address</span>
                                <span class="font-weight-bold text-dark text-right" style="max-width: 60%;">{{ $additionalData->address }}</span>
                            </li>
                        @endif
                    </ul>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-outline-primary btn-sm px-3 mr-2" onclick="switchToTab('settings-tab')">
                            <i class="fas fa-user-edit mr-1"></i> Edit Info
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" onclick="switchToTab('security-tab')">
                            <i class="fas fa-key mr-1"></i> Password
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Form & Settings Tabs -->
        <div class="col-lg-8 col-md-7 mb-4">
            <div class="card form-card border-0">
                <div class="card-header profile-card-header border-bottom p-3">
                    <ul class="nav nav-pills profile-nav-pills" id="profileTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="settings-tab" data-toggle="pill" href="#settings" role="tab" aria-controls="settings" aria-selected="true">
                                <i class="fas fa-user-cog mr-1"></i> Edit Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="security-tab" data-toggle="pill" href="#security" role="tab" aria-controls="security" aria-selected="false">
                                <i class="fas fa-lock mr-1"></i> Change Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="pill" href="#details" role="tab" aria-controls="details" aria-selected="false">
                                <i class="fas fa-info-circle mr-1"></i> Account Details
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4">
                    <div class="tab-content" id="profileTabContent">
                        <!-- TAB 1: Edit Profile Form -->
                        <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <form id="main-profile-form" method="POST" action="{{ route('user_profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="remove_photo" id="form-remove-photo" value="0">

                                <!-- Profile Picture Upload Box -->
                                <div class="custom-file-upload-box mb-4">
                                    <div class="d-flex flex-column flex-sm-row align-items-center">
                                        <div class="position-relative mb-3 mb-sm-0 mr-sm-4 text-center">
                                            <img id="form-photo-preview"
                                                 src="{{ $user->photo_url }}"
                                                 alt="{{ $user->name }}"
                                                 class="rounded-circle shadow-sm profile-preview-img"
                                                 onerror="this.src='{{ asset('user-profile-default.png') }}';">
                                        </div>
                                        <div class="flex-grow-1 text-center text-sm-left">
                                            <h6 class="font-weight-bold mb-1 text-dark">Profile Photo</h6>
                                            <p class="text-muted small mb-2">Upload a crisp photo for your avatar (Max: 3MB). Supported: JPG, PNG, WEBP, GIF.</p>
                                            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start">
                                                <label for="form-photo-input" class="btn btn-sm btn-primary mb-1 mr-2 px-3" style="cursor: pointer;">
                                                    <i class="fas fa-upload mr-1"></i> Choose New Photo
                                                </label>
                                                <input type="file" id="form-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="handleFormPhotoSelect(this)">
                                                <button type="button" id="form-photo-remove-btn" class="btn btn-sm btn-outline-danger mb-1 mr-2" onclick="handleFormPhotoRemove()">
                                                    <i class="fas fa-trash-alt mr-1"></i> Remove Photo
                                                </button>
                                                <button type="button" id="form-photo-reset-btn" class="btn btn-sm btn-outline-secondary mb-1" style="display: none;" onclick="handleFormPhotoReset()">
                                                    <i class="fas fa-undo mr-1"></i> Revert
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="profile-name" class="font-weight-bold text-dark">
                                            Full Name <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-user text-primary"></i></span>
                                            </div>
                                            <input type="text" class="form-control" id="profile-name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Enter full name">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="profile-email" class="font-weight-bold text-dark">
                                            Email Address <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-envelope text-primary"></i></span>
                                            </div>
                                            <input type="email" class="form-control" id="profile-email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Enter email address">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="font-weight-bold text-dark">Assigned Role</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-shield-alt text-muted"></i></span>
                                            </div>
                                            <input type="text" class="form-control bg-light font-weight-bold" readonly
                                                   value="@if($user->role == 0)Administrator @elseif($user->role == 1)Teacher @elseif($user->role == 2)Student @elseif($user->role == 3)Accountant @elseif($user->role == 4)Receptionist @else User @endif">
                                        </div>
                                        <small class="form-text text-muted">Role permissions are managed by system administrators.</small>
                                    </div>

                                    @if($additionalData)
                                        <div class="col-md-6 mb-3">
                                            <label for="profile-phone" class="font-weight-bold text-dark">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone text-primary"></i></span>
                                                </div>
                                                <input type="text" class="form-control" id="profile-phone" name="phone" value="{{ old('phone', $additionalData->phone ?? '') }}" placeholder="Enter phone number">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($additionalData && isset($additionalData->address))
                                    <div class="form-group mb-3">
                                        <label for="profile-address" class="font-weight-bold text-dark">Location / Address</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-map-marker-alt text-primary"></i></span>
                                            </div>
                                            <textarea class="form-control" id="profile-address" name="address" rows="2" placeholder="Enter physical address">{{ old('address', $additionalData->address ?? '') }}</textarea>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-end align-items-center pt-3 border-top mt-4">
                                    <button type="reset" class="btn btn-light text-muted mr-3 px-4 font-weight-bold" onclick="handleFormPhotoReset()">
                                        <i class="fas fa-undo mr-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm">
                                        <i class="fas fa-save mr-1"></i> Save Profile Changes
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 2: Change Password -->
                        <div class="tab-pane fade" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <form id="password-change-form" method="POST" action="{{ route('user_profile.update') }}">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="hidden" name="name" value="{{ $user->name }}">
                                <input type="hidden" name="email" value="{{ $user->email }}">

                                <div class="alert alert-info border-0 mb-4" style="border-radius: 8px;">
                                    <i class="fas fa-info-circle mr-1"></i> Use a strong password containing at least 6 characters with a combination of letters and numbers.
                                </div>

                                <div class="form-group mb-3">
                                    <label for="new_password" class="font-weight-bold text-dark">
                                        New Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-key text-primary"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="new_password" name="password" required minlength="6" placeholder="Enter new password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" onclick="togglePasswordVisibility('new_password', this)">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted">Must be at least 6 characters long.</small>
                                </div>

                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="font-weight-bold text-dark">
                                        Confirm New Password <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-check-double text-primary"></i></span>
                                        </div>
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required minlength="6" placeholder="Repeat new password">
                                        <div class="input-group-append">
                                            <span class="input-group-text toggle-password" onclick="togglePasswordVisibility('password_confirmation', this)">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div id="password-match-feedback" class="small mt-1" style="display: none;"></div>
                                </div>

                                <div class="d-flex justify-content-end align-items-center pt-3 border-top">
                                    <button type="submit" class="btn btn-warning px-4 py-2 font-weight-bold shadow-sm text-dark">
                                        <i class="fas fa-lock mr-1"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- TAB 3: Account Details -->
                        <div class="tab-pane fade" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <h5 class="font-weight-bold text-dark mb-3"><i class="fas fa-clipboard-check text-primary mr-1"></i> Account Overview</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <tbody>
                                        <tr>
                                            <th style="width: 35%;" class="bg-light">User ID</th>
                                            <td>#{{ $user->id }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Full Name</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Registered Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Current Role</th>
                                            <td>
                                                @if($user->role == 0) Admin
                                                @elseif($user->role == 1) Teacher
                                                @elseif($user->role == 2) Student
                                                @elseif($user->role == 3) Accountant
                                                @elseif($user->role == 4) Receptionist
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Email Verified</th>
                                            <td>
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success"><i class="fas fa-check-circle mr-1"></i> Verified on {{ $user->email_verified_at->format('M d, Y') }}</span>
                                                @else
                                                    <span class="badge badge-secondary"><i class="fas fa-clock mr-1"></i> Not Verified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Account Created</th>
                                            <td>{{ $user->created_at ? $user->created_at->format('M d, Y - h:i A') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="bg-light">Last Updated</th>
                                            <td>{{ $user->updated_at ? $user->updated_at->format('M d, Y - h:i A') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal (Kept for external triggers & mobile compatibility) -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title font-weight-bold" id="editProfileModalLabel">
                        <i class="fas fa-user-edit mr-1"></i> Quick Edit Profile
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit-profile-form" method="POST" action="{{ route('user_profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-user-id" value="{{ $user->id }}">
                    <input type="hidden" name="remove_photo" id="modal-remove-photo" value="0">

                    <div class="modal-body p-4">
                        <!-- Profile Picture Upload -->
                        <div class="form-group text-center mb-4">
                            <label class="d-block font-weight-bold text-dark mb-2">Profile Photo</label>
                            <div class="position-relative d-inline-block" style="width: 105px; height: 105px;">
                                <img id="modal-profile-photo-preview" src="{{ $user->photo_url }}" alt="Profile Photo"
                                     class="rounded-circle shadow-sm profile-preview-img"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                                <label for="modal-profile-photo-input" class="btn btn-sm btn-primary rounded-circle shadow position-absolute"
                                       style="bottom: 2px; right: 2px; width: 32px; height: 32px; padding: 0; display: flex; align-items: center; justify-content: center; cursor: pointer;"
                                       title="Change profile picture">
                                    <i class="fas fa-camera text-white" style="font-size: 13px;"></i>
                                </label>
                                <input type="file" id="modal-profile-photo-input" name="photo" accept="image/jpeg,image/png,image/webp,image/gif" style="display: none;" onchange="previewModalPhoto(this)">
                            </div>
                            <div class="mt-2">
                                <button type="button" id="modal-photo-remove-btn" class="btn btn-xs btn-outline-danger" onclick="removeModalPhoto()">
                                    <i class="fas fa-trash-alt mr-1"></i> Remove Photo
                                </button>
                                <button type="button" id="modal-photo-reset-btn" class="btn btn-xs btn-outline-secondary" style="display: none;" onclick="resetModalPhoto()">
                                    <i class="fas fa-undo mr-1"></i> Revert
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="modal-edit-user-name" class="font-weight-bold text-dark">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="modal-edit-user-name" name="name" value="{{ $user->name }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="modal-edit-user-email" class="font-weight-bold text-dark">Email Address <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="modal-edit-user-email" name="email" value="{{ $user->email }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold text-dark">Role</label>
                            <input type="text" class="form-control bg-light" readonly
                                   value="@if($user->role == 0)Admin @elseif($user->role == 1)Teacher @elseif($user->role == 2)Student @elseif($user->role == 3)Accountant @elseif($user->role == 4)Receptionist @endif">
                        </div>

                        <div class="form-group mb-2">
                            <label for="modal-edit-user-password" class="font-weight-bold text-dark">Password (Optional)</label>
                            <input type="password" class="form-control" id="modal-edit-user-password" name="password" placeholder="Leave empty to keep unchanged">
                        </div>
                    </div>
                    <div class="modal-footer bg-light px-4 py-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary font-weight-bold px-4">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const ORIGINAL_AVATAR = "{{ $user->photo_url }}";
        const DEFAULT_AVATAR = "{{ asset('user-profile-default.png') }}";

        // Tab switching helper
        function switchToTab(tabId) {
            $('#' + tabId).tab('show');
            window.scrollTo({
                top: document.getElementById('profileTab').offsetTop - 20,
                behavior: 'smooth'
            });
        }

        // In-page photo preview handler
        function handleFormPhotoSelect(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('form-photo-preview').src = e.target.result;
                    document.getElementById('card-avatar-img').src = e.target.result;
                    document.getElementById('form-remove-photo').value = '0';
                    document.getElementById('form-photo-reset-btn').style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function handleFormPhotoRemove() {
            document.getElementById('form-photo-input').value = '';
            document.getElementById('form-photo-preview').src = DEFAULT_AVATAR;
            document.getElementById('card-avatar-img').src = DEFAULT_AVATAR;
            document.getElementById('form-remove-photo').value = '1';
            document.getElementById('form-photo-reset-btn').style.display = 'inline-block';
        }

        function handleFormPhotoReset() {
            document.getElementById('form-photo-input').value = '';
            document.getElementById('form-photo-preview').src = ORIGINAL_AVATAR;
            document.getElementById('card-avatar-img').src = ORIGINAL_AVATAR;
            document.getElementById('form-remove-photo').value = '0';
            document.getElementById('form-photo-reset-btn').style.display = 'none';
        }

        // Modal photo preview handler
        function previewModalPhoto(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('modal-profile-photo-preview').src = e.target.result;
                    document.getElementById('modal-remove-photo').value = '0';
                    document.getElementById('modal-photo-reset-btn').style.display = 'inline-block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeModalPhoto() {
            document.getElementById('modal-profile-photo-input').value = '';
            document.getElementById('modal-profile-photo-preview').src = DEFAULT_AVATAR;
            document.getElementById('modal-remove-photo').value = '1';
            document.getElementById('modal-photo-reset-btn').style.display = 'inline-block';
        }

        function resetModalPhoto() {
            document.getElementById('modal-profile-photo-input').value = '';
            document.getElementById('modal-profile-photo-preview').src = ORIGINAL_AVATAR;
            document.getElementById('modal-remove-photo').value = '0';
            document.getElementById('modal-photo-reset-btn').style.display = 'none';
        }

        // Password visibility toggle
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Realtime password match check
        document.addEventListener('DOMContentLoaded', function() {
            const newPassword = document.getElementById('new_password');
            const confirmPassword = document.getElementById('password_confirmation');
            const matchFeedback = document.getElementById('password-match-feedback');

            function checkPasswords() {
                if (!confirmPassword.value) {
                    matchFeedback.style.display = 'none';
                    return;
                }
                matchFeedback.style.display = 'block';
                if (newPassword.value === confirmPassword.value) {
                    matchFeedback.className = 'small mt-1 text-success font-weight-bold';
                    matchFeedback.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Passwords match';
                } else {
                    matchFeedback.className = 'small mt-1 text-danger font-weight-bold';
                    matchFeedback.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Passwords do not match';
                }
            }

            if (newPassword && confirmPassword) {
                newPassword.addEventListener('input', checkPasswords);
                confirmPassword.addEventListener('input', checkPasswords);
            }
        });
    </script>
@endsection

@extends('layout.main')

@section('title', __('Add New Class'))

@section('content')

<style>
.cls-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}
html.dark-mode .cls-form-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.cls-form-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
html.dark-mode .cls-form-header {
    background: #191c2b;
    border-color: #2e354f;
}

.cls-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
}
html.dark-mode .cls-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}
.cls-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
}
html.dark-mode .cls-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}
.cls-input-group .form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
</style>

<section class="content-header pt-3 pb-2">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3 class="font-weight-bold" style="font-size: 1.35rem;">
                    <i class="fas fa-graduation-cap text-primary mr-2"></i>{{ __('Add New Class') }}
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-0">
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('class.index') }}">{{ __('Class List') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Add Class') }}</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="cls-form-card">
                <div class="cls-form-header">
                    <div>
                        <h5 class="mb-1 font-weight-bold">
                            {{ __('Class Information') }}
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ __('Fill in the academic grade details and assign a teacher in charge.') }}
                        </p>
                    </div>
                    <a href="{{ route('class.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Classes') }}
                    </a>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('class.store') }}" method="POST" onsubmit="if (typeof showOverlay === 'function') showOverlay();">
                        @csrf
                        
                        <!-- Class Name -->
                        <div class="form-group mb-4">
                            <label for="name" class="font-weight-bold text-sm">
                                {{ __('Class Name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group cls-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                </div>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('e.g., Grade 10 - Science') }}" required>
                            </div>
                        </div>

                        <!-- Class Code -->
                        <div class="form-group mb-4">
                            <label for="class_code" class="font-weight-bold text-sm">
                                {{ __('Class Code') }}
                            </label>
                            <div class="input-group cls-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                </div>
                                <input type="text" name="class_code" id="class_code" class="form-control" placeholder="{{ __('e.g., CLS-10A') }}">
                            </div>
                        </div>

                        <!-- Class Room -->
                        <div class="form-group mb-4">
                            <label for="class_room" class="font-weight-bold text-sm">
                                {{ __('Class Room') }}
                            </label>
                            <div class="input-group cls-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-door-open"></i></span>
                                </div>
                                <input type="text" name="class_room" id="class_room" class="form-control" placeholder="{{ __('e.g., Room 302, Building B') }}">
                            </div>
                        </div>

                        <!-- Teacher -->
                        <div class="form-group mb-4">
                            <label for="teacher_id" class="font-weight-bold text-sm">
                                {{ __('Teacher in Charge') }}
                            </label>
                            <div class="input-group cls-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                                </div>
                                <select class="form-control" id="teacher_id" name="teacher_id">
                                    <option value="">-- {{ __('Select Teacher') }} --</option>
                                    @foreach ($teachers as $teacher)
                                        <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            <a href="{{ route('class.index') }}" class="btn btn-secondary px-4">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                                <i class="fas fa-check mr-1"></i> {{ __('Save Class') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@extends('layout.main')

@php
    $isEdit = isset($material);
    $pageTitle = $isEdit ? __('Edit Learning Material') : __('Upload Learning Material');

    // Decode existing media for edit mode
    $existingGallery = [];
    if ($isEdit && !empty($material->gallery_path)) {
        $decoded = json_decode($material->gallery_path, true);
        $existingGallery = is_array($decoded) ? $decoded : [];
    }

    $existingFiles = [];
    if ($isEdit && !empty($material->file_path)) {
        $decoded = json_decode($material->file_path, true);
        $existingFiles = is_array($decoded) ? $decoded : [];
    }

    $existingVideos = [];
    $existingYoutubeUrls = [];
    if ($isEdit && !empty($material->url_vdo)) {
        $decoded = json_decode($material->url_vdo, true);
        $rawVideos = is_array($decoded) ? $decoded : [$material->url_vdo];
        foreach ($rawVideos as $v) {
            if (strpos($v, 'youtube.com') !== false || strpos($v, 'youtu.be') !== false) {
                $existingYoutubeUrls[] = $v;
            } else {
                $existingVideos[] = $v;
            }
        }
    }
@endphp

@section('title', $pageTitle . ' - ' . $subject->name)

@section('content')

<style>
/* ══════════════════════════════════════════════════════════════════
   ALL-IN-ONE MATERIAL STUDIO – Executive SaaS Architecture
══════════════════════════════════════════════════════════════════ */
.mat-upload-wrapper {
    padding: 0.5rem 0.25rem 4rem;
}

/* Hero Header Card */
.mat-header-box {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.25rem 1.6rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
}
html.dark-mode .mat-header-box {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mat-header-title {
    font-size: 1.35rem;
    font-weight: 800;
    margin-bottom: 0.25rem;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.65rem;
}
html.dark-mode .mat-header-title {
    color: #f8fafc;
}

.mat-header-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .mat-header-subtitle {
    color: #94a3b8;
}

.mat-meta-tags {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 0.35rem;
}

.mat-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.2rem 0.65rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
}
html.dark-mode .mat-meta-pill {
    background: #252a3d;
    color: #cbd5e1;
    border-color: #3b4261;
}

/* Form Cards */
.mat-form-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    margin-bottom: 1.25rem;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .mat-form-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mat-card-header {
    padding: 1rem 1.4rem;
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
html.dark-mode .mat-card-header {
    background: #191c2b;
    border-color: #2e354f;
}

.mat-card-header h5 {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
    gap: 0.55rem;
    color: #1e293b;
}
html.dark-mode .mat-card-header h5 {
    color: #f1f5f9;
}

.mat-card-body {
    padding: 1.4rem;
}

/* Custom Input Groups */
.mat-input-group .input-group-text {
    background: #f8fafc;
    border-color: #cbd5e1;
    color: #64748b;
    border-radius: 10px 0 0 10px;
}
html.dark-mode .mat-input-group .input-group-text {
    background: #252a3d;
    border-color: #3b4261;
    color: #94a3b8;
}

.mat-input-group .form-control {
    border-color: #cbd5e1;
    border-radius: 0 10px 10px 0;
}
html.dark-mode .mat-input-group .form-control {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}

.mat-input-group .form-control:focus,
.mat-textarea:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
.mat-textarea {
    border-radius: 10px;
    border-color: #cbd5e1;
}
html.dark-mode .mat-textarea {
    background: #1b1e2e;
    border-color: #3b4261;
    color: #f1f5f9;
}

/* ══════════════════════════════════════════════════════════════════
   ALL-IN-ONE UNIFIED DRAG & DROP BOX
══════════════════════════════════════════════════════════════════ */
.aio-dropzone {
    border: 2px dashed #93c5fd;
    border-radius: 16px;
    padding: 2.25rem 1.5rem;
    text-align: center;
    cursor: pointer;
    background: linear-gradient(180deg, #f8fafc 0%, #f0f7ff 100%);
    transition: all 0.25s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    position: relative;
}
.aio-dropzone:hover,
.aio-dropzone.dragover {
    border-color: #2563eb;
    background: #e0f2fe;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px -2px rgba(37, 99, 235, 0.18);
}
html.dark-mode .aio-dropzone {
    background: linear-gradient(180deg, #191c2b 0%, #151928 100%);
    border-color: #3b4261;
}
html.dark-mode .aio-dropzone:hover,
html.dark-mode .aio-dropzone.dragover {
    background: #1a233d;
    border-color: #60a5fa;
    box-shadow: 0 8px 24px -2px rgba(0, 0, 0, 0.45);
}

/* Multi-Type Icon Cluster */
.aio-icon-cluster {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.65rem;
    margin-bottom: 0.25rem;
}
.aio-cluster-badge {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    transition: transform 0.2s ease;
}
.aio-dropzone:hover .aio-cluster-badge {
    transform: translateY(-2px);
}
.cluster-img   { background: rgba(139, 92, 246, 0.14); color: #8b5cf6; }
.cluster-doc   { background: rgba(59, 130, 246, 0.14); color: #3b82f6; }
.cluster-video { background: rgba(239, 68, 68, 0.14); color: #ef4444; }

.aio-title {
    font-size: 1.05rem;
    font-weight: 800;
    color: #0f172a;
}
html.dark-mode .aio-title {
    color: #f8fafc;
}

.aio-subtitle {
    font-size: 0.85rem;
    color: #64748b;
    max-width: 480px;
    margin: 0 auto;
}
html.dark-mode .aio-subtitle {
    color: #94a3b8;
}

.aio-pill-tags {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    flex-wrap: wrap;
    margin-top: 0.25rem;
}
.aio-tag {
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding: 0.2rem 0.55rem;
    border-radius: 6px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    color: #475569;
}
html.dark-mode .aio-tag {
    background: #252a3d;
    border-color: #3b4261;
    color: #cbd5e1;
}

/* ══════════════════════════════════════════════════════════════════
   LIVE ATTACHED ASSET HUB (CATEGORIZED PREVIEW TRAY)
══════════════════════════════════════════════════════════════════ */
.asset-hub-wrap {
    margin-top: 1.5rem;
}

.asset-hub-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #e2e8f0;
}
html.dark-mode .asset-hub-header {
    border-color: #2e354f;
}

.asset-hub-tabs {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
}

.asset-tab-pill {
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 600;
    cursor: pointer;
    background: #f1f5f9;
    color: #475569;
    transition: all 0.2s;
    user-select: none;
}
.asset-tab-pill:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.asset-tab-pill.active {
    background: #3b82f6;
    color: #ffffff;
}
html.dark-mode .asset-tab-pill {
    background: #252a3d;
    color: #cbd5e1;
}
html.dark-mode .asset-tab-pill:hover {
    background: #2e354f;
}
html.dark-mode .asset-tab-pill.active {
    background: #3b82f6;
    color: #ffffff;
}

/* Image Previews Grid */
.asset-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(95px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.asset-img-box {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
}
html.dark-mode .asset-img-box {
    border-color: #2e354f;
    background: #252a3d;
}
.asset-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.asset-remove-btn {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    background: #ef4444;
    color: #ffffff;
    border: none;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.25);
    transition: transform 0.15s;
}
.asset-remove-btn:hover {
    transform: scale(1.15);
    background: #dc2626;
}

/* Document & Video Rows */
.asset-list {
    display: flex;
    flex-direction: column;
    gap: 0.6rem;
    margin-bottom: 1.25rem;
}
.asset-item-row {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 0.65rem 0.95rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    transition: all 0.2s;
}
.asset-item-row:hover {
    border-color: #cbd5e1;
    background: #f1f5f9;
}
html.dark-mode .asset-item-row {
    background: #191c2b;
    border-color: #2e354f;
    color: #e2e8f0;
}
html.dark-mode .asset-item-row:hover {
    background: #202538;
}

.asset-item-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 0;
    flex: 1;
}
.asset-item-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.icon-pdf   { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.icon-word  { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.icon-excel { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.icon-ppt   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.icon-zip   { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.icon-video { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.icon-file  { background: rgba(100, 116, 139, 0.12); color: #64748b; }

.asset-item-name {
    font-size: 0.88rem;
    font-weight: 600;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

/* Sticky Footer */
.mat-sticky-footer {
    position: sticky;
    bottom: 0;
    z-index: 1030;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-top: 1px solid #e2e8f0;
    padding: 1rem 1.5rem;
    margin: 2rem -0.75rem -1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    box-shadow: 0 -4px 16px rgba(0, 0, 0, 0.05);
}
html.dark-mode .mat-sticky-footer {
    background: rgba(30, 34, 53, 0.95);
    border-color: #2e354f;
    box-shadow: 0 -4px 20px rgba(0, 0, 0, 0.35);
}

/* Upload Progress Overlay */
#uploadOverlay {
    display: none;
    position: fixed;
    z-index: 99999;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(6px);
    align-items: center;
    justify-content: center;
}
.upload-modal-box {
    background: #ffffff;
    border-radius: 18px;
    padding: 2rem;
    width: 90%;
    max-width: 460px;
    text-align: center;
    box-shadow: 0 16px 40px rgba(0, 0, 0, 0.3);
}
html.dark-mode .upload-modal-box {
    background: #1e2235;
    color: #f8fafc;
    border: 1px solid #2e354f;
}
.upload-spinner-ring {
    width: 54px;
    height: 54px;
    border: 4px solid #e2e8f0;
    border-top-color: #3b82f6;
    border-radius: 50%;
    animation: spinRing 0.9s linear infinite;
    margin: 0 auto 1.25rem;
}
html.dark-mode .upload-spinner-ring {
    border-color: #2e354f;
    border-top-color: #60a5fa;
}
@keyframes spinRing { to { transform: rotate(360deg); } }

.upload-progress-wrap {
    background: #f1f5f9;
    border-radius: 10px;
    height: 12px;
    overflow: hidden;
    margin: 1.25rem 0 0.5rem;
}
html.dark-mode .upload-progress-wrap { background: #252a3d; }
.upload-progress-fill {
    height: 100%;
    width: 0%;
    background: linear-gradient(90deg, #3b82f6, #10b981);
    transition: width 0.25s ease;
}
</style>

<div class="mat-upload-wrapper">
    <!-- Breadcrumb Section -->
    <section class="content-header pt-1 pb-2">
        <div class="container-fluid px-0">
            <div class="row align-items-center mb-1">
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="/dashboard">{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('myClass.index') }}">{{ __('My Classes') }}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('getSubject.index', ['class_id' => $subject->class_id]) }}">
                                {{ $subject->class_name ?? __('Class Subjects') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}">
                                {{ $subject->name }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $pageTitle }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Header Box -->
    <div class="mat-header-box">
        <div>
            <h1 class="mat-header-title">
                <i class="{{ $isEdit ? 'fas fa-edit text-primary' : 'fas fa-cloud-upload-alt text-primary' }}"></i>
                {{ $pageTitle }}
            </h1>
            <p class="mat-header-subtitle">
                {{ __('Publish lecture notes, slide presentations, assignment documents, video links, or photo galleries for') }} <strong>{{ $subject->name }}</strong>.
            </p>
            <div class="mat-meta-tags">
                @if(!empty($subject->class_name))
                    <span class="mat-meta-pill">
                        <i class="fas fa-graduation-cap text-primary"></i>
                        <span>{{ $subject->class_name }}</span>
                        @if(!empty($subject->class_code))
                            <span class="badge badge-light border ml-1">{{ $subject->class_code }}</span>
                        @endif
                    </span>
                @endif
                @if(!empty($subject->class_room))
                    <span class="mat-meta-pill">
                        <i class="fas fa-door-open text-success"></i>
                        <span>{{ $subject->class_room }}</span>
                    </span>
                @endif
                @if(!empty($subject->teacher_name))
                    <span class="mat-meta-pill">
                        <i class="fas fa-user-tie text-info"></i>
                        <span>{{ $subject->teacher_name }}</span>
                    </span>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}" class="btn btn-outline-secondary font-weight-600" style="border-radius: 10px;">
                <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Materials') }}
            </a>
            <button type="submit" form="materialUploadForm" class="btn btn-primary font-weight-bold px-4" style="border-radius: 10px;">
                <i class="{{ $isEdit ? 'fas fa-save mr-1' : 'fas fa-paper-plane mr-1' }}"></i>
                {{ $isEdit ? __('Update Material') : __('Publish Material') }}
            </button>
        </div>
    </div>

    <!-- Main Authoring Form -->
    <form id="materialUploadForm" action="{{ $isEdit ? route('materials.updateFull', $material->id) : route('materials.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($isEdit)
            <input type="hidden" name="material_id" value="{{ $material->id }}">
            <input type="hidden" name="existing_gallery" id="existingGalleryInput" value="{{ json_encode($existingGallery) }}">
            <input type="hidden" name="existing_files" id="existingFilesInput" value="{{ json_encode($existingFiles) }}">
            <input type="hidden" name="existing_videos" id="existingVideosInput" value="{{ json_encode($existingVideos) }}">
        @else
            <input type="hidden" name="subject_id" value="{{ $subject->subject_id }}">
        @endif

        <!-- Hidden Categorized Native File Inputs populated automatically by the All-In-One Box -->
        <input type="file" id="galleryInput" name="gallery_path[]" class="d-none" multiple accept="image/*">
        <input type="file" id="documentInput" name="file_path[]" class="d-none" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
        <input type="file" id="videoInput" name="video_file[]" class="d-none" multiple accept="video/mp4,video/avi,video/mov,video/mkv">

        <div class="row">
            <!-- Left Column: General Notes & YouTube Links -->
            <div class="col-lg-5">
                <!-- 1. General Notes Card -->
                <div class="mat-form-card">
                    <div class="mat-card-header">
                        <h5>
                            <i class="fas fa-align-left text-primary"></i>
                            {{ __('General Lecture Information') }}
                        </h5>
                    </div>
                    <div class="mat-card-body">
                        <!-- Title Input -->
                        <div class="form-group mb-3">
                            <label for="materialTitle" class="font-weight-bold text-sm">
                                {{ __('Material / Post Title') }}
                            </label>
                            <div class="input-group mat-input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-heading"></i></span>
                                </div>
                                <input type="text" id="materialTitle" name="title" class="form-control"
                                       value="{{ old('title', $material->title ?? '') }}"
                                       placeholder="{{ __('e.g., Week 3: Figma Prototyping & Variables') }}">
                            </div>
                        </div>

                        <!-- Description Textarea -->
                        <div class="form-group mb-0">
                            <label for="materialDescription" class="font-weight-bold text-sm">
                                {{ __('Lecture Notes & Instructions') }}
                            </label>
                            <textarea id="materialDescription" name="description" class="form-control mat-textarea" rows="7"
                                      placeholder="{{ __('Enter lecture summary, reading assignments, or homework guidance...') }}">{{ old('description', $material->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- 2. YouTube Video URLs Card -->
                <div class="mat-form-card">
                    <div class="mat-card-header">
                        <h5>
                            <i class="fab fa-youtube text-danger"></i>
                            {{ __('YouTube Video Links') }}
                        </h5>
                    </div>
                    <div class="mat-card-body">
                        <div class="form-group mb-0">
                            <label for="url_vdo" class="font-weight-bold text-sm">
                                {{ __('Paste YouTube URLs (Separate by commas or lines)') }}
                            </label>
                            <textarea name="url_vdo" id="url_vdo" class="form-control mat-textarea" rows="3"
                                      placeholder="https://www.youtube.com/watch?v=..., https://youtu.be/...">{{ old('url_vdo', implode(', ', $existingYoutubeUrls)) }}</textarea>
                            <small class="text-muted d-block mt-1">
                                <i class="fas fa-info-circle mr-1"></i> {{ __('YouTube links are automatically parsed into responsive 16:9 embeds.') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: ALL-IN-ONE DRAG & DROP BOX & LIVE ASSET HUB -->
            <div class="col-lg-7">
                <div class="mat-form-card">
                    <div class="mat-card-header">
                        <h5>
                            <i class="fas fa-cloud-upload-alt text-primary"></i>
                            {{ __('All-In-One Media & Files Dropzone') }}
                        </h5>
                        <span class="badge badge-light border text-muted" id="totalAssetBadge">
                            0 {{ __('Assets attached') }}
                        </span>
                    </div>

                    <div class="mat-card-body">
                        <!-- THE UNIFIED ALL-IN-ONE DROPZONE -->
                        <div class="aio-dropzone" id="allInOneDropzone">
                            <div class="aio-icon-cluster">
                                <div class="aio-cluster-badge cluster-img" title="{{ __('Images') }}">
                                    <i class="fas fa-image"></i>
                                </div>
                                <div class="aio-cluster-badge cluster-doc" title="{{ __('Documents') }}">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                                <div class="aio-cluster-badge cluster-video" title="{{ __('Videos') }}">
                                    <i class="fas fa-video"></i>
                                </div>
                            </div>

                            <div class="aio-title">
                                {{ __('Drag & drop ANY files here, or click to browse') }}
                            </div>
                            <div class="aio-subtitle">
                                {{ __('Drop images, PDF handouts, slides, spreadsheets, or video recordings together. They are automatically categorized!') }}
                            </div>

                            <div class="aio-pill-tags">
                                <span class="aio-tag"><i class="fas fa-camera mr-1 text-purple"></i> Images</span>
                                <span class="aio-tag"><i class="fas fa-file-pdf mr-1 text-danger"></i> PDF / Docs</span>
                                <span class="aio-tag"><i class="fas fa-file-excel mr-1 text-success"></i> Excel / Slides</span>
                                <span class="aio-tag"><i class="fas fa-film mr-1 text-danger"></i> Videos (MP4/MOV)</span>
                                <span class="aio-tag"><i class="fas fa-file-archive mr-1 text-primary"></i> ZIP / RAR</span>
                            </div>

                            <button type="button" class="btn btn-sm btn-primary px-3 mt-2 font-weight-bold" style="border-radius: 8px;">
                                <i class="fas fa-folder-open mr-1"></i> {{ __('Browse Files on Device') }}
                            </button>

                            <!-- Master All-in-One File Input -->
                            <input type="file" id="allInOneInput" class="d-none" multiple accept="image/*,video/*,.pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
                        </div>

                        <!-- LIVE CATEGORIZED ASSET HUB TRAY -->
                        <div class="asset-hub-wrap" id="assetHubSection">
                            <div class="asset-hub-header">
                                <div class="asset-hub-tabs">
                                    <div class="asset-tab-pill active" data-tab="all">
                                        <i class="fas fa-th mr-1"></i> {{ __('All Assets') }} (<span id="countAll">0</span>)
                                    </div>
                                    <div class="asset-tab-pill" data-tab="images">
                                        <i class="fas fa-images mr-1 text-purple"></i> {{ __('Images') }} (<span id="countImg">0</span>)
                                    </div>
                                    <div class="asset-tab-pill" data-tab="docs">
                                        <i class="fas fa-file-alt mr-1 text-primary"></i> {{ __('Documents') }} (<span id="countDocs">0</span>)
                                    </div>
                                    <div class="asset-tab-pill" data-tab="videos">
                                        <i class="fas fa-video mr-1 text-danger"></i> {{ __('Videos') }} (<span id="countVideos">0</span>)
                                    </div>
                                </div>

                                <button type="button" class="btn btn-sm btn-link text-danger p-0" id="clearAllAssetsBtn" style="font-size: 0.8rem; display: none;">
                                    <i class="fas fa-trash-alt mr-1"></i> {{ __('Clear all') }}
                                </button>
                            </div>

                            <!-- 1. Photos & Gallery Asset Section -->
                            <div class="asset-category-block" id="categoryBlockImages">
                                <label class="font-weight-bold text-xs text-uppercase text-muted mb-2 d-block">
                                    <i class="fas fa-images text-purple mr-1"></i> {{ __('Attached Photos & Gallery') }}
                                </label>
                                <div class="asset-gallery-grid" id="assetGalleryGrid">
                                    <!-- Rendered dynamically -->
                                </div>
                            </div>

                            <!-- 2. Documents Asset Section -->
                            <div class="asset-category-block" id="categoryBlockDocs">
                                <label class="font-weight-bold text-xs text-uppercase text-muted mb-2 d-block">
                                    <i class="fas fa-folder text-primary mr-1"></i> {{ __('Attached Documents & Handouts') }}
                                </label>
                                <div class="asset-list" id="assetDocsList">
                                    <!-- Rendered dynamically -->
                                </div>
                            </div>

                            <!-- 3. Videos Asset Section -->
                            <div class="asset-category-block" id="categoryBlockVideos">
                                <label class="font-weight-bold text-xs text-uppercase text-muted mb-2 d-block">
                                    <i class="fas fa-film text-danger mr-1"></i> {{ __('Attached Video Recordings') }}
                                </label>
                                <div class="asset-list" id="assetVideosList">
                                    <!-- Rendered dynamically -->
                                </div>
                            </div>

                            <!-- Empty Tray Notice -->
                            <div id="emptyAssetTrayNotice" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-2x mb-2 text-secondary opacity-50"></i>
                                <p class="small font-weight-bold mb-0">{{ __('No media or files added yet') }}</p>
                                <small>{{ __('Drop your images, PDFs, spreadsheets, or videos in the box above.') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer Action Bar -->
        <div class="mat-sticky-footer">
            <div class="d-flex align-items-center">
                <span class="text-muted small mr-2 d-none d-sm-inline">
                    {{ __('Target Subject:') }}
                </span>
                <span class="badge badge-light border font-weight-bold text-primary p-2" style="font-size: 0.85rem;">
                    <i class="fas fa-book-open mr-1"></i> {{ $subject->name }}
                </span>
            </div>

            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}" class="btn btn-secondary px-4 font-weight-600" style="border-radius: 10px;">
                    {{ __('Cancel') }}
                </a>
                <button type="submit" class="btn btn-primary px-4 font-weight-bold" style="border-radius: 10px;">
                    <i class="{{ $isEdit ? 'fas fa-save mr-1' : 'fas fa-paper-plane mr-1' }}"></i>
                    {{ $isEdit ? __('Save Material Updates') : __('Publish Material') }}
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Upload Progress Modal Overlay -->
<div id="uploadOverlay">
    <div class="upload-modal-box">
        <div class="upload-spinner-ring"></div>
        <h4 class="font-weight-bold mb-1" id="uploadStatusTitle">{{ __('Uploading Material...') }}</h4>
        <p class="text-muted small mb-0">{{ __('Please wait while your files and media are uploaded to the server.') }}</p>

        <div class="upload-progress-wrap">
            <div class="upload-progress-fill" id="uploadProgressBar"></div>
        </div>
        <div class="font-weight-bold text-primary small" id="uploadProgressText">0%</div>
    </div>
</div>

<!-- ============================================================== -->
<!-- JAVASCRIPT: ALL-IN-ONE PARSER, SYNC & PREVIEWS                 -->
<!-- ============================================================== -->
<script>
const base_url = "{{ asset('') }}";

// Pre-existing media arrays for edit mode
let existingGallery = @json($existingGallery);
let existingFiles   = @json($existingFiles);
let existingVideos  = @json($existingVideos);

// Queues for newly added files
let queuedImages = [];
let queuedDocs   = [];
let queuedVideos = [];

document.addEventListener('DOMContentLoaded', function () {
    const allInOneInput    = document.getElementById('allInOneInput');
    const allInOneDropzone = document.getElementById('allInOneDropzone');

    const galleryInput  = document.getElementById('galleryInput');
    const documentInput = document.getElementById('documentInput');
    const videoInput    = document.getElementById('videoInput');

    const existingGalleryInput = document.getElementById('existingGalleryInput');
    const existingFilesInput   = document.getElementById('existingFilesInput');
    const existingVideosInput  = document.getElementById('existingVideosInput');

    const assetGalleryGrid = document.getElementById('assetGalleryGrid');
    const assetDocsList    = document.getElementById('assetDocsList');
    const assetVideosList  = document.getElementById('assetVideosList');

    const categoryBlockImages = document.getElementById('categoryBlockImages');
    const categoryBlockDocs   = document.getElementById('categoryBlockDocs');
    const categoryBlockVideos = document.getElementById('categoryBlockVideos');

    const countAll    = document.getElementById('countAll');
    const countImg    = document.getElementById('countImg');
    const countDocs   = document.getElementById('countDocs');
    const countVideos = document.getElementById('countVideos');
    const totalAssetBadge = document.getElementById('totalAssetBadge');

    const emptyNotice = document.getElementById('emptyAssetTrayNotice');
    const clearAllBtn = document.getElementById('clearAllAssetsBtn');
    const tabPills    = document.querySelectorAll('.asset-tab-pill');

    let activeFilter = 'all';

    // -------------------------------------------------------------
    // 1. SMART FILE CLASSIFICATION
    // -------------------------------------------------------------
    const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
    const videoExts = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'wmv', 'flv'];

    function classifyFile(file) {
        const ext = (file.name.split('.').pop() || '').toLowerCase();
        const mime = file.type || '';

        if (mime.startsWith('image/') || imageExts.includes(ext)) {
            return 'image';
        }
        if (mime.startsWith('video/') || videoExts.includes(ext)) {
            return 'video';
        }
        return 'document';
    }

    function processIncomingFiles(fileList) {
        Array.from(fileList).forEach(file => {
            const kind = classifyFile(file);
            if (kind === 'image') {
                queuedImages.push(file);
            } else if (kind === 'video') {
                queuedVideos.push(file);
            } else {
                queuedDocs.push(file);
            }
        });

        syncNativeInputs();
        renderAssetTray();
    }

    // -------------------------------------------------------------
    // 2. SYNC WITH NATIVE SUBMISSION INPUTS VIA DATATRANSFER
    // -------------------------------------------------------------
    function syncNativeInputs() {
        if (galleryInput) {
            const dtImg = new DataTransfer();
            queuedImages.forEach(f => dtImg.items.add(f));
            galleryInput.files = dtImg.files;
        }

        if (documentInput) {
            const dtDoc = new DataTransfer();
            queuedDocs.forEach(f => dtDoc.items.add(f));
            documentInput.files = dtDoc.files;
        }

        if (videoInput) {
            const dtVid = new DataTransfer();
            queuedVideos.forEach(f => dtVid.items.add(f));
            videoInput.files = dtVid.files;
        }

        if (existingGalleryInput) existingGalleryInput.value = JSON.stringify(existingGallery);
        if (existingFilesInput)   existingFilesInput.value   = JSON.stringify(existingFiles);
        if (existingVideosInput)  existingVideosInput.value  = JSON.stringify(existingVideos);
    }

    // -------------------------------------------------------------
    // 3. RENDER THE ASSET TRAY (IMAGES, DOCS, VIDEOS)
    // -------------------------------------------------------------
    function renderAssetTray() {
        const totalImg   = existingGallery.length + queuedImages.length;
        const totalDocs  = existingFiles.length + queuedDocs.length;
        const totalVids  = existingVideos.length + queuedVideos.length;
        const grandTotal = totalImg + totalDocs + totalVids;

        // Update counters
        if (countAll)    countAll.textContent    = grandTotal;
        if (countImg)    countImg.textContent    = totalImg;
        if (countDocs)   countDocs.textContent   = totalDocs;
        if (countVideos) countVideos.textContent = totalVids;
        if (totalAssetBadge) totalAssetBadge.textContent = `${grandTotal} {{ __('Assets attached') }}`;

        if (clearAllBtn) {
            clearAllBtn.style.display = grandTotal > 0 ? 'inline-block' : 'none';
        }

        if (emptyNotice) {
            emptyNotice.style.display = grandTotal === 0 ? 'block' : 'none';
        }

        // --- Render Images ---
        if (categoryBlockImages && assetGalleryGrid) {
            const showImages = (activeFilter === 'all' || activeFilter === 'images') && totalImg > 0;
            categoryBlockImages.style.display = showImages ? 'block' : 'none';
            assetGalleryGrid.innerHTML = '';

            // Existing images
            existingGallery.forEach((img, i) => {
                const box = document.createElement('div');
                box.className = 'asset-img-box';
                box.innerHTML = `
                    <img src="${base_url}upload_materials/${img}" alt="Photo">
                    <button type="button" class="asset-remove-btn" onclick="removeExistingGalleryItem(${i})" title="{{ __('Remove photo') }}">×</button>
                `;
                assetGalleryGrid.appendChild(box);
            });

            // Queued new images
            queuedImages.forEach((file, i) => {
                const box = document.createElement('div');
                box.className = 'asset-img-box';
                const img = document.createElement('img');

                const reader = new FileReader();
                reader.onload = e => { img.src = e.target.result; };
                reader.readAsDataURL(file);

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'asset-remove-btn';
                btn.innerHTML = '×';
                btn.title = '{{ __("Remove photo") }}';
                btn.onclick = () => {
                    queuedImages.splice(i, 1);
                    syncNativeInputs();
                    renderAssetTray();
                };

                box.appendChild(img);
                box.appendChild(btn);
                assetGalleryGrid.appendChild(box);
            });
        }

        // --- Render Documents ---
        if (categoryBlockDocs && assetDocsList) {
            const showDocs = (activeFilter === 'all' || activeFilter === 'docs') && totalDocs > 0;
            categoryBlockDocs.style.display = showDocs ? 'block' : 'none';
            assetDocsList.innerHTML = '';

            // Existing docs
            existingFiles.forEach((doc, i) => {
                const ext = doc.split('.').pop().toLowerCase();
                const filename = doc.split('/').pop();
                const iconClass = getDocIconClass(ext);

                const item = document.createElement('div');
                item.className = 'asset-item-row';
                item.innerHTML = `
                    <div class="asset-item-left">
                        <div class="asset-item-icon ${iconClass.boxClass}"><i class="${iconClass.icon}"></i></div>
                        <div class="text-truncate" style="flex: 1;">
                            <div class="asset-item-name" title="${filename}">${filename}</div>
                            <span class="badge badge-light border text-uppercase" style="font-size: 0.68rem;">${ext}</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeExistingDocItem(${i})" title="{{ __('Remove document') }}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                assetDocsList.appendChild(item);
            });

            // Queued new docs
            queuedDocs.forEach((file, i) => {
                const ext = (file.name.split('.').pop() || '').toLowerCase();
                const sizeMb = (file.size / 1024 / 1024).toFixed(2);
                const iconClass = getDocIconClass(ext);

                const item = document.createElement('div');
                item.className = 'asset-item-row';
                item.innerHTML = `
                    <div class="asset-item-left">
                        <div class="asset-item-icon ${iconClass.boxClass}"><i class="${iconClass.icon}"></i></div>
                        <div class="text-truncate" style="flex: 1;">
                            <div class="asset-item-name" title="${file.name}">${file.name}</div>
                            <span class="badge badge-light border text-uppercase" style="font-size: 0.68rem;">${ext}</span>
                            <span class="text-muted small ml-1">(${sizeMb} MB)</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeQueuedDocItem(${i})" title="{{ __('Remove document') }}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                assetDocsList.appendChild(item);
            });
        }

        // --- Render Videos ---
        if (categoryBlockVideos && assetVideosList) {
            const showVideos = (activeFilter === 'all' || activeFilter === 'videos') && totalVids > 0;
            categoryBlockVideos.style.display = showVideos ? 'block' : 'none';
            assetVideosList.innerHTML = '';

            // Existing videos
            existingVideos.forEach((vid, i) => {
                const item = document.createElement('div');
                item.className = 'asset-item-row';
                item.innerHTML = `
                    <div class="asset-item-left">
                        <div class="asset-item-icon icon-video"><i class="fas fa-video"></i></div>
                        <div class="text-truncate" style="flex: 1;">
                            <div class="asset-item-name" title="${vid}">${vid}</div>
                            <span class="badge badge-light border text-uppercase" style="font-size: 0.68rem;">VIDEO</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeExistingVideoItem(${i})" title="{{ __('Remove video') }}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                assetVideosList.appendChild(item);
            });

            // Queued new videos
            queuedVideos.forEach((file, i) => {
                const sizeMb = (file.size / 1024 / 1024).toFixed(2);
                const item = document.createElement('div');
                item.className = 'asset-item-row';
                item.innerHTML = `
                    <div class="asset-item-left">
                        <div class="asset-item-icon icon-video"><i class="fas fa-video"></i></div>
                        <div class="text-truncate" style="flex: 1;">
                            <div class="asset-item-name" title="${file.name}">${file.name}</div>
                            <span class="badge badge-light border text-uppercase" style="font-size: 0.68rem;">VIDEO</span>
                            <span class="text-muted small ml-1">(${sizeMb} MB)</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeQueuedVideoItem(${i})" title="{{ __('Remove video') }}">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                assetVideosList.appendChild(item);
            });
        }
    }

    function getDocIconClass(ext) {
        if (['pdf'].includes(ext)) {
            return { boxClass: 'icon-pdf', icon: 'fas fa-file-pdf' };
        }
        if (['doc', 'docx'].includes(ext)) {
            return { boxClass: 'icon-word', icon: 'fas fa-file-word' };
        }
        if (['xls', 'xlsx', 'csv'].includes(ext)) {
            return { boxClass: 'icon-excel', icon: 'fas fa-file-excel' };
        }
        if (['ppt', 'pptx'].includes(ext)) {
            return { boxClass: 'icon-ppt', icon: 'fas fa-file-powerpoint' };
        }
        if (['zip', 'rar', '7z', 'tar', 'gz'].includes(ext)) {
            return { boxClass: 'icon-zip', icon: 'fas fa-file-archive' };
        }
        return { boxClass: 'icon-file', icon: 'fas fa-file' };
    }

    // -------------------------------------------------------------
    // 4. ITEM REMOVAL HANDLERS
    // -------------------------------------------------------------
    window.removeExistingGalleryItem = function(index) {
        existingGallery.splice(index, 1);
        syncNativeInputs();
        renderAssetTray();
    };

    window.removeExistingDocItem = function(index) {
        existingFiles.splice(index, 1);
        syncNativeInputs();
        renderAssetTray();
    };

    window.removeExistingVideoItem = function(index) {
        existingVideos.splice(index, 1);
        syncNativeInputs();
        renderAssetTray();
    };

    window.removeQueuedDocItem = function(index) {
        queuedDocs.splice(index, 1);
        syncNativeInputs();
        renderAssetTray();
    };

    window.removeQueuedVideoItem = function(index) {
        queuedVideos.splice(index, 1);
        syncNativeInputs();
        renderAssetTray();
    };

    if (clearAllBtn) {
        clearAllBtn.addEventListener('click', function () {
            existingGallery = [];
            existingFiles   = [];
            existingVideos  = [];
            queuedImages    = [];
            queuedDocs      = [];
            queuedVideos    = [];
            syncNativeInputs();
            renderAssetTray();
        });
    }

    // Filter tab switching
    tabPills.forEach(pill => {
        pill.addEventListener('click', function () {
            tabPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.getAttribute('data-tab') || 'all';
            renderAssetTray();
        });
    });

    // -------------------------------------------------------------
    // 5. ALL-IN-ONE DROPZONE & FILE INPUT LISTENERS
    // -------------------------------------------------------------
    if (allInOneDropzone && allInOneInput) {
        allInOneDropzone.addEventListener('click', () => allInOneInput.click());

        allInOneInput.addEventListener('change', function () {
            if (this.files && this.files.length > 0) {
                processIncomingFiles(this.files);
                this.value = ''; // Reset so the same file can be re-selected if deleted
            }
        });

        // Drag & drop highlight events
        ['dragenter', 'dragover'].forEach(eventName => {
            allInOneDropzone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                allInOneDropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(eventName => {
            allInOneDropzone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
                allInOneDropzone.classList.remove('dragover');
            });
        });

        allInOneDropzone.addEventListener('drop', e => {
            if (e.dataTransfer && e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                processIncomingFiles(e.dataTransfer.files);
            }
        });
    }

    // Initial render for pre-existing media in edit mode
    renderAssetTray();

    // -------------------------------------------------------------
    // 6. ASYNC UPLOAD PROGRESS ON FORM SUBMIT
    // -------------------------------------------------------------
    const form = document.getElementById('materialUploadForm');
    const overlay = document.getElementById('uploadOverlay');
    const progressBar = document.getElementById('uploadProgressBar');
    const progressText = document.getElementById('uploadProgressText');
    const statusTitle = document.getElementById('uploadStatusTitle');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Show upload overlay
            if (overlay) overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', form.action, true);
            xhr.setRequestHeader('Accept', 'application/json');

            xhr.upload.addEventListener('progress', function (event) {
                if (event.lengthComputable) {
                    const pct = Math.round((event.loaded / event.total) * 100);
                    if (progressBar) progressBar.style.width = pct + '%';
                    if (progressText) progressText.textContent = pct + '%';
                }
            });

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 400) {
                    if (statusTitle) statusTitle.textContent = '{{ __("Upload Complete!") }}';
                    if (progressBar) progressBar.style.width = '100%';
                    if (progressText) progressText.textContent = '100%';

                    setTimeout(() => {
                        window.location.href = "{{ route('class.materials', ['subject_id' => $subject->subject_id]) }}";
                    }, 800);
                } else {
                    document.body.style.overflow = '';
                    if (overlay) overlay.style.display = 'none';

                    try {
                        const res = JSON.parse(xhr.responseText);
                        const msg = res.message || res.error || '{{ __("Upload failed.") }}';
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({ icon: 'error', title: '{{ __("Upload Error") }}', text: msg });
                        } else {
                            alert(msg);
                        }
                    } catch (err) {
                        alert('{{ __("An error occurred during upload. Please verify file sizes and formats.") }}');
                    }
                }
            };

            xhr.onerror = function () {
                document.body.style.overflow = '';
                if (overlay) overlay.style.display = 'none';
                alert('{{ __("Connection error occurred.") }}');
            };

            xhr.send(formData);
        });
    }
});
</script>

@endsection

@extends('layout.main')

@section('title', __('Course Materials') . ' - ' . $subject->name)

@section('content')

@php
    $canManage = in_array((int)Auth::user()->role, [0, 1]);
@endphp

<style>
/* ══════════════════════════════════════════════════════════════════
   COURSE MATERIALS PORTAL – Executive SaaS Architecture
══════════════════════════════════════════════════════════════════ */
.mat-portal-wrapper {
    padding: 0.5rem 0.25rem 3rem;
}

/* Hero Header Banner */
.mat-hero-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.35rem 1.6rem;
    margin-bottom: 1.25rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1.25rem;
}
html.dark-mode .mat-hero-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mat-hero-main {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.mat-hero-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.25);
    flex-shrink: 0;
}

.mat-hero-title {
    font-size: 1.45rem;
    font-weight: 800;
    margin-bottom: 0.3rem;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 0.6rem;
}
html.dark-mode .mat-hero-title {
    color: #f8fafc;
}

.mat-meta-tags {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.mat-meta-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    padding: 0.25rem 0.65rem;
    border-radius: 8px;
    font-size: 0.8rem;
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

.mat-action-btn-group {
    display: flex;
    align-items: center;
    gap: 0.65rem;
    flex-wrap: wrap;
}

.mat-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.55rem 1.15rem;
    border-radius: 10px;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: 1px solid transparent;
}
.mat-btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
}
.mat-btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.35);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
.mat-btn-secondary {
    background: #f1f5f9;
    color: #334155 !important;
    border-color: #cbd5e1;
}
.mat-btn-secondary:hover {
    background: #e2e8f0;
    color: #0f172a !important;
}
html.dark-mode .mat-btn-secondary {
    background: #282f48;
    color: #e2e8f0 !important;
    border-color: #3b4261;
}
html.dark-mode .mat-btn-secondary:hover {
    background: #333c5e;
}

/* KPI Cards Grid */
.mat-kpi-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}

.mat-kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 1.15rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.mat-kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
html.dark-mode .mat-kpi-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.mat-kpi-icon {
    width: 46px;
    height: 46px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    flex-shrink: 0;
}
.kpi-blue    { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.kpi-emerald { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.kpi-violet  { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.kpi-amber   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }

.mat-kpi-value {
    font-size: 1.6rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .mat-kpi-value {
    color: #f8fafc;
}
.mat-kpi-label {
    font-size: 0.78rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #64748b;
    margin-top: 0.15rem;
}
html.dark-mode .mat-kpi-label {
    color: #94a3b8;
}

/* Filter & Search Bar */
.mat-toolbar-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 0.85rem 1.25rem;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.85rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
}
html.dark-mode .mat-toolbar-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.25);
}

.mat-filter-pills {
    display: flex;
    align-items: center;
    gap: 0.4rem;
    flex-wrap: wrap;
}

.mat-filter-pill {
    padding: 0.4rem 0.85rem;
    border-radius: 8px;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid transparent;
    transition: all 0.2s;
    user-select: none;
}
.mat-filter-pill:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.mat-filter-pill.active {
    background: #3b82f6;
    color: #ffffff;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.25);
}
html.dark-mode .mat-filter-pill {
    background: #252a3d;
    color: #cbd5e1;
}
html.dark-mode .mat-filter-pill:hover {
    background: #2e354f;
}
html.dark-mode .mat-filter-pill.active {
    background: #3b82f6;
    color: #ffffff;
}

.mat-search-box {
    position: relative;
    min-width: 240px;
    max-width: 340px;
    flex: 1;
}
.mat-search-input {
    width: 100%;
    padding: 0.45rem 1rem 0.45rem 2.25rem;
    border-radius: 10px;
    border: 1px solid #cbd5e1;
    font-size: 0.875rem;
    background: #ffffff;
    color: #1e293b;
    transition: all 0.2s;
}
.mat-search-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
}
html.dark-mode .mat-search-input {
    background: #252a3d;
    border-color: #3b4261;
    color: #f1f5f9;
}
.mat-search-icon {
    position: absolute;
    left: 0.8rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}

/* Material Feed Cards */
.mat-feed {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.mat-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.mat-card:hover {
    box-shadow: 0 8px 24px -2px rgba(0, 0, 0, 0.07);
}
html.dark-mode .mat-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mat-card-header {
    padding: 1.15rem 1.4rem;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    background: #fafafa;
}
html.dark-mode .mat-card-header {
    background: #191c2b;
    border-color: #2e354f;
}

.mat-author-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.mat-author-avatar {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    background: linear-gradient(135deg, #e0e7ff, #c7d2fe);
    color: #3730a3;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.9rem;
    flex-shrink: 0;
}
html.dark-mode .mat-author-avatar {
    background: linear-gradient(135deg, #2e3558, #3b426b);
    color: #a5b4fc;
}

.mat-author-name {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1e293b;
    line-height: 1.2;
}
html.dark-mode .mat-author-name {
    color: #f1f5f9;
}
.mat-post-date {
    font-size: 0.78rem;
    color: #64748b;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: 0.15rem;
}
html.dark-mode .mat-post-date {
    color: #94a3b8;
}

.mat-card-body {
    padding: 1.4rem;
}

.mat-card-title {
    font-size: 1.2rem;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 0.65rem;
}
html.dark-mode .mat-card-title {
    color: #f8fafc;
}

.mat-card-desc {
    font-size: 0.92rem;
    color: #334155;
    line-height: 1.6;
    margin-bottom: 1.25rem;
    white-space: pre-line;
}
html.dark-mode .mat-card-desc {
    color: #cbd5e1;
}

/* Attached Document Cards */
.mat-section-title {
    font-size: 0.85rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    color: #475569;
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.4rem;
}
html.dark-mode .mat-section-title {
    color: #94a3b8;
}

.mat-docs-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 0.85rem;
    margin-bottom: 1.25rem;
}

.mat-doc-card {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 0.75rem;
    transition: all 0.2s ease;
}
.mat-doc-card:hover {
    border-color: #3b82f6;
    background: #f0f7ff;
    transform: translateY(-1px);
}
html.dark-mode .mat-doc-card {
    background: #191c2b;
    border-color: #2e354f;
}
html.dark-mode .mat-doc-card:hover {
    border-color: #3b82f6;
    background: #1f253d;
}

.mat-doc-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    min-width: 0;
    flex: 1;
}

.mat-doc-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    flex-shrink: 0;
}
.icon-pdf   { background: rgba(239, 68, 68, 0.12); color: #ef4444; }
.icon-word  { background: rgba(59, 130, 246, 0.12); color: #3b82f6; }
.icon-excel { background: rgba(16, 185, 129, 0.12); color: #10b981; }
.icon-ppt   { background: rgba(245, 158, 11, 0.12); color: #f59e0b; }
.icon-zip   { background: rgba(139, 92, 246, 0.12); color: #8b5cf6; }
.icon-file  { background: rgba(100, 116, 139, 0.12); color: #64748b; }

.mat-doc-name {
    font-size: 0.875rem;
    font-weight: 600;
    color: #1e293b;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    text-decoration: none !important;
}
html.dark-mode .mat-doc-name {
    color: #f1f5f9;
}

/* Video Section */
.mat-videos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.mat-video-frame {
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e2e8f0;
    background: #000;
    box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
}
html.dark-mode .mat-video-frame {
    border-color: #2e354f;
}

/* Gallery Section */
.mat-gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.mat-gallery-item {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    aspect-ratio: 1;
    border: 1px solid #e2e8f0;
    background: #f1f5f9;
    cursor: pointer;
}
html.dark-mode .mat-gallery-item {
    border-color: #2e354f;
    background: #252a3d;
}
.mat-gallery-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}
.mat-gallery-item:hover .mat-gallery-img {
    transform: scale(1.06);
}

/* Empty State Card */
.mat-empty-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 3.5rem 1.5rem;
    text-align: center;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.04);
}
html.dark-mode .mat-empty-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 24px -2px rgba(0, 0, 0, 0.35);
}

.mat-empty-icon-circle {
    width: 80px;
    height: 80px;
    border-radius: 24px;
    background: rgba(59, 130, 246, 0.1);
    color: #3b82f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    font-size: 2.2rem;
}
html.dark-mode .mat-empty-icon-circle {
    background: rgba(59, 130, 246, 0.15);
    color: #60a5fa;
}

/* Modals */
.mat-modal .modal-content {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
html.dark-mode .mat-modal .modal-content {
    background: #1e2235;
    border-color: #2e354f;
    color: #f1f5f9;
}
.mat-modal .modal-header {
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 1.25rem;
}
html.dark-mode .mat-modal .modal-header {
    background: #191c2b;
    border-color: #2e354f;
}
.mat-modal .modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    padding: 0.85rem 1.25rem;
}
html.dark-mode .mat-modal .modal-footer {
    border-color: #2e354f;
    background: #191c2b;
}

/* Floating Action Button */
.mat-fab-button {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 56px;
    height: 56px;
    border-radius: 50%;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: #ffffff !important;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    box-shadow: 0 8px 24px rgba(37, 99, 235, 0.4);
    z-index: 1040;
    transition: all 0.25s ease;
    border: none;
    text-decoration: none !important;
}
.mat-fab-button:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 12px 28px rgba(37, 99, 235, 0.5);
    background: linear-gradient(135deg, #2563eb, #1d4ed8);
}
</style>

<div class="mat-portal-wrapper">
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
                        <li class="breadcrumb-item active">{{ $subject->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Hero Header Banner -->
    <div class="mat-hero-card">
        <div class="mat-hero-main">
            <div class="mat-hero-icon">
                <i class="fas fa-layer-group"></i>
            </div>
            <div>
                <h1 class="mat-hero-title">
                    {{ $subject->name }}
                    <span class="badge badge-primary font-weight-normal text-xs ml-1" style="font-size: 0.75rem; vertical-align: middle;">
                        {{ __('Subject Materials') }}
                    </span>
                </h1>
                <div class="mat-meta-tags">
                    @if(!empty($subject->class_name))
                        <span class="mat-meta-pill">
                            <i class="fas fa-graduation-cap text-primary"></i>
                            <span>{{ $subject->class_name }}</span>
                            @if(!empty($subject->class_code))
                                <span class="badge badge-light border ml-1 font-monospace">{{ $subject->class_code }}</span>
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
                    @else
                        <span class="mat-meta-pill text-muted">
                            <i class="fas fa-user-slash text-secondary"></i>
                            <span>{{ __('No Teacher Assigned') }}</span>
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="mat-action-btn-group">
            <a href="{{ route('getSubject.index', ['class_id' => $subject->class_id]) }}" class="mat-btn mat-btn-secondary" title="{{ __('Back to Subject Catalog') }}">
                <i class="fas fa-arrow-left"></i>
                <span>{{ __('Back to Subjects') }}</span>
            </a>

            @if ($canManage)
                <a href="{{ route('materials.create', ['subject_id' => $subject->subject_id]) }}" class="mat-btn mat-btn-primary" title="{{ __('Upload new lecture, handout, or video') }}">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>{{ __('Upload Material') }}</span>
                </a>
            @endif
        </div>
    </div>

    <!-- Top KPI Metric Cards -->
    <div class="mat-kpi-grid">
        <div class="mat-kpi-card">
            <div class="mat-kpi-icon kpi-blue">
                <i class="fas fa-boxes"></i>
            </div>
            <div>
                <div class="mat-kpi-value">{{ $stats['total_materials'] ?? count($materials) }}</div>
                <div class="mat-kpi-label">{{ __('Total Posts') }}</div>
            </div>
        </div>

        <div class="mat-kpi-card">
            <div class="mat-kpi-icon kpi-emerald">
                <i class="fas fa-file-alt"></i>
            </div>
            <div>
                <div class="mat-kpi-value">{{ $stats['total_files'] ?? 0 }}</div>
                <div class="mat-kpi-label">{{ __('Attached Documents') }}</div>
            </div>
        </div>

        <div class="mat-kpi-card">
            <div class="mat-kpi-icon kpi-violet">
                <i class="fas fa-video"></i>
            </div>
            <div>
                <div class="mat-kpi-value">{{ $stats['total_videos'] ?? 0 }}</div>
                <div class="mat-kpi-label">{{ __('Video Lectures') }}</div>
            </div>
        </div>

        <div class="mat-kpi-card">
            <div class="mat-kpi-icon kpi-amber">
                <i class="fas fa-images"></i>
            </div>
            <div>
                <div class="mat-kpi-value">{{ $stats['total_photos'] ?? 0 }}</div>
                <div class="mat-kpi-label">{{ __('Gallery Images') }}</div>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="mat-toolbar-card">
        <div class="mat-filter-pills" id="categoryFilterBar">
            <div class="mat-filter-pill active" data-filter="all">
                <i class="fas fa-th-large mr-1"></i> {{ __('All Content') }}
            </div>
            <div class="mat-filter-pill" data-filter="docs">
                <i class="fas fa-file-alt mr-1"></i> {{ __('Documents') }}
            </div>
            <div class="mat-filter-pill" data-filter="videos">
                <i class="fas fa-video mr-1"></i> {{ __('Videos') }}
            </div>
            <div class="mat-filter-pill" data-filter="gallery">
                <i class="fas fa-images mr-1"></i> {{ __('Gallery') }}
            </div>
            <div class="mat-filter-pill" data-filter="notes">
                <i class="fas fa-sticky-note mr-1"></i> {{ __('Notes & Announcements') }}
            </div>
        </div>

        <div class="mat-search-box">
            <i class="fas fa-search mat-search-icon"></i>
            <input type="text" id="materialSearchInput" class="mat-search-input" placeholder="{{ __('Search materials, files, lectures...') }}" autocomplete="off">
        </div>
    </div>

    <!-- Feed Content -->
    <div class="mat-feed" id="materialFeedContainer">
        @forelse ($materials as $material)
            @php
                $docs = [];
                if (!empty($material->file_path)) {
                    $decoded = json_decode($material->file_path, true);
                    $docs = is_array($decoded) ? $decoded : [];
                }

                $gallery = [];
                if (!empty($material->gallery_path)) {
                    $decoded = json_decode($material->gallery_path, true);
                    $gallery = is_array($decoded) ? $decoded : [];
                }

                $videos = [];
                if (!empty($material->url_vdo)) {
                    $decoded = json_decode($material->url_vdo, true);
                    $videos = is_array($decoded) ? $decoded : [$material->url_vdo];
                }

                $hasDocs    = count($docs) > 0;
                $hasVideos  = count($videos) > 0;
                $hasGallery = count($gallery) > 0;
                $hasNotes   = !empty($material->title) || !empty($material->description);

                // Build category tags for live filtering
                $categories = ['all'];
                if ($hasDocs) $categories[] = 'docs';
                if ($hasVideos) $categories[] = 'videos';
                if ($hasGallery) $categories[] = 'gallery';
                if ($hasNotes) $categories[] = 'notes';

                // Build search text
                $docNames = implode(' ', array_map('basename', $docs));
                $searchData = strtolower(($material->title ?? '') . ' ' . ($material->description ?? '') . ' ' . ($material->author_name ?? '') . ' ' . $docNames);
            @endphp

            <div class="mat-card material-feed-item" data-categories="{{ implode(' ', $categories) }}" data-search="{{ $searchData }}" id="materialCard-{{ $material->id }}">
                <!-- Card Header -->
                <div class="mat-card-header">
                    <div class="mat-author-info">
                        <div class="mat-author-avatar">
                            {{ strtoupper(mb_substr($material->author_name ?? 'AU', 0, 2)) }}
                        </div>
                        <div>
                            <div class="mat-author-name">
                                {{ $material->author_name ?? __('Instructor') }}
                            </div>
                            <div class="mat-post-date">
                                <i class="far fa-clock"></i>
                                <span>{{ date('d M Y, h:i A', strtotime($material->created_at)) }}</span>
                                <span class="mx-1">•</span>
                                <span>{{ \Carbon\Carbon::parse($material->created_at)->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Dropdown for Teachers/Admins -->
                    <div class="d-flex align-items-center gap-2">
                        @if ($hasDocs)
                            <span class="badge badge-light border text-primary" style="font-size: 0.75rem;">
                                <i class="fas fa-file-alt mr-1"></i> {{ count($docs) }} {{ __('files') }}
                            </span>
                        @endif
                        @if ($hasVideos)
                            <span class="badge badge-light border text-danger" style="font-size: 0.75rem;">
                                <i class="fas fa-video mr-1"></i> {{ count($videos) }} {{ __('videos') }}
                            </span>
                        @endif
                        @if ($hasGallery)
                            <span class="badge badge-light border text-purple" style="font-size: 0.75rem;">
                                <i class="fas fa-images mr-1"></i> {{ count($gallery) }} {{ __('photos') }}
                            </span>
                        @endif

                        @if ($canManage)
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius: 8px;">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow-sm border-0" style="border-radius: 10px;">
                                    <!-- Edit Full Material Page -->
                                    <a href="{{ route('materials.edit', $material->id) }}" class="dropdown-item text-primary font-weight-600 py-2">
                                        <i class="fas fa-edit mr-2"></i> {{ __('Edit Full Material') }}
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <!-- Quick Edit Title & Description -->
                                    <button type="button" class="dropdown-item edit-description-btn text-dark font-weight-500 py-2"
                                            data-id="{{ $material->id }}"
                                            data-title="{{ $material->title }}"
                                            data-description="{{ $material->description }}">
                                        <i class="fas fa-pen mr-2"></i> {{ __('Edit Notes & Title') }}
                                    </button>

                                    <!-- Edit Attached Files -->
                                    <button type="button" class="dropdown-item edit-file-btn text-info font-weight-500 py-2"
                                            data-id="{{ $material->id }}"
                                            data-file="{{ json_encode($docs) }}">
                                        <i class="fas fa-folder-open mr-2"></i> {{ __('Manage Documents') }}
                                    </button>

                                    <!-- Edit Attached Videos -->
                                    <button type="button" class="dropdown-item edit-video-btn text-success font-weight-500 py-2"
                                            data-id="{{ $material->id }}"
                                            data-url="{{ json_encode($videos) }}">
                                        <i class="fas fa-video mr-2"></i> {{ __('Manage Videos') }}
                                    </button>

                                    <!-- Edit Photo Gallery -->
                                    <button type="button" class="dropdown-item edit-gallery-btn text-warning font-weight-500 py-2"
                                            data-id="{{ $material->id }}"
                                            data-gallery="{{ json_encode($gallery) }}">
                                        <i class="fas fa-images mr-2"></i> {{ __('Manage Gallery') }}
                                    </button>

                                    <div class="dropdown-divider"></div>

                                    <!-- Delete Description Option -->
                                    @if(!empty($material->title) || !empty($material->description))
                                        <form action="{{ route('materials.deleteDescription', $material->id) }}" method="POST" class="delete-content-form" data-type="{{ __('Notes & Announcement') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger py-2 delete-prompt-btn">
                                                <i class="fas fa-trash-alt mr-2"></i> {{ __('Delete Notes') }}
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Files Option -->
                                    @if($hasDocs)
                                        <form action="{{ route('materials.deleteFiles', $material->id) }}" method="POST" class="delete-content-form" data-type="{{ __('Documents') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger py-2 delete-prompt-btn">
                                                <i class="fas fa-file-excel mr-2"></i> {{ __('Delete All Files') }}
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Videos Option -->
                                    @if($hasVideos)
                                        <form action="{{ route('materials.deleteVideos', $material->id) }}" method="POST" class="delete-content-form" data-type="{{ __('Videos') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger py-2 delete-prompt-btn">
                                                <i class="fas fa-video-slash mr-2"></i> {{ __('Delete All Videos') }}
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Delete Gallery Option -->
                                    @if($hasGallery)
                                        <form action="{{ route('materials.deleteGallery', $material->id) }}" method="POST" class="delete-content-form" data-type="{{ __('Gallery Photos') }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="dropdown-item text-danger py-2 delete-prompt-btn">
                                                <i class="fas fa-images mr-2"></i> {{ __('Delete Gallery') }}
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="mat-card-body">
                    <!-- Title & Text Description -->
                    @if(!empty($material->title))
                        <div class="mat-card-title" id="title-{{ $material->id }}">
                            {{ $material->title }}
                        </div>
                    @endif

                    @if(!empty($material->description))
                        <div class="mat-card-desc" id="desc-{{ $material->id }}">
                            {!! nl2br(e($material->description)) !!}
                        </div>
                    @endif

                    <!-- Documents Section -->
                    @if ($hasDocs)
                        <div class="mb-4">
                            <div class="mat-section-title">
                                <i class="fas fa-paperclip text-primary"></i>
                                <span>{{ __('Attached Documents') }} ({{ count($docs) }})</span>
                            </div>
                            <div class="mat-docs-grid">
                                @foreach ($docs as $doc)
                                    @php
                                        $ext = strtolower(pathinfo($doc, PATHINFO_EXTENSION));
                                        $iconClass = 'icon-file fas fa-file';
                                        if (in_array($ext, ['pdf'])) {
                                            $iconClass = 'icon-pdf fas fa-file-pdf';
                                        } elseif (in_array($ext, ['doc', 'docx'])) {
                                            $iconClass = 'icon-word fas fa-file-word';
                                        } elseif (in_array($ext, ['xls', 'xlsx', 'csv'])) {
                                            $iconClass = 'icon-excel fas fa-file-excel';
                                        } elseif (in_array($ext, ['ppt', 'pptx'])) {
                                            $iconClass = 'icon-ppt fas fa-file-powerpoint';
                                        } elseif (in_array($ext, ['zip', 'rar', '7z'])) {
                                            $iconClass = 'icon-zip fas fa-file-archive';
                                        }
                                        $filename = basename($doc);
                                        $fileUrl = asset('upload_materials/' . $doc);
                                    @endphp
                                    <div class="mat-doc-card">
                                        <div class="mat-doc-left">
                                            <div class="mat-doc-icon {{ $iconClass }}"></div>
                                            <div class="text-truncate" style="max-width: 170px;">
                                                <div class="mat-doc-name" title="{{ $filename }}">{{ $filename }}</div>
                                                <span class="badge badge-light border" style="font-size: 0.68rem; text-transform: uppercase;">{{ $ext }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center gap-1">
                                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-light border text-primary" title="{{ __('Preview / Open file') }}" style="border-radius: 8px;">
                                                <i class="fas fa-external-link-alt"></i>
                                            </a>
                                            <a href="{{ $fileUrl }}" download class="btn btn-sm btn-light border text-success" title="{{ __('Download file') }}" style="border-radius: 8px;">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Videos Section -->
                    @if ($hasVideos)
                        <div class="mb-4">
                            <div class="mat-section-title">
                                <i class="fas fa-video text-danger"></i>
                                <span>{{ __('Video Lectures & Demonstrations') }} ({{ count($videos) }})</span>
                            </div>
                            <div class="mat-videos-grid">
                                @foreach ($videos as $vid)
                                    <div class="mat-video-frame">
                                        @if (strpos($vid, 'youtube.com/embed/') !== false)
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="{{ $vid }}" allowfullscreen></iframe>
                                            </div>
                                        @elseif (preg_match('/\.(mp4|avi|mov|mkv)$/i', $vid))
                                            <video width="100%" controls style="display: block; max-height: 380px; background: #000;">
                                                <source src="{{ asset('upload_materials/' . $vid) }}" type="video/mp4">
                                                {{ __('Your browser does not support HTML5 video.') }}
                                            </video>
                                        @else
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="{{ $vid }}" allowfullscreen></iframe>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Gallery Photos Section -->
                    @if ($hasGallery)
                        <div>
                            <div class="mat-section-title">
                                <i class="fas fa-images text-purple"></i>
                                <span>{{ __('Photo Gallery & Visual Assets') }} ({{ count($gallery) }})</span>
                            </div>
                            <div class="mat-gallery-grid">
                                @foreach ($gallery as $img)
                                    <a href="{{ asset('upload_materials/' . $img) }}" target="_blank" class="mat-gallery-item" title="{{ __('Click to view full photo') }}">
                                        <img src="{{ asset('upload_materials/' . $img) }}" alt="Gallery Image" class="mat-gallery-img" loading="lazy">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <!-- Modern Empty State -->
            <div class="mat-empty-card">
                <div class="mat-empty-icon-circle">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h3 class="font-weight-bold mb-1" style="font-size: 1.35rem; color: #1e293b;">
                    {{ __('No Learning Materials Published Yet') }}
                </h3>
                <p class="text-muted mx-auto mb-4" style="max-width: 480px; font-size: 0.92rem;">
                    {{ __('There are currently no files, lecture slides, video tutorials, or photo galleries uploaded for') }} <strong>{{ $subject->name }}</strong>.
                </p>

                @if ($canManage)
                    <a href="{{ route('materials.create', ['subject_id' => $subject->subject_id]) }}" class="btn btn-primary px-4 py-2 font-weight-bold shadow-sm" style="border-radius: 10px;">
                        <i class="fas fa-plus mr-1"></i> {{ __('Upload First Material') }}
                    </a>
                @endif
            </div>
        @endforelse

        <!-- No Search Results Found Row -->
        <div id="noSearchMaterialsCard" class="mat-empty-card" style="display: none;">
            <i class="fas fa-search fa-2x mb-2 text-secondary opacity-50"></i>
            <h5 class="font-weight-bold mb-1">{{ __('No matching materials found') }}</h5>
            <small class="text-muted">{{ __('Try adjusting your search keywords or category filters.') }}</small>
        </div>
    </div>
</div>

<!-- Floating Action Button for Teachers/Admins -->
@if ($canManage)
    <a href="{{ route('materials.create', ['subject_id' => $subject->subject_id]) }}" class="mat-fab-button" title="{{ __('Upload New Material') }}">
        <i class="fas fa-plus"></i>
    </a>
@endif

<!-- ============================================================== -->
<!-- MODAL: EDIT DESCRIPTION & TITLE                                -->
<!-- ============================================================== -->
@if ($canManage)
<div class="modal fade mat-modal" id="editDescriptionModal" tabindex="-1" role="dialog" aria-labelledby="editDescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="editDescriptionForm">
                @csrf
                <input type="hidden" id="editMaterialId">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="editDescriptionModalLabel">
                        <i class="fas fa-pen text-primary mr-1"></i>
                        {{ __('Edit Notes & Title') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <div class="form-group mb-3">
                        <label for="editTitle" class="font-weight-bold text-sm">{{ __('Post Title') }}</label>
                        <input type="text" id="editTitle" class="form-control" placeholder="{{ __('e.g., Week 3: UI Design Principles') }}">
                    </div>
                    <div class="form-group mb-0">
                        <label for="editDescription" class="font-weight-bold text-sm">{{ __('Description & Notes') }}</label>
                        <textarea id="editDescription" class="form-control" rows="6" placeholder="{{ __('Enter detailed lecture notes or instructions...') }}"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 font-weight-bold">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Changes') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT DOCUMENTS                                          -->
<!-- ============================================================== -->
<div class="modal fade mat-modal" id="editFileModal" tabindex="-1" role="dialog" aria-labelledby="editFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="editFileForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editFileMaterialId">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="editFileModalLabel">
                        <i class="fas fa-folder-open text-primary mr-1"></i>
                        {{ __('Manage Attached Documents') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Current Files List -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-sm mb-2">{{ __('Current Attached Files:') }}</label>
                        <div id="currentFilesList" class="d-flex flex-column gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Upload Additional Files -->
                    <div class="form-group mb-0 pt-3 border-top">
                        <label for="editFiles" class="font-weight-bold text-sm mb-1">
                            {{ __('Upload Additional Files (PDF, DOCX, XLSX, PPTX, etc.)') }}
                        </label>
                        <input type="file" name="new_files[]" id="editFiles" class="form-control-file border rounded p-2 w-100" multiple accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar">
                        <small class="text-muted">{{ __('Select one or more files to append to this material post.') }}</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary px-4 font-weight-bold" onclick="saveUpdatedFiles()">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Document Updates') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT VIDEOS                                             -->
<!-- ============================================================== -->
<div class="modal fade mat-modal" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="editVideoForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editVideoMaterialId">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="editVideoModalLabel">
                        <i class="fas fa-video text-danger mr-1"></i>
                        {{ __('Manage Videos & Lectures') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Current Videos -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-sm mb-2">{{ __('Current Attached Videos:') }}</label>
                        <div id="currentVideosContainer" class="d-flex flex-column gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Add YouTube URLs -->
                    <div class="form-group mb-3 pt-3 border-top">
                        <label for="editVideoUrl" class="font-weight-bold text-sm mb-1">
                            {{ __('Add YouTube Video URLs (comma-separated)') }}
                        </label>
                        <textarea class="form-control" id="editVideoUrl" rows="2" placeholder="https://www.youtube.com/watch?v=..., https://youtu.be/..."></textarea>
                    </div>

                    <!-- Upload Video Files -->
                    <div class="form-group mb-0">
                        <label for="editVideoFile" class="font-weight-bold text-sm mb-1">
                            {{ __('Or Upload Video Files (MP4, AVI, MOV, MKV)') }}
                        </label>
                        <input type="file" name="video_file[]" id="editVideoFile" class="form-control-file border rounded p-2 w-100" multiple accept=".mp4,.avi,.mov,.mkv">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary px-4 font-weight-bold" onclick="saveUpdatedVideos()">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Video Updates') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL: EDIT GALLERY                                            -->
<!-- ============================================================== -->
<div class="modal fade mat-modal" id="editGalleryModal" tabindex="-1" role="dialog" aria-labelledby="editGalleryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="editGalleryForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editGalleryMaterialId">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-bold" id="editGalleryModalLabel">
                        <i class="fas fa-images text-warning mr-1"></i>
                        {{ __('Manage Photo Gallery') }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body p-4">
                    <!-- Current Gallery Images -->
                    <div class="form-group mb-4">
                        <label class="font-weight-bold text-sm mb-2">{{ __('Current Gallery Photos (Click ❌ to remove):') }}</label>
                        <div id="currentGalleryContainer" class="d-flex flex-wrap gap-2">
                            <!-- Populated dynamically via JS -->
                        </div>
                    </div>

                    <!-- Upload Additional Photos -->
                    <div class="form-group mb-0 pt-3 border-top">
                        <label for="editGalleryFiles" class="font-weight-bold text-sm mb-1">
                            {{ __('Upload Additional Images (JPEG, PNG, JPG, GIF)') }}
                        </label>
                        <input type="file" name="new_gallery[]" id="editGalleryFiles" class="form-control-file border rounded p-2 w-100" multiple accept=".jpeg,.png,.jpg,.gif">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary px-4" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary px-4 font-weight-bold" onclick="saveUpdatedGallery()">
                        <i class="fas fa-save mr-1"></i> {{ __('Save Gallery Updates') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ============================================================== -->
<!-- INTERACTIVE JAVASCRIPT LOGIC                                   -->
<!-- ============================================================== -->
<script>
const base_url = "{{ asset('') }}";
const csrfToken = "{{ csrf_token() }}";

document.addEventListener('DOMContentLoaded', function () {
    // 1. Live Filter Tabs and Search
    const filterPills = document.querySelectorAll('.mat-filter-pill');
    const searchInput = document.getElementById('materialSearchInput');
    const feedItems = document.querySelectorAll('.material-feed-item');
    const noSearchCard = document.getElementById('noSearchMaterialsCard');

    let currentFilter = 'all';

    function applyFilters() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        let visibleCount = 0;

        feedItems.forEach(item => {
            const categories = (item.getAttribute('data-categories') || '').split(' ');
            const searchData = item.getAttribute('data-search') || '';

            const matchesFilter = (currentFilter === 'all') || categories.includes(currentFilter);
            const matchesSearch = !query || searchData.includes(query);

            if (matchesFilter && matchesSearch) {
                item.style.display = '';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });

        if (noSearchCard) {
            noSearchCard.style.display = (visibleCount === 0 && feedItems.length > 0) ? '' : 'none';
        }
    }

    filterPills.forEach(pill => {
        pill.addEventListener('click', function () {
            filterPills.forEach(p => p.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter') || 'all';
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }

    // 2. SweetAlert2 Delete Confirmations
    document.querySelectorAll('.delete-prompt-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');
            const contentType = form.getAttribute('data-type') || 'this content';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '{{ __("Delete Content?") }}',
                    html: `{{ __("Are you sure you want to delete") }} <strong>${contentType}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> {{ __("Yes, delete it") }}',
                    cancelButtonText: '{{ __("Cancel") }}',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        if (typeof showOverlay === 'function') showOverlay();
                        form.submit();
                    }
                });
            } else {
                if (confirm(`{{ __("Are you sure you want to delete") }} ${contentType}?`)) {
                    if (typeof showOverlay === 'function') showOverlay();
                    form.submit();
                }
            }
        });
    });

    // 3. Edit Notes & Title Modal Hook
    document.querySelectorAll('.edit-description-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const title = this.getAttribute('data-title') || '';
            const description = this.getAttribute('data-description') || '';

            document.getElementById('editMaterialId').value = id;
            document.getElementById('editTitle').value = title;
            document.getElementById('editDescription').value = description;

            $('#editDescriptionModal').modal('show');
        });
    });

    const editDescForm = document.getElementById('editDescriptionForm');
    if (editDescForm) {
        editDescForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const id = document.getElementById('editMaterialId').value;
            const title = document.getElementById('editTitle').value;
            const description = document.getElementById('editDescription').value;

            fetch(`/materials/update-description/${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ title, description })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'success', title: '{{ __("Updated!") }}', text: data.message || '{{ __("Notes updated successfully.") }}', timer: 1500, showConfirmButton: false });
                    }
                    setTimeout(() => location.reload(), 1200);
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'error', title: '{{ __("Error") }}', text: data.error || '{{ __("Failed to update.") }}' });
                    } else {
                        alert(data.error || 'Failed to update.');
                    }
                }
            })
            .catch(err => {
                console.error(err);
                alert('Server error occurred.');
            });
        });
    }

    // 4. Edit Documents Modal Hook
    let currentFiles = [];

    document.querySelectorAll('.edit-file-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const materialId = this.getAttribute('data-id');
            const raw = this.getAttribute('data-file');
            try {
                currentFiles = raw ? JSON.parse(raw) : [];
            } catch(e) { currentFiles = []; }

            document.getElementById('editFileMaterialId').value = materialId;
            renderCurrentFilesList();
            $('#editFileModal').modal('show');
        });
    });

    function renderCurrentFilesList() {
        const container = document.getElementById('currentFilesList');
        if (!container) return;

        if (currentFiles.length === 0) {
            container.innerHTML = `<span class="text-muted small"><em>{{ __('No documents attached currently.') }}</em></span>`;
            return;
        }

        container.innerHTML = currentFiles.map((f, i) => `
            <div class="d-flex align-items-center justify-content-between p-2 rounded border bg-light">
                <span class="text-truncate font-weight-500 mr-2" style="font-size: 0.88rem;"><i class="fas fa-file-alt mr-2 text-primary"></i>${f.split('/').pop()}</span>
                <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeDocumentItem(${i})" title="{{ __('Remove file') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }

    window.removeDocumentItem = function(index) {
        currentFiles.splice(index, 1);
        renderCurrentFilesList();
    };

    window.saveUpdatedFiles = function() {
        const materialId = document.getElementById('editFileMaterialId').value;
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('material_id', materialId);
        formData.append('existing_files', JSON.stringify(currentFiles));

        const fileInput = document.getElementById('editFiles');
        if (fileInput && fileInput.files) {
            for (let i = 0; i < fileInput.files.length; i++) {
                formData.append('new_files[]', fileInput.files[i]);
            }
        }

        fetch(`/materials/update-files/${materialId}`, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: '{{ __("Updated!") }}', text: data.message || '{{ __("Files updated successfully.") }}', timer: 1500, showConfirmButton: false });
                }
                setTimeout(() => location.reload(), 1200);
            } else {
                alert(data.error || 'Failed to update files.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Server error.');
        });
    };

    // 5. Edit Videos Modal Hook
    let currentVideos = [];

    document.querySelectorAll('.edit-video-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const materialId = this.getAttribute('data-id');
            const raw = this.getAttribute('data-url');
            try {
                currentVideos = raw ? JSON.parse(raw) : [];
            } catch(e) { currentVideos = []; }

            document.getElementById('editVideoMaterialId').value = materialId;
            document.getElementById('editVideoUrl').value = '';
            renderCurrentVideosList();
            $('#editVideoModal').modal('show');
        });
    });

    function renderCurrentVideosList() {
        const container = document.getElementById('currentVideosContainer');
        if (!container) return;

        if (currentVideos.length === 0) {
            container.innerHTML = `<span class="text-muted small"><em>{{ __('No videos attached currently.') }}</em></span>`;
            return;
        }

        container.innerHTML = currentVideos.map((v, i) => `
            <div class="d-flex align-items-center justify-content-between p-2 rounded border bg-light">
                <span class="text-truncate mr-2 font-monospace" style="font-size: 0.85rem;"><i class="fas fa-video mr-2 text-danger"></i>${v}</span>
                <button type="button" class="btn btn-sm btn-danger px-2" onclick="removeVideoItem(${i})" title="{{ __('Remove video') }}">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }

    window.removeVideoItem = function(index) {
        currentVideos.splice(index, 1);
        renderCurrentVideosList();
    };

    window.saveUpdatedVideos = function() {
        const materialId = document.getElementById('editVideoMaterialId').value;
        const urlInput = document.getElementById('editVideoUrl').value;
        const newUrls = urlInput.split(',').map(u => u.trim()).filter(u => u !== '');
        const allUrls = [...currentVideos, ...newUrls];

        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('material_id', materialId);
        formData.append('url_vdo', allUrls.join(', '));

        const videoFileInput = document.getElementById('editVideoFile');
        if (videoFileInput && videoFileInput.files) {
            for (let i = 0; i < videoFileInput.files.length; i++) {
                formData.append('video_file[]', videoFileInput.files[i]);
            }
        }

        fetch(`/materials/update-video/${materialId}`, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: '{{ __("Updated!") }}', text: data.message || '{{ __("Videos updated successfully.") }}', timer: 1500, showConfirmButton: false });
                }
                setTimeout(() => location.reload(), 1200);
            } else {
                alert(data.error || 'Failed to update videos.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Server error.');
        });
    };

    // 6. Edit Gallery Modal Hook
    let currentGallery = [];

    document.querySelectorAll('.edit-gallery-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const materialId = this.getAttribute('data-id');
            const raw = this.getAttribute('data-gallery');
            try {
                currentGallery = raw ? JSON.parse(raw) : [];
            } catch(e) { currentGallery = []; }

            document.getElementById('editGalleryMaterialId').value = materialId;
            renderCurrentGalleryList();
            $('#editGalleryModal').modal('show');
        });
    });

    function renderCurrentGalleryList() {
        const container = document.getElementById('currentGalleryContainer');
        if (!container) return;

        if (currentGallery.length === 0) {
            container.innerHTML = `<span class="text-muted small"><em>{{ __('No gallery photos currently.') }}</em></span>`;
            return;
        }

        container.innerHTML = currentGallery.map((img, i) => `
            <div class="position-relative d-inline-block rounded overflow-hidden border m-1" style="width: 80px; height: 80px;">
                <img src="${base_url}upload_materials/${img}" style="width: 100%; height: 100%; object-fit: cover;">
                <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 2px; right: 2px; padding: 1px 5px; font-size: 0.7rem; border-radius: 50%;" onclick="removeGalleryItem(${i})">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        `).join('');
    }

    window.removeGalleryItem = function(index) {
        currentGallery.splice(index, 1);
        renderCurrentGalleryList();
    };

    window.saveUpdatedGallery = function() {
        const materialId = document.getElementById('editGalleryMaterialId').value;
        const formData = new FormData();
        formData.append('_token', csrfToken);
        formData.append('material_id', materialId);
        formData.append('gallery', JSON.stringify(currentGallery));

        const galleryInput = document.getElementById('editGalleryFiles');
        if (galleryInput && galleryInput.files) {
            for (let i = 0; i < galleryInput.files.length; i++) {
                formData.append('gallery_files[]', galleryInput.files[i]);
            }
        }

        fetch(`/materials/update-gallery/${materialId}`, {
            method: 'POST',
            headers: { 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'success', title: '{{ __("Updated!") }}', text: data.message || '{{ __("Gallery updated successfully.") }}', timer: 1500, showConfirmButton: false });
                }
                setTimeout(() => location.reload(), 1200);
            } else {
                alert(data.error || 'Failed to update gallery.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Server error.');
        });
    };
});
</script>

@endsection

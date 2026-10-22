@extends('layout.main')

@section('content')
<style>
    /* Modern Subject Portal Styling */
    .subject-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #007bff 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 26px 30px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.22);
    }
    .subject-hero .badge-pill-header {
        border: 1px solid rgba(255, 255, 255, 0.4);
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.82rem;
        backdrop-filter: blur(4px);
    }
    .hero-stat-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 12px;
        padding: 12px 16px;
        color: #fff;
        text-align: center;
        transition: transform 0.2s ease;
    }
    .hero-stat-card:hover {
        transform: translateY(-2px);
        background: rgba(255, 255, 255, 0.22);
    }
    .hero-stat-card .stat-number {
        font-size: 1.6rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .hero-stat-card .stat-label {
        font-size: 0.8rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Control Bar */
    .control-panel-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        margin-bottom: 22px;
        background-color: #fff;
    }
    .dark-mode .control-panel-card {
        background-color: #2c3034;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25);
    }
    .search-input-group .form-control {
        border-radius: 10px 0 0 10px;
        border-right: none;
        height: 44px;
    }
    .search-input-group .input-group-text {
        border-radius: 0 10px 10px 0;
        background-color: transparent;
    }

    /* Modern Subject Cards Grid */
    .subjects-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 22px;
    }
    .subject-card {
        background: #fff;
        border-radius: 14px;
        border: 1px solid #edf2f7;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        transition: all 0.25s cubic-bezier(0.165, 0.84, 0.44, 1);
        display: flex;
        flex-direction: column;
        position: relative;
    }
    .dark-mode .subject-card {
        background: #2b3035;
        border-color: #3b4248;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }
    .subject-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 123, 255, 0.15);
        border-color: #b8daff;
    }
    .dark-mode .subject-card:hover {
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.4);
        border-color: #007bff;
    }
    .card-top-accent {
        height: 6px;
        background: linear-gradient(90deg, #007bff, #00c6ff);
    }
    .card-accent-emerald {
        background: linear-gradient(90deg, #10b981, #059669);
    }
    .card-accent-purple {
        background: linear-gradient(90deg, #8b5cf6, #6366f1);
    }
    .card-accent-amber {
        background: linear-gradient(90deg, #f59e0b, #d97706);
    }
    .card-accent-rose {
        background: linear-gradient(90deg, #ec4899, #f43f5e);
    }

    .subject-card-body {
        padding: 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .subject-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        margin-bottom: 14px;
        background: #eef2ff;
        color: #4f46e5;
    }
    .dark-mode .subject-icon-box {
        background: #3730a3;
        color: #c7d2fe;
    }
    .subject-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark-mode .subject-title {
        color: #f8f9fa;
    }
    .teacher-pill {
        display: inline-flex;
        align-items: center;
        background-color: #f1f5f9;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.85rem;
        color: #475569;
        margin-bottom: 16px;
    }
    .dark-mode .teacher-pill {
        background-color: #343a40;
        color: #ced4da;
    }
    .subject-metrics-row {
        display: flex;
        justify-content: space-between;
        background-color: #f8fafc;
        border-radius: 10px;
        padding: 10px 14px;
        margin-top: auto;
        margin-bottom: 16px;
        border: 1px dashed #e2e8f0;
    }
    .dark-mode .subject-metrics-row {
        background-color: #22262a;
        border-color: #3e444a;
    }
    .metric-item {
        text-align: center;
        flex: 1;
    }
    .metric-item:first-child {
        border-right: 1px solid #e2e8f0;
    }
    .dark-mode .metric-item:first-child {
        border-right-color: #3e444a;
    }
    .metric-val {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1e293b;
    }
    .dark-mode .metric-val {
        color: #e2e8f0;
    }
    .metric-lbl {
        font-size: 0.72rem;
        color: #64748b;
        text-transform: uppercase;
        margin-top: 2px;
    }

    .btn-open-materials {
        border-radius: 10px;
        font-weight: 600;
        padding: 10px 16px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: #fff;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-open-materials:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }

    /* Empty state */
    .empty-state-container {
        text-align: center;
        padding: 60px 20px;
        background: #fff;
        border-radius: 16px;
        border: 2px dashed #dee2e6;
    }
    .dark-mode .empty-state-container {
        background: #2b3035;
        border-color: #495057;
    }
    .empty-state-icon {
        font-size: 3.5rem;
        color: #adb5bd;
        margin-bottom: 15px;
    }
</style>

<div class="content-header p-0 mb-3">
    <div class="container-fluid p-0">
        <!-- Validation / Session Alerts -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        @if (isset($errors) && $errors->any())
            <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
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

        <!-- Class & Subject Hero Banner -->
        <div class="subject-hero">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-12 mb-3 mb-lg-0">
                    <a href="{{ route('myClass.index') }}" class="btn btn-outline-light btn-sm mb-3" style="border-radius: 8px;">
                        <i class="fas fa-arrow-left mr-1"></i> Back to My Classes
                    </a>
                    <div class="d-flex align-items-center flex-wrap mb-2" style="gap: 8px;">
                        <h2 class="font-weight-bold mb-0">{{ $class->name }}</h2>
                        @if(!empty($class->class_code))
                            <span class="badge-pill-header"><i class="fas fa-tag mr-1"></i>{{ $class->class_code }}</span>
                        @endif
                        @if(!empty($class->class_room))
                            <span class="badge-pill-header"><i class="fas fa-door-open mr-1"></i>Room {{ $class->class_room }}</span>
                        @endif
                        @if(!empty($class->teacher_name))
                            <span class="badge-pill-header"><i class="fas fa-chalkboard-teacher mr-1"></i>{{ $class->teacher_name }}</span>
                        @endif
                    </div>
                    <p class="mb-0 text-white-50" style="font-size: 0.95rem;">
                        Select a subject below to download syllabus documents, watch lecture videos, and access assignments.
                    </p>
                </div>

                <div class="col-lg-4 col-md-12 text-lg-right text-left">
                    <div class="d-flex align-items-center justify-content-lg-end justify-content-start flex-wrap" style="gap: 10px;">
                        <div class="hero-stat-card" style="min-width: 90px;">
                            <div class="stat-number">{{ $subjects->count() }}</div>
                            <div class="stat-label">Subjects</div>
                        </div>
                        <div class="hero-stat-card" style="min-width: 90px;">
                            <div class="stat-number">{{ $subjects->sum('material_count') }}</div>
                            <div class="stat-label">Materials</div>
                        </div>
                        <a href="{{ route('class_routines.index', $class->class_id) }}" class="btn btn-light btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px;">
                            <i class="fas fa-calendar-alt mr-1"></i> Timetable
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Class Switching Bar -->
        <div class="card control-panel-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-lg-7 col-md-6 mb-2 mb-lg-0">
                        <div class="input-group search-input-group">
                            <input type="text" id="subjectFilterSearch" class="form-control" placeholder="Search subjects by name or teacher...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Switch Class Dropdown -->
                    @if(isset($allClasses) && $allClasses->count() > 1)
                        <div class="col-lg-5 col-md-6 text-lg-right text-left">
                            <div class="input-group">
                                <select id="switchClassDropdown" class="form-control" style="border-radius: 10px;" onchange="if(this.value) window.location.href=this.value;">
                                    <option value="">-- Switch to Another Class --</option>
                                    @foreach($allClasses as $c)
                                        <option value="{{ route('getSubject.index', ['class_id' => $c->class_id]) }}" {{ $c->class_id == $class->class_id ? 'selected' : '' }}>
                                            {{ $c->name }} ({{ $c->class_code ?? 'Class #' . $c->class_id }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Subject Cards Grid -->
        @php
            $accentColors = ['card-accent-emerald', 'card-accent-purple', 'card-accent-amber', 'card-accent-rose', ''];
            $subjectIcons = [
                'math' => 'fas fa-calculator',
                'science' => 'fas fa-flask',
                'physics' => 'fas fa-atom',
                'chemistry' => 'fas fa-vial',
                'english' => 'fas fa-language',
                'history' => 'fas fa-landmark',
                'geography' => 'fas fa-globe-americas',
                'art' => 'fas fa-palette',
                'music' => 'fas fa-music',
                'computer' => 'fas fa-laptop-code',
                'development' => 'fas fa-code',
                'design' => 'fas fa-pencil-ruler',
            ];
        @endphp

        <div class="subjects-cards-grid" id="subjectCardsContainer">
            @forelse($subjects as $index => $item)
                @php
                    $accentClass = $accentColors[$index % count($accentColors)];
                    $lowerName = strtolower($item->name);
                    $iconClass = 'fas fa-book';
                    foreach($subjectIcons as $key => $icon) {
                        if (strpos($lowerName, $key) !== false) {
                            $iconClass = $icon;
                            break;
                        }
                    }
                @endphp
                <div class="subject-card"
                     data-name="{{ strtolower($item->name) }}"
                     data-teacher="{{ strtolower($item->teacher_name ?? '') }}">
                    <div class="card-top-accent {{ $accentClass }}"></div>
                    <div class="subject-card-body">
                        <!-- Icon Box -->
                        <div class="subject-icon-box">
                            <i class="{{ $iconClass }}"></i>
                        </div>

                        <!-- Subject Name -->
                        <h4 class="subject-title" title="{{ $item->name }}">{{ $item->name }}</h4>

                        <!-- Teacher Pill -->
                        <div class="teacher-pill">
                            <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i>
                            <span class="text-truncate">
                                {{ $item->teacher_name ? 'Teacher: ' . $item->teacher_name : 'Teacher Not Assigned' }}
                            </span>
                        </div>

                        <!-- Metrics row -->
                        <div class="subject-metrics-row">
                            <div class="metric-item">
                                <div class="metric-val text-primary">{{ $item->material_count }}</div>
                                <div class="metric-lbl">Materials</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-val text-info">{{ $item->routine_count }}</div>
                                <div class="metric-lbl">Routine Slots</div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <a href="{{ route('class.materials', ['subject_id' => $item->subject_id]) }}" class="btn-open-materials">
                            <i class="fas fa-folder-open"></i>
                            <span>View Materials</span>
                            <i class="fas fa-arrow-right ml-auto" style="font-size: 0.8rem;"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12" style="grid-column: 1 / -1;">
                    <div class="empty-state-container">
                        <i class="fas fa-book-reader empty-state-icon"></i>
                        <h4 class="font-weight-bold">No Subjects Found</h4>
                        <p class="text-muted mb-3">No subjects have been assigned to <strong>{{ $class->name }}</strong> yet.</p>
                        <a href="{{ route('myClass.index') }}" class="btn btn-outline-primary btn-sm px-3">
                            <i class="fas fa-arrow-left mr-1"></i> Return to My Classes
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No search matches empty state (hidden by default) -->
        <div id="noSubjectSearchMatches" class="empty-state-container mt-4" style="display: none;">
            <i class="fas fa-search empty-state-icon"></i>
            <h4 class="font-weight-bold">No Matching Subjects Found</h4>
            <p class="text-muted mb-3">No subjects match your current search keyword. Try a different search.</p>
            <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="resetSubjectSearch()">
                <i class="fas fa-redo mr-1"></i> Clear Search
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('subjectFilterSearch');
        const cards = document.querySelectorAll('.subject-card');
        const noMatchesAlert = document.getElementById('noSubjectSearchMatches');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                let visibleCount = 0;

                cards.forEach(card => {
                    const name = card.getAttribute('data-name') || '';
                    const teacher = card.getAttribute('data-teacher') || '';

                    const matches = !query || name.includes(query) || teacher.includes(query);
                    if (matches) {
                        card.style.display = 'flex';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                if (noMatchesAlert) {
                    noMatchesAlert.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
                }
            });
        }
    });

    function resetSubjectSearch() {
        const searchInput = document.getElementById('subjectFilterSearch');
        if (searchInput) {
            searchInput.value = '';
            searchInput.dispatchEvent(new Event('input'));
        }
    }
</script>
@endsection


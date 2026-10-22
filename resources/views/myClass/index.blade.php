@extends('layout.main')

@section('content')
<style>
    /* Modern My Class Portal Styling */
    .myclass-hero {
        background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #007bff 100%);
        border-radius: 16px;
        color: #ffffff;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 10px 25px rgba(30, 60, 114, 0.25);
        position: relative;
        overflow: hidden;
    }
    .myclass-hero::after {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }
    .hero-stat-card {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        border-radius: 12px;
        padding: 14px 18px;
        color: #fff;
        transition: transform 0.2s ease, background 0.2s ease;
    }
    .hero-stat-card:hover {
        transform: translateY(-3px);
        background: rgba(255, 255, 255, 0.22);
    }
    .hero-stat-card .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        line-height: 1.2;
    }
    .hero-stat-card .stat-label {
        font-size: 0.85rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Filter & Search Panel */
    .control-panel-card {
        border-radius: 14px;
        border: none;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.06);
        margin-bottom: 25px;
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
    .filter-btn-pill {
        border-radius: 20px;
        padding: 6px 16px;
        font-size: 0.88rem;
        font-weight: 600;
        border: 1px solid #dee2e6;
        color: #495057;
        background: #fff;
        transition: all 0.2s;
        cursor: pointer;
    }
    .dark-mode .filter-btn-pill {
        background: #343a40;
        color: #ced4da;
        border-color: #495057;
    }
    .filter-btn-pill.active, .filter-btn-pill:hover {
        background-color: #007bff;
        color: #fff;
        border-color: #007bff;
    }

    /* Modern Class Cards Grid */
    .class-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 22px;
    }
    .academic-class-card {
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
    .dark-mode .academic-class-card {
        background: #2b3035;
        border-color: #3b4248;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }
    .academic-class-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 123, 255, 0.15);
        border-color: #b8daff;
    }
    .dark-mode .academic-class-card:hover {
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

    .class-card-body {
        padding: 20px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    .class-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .dark-mode .class-title {
        color: #f8f9fa;
    }
    .class-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 14px;
    }
    .badge-pill-custom {
        font-size: 0.75rem;
        padding: 4px 10px;
        border-radius: 20px;
        font-weight: 600;
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
    .class-metrics-row {
        display: flex;
        justify-content: space-between;
        background-color: #f8fafc;
        border-radius: 10px;
        padding: 10px 12px;
        margin-top: auto;
        margin-bottom: 16px;
        border: 1px dashed #e2e8f0;
    }
    .dark-mode .class-metrics-row {
        background-color: #22262a;
        border-color: #3e444a;
    }
    .metric-item {
        text-align: center;
        flex: 1;
    }
    .metric-item:not(:last-child) {
        border-right: 1px solid #e2e8f0;
    }
    .dark-mode .metric-item:not(:last-child) {
        border-right-color: #3e444a;
    }
    .metric-val {
        font-weight: 700;
        font-size: 1.05rem;
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

    .class-card-actions {
        display: flex;
        gap: 8px;
    }
    .btn-explore-class {
        flex: 1;
        border-radius: 10px;
        font-weight: 600;
        padding: 9px 14px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        color: #fff;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-explore-class:hover {
        background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
        color: #fff;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.3);
    }
    .btn-timetable-shortcut {
        border-radius: 10px;
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        color: #495057;
        background-color: #f8fafc;
        transition: all 0.2s;
        text-decoration: none;
    }
    .dark-mode .btn-timetable-shortcut {
        background-color: #343a40;
        border-color: #495057;
        color: #ced4da;
    }
    .btn-timetable-shortcut:hover {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
        transform: translateY(-1px);
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

        <!-- Hero Header -->
        <div class="myclass-hero">
            <div class="row align-items-center">
                <div class="col-lg-7 col-md-12 mb-3 mb-lg-0">
                    <span class="badge badge-light px-3 py-1 mb-2 font-weight-bold text-primary">
                        <i class="fas fa-graduation-cap mr-1"></i> Academic Courses & Classes
                    </span>
                    <h2 class="font-weight-bold mb-2">My Classes & Subjects</h2>
                    <p class="mb-0 text-white-50" style="font-size: 1rem;">
                        Select a class below to browse course subjects, download learning materials, and view lecture schedules.
                    </p>
                </div>
                <div class="col-lg-5 col-md-12">
                    <div class="row">
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $classes->count() }}</div>
                                <div class="stat-label">Classes</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $totalSubjects ?? 0 }}</div>
                                <div class="stat-label">Subjects</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="hero-stat-card text-center">
                                <div class="stat-number">{{ $totalMaterials ?? 0 }}</div>
                                <div class="stat-label">Materials</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="card control-panel-card">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <!-- Search Input -->
                    <div class="col-lg-6 col-md-6 mb-2 mb-lg-0">
                        <div class="input-group search-input-group">
                            <input type="text" id="classFilterSearch" class="form-control" placeholder="Search classes by name, code, room, or teacher...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search text-muted"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Dropdown Jump -->
                    <div class="col-lg-4 col-md-6 mb-2 mb-lg-0">
                        <div class="input-group">
                            <select id="quickClassDropdown" class="form-control" style="border-radius: 10px;">
                                <option value="">-- Quick Jump to Class Subjects --</option>
                                @foreach($classes as $c)
                                    <option value="{{ route('getSubject.index', ['class_id' => $c->class_id]) }}">
                                        {{ $c->name }} ({{ $c->class_code ?? 'Class #' . $c->class_id }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Shortcut to Routines -->
                    <div class="col-lg-2 col-md-12 text-lg-right text-left">
                        <a href="{{ route('class_routines.show_classes') }}" class="btn btn-outline-primary btn-block" style="border-radius: 10px; height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar-alt mr-1"></i> Routines
                        </a>
                    </div>
                </div>

                <!-- Filter Tabs -->
                <div class="d-flex flex-wrap align-items-center mt-3 pt-2 border-top" style="gap: 8px;">
                    <span class="text-muted mr-2 font-weight-bold" style="font-size: 0.85rem;">Filter:</span>
                    <button type="button" class="filter-btn-pill active" data-filter="all">
                        All Classes ({{ $classes->count() }})
                    </button>
                    <button type="button" class="filter-btn-pill" data-filter="with-subjects">
                        With Subjects ({{ $classes->where('subject_count', '>', 0)->count() }})
                    </button>
                    <button type="button" class="filter-btn-pill" data-filter="no-subjects">
                        No Subjects ({{ $classes->where('subject_count', 0)->count() }})
                    </button>
                </div>
            </div>
        </div>

        <!-- Class Cards Grid -->
        @php
            $accentColors = ['card-accent-emerald', 'card-accent-purple', 'card-accent-amber', 'card-accent-rose', ''];
        @endphp

        <div class="class-cards-grid" id="classCardsContainer">
            @forelse($classes as $index => $item)
                @php
                    $accentClass = $accentColors[$index % count($accentColors)];
                    $hasSubjects = ($item->subject_count > 0);
                @endphp
                <div class="academic-class-card"
                     data-name="{{ strtolower($item->name) }}"
                     data-code="{{ strtolower($item->class_code ?? '') }}"
                     data-room="{{ strtolower($item->class_room ?? '') }}"
                     data-teacher="{{ strtolower($item->teacher_name ?? '') }}"
                     data-has-subjects="{{ $hasSubjects ? 'yes' : 'no' }}">
                    <div class="card-top-accent {{ $accentClass }}"></div>
                    <div class="class-card-body">
                        <!-- Badges: Room & Code -->
                        <div class="class-badges">
                            @if(!empty($item->class_code))
                                <span class="badge badge-primary badge-pill-custom">
                                    <i class="fas fa-tag mr-1"></i>{{ $item->class_code }}
                                </span>
                            @endif
                            @if(!empty($item->class_room))
                                <span class="badge badge-info badge-pill-custom">
                                    <i class="fas fa-door-open mr-1"></i>Room {{ $item->class_room }}
                                </span>
                            @else
                                <span class="badge badge-light badge-pill-custom text-muted">
                                    <i class="fas fa-door-open mr-1"></i>Room N/A
                                </span>
                            @endif
                            @if($hasSubjects)
                                <span class="badge badge-success badge-pill-custom ml-auto">
                                    <i class="fas fa-book-open mr-1"></i>{{ $item->subject_count }} {{ $item->subject_count === 1 ? 'Subject' : 'Subjects' }}
                                </span>
                            @else
                                <span class="badge badge-warning badge-pill-custom ml-auto">
                                    <i class="fas fa-clock mr-1"></i>No Subjects
                                </span>
                            @endif
                        </div>

                        <!-- Class Name -->
                        <h4 class="class-title" title="{{ $item->name }}">{{ $item->name }}</h4>

                        <!-- Homeroom Teacher -->
                        <div class="teacher-pill">
                            <i class="fas fa-chalkboard-teacher mr-2 text-primary"></i>
                            <span class="text-truncate">
                                {{ $item->teacher_name ? 'Teacher: ' . $item->teacher_name : 'No Teacher Assigned' }}
                            </span>
                        </div>

                        <!-- Metrics row -->
                        <div class="class-metrics-row">
                            <div class="metric-item">
                                <div class="metric-val text-primary">{{ $item->subject_count }}</div>
                                <div class="metric-lbl">Subjects</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-val text-info">{{ $item->student_count }}</div>
                                <div class="metric-lbl">Students</div>
                            </div>
                            <div class="metric-item">
                                <div class="metric-val text-success">{{ $item->routine_count }}</div>
                                <div class="metric-lbl">Routines</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="class-card-actions">
                            <a href="{{ route('getSubject.index', ['class_id' => $item->class_id]) }}" class="btn-explore-class">
                                <i class="fas fa-book-reader"></i>
                                <span>View Subjects</span>
                                <i class="fas fa-arrow-right ml-auto" style="font-size: 0.8rem;"></i>
                            </a>
                            <a href="{{ route('class_routines.index', $item->class_id) }}" class="btn-timetable-shortcut" title="View Weekly Timetable">
                                <i class="fas fa-calendar-alt"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12" style="grid-column: 1 / -1;">
                    <div class="empty-state-container">
                        <i class="fas fa-school empty-state-icon"></i>
                        <h4 class="font-weight-bold">No Classes Available</h4>
                        <p class="text-muted">You are currently not enrolled in any classes or no classes were found.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- No search matches empty state (hidden by default) -->
        <div id="noSearchMatches" class="empty-state-container mt-4" style="display: none;">
            <i class="fas fa-search empty-state-icon"></i>
            <h4 class="font-weight-bold">No Matching Classes Found</h4>
            <p class="text-muted mb-3">No classes match your current search criteria. Try a different keyword.</p>
            <button type="button" class="btn btn-outline-primary btn-sm px-3" onclick="resetClassSearch()">
                <i class="fas fa-redo mr-1"></i> Clear Search
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('classFilterSearch');
        const cards = document.querySelectorAll('.academic-class-card');
        const filterBtns = document.querySelectorAll('.filter-btn-pill');
        const noMatchesAlert = document.getElementById('noSearchMatches');
        const quickSelect = document.getElementById('quickClassDropdown');

        let activeFilter = 'all';

        // Quick Class Jump
        if (quickSelect) {
            quickSelect.addEventListener('change', function() {
                if (this.value) {
                    window.location.href = this.value;
                }
            });
        }

        function filterCards() {
            const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
            let visibleCount = 0;

            cards.forEach(card => {
                const name = card.getAttribute('data-name') || '';
                const code = card.getAttribute('data-code') || '';
                const room = card.getAttribute('data-room') || '';
                const teacher = card.getAttribute('data-teacher') || '';
                const hasSubjects = card.getAttribute('data-has-subjects') || 'no';

                // Check text query
                const matchesSearch = !query ||
                    name.includes(query) ||
                    code.includes(query) ||
                    room.includes(query) ||
                    teacher.includes(query);

                // Check status filter tab
                let matchesFilter = true;
                if (activeFilter === 'with-subjects') {
                    matchesFilter = (hasSubjects === 'yes');
                } else if (activeFilter === 'no-subjects') {
                    matchesFilter = (hasSubjects === 'no');
                }

                if (matchesSearch && matchesFilter) {
                    card.style.display = 'flex';
                    visibleCount++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (noMatchesAlert) {
                noMatchesAlert.style.display = (visibleCount === 0 && cards.length > 0) ? 'block' : 'none';
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterCards);
        }

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                activeFilter = this.getAttribute('data-filter');
                filterCards();
            });
        });
    });

    function resetClassSearch() {
        const searchInput = document.getElementById('classFilterSearch');
        if (searchInput) {
            searchInput.value = '';
        }
        const allBtn = document.querySelector('.filter-btn-pill[data-filter="all"]');
        if (allBtn) {
            allBtn.click();
        }
    }
</script>
@endsection


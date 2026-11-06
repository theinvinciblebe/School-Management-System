@extends('layout.main')

@push('styles')
<style>
/* ═══════════════════════════════════════════════════
   MANAGE MARKS – Modern Clean UI
═══════════════════════════════════════════════════ */

/* Page layout */
.marks-wrap { max-width: 1100px; margin: 0 auto; padding: 0 1rem 3rem; }

/* Page heading */
.marks-heading { display:flex; align-items:center; gap:.85rem; margin-bottom:1.6rem; }
.marks-heading-icon {
    width:46px; height:46px; border-radius:12px;
    background:linear-gradient(135deg,#6366f1,#818cf8);
    display:flex; align-items:center; justify-content:center;
    color:#fff; font-size:1.1rem; flex-shrink:0;
    box-shadow:0 4px 12px rgba(99,102,241,.35);
}
.marks-heading h1 { font-size:1.35rem; font-weight:700; margin:0; line-height:1.2; }
.marks-heading p  { font-size:.82rem; color:#94a3b8; margin:0; }

/* Card */
.mk-card {
    background:#fff; border-radius:16px;
    box-shadow:0 2px 16px rgba(0,0,0,.07);
    border:1px solid #e8ecf2; overflow:hidden;
    margin-bottom:1.25rem;
}
html.dark-mode .mk-card {
    background:#1e2130; border-color:#2d3348;
    box-shadow:0 2px 16px rgba(0,0,0,.35);
}
.mk-card-header {
    padding:1rem 1.4rem; border-bottom:1px solid #e8ecf2;
    display:flex; align-items:center; justify-content:space-between;
    background:#fafbff;
}
html.dark-mode .mk-card-header { background:#252840; border-color:#2d3348; }
.mk-card-header-left { display:flex; align-items:center; gap:.75rem; }
.mk-step-num {
    width:28px; height:28px; border-radius:8px; flex-shrink:0;
    background:linear-gradient(135deg,#6366f1,#818cf8);
    color:#fff; font-size:.8rem; font-weight:700;
    display:flex; align-items:center; justify-content:center;
}
.mk-card-title { font-size:.95rem; font-weight:700; margin:0; }
.mk-card-sub   { font-size:.78rem; color:#94a3b8; margin:0; }
.mk-card-body  { padding:1.4rem; }

/* Form labels */
.mk-label { font-size:.8rem; font-weight:600; color:#374151; margin-bottom:.35rem; display:block; letter-spacing:.01em; }
html.dark-mode .mk-label { color:#cbd5e1; }

/* Select / input */
.mk-control {
    width:100%; padding:.6rem .85rem; border-radius:10px;
    border:1.5px solid #d1d5db; font-size:.88rem;
    background:#fff; color:#111; outline:none;
    transition:border-color .18s, box-shadow .18s;
}
.mk-control:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.14); }
html.dark-mode .mk-control { background:#1a1d2e; border-color:#3a3f5a; color:#e2e8f0; }
html.dark-mode .mk-control:focus { border-color:#818cf8; box-shadow:0 0 0 3px rgba(129,140,248,.18); }

/* Buttons */
.mk-btn {
    display:inline-flex; align-items:center; gap:.45rem;
    padding:.6rem 1.3rem; border-radius:10px; font-size:.88rem;
    font-weight:600; cursor:pointer; border:none; outline:none;
    transition:all .18s;
}
.mk-btn-primary {
    background:linear-gradient(135deg,#6366f1,#818cf8); color:#fff;
    box-shadow:0 3px 10px rgba(99,102,241,.35);
}
.mk-btn-primary:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(99,102,241,.45); }
.mk-btn-primary:disabled { opacity:.55; cursor:not-allowed; transform:none; }
.mk-btn-ghost {
    background:transparent; color:#6366f1;
    border:1.5px solid #6366f1;
}
.mk-btn-ghost:hover { background:rgba(99,102,241,.08); }
.mk-btn-success {
    background:linear-gradient(135deg,#10b981,#059669); color:#fff;
    box-shadow:0 3px 10px rgba(16,185,129,.3);
}
.mk-btn-success:hover { transform:translateY(-1px); box-shadow:0 5px 16px rgba(16,185,129,.4); }
.mk-btn-sm { padding:.42rem .9rem; font-size:.8rem; border-radius:8px; }

/* Status badge */
.mk-status-badge {
    display:inline-flex; align-items:center; gap:.35rem;
    padding:.28rem .75rem; border-radius:20px; font-size:.75rem; font-weight:600;
}
.mk-status-idle  { background:#f1f5f9; color:#64748b; }
.mk-status-ready { background:#dcfce7; color:#15803d; }
html.dark-mode .mk-status-idle  { background:#252840; color:#94a3b8; }
html.dark-mode .mk-status-ready { background:#14532d40; color:#4ade80; }

/* Alert */
.mk-alert {
    padding:.85rem 1.1rem; border-radius:12px; font-size:.85rem;
    margin-bottom:1.2rem; display:flex; align-items:flex-start; gap:.6rem;
}
.mk-alert-success { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
.mk-alert-danger  { background:#fee2e2; color:#991b1b; border:1px solid #fecaca; }
html.dark-mode .mk-alert-success { background:#14532d40; color:#4ade80; border-color:#166534; }
html.dark-mode .mk-alert-danger  { background:#7f1d1d40; color:#fca5a5; border-color:#991b1b; }

/* Toolbar row (search + filter chips) */
.marks-toolbar {
    display:flex; align-items:center; gap:.75rem; flex-wrap:wrap; margin-bottom:1rem;
}
.mk-search-wrap { position:relative; flex:1; min-width:200px; }
.mk-search-wrap i { position:absolute; left:.75rem; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:.85rem; }
.mk-search { padding:.55rem .85rem .55rem 2.2rem; border-radius:10px; border:1.5px solid #d1d5db; font-size:.85rem; width:100%; background:#fff; color:#111; outline:none; transition:border-color .18s, box-shadow .18s; }
.mk-search:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.14); }
html.dark-mode .mk-search { background:#1a1d2e; border-color:#3a3f5a; color:#e2e8f0; }
html.dark-mode .mk-search:focus { border-color:#818cf8; }

.mk-chips { display:flex; gap:.4rem; }
.mk-chip {
    padding:.35rem .8rem; border-radius:20px; font-size:.77rem; font-weight:600;
    border:1.5px solid #e2e8f0; background:#f8fafc; color:#64748b; cursor:pointer;
    transition:all .15s;
}
.mk-chip.active { background:#6366f1; color:#fff; border-color:#6366f1; }
html.dark-mode .mk-chip { background:#252840; border-color:#3a3f5a; color:#94a3b8; }
html.dark-mode .mk-chip.active { background:#6366f1; color:#fff; }

/* Quick-fill bar */
.mk-quickfill {
    display:none; align-items:center; gap:.75rem; flex-wrap:wrap;
    padding:.85rem 1rem; border-radius:12px;
    background:#f0f4ff; border:1.5px solid #c7d2fe;
    margin-bottom:1rem;
}
html.dark-mode .mk-quickfill { background:#1e1f3a; border-color:#3730a3; }
.mk-quickfill.visible { display:flex; }
.mk-quickfill-label { font-size:.8rem; font-weight:600; color:#4338ca; white-space:nowrap; }
html.dark-mode .mk-quickfill-label { color:#a5b4fc; }
.mk-quickfill input[type=number] {
    width:90px; padding:.45rem .65rem; border-radius:8px;
    border:1.5px solid #c7d2fe; font-size:.85rem; outline:none;
    background:#fff; color:#111;
}
html.dark-mode .mk-quickfill input[type=number] { background:#1a1d2e; border-color:#3730a3; color:#e2e8f0; }

/* Stats bar */
.mk-stats-bar {
    display:flex; gap:1rem; flex-wrap:wrap; padding:.85rem 1rem;
    background:#fafbff; border-radius:12px; border:1px solid #e8ecf2;
    margin-bottom:1rem;
}
html.dark-mode .mk-stats-bar { background:#252840; border-color:#2d3348; }
.mk-stat-item { text-align:center; }
.mk-stat-num  { font-size:1.1rem; font-weight:700; line-height:1; }
.mk-stat-lbl  { font-size:.7rem; color:#94a3b8; white-space:nowrap; }

/* Table */
.marks-table-wrap { overflow-x:auto; border-radius:12px; border:1px solid #e8ecf2; }
html.dark-mode .marks-table-wrap { border-color:#2d3348; }
.marks-table { width:100%; border-collapse:collapse; font-size:.85rem; }
.marks-table thead th {
    padding:.7rem 1rem; background:#f8fafc; color:#64748b;
    font-size:.75rem; font-weight:700; letter-spacing:.04em; text-transform:uppercase;
    border-bottom:1.5px solid #e2e8f0; white-space:nowrap;
}
html.dark-mode .marks-table thead th { background:#252840; color:#94a3b8; border-color:#2d3348; }
.marks-table tbody tr { border-bottom:1px solid #f1f5f9; transition:background .15s; }
html.dark-mode .marks-table tbody tr { border-color:#2d3348; }
.marks-table tbody tr:hover { background:#f8faff; }
html.dark-mode .marks-table tbody tr:hover { background:#1e2545; }
.marks-table tbody tr:last-child { border-bottom:none; }
.marks-table td { padding:.65rem 1rem; vertical-align:middle; }

/* Roll badge */
.roll-badge {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:34px; height:24px; padding:0 .5rem;
    border-radius:6px; font-size:.74rem; font-weight:700;
    background:#e0e7ff; color:#4338ca;
}
html.dark-mode .roll-badge { background:#1e1f3a; color:#a5b4fc; }

/* Avatar */
.mk-avatar {
    width:34px; height:34px; border-radius:10px;
    display:inline-flex; align-items:center; justify-content:center;
    font-weight:700; font-size:.78rem; flex-shrink:0;
    background:linear-gradient(135deg,#6366f1,#818cf8); color:#fff;
}

/* Mark input */
.mark-input {
    width:90px; padding:.42rem .65rem; border-radius:8px;
    border:1.5px solid #d1d5db; font-size:.9rem; font-weight:600;
    outline:none; text-align:center; transition:border-color .15s, box-shadow .15s;
    background:#fff; color:#111;
}
html.dark-mode .mark-input { background:#1a1d2e; border-color:#3a3f5a; color:#e2e8f0; }
.mark-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.14); }
.mark-input.is-good   { border-color:#10b981; background:#f0fdf4; }
.mark-input.is-avg    { border-color:#f59e0b; background:#fffbeb; }
.mark-input.is-poor   { border-color:#ef4444; background:#fef2f2; }
html.dark-mode .mark-input.is-good { border-color:#10b981; background:#14532d30; }
html.dark-mode .mark-input.is-avg  { border-color:#f59e0b; background:#78350f30; }
html.dark-mode .mark-input.is-poor { border-color:#ef4444; background:#7f1d1d30; }

/* Grade badge */
.grade-badge {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:36px; height:24px; padding:0 .5rem;
    border-radius:6px; font-size:.74rem; font-weight:700;
    background:#e0e7ff; color:#4338ca;
}
.grade-badge.A-plus  { background:#dcfce7; color:#15803d; }
.grade-badge.A       { background:#d1fae5; color:#065f46; }
.grade-badge.B-plus  { background:#dbeafe; color:#1e40af; }
.grade-badge.B       { background:#eff6ff; color:#3730a3; }
.grade-badge.C       { background:#fef9c3; color:#854d0e; }
.grade-badge.D       { background:#ffedd5; color:#9a3412; }
.grade-badge.F       { background:#fee2e2; color:#991b1b; }
html.dark-mode .grade-badge { background:#1e1f3a; color:#a5b4fc; }

/* Remark input */
.remark-input {
    width:100%; min-width:120px; padding:.4rem .65rem; border-radius:8px;
    border:1.5px solid #d1d5db; font-size:.82rem;
    outline:none; background:#fff; color:#111;
    transition:border-color .15s;
}
html.dark-mode .remark-input { background:#1a1d2e; border-color:#3a3f5a; color:#e2e8f0; }
.remark-input:focus { border-color:#6366f1; }

/* Status pill in row */
.row-status { font-size:.74rem; font-weight:600; padding:.22rem .6rem; border-radius:20px; white-space:nowrap; }
.row-status.graded  { background:#dcfce7; color:#15803d; }
.row-status.pending { background:#f1f5f9; color:#64748b; }
html.dark-mode .row-status.graded  { background:#14532d40; color:#4ade80; }
html.dark-mode .row-status.pending { background:#1e2130; color:#94a3b8; }

/* Empty state */
.mk-empty {
    text-align:center; padding:3rem 1rem;
    color:#94a3b8;
}
.mk-empty i { font-size:2.5rem; display:block; margin-bottom:.75rem; opacity:.5; }

/* Loading spinner row */
.mk-loading { text-align:center; padding:2.5rem 1rem; color:#94a3b8; }
.mk-loading i { font-size:1.5rem; }

/* Submit bar */
.mk-submit-bar {
    display:flex; align-items:center; justify-content:space-between; gap:1rem;
    flex-wrap:wrap; padding:1rem 1.4rem;
    border-top:1px solid #e8ecf2; background:#fafbff;
}
html.dark-mode .mk-submit-bar { background:#252840; border-color:#2d3348; }
.mk-avg-pill {
    display:inline-flex; align-items:center; gap:.4rem;
    padding:.35rem .85rem; border-radius:20px; font-size:.8rem; font-weight:600;
    background:#e0e7ff; color:#4338ca;
}
html.dark-mode .mk-avg-pill { background:#1e1f3a; color:#a5b4fc; }

/* Hidden row for filtering */
.mk-row-hidden { display:none !important; }

/* Responsive */
@media (max-width:768px) {
    .marks-table td:nth-child(5),
    .marks-table th:nth-child(5) { display:none; } /* hide remark on mobile */
    .mark-input { width:72px; }
}
</style>
@endpush

@section('content')
<div class="content-header pb-0">
    <div class="marks-wrap">
        {{-- Page Heading --}}
        <div class="marks-heading mt-2">
            <div class="marks-heading-icon"><i class="fas fa-marker"></i></div>
            <div>
                <h1>{{ __('Manage Exam Marks') }}</h1>
                <p>{{ __('Assign marks per exam · class · subject') }}</p>
            </div>
            <ol class="breadcrumb bg-transparent p-0 mb-0 ml-auto" style="font-size:.78rem;">
                <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                <li class="breadcrumb-item active">{{ __('Marks') }}</li>
            </ol>
        </div>

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="mk-alert mk-alert-success">
            <i class="fas fa-check-circle mt-1"></i>
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto mk-btn mk-btn-sm" style="background:transparent;color:inherit;border:none;padding:0 .25rem;cursor:pointer;font-size:1rem;">×</button>
        </div>
        @endif
        @if($errors->any())
        <div class="mk-alert mk-alert-danger">
            <i class="fas fa-exclamation-circle mt-1"></i>
            <span>{{ $errors->first() }}</span>
            <button onclick="this.parentElement.remove()" class="ml-auto mk-btn mk-btn-sm" style="background:transparent;color:inherit;border:none;padding:0 .25rem;cursor:pointer;font-size:1rem;">×</button>
        </div>
        @endif

        {{-- ── STEP 1: Select Criteria ──────────────────────────── --}}
        <div class="mk-card" id="step1-card">
            <div class="mk-card-header">
                <div class="mk-card-header-left">
                    <div class="mk-step-num">1</div>
                    <div>
                        <div class="mk-card-title">{{ __('Select Criteria') }}</div>
                        <div class="mk-card-sub">{{ __('Pick exam, class & subject then load students') }}</div>
                    </div>
                </div>
                <span class="mk-status-badge mk-status-idle" id="step1-badge">
                    <i class="fas fa-circle" style="font-size:.45rem;"></i> {{ __('Not loaded') }}
                </span>
            </div>
            <div class="mk-card-body">
                <div class="row">
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label class="mk-label" for="sel-exam">
                            <i class="fas fa-scroll mr-1" style="color:#6366f1;"></i>{{ __('Exam') }} <span class="text-danger">*</span>
                        </label>
                        <select id="sel-exam" class="mk-control select2bs4">
                            <option value="">{{ __('-- Select --') }}</option>
                            @foreach($exams as $exam)
                            <option value="{{ $exam->exam_id }}">
                                {{ $exam->name }}@if(!empty($exam->date)) · {{ date('d/m/Y', strtotime($exam->date)) }}@endif
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label class="mk-label" for="sel-class">
                            <i class="fas fa-university mr-1" style="color:#0ea5e9;"></i>{{ __('Class') }} <span class="text-danger">*</span>
                        </label>
                        <select id="sel-class" class="mk-control select2bs4">
                            <option value="">{{ __('-- Select --') }}</option>
                            @foreach($classes as $class)
                            <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label class="mk-label" for="sel-subject">
                            <i class="fas fa-book-open mr-1" style="color:#10b981;"></i>{{ __('Subject') }} <span class="text-danger">*</span>
                        </label>
                        <select id="sel-subject" class="mk-control select2bs4">
                            <option value="">{{ __('-- Select --') }}</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-6 col-md-3 mb-3">
                        <label class="mk-label" for="inp-max">
                            <i class="fas fa-tachometer-alt mr-1" style="color:#f59e0b;"></i>{{ __('Max Marks') }}
                        </label>
                        <input type="number" id="inp-max" class="mk-control" value="100" min="1" max="9999">
                    </div>
                </div>
                <div class="d-flex gap-2 mt-1" style="gap:.6rem;">
                    <button type="button" class="mk-btn mk-btn-primary" id="btn-load">
                        <i class="fas fa-users-cog"></i> <span id="btn-load-txt">{{ __('Load Students') }}</span>
                    </button>
                    <button type="button" class="mk-btn mk-btn-ghost" id="btn-reset" style="display:none;">
                        <i class="fas fa-undo"></i> {{ __('Reset') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- ── STEP 2: Mark Entry Sheet ─────────────────────────── --}}
        <div class="mk-card" id="step2-card" style="display:none;">
            <div class="mk-card-header">
                <div class="mk-card-header-left">
                    <div class="mk-step-num" style="background:linear-gradient(135deg,#10b981,#059669);">2</div>
                    <div>
                        <div class="mk-card-title">{{ __('Mark Entry') }}</div>
                        <div class="mk-card-sub" id="sheet-sub">—</div>
                    </div>
                </div>
                <div class="d-flex align-items-center" style="gap:.5rem;">
                    <span class="mk-status-badge mk-status-ready" id="student-count-badge">0 {{ __('students') }}</span>
                    <button type="button" class="mk-btn mk-btn-ghost mk-btn-sm" id="btn-toggle-qf" title="{{ __('Quick Fill') }}">
                        <i class="fas fa-magic"></i>
                    </button>
                </div>
            </div>

            {{-- Stats bar --}}
            <div class="mk-card-body" style="padding-bottom:.5rem;">
                <div class="mk-stats-bar">
                    <div class="mk-stat-item">
                        <div class="mk-stat-num" style="color:#6366f1;" id="st-total">0</div>
                        <div class="mk-stat-lbl">{{ __('Total') }}</div>
                    </div>
                    <div class="mk-stat-item">
                        <div class="mk-stat-num" style="color:#10b981;" id="st-graded">0</div>
                        <div class="mk-stat-lbl">{{ __('Graded') }}</div>
                    </div>
                    <div class="mk-stat-item">
                        <div class="mk-stat-num" style="color:#ef4444;" id="st-pending">0</div>
                        <div class="mk-stat-lbl">{{ __('Pending') }}</div>
                    </div>
                    <div class="mk-stat-item">
                        <div class="mk-stat-num" style="color:#f59e0b;" id="st-avg">—</div>
                        <div class="mk-stat-lbl">{{ __('Average') }}</div>
                    </div>
                </div>

                {{-- Quick-fill bar --}}
                <div class="mk-quickfill" id="qf-bar">
                    <span class="mk-quickfill-label"><i class="fas fa-magic mr-1"></i>{{ __('Quick Fill') }}</span>
                    <input type="number" id="qf-value" placeholder="{{ __('Mark') }}" min="0">
                    <button type="button" class="mk-btn mk-btn-primary mk-btn-sm" id="qf-empty">{{ __('Fill empty') }}</button>
                    <button type="button" class="mk-btn mk-btn-ghost mk-btn-sm" id="qf-all">{{ __('Fill all') }}</button>
                    <button type="button" class="mk-btn mk-btn-sm" style="border:1.5px solid #ef4444;color:#ef4444;background:transparent;" id="qf-clear">{{ __('Clear all') }}</button>
                </div>

                {{-- Search + filter chips --}}
                <div class="marks-toolbar">
                    <div class="mk-search-wrap">
                        <i class="fas fa-search"></i>
                        <input type="text" class="mk-search" id="mk-search" placeholder="{{ __('Search student name or roll…') }}">
                    </div>
                    <div class="mk-chips">
                        <span class="mk-chip active" data-filter="all">{{ __('All') }}</span>
                        <span class="mk-chip" data-filter="graded">{{ __('Graded') }}</span>
                        <span class="mk-chip" data-filter="pending">{{ __('Pending') }}</span>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <form method="POST" action="{{ route('marks.assign') }}" id="marks-form">
                @csrf
                <input type="hidden" name="exam_id"    id="h-exam">
                <input type="hidden" name="subject_id" id="h-subject">
                <input type="hidden" name="mark_total" id="h-max">

                <div class="marks-table-wrap mx-3 mb-0">
                    <table class="marks-table">
                        <thead>
                            <tr>
                                <th>{{ __('Roll') }}</th>
                                <th>{{ __('Student') }}</th>
                                <th>{{ __('Mark') }} / <span id="th-max">100</span></th>
                                <th>{{ __('Grade') }}</th>
                                <th>{{ __('Remark') }}</th>
                                <th>{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="marks-tbody">
                            <tr>
                                <td colspan="6" class="mk-loading">
                                    <i class="fas fa-circle-notch fa-spin"></i>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Submit bar --}}
                <div class="mk-submit-bar">
                    <span class="mk-avg-pill" id="avg-pill" style="display:none;">
                        <i class="fas fa-chart-line"></i>
                        {{ __('Avg') }}: <strong id="avg-val">0</strong> / <span id="avg-max">100</span>
                    </span>
                    <div class="ml-auto d-flex" style="gap:.6rem;">
                        <button type="button" class="mk-btn mk-btn-ghost" onclick="document.getElementById('btn-reset').click()">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </button>
                        <button type="submit" class="mk-btn mk-btn-success" id="btn-submit">
                            <i class="fas fa-save"></i> {{ __('Save Marks') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

    </div>{{-- /marks-wrap --}}
</div>

@push('scripts')
<script>
(function () {
    'use strict';

    /* ─── Helpers ───────────────────────────────────────────────────── */
    const $ = id => document.getElementById(id);
    const gradeScale = [
        { min:90, label:'A+', cls:'A-plus' },
        { min:80, label:'A',  cls:'A'      },
        { min:70, label:'B+', cls:'B-plus' },
        { min:60, label:'B',  cls:'B'      },
        { min:50, label:'C',  cls:'C'      },
        { min:40, label:'D',  cls:'D'      },
        { min:0,  label:'F',  cls:'F'      },
    ];

    function getGrade(mark, max) {
        if (mark === '' || mark === null || isNaN(mark)) return { label:'—', cls:'' };
        const pct = (parseFloat(mark) / parseFloat(max)) * 100;
        for (const g of gradeScale) {
            if (pct >= g.min) return g;
        }
        return { label:'F', cls:'F' };
    }

    function initials(name) {
        return name.trim().split(/\s+/).slice(0,2).map(w=>w[0]).join('').toUpperCase();
    }

    /* ─── State ─────────────────────────────────────────────────────── */
    let activeFilter = 'all';
    let searchText   = '';
    let students     = [];

    /* ─── DOM refs ──────────────────────────────────────────────────── */
    const selExam    = $('sel-exam');
    const selClass   = $('sel-class');
    const selSubject = $('sel-subject');
    const inpMax     = $('inp-max');
    const btnLoad    = $('btn-load');
    const btnReset   = $('btn-reset');
    const step2Card  = $('step2-card');
    const tbody      = $('marks-tbody');
    const hExam      = $('h-exam');
    const hSubject   = $('h-subject');
    const hMax       = $('h-max');
    const thMax      = $('th-max');
    const sheetSub   = $('sheet-sub');
    const badgeCount = $('student-count-badge');
    const step1Badge = $('step1-badge');
    const avgPill    = $('avg-pill');
    const avgVal     = $('avg-val');
    const avgMax     = $('avg-max');
    const qfBar      = $('qf-bar');

    /* ─── Load students ─────────────────────────────────────────────── */
    btnLoad.addEventListener('click', async () => {
        const examId   = selExam.value;
        const classId  = selClass.value;
        const subjId   = selSubject.value;
        const maxMark  = parseInt(inpMax.value) || 100;

        if (!examId || !classId || !subjId) {
            alert('{{ __("Please select Exam, Class and Subject first.") }}');
            return;
        }

        // Update button state
        const origHTML = btnLoad.innerHTML;
        btnLoad.disabled = true;
        btnLoad.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("Loading…") }}';

        try {
            const url = `/get-students-for-exam?exam_id=${examId}&class_id=${classId}&subject_id=${subjId}`;
            const res  = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();

            if (data.error) throw new Error(data.error);

            students = data.students || [];

            // Set hidden fields
            hExam.value    = examId;
            hSubject.value = subjId;
            hMax.value     = maxMark;
            thMax.textContent = maxMark;
            avgMax.textContent = maxMark;

            // Sheet subtitle
            const examTxt = selExam.options[selExam.selectedIndex].text;
            const classTxt  = selClass.options[selClass.selectedIndex].text;
            const subjTxt   = selSubject.options[selSubject.selectedIndex].text;
            sheetSub.textContent = `${examTxt} · ${classTxt} · ${subjTxt}`;

            // Build rows
            buildTable(students, data.marks || {}, maxMark);

            // Show step 2
            step2Card.style.display = '';
            step2Card.scrollIntoView({ behavior:'smooth', block:'start' });
            btnReset.style.display = '';
            step1Badge.className = 'mk-status-badge mk-status-ready';
            step1Badge.innerHTML = '<i class="fas fa-check-circle" style="font-size:.8rem;"></i> {{ __("Loaded") }}';

            updateStats();

        } catch(err) {
            alert('Error: ' + err.message);
        } finally {
            btnLoad.disabled = false;
            btnLoad.innerHTML = origHTML;
        }
    });

    /* ─── Build table rows ──────────────────────────────────────────── */
    function buildTable(studs, marks, maxMark) {
        if (!studs.length) {
            tbody.innerHTML = `<tr><td colspan="6" class="mk-empty">
                <i class="fas fa-user-slash"></i>
                {{ __('No students found in this class.') }}
            </td></tr>`;
            return;
        }

        tbody.innerHTML = studs.map((s, idx) => {
            const existing   = marks[s.student_class_id];
            const markVal    = existing ? existing.mark_obtained : '';
            const remarkVal  = existing ? (existing.comment || '') : '';
            const isGraded   = existing && markVal !== '' && markVal !== null;
            const grade      = getGrade(markVal, maxMark);
            const colorCls   = markVal === '' ? '' : gradeColorCls(markVal, maxMark);
            const avColor    = ['A+','A','B+','B'].includes(grade.label) ? '#6366f1' : (grade.label === 'F' ? '#ef4444' : '#f59e0b');

            return `<tr data-idx="${idx}" data-graded="${isGraded ? '1':'0'}">
                <td><span class="roll-badge">${s.roll || '—'}</span></td>
                <td>
                    <div class="d-flex align-items-center" style="gap:.6rem;">
                        <div class="mk-avatar" style="background:${avatarColor(s.name)};">${initials(s.name)}</div>
                        <span style="font-weight:600;font-size:.87rem;">${escHtml(s.name)}</span>
                    </div>
                </td>
                <td>
                    <input type="number" name="marks[${s.student_class_id}][mark_obtained]"
                           class="mark-input ${colorCls}"
                           value="${markVal}" min="0" max="${maxMark}"
                           data-scid="${s.student_class_id}"
                           placeholder="0–${maxMark}"
                           tabindex="${idx+1}"
                           autocomplete="off">
                </td>
                <td><span class="grade-badge ${grade.cls}" id="grade-${s.student_class_id}">${grade.label}</span></td>
                <td>
                    <input type="text" name="marks[${s.student_class_id}][comment]"
                           class="remark-input" value="${escHtml(remarkVal)}"
                           placeholder="{{ __('Optional remark') }}">
                </td>
                <td><span class="row-status ${isGraded ? 'graded':'pending'}" id="status-${s.student_class_id}">${isGraded ? '{{ __("Graded") }}' : '{{ __("Pending") }}'}</span></td>
            </tr>`;
        }).join('');

        // Live update on mark input
        tbody.querySelectorAll('.mark-input').forEach(input => {
            input.addEventListener('input', () => onMarkInput(input));
            input.addEventListener('keydown', onMarkKeydown);
        });

        badgeCount.innerHTML = `<i class="fas fa-check-circle" style="font-size:.8rem;"></i> ${studs.length} {{ __('students') }}`;
        updateStats();
        applyFilter();
    }

    function gradeColorCls(mark, max) {
        const pct = (parseFloat(mark) / parseFloat(max)) * 100;
        if (pct >= 60) return 'is-good';
        if (pct >= 40) return 'is-avg';
        return 'is-poor';
    }

    function avatarColor(name) {
        const colors = ['#6366f1','#8b5cf6','#ec4899','#f59e0b','#10b981','#0ea5e9','#ef4444'];
        let h = 0;
        for (let i=0; i<name.length; i++) h = name.charCodeAt(i) + ((h<<5)-h);
        return colors[Math.abs(h) % colors.length];
    }

    function escHtml(s) {
        return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    /* ─── Live mark input ───────────────────────────────────────────── */
    function onMarkInput(input) {
        const scid   = input.dataset.scid;
        const maxMk  = parseInt(hMax.value) || 100;
        let   val    = input.value;

        // Clamp
        if (val !== '' && parseFloat(val) > maxMk) { input.value = maxMk; val = maxMk; }
        if (val !== '' && parseFloat(val) < 0)      { input.value = 0;    val = 0; }

        // Color class
        input.classList.remove('is-good','is-avg','is-poor');
        if (val !== '') input.classList.add(gradeColorCls(val, maxMk));

        // Grade badge
        const grade = getGrade(val, maxMk);
        const gb = $(`grade-${scid}`);
        if (gb) { gb.textContent = grade.label; gb.className = `grade-badge ${grade.cls}`; }

        // Status pill
        const sp = $(`status-${scid}`);
        const tr = input.closest('tr');
        if (val !== '') {
            if (sp) { sp.textContent = '{{ __("Graded") }}'; sp.className = 'row-status graded'; }
            if (tr)   tr.dataset.graded = '1';
        } else {
            if (sp) { sp.textContent = '{{ __("Pending") }}'; sp.className = 'row-status pending'; }
            if (tr)   tr.dataset.graded = '0';
        }

        updateStats();
        applyFilter();
    }

    function onMarkKeydown(e) {
        const inputs = [...tbody.querySelectorAll('.mark-input')];
        const idx    = inputs.indexOf(e.target);
        if (e.key === 'Enter' || e.key === 'ArrowDown') {
            e.preventDefault();
            if (inputs[idx+1]) inputs[idx+1].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (inputs[idx-1]) inputs[idx-1].focus();
        }
    }

    /* ─── Stats ─────────────────────────────────────────────────────── */
    function updateStats() {
        const inputs  = [...tbody.querySelectorAll('.mark-input')];
        const total   = inputs.length;
        const graded  = inputs.filter(i => i.value !== '').length;
        const pending = total - graded;
        const vals    = inputs.filter(i => i.value !== '').map(i => parseFloat(i.value));
        const avg     = vals.length ? (vals.reduce((a,b)=>a+b,0)/vals.length).toFixed(1) : null;

        $('st-total').textContent   = total;
        $('st-graded').textContent  = graded;
        $('st-pending').textContent = pending;
        $('st-avg').textContent     = avg ?? '—';

        // Header stats
        $('stat-students') && ($('stat-students').textContent = total);
        $('stat-graded')   && ($('stat-graded').textContent   = graded);
        $('stat-pending')  && ($('stat-pending').textContent  = pending);

        // Avg pill
        if (avg !== null) {
            avgPill.style.display = '';
            avgVal.textContent    = avg;
        } else {
            avgPill.style.display = 'none';
        }
    }

    /* ─── Filter + search ───────────────────────────────────────────── */
    function applyFilter() {
        const rows = [...tbody.querySelectorAll('tr[data-idx]')];
        rows.forEach(tr => {
            const isGraded  = tr.dataset.graded === '1';
            const name      = tr.querySelector('span[style]')?.textContent?.toLowerCase() || '';
            const rollEl    = tr.querySelector('.roll-badge');
            const roll      = rollEl?.textContent?.toLowerCase() || '';

            const passFilter =
                activeFilter === 'all' ||
                (activeFilter === 'graded'  &&  isGraded) ||
                (activeFilter === 'pending' && !isGraded);

            const passSearch = !searchText || name.includes(searchText) || roll.includes(searchText);

            tr.classList.toggle('mk-row-hidden', !(passFilter && passSearch));
        });
    }

    document.querySelectorAll('.mk-chip').forEach(chip => {
        chip.addEventListener('click', () => {
            document.querySelectorAll('.mk-chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            activeFilter = chip.dataset.filter;
            applyFilter();
        });
    });

    $('mk-search').addEventListener('input', e => {
        searchText = e.target.value.trim().toLowerCase();
        applyFilter();
    });

    /* ─── Quick fill ─────────────────────────────────────────────────── */
    $('btn-toggle-qf').addEventListener('click', () => {
        qfBar.classList.toggle('visible');
    });

    $('qf-empty').addEventListener('click', () => {
        const val   = $('qf-value').value;
        const maxMk = parseInt(hMax.value) || 100;
        if (val === '') return;
        tbody.querySelectorAll('.mark-input').forEach(input => {
            if (input.value === '') { input.value = val; onMarkInput(input); }
        });
    });

    $('qf-all').addEventListener('click', () => {
        const val   = $('qf-value').value;
        const maxMk = parseInt(hMax.value) || 100;
        if (val === '') return;
        tbody.querySelectorAll('.mark-input').forEach(input => {
            input.value = val; onMarkInput(input);
        });
    });

    $('qf-clear').addEventListener('click', () => {
        if (!confirm('{{ __("Clear all marks?") }}')) return;
        tbody.querySelectorAll('.mark-input').forEach(input => {
            input.value = ''; onMarkInput(input);
        });
    });

    /* ─── Reset ─────────────────────────────────────────────────────── */
    btnReset.addEventListener('click', () => {
        step2Card.style.display = 'none';
        btnReset.style.display  = 'none';
        qfBar.classList.remove('visible');
        step1Badge.className = 'mk-status-badge mk-status-idle';
        step1Badge.innerHTML = '<i class="fas fa-circle" style="font-size:.45rem;"></i> {{ __("Not loaded") }}';
        // Reset select2 / selects
        selExam.value = ''; selClass.value = ''; selSubject.value = '';
        if (window.jQuery && jQuery.fn.select2) {
            jQuery('#sel-exam, #sel-class, #sel-subject').val(null).trigger('change');
        }
        window.scrollTo({ top:0, behavior:'smooth' });
    });

    /* ─── Form submit validation ─────────────────────────────────────── */
    $('marks-form').addEventListener('submit', e => {
        const inputs = [...tbody.querySelectorAll('.mark-input')];
        const filled = inputs.filter(i => i.value !== '').length;
        if (filled === 0) {
            e.preventDefault();
            alert('{{ __("Please enter at least one mark before saving.") }}');
            return;
        }
        const btn = $('btn-submit');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("Saving…") }}';
    });

    /* ─── Init Select2 ───────────────────────────────────────────────── */
    if (window.jQuery && jQuery.fn.select2) {
        jQuery('#sel-exam, #sel-class, #sel-subject').select2({
            theme: 'bootstrap4',
            width: '100%',
        });
    }

})();
</script>
@endpush
@endsection

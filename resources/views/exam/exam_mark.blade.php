@extends('layout.main')

@push('styles')
<style>
/* ══════════════════════════════════════════════════════════════════
   GRADEBOOK / MANAGE MARKS – Next-Gen SaaS UI
══════════════════════════════════════════════════════════════════ */

.gb-wrapper {
    max-width: 1280px;
    margin: 0 auto;
    padding: 0.5rem 1rem 5rem;
}

/* Hero Header */
.gb-hero {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.gb-hero-left {
    display: flex;
    align-items: center;
    gap: 1rem;
}
.gb-hero-icon {
    width: 52px;
    height: 52px;
    border-radius: 16px;
    background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #d946ef 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 1.35rem;
    box-shadow: 0 10px 25px -5px rgba(99, 102, 241, 0.45);
    flex-shrink: 0;
}
.gb-hero-title {
    font-size: 1.5rem;
    font-weight: 800;
    margin: 0;
    letter-spacing: -0.02em;
    color: #0f172a;
}
html.dark-mode .gb-hero-title { color: #f8fafc; }
.gb-hero-sub {
    font-size: 0.85rem;
    color: #64748b;
    margin: 0;
}
html.dark-mode .gb-hero-sub { color: #94a3b8; }

/* Criteria Ribbon (Unified Modern Filter Bar) */
.gb-criteria-bar {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    transition: all 0.25s ease;
}
html.dark-mode .gb-criteria-bar {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.35);
}
.gb-criteria-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding-bottom: 0.75rem;
    border-bottom: 1px solid #f1f5f9;
}
html.dark-mode .gb-criteria-header {
    border-bottom-color: #293049;
}
.gb-criteria-title {
    font-size: 0.88rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: #475569;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
html.dark-mode .gb-criteria-title { color: #94a3b8; }

.gb-sync-status {
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    padding: 0.35rem 0.85rem;
    border-radius: 9999px;
    font-size: 0.78rem;
    font-weight: 600;
    transition: all 0.2s ease;
}
.gb-sync-waiting { background: #f1f5f9; color: #64748b; }
.gb-sync-loading { background: #e0e7ff; color: #4338ca; animation: pulse 1.5s infinite; }
.gb-sync-ready   { background: #dcfce7; color: #15803d; }
html.dark-mode .gb-sync-waiting { background: #262c40; color: #94a3b8; }
html.dark-mode .gb-sync-loading { background: #312e81; color: #c7d2fe; }
html.dark-mode .gb-sync-ready   { background: #064e3b40; color: #4ade80; }

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}

/* Criteria Grid Controls */
.gb-criteria-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    align-items: end;
}
.gb-field-group {
    display: flex;
    flex-direction: column;
    gap: 0.4rem;
}
.gb-field-label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #334155;
    text-transform: uppercase;
    letter-spacing: 0.03em;
    display: flex;
    align-items: center;
    gap: 0.35rem;
    margin: 0;
}
html.dark-mode .gb-field-label { color: #cbd5e1; }
.gb-select-wrap {
    position: relative;
    width: 100%;
}
.gb-select, .gb-input {
    width: 100%;
    height: 44px;
    padding: 0.55rem 1rem;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #0f172a;
    font-size: 0.88rem;
    font-weight: 500;
    outline: none;
    transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    appearance: none;
    -webkit-appearance: none;
}
.gb-select {
    padding-right: 2.2rem;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 0.85rem center;
    background-size: 1rem;
}
.gb-select:focus, .gb-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.15);
}
html.dark-mode .gb-select, html.dark-mode .gb-input {
    background-color: #171a29;
    border-color: #333c56;
    color: #f1f5f9;
}
html.dark-mode .gb-select:focus, html.dark-mode .gb-input:focus {
    border-color: #818cf8;
    box-shadow: 0 0 0 4px rgba(129, 140, 248, 0.2);
}

/* Empty Guided State */
.gb-guided-state {
    background: #ffffff;
    border: 2px dashed #cbd5e1;
    border-radius: 24px;
    padding: 4rem 2rem;
    text-align: center;
    margin-bottom: 2rem;
}
html.dark-mode .gb-guided-state {
    background: #1a1e30;
    border-color: #2f3752;
}
.gb-guided-icon {
    width: 72px;
    height: 72px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(139, 92, 246, 0.15));
    color: #6366f1;
    font-size: 2rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}
.gb-guided-steps {
    display: flex;
    justify-content: center;
    gap: 1rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
}
.gb-step-pill {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1.1rem;
    border-radius: 12px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    font-size: 0.82rem;
    font-weight: 600;
    color: #64748b;
    transition: all 0.2s ease;
}
.gb-step-pill.done {
    background: #ecfdf5;
    border-color: #a7f3d0;
    color: #059669;
}
html.dark-mode .gb-step-pill {
    background: #20263b;
    border-color: #313955;
    color: #94a3b8;
}
html.dark-mode .gb-step-pill.done {
    background: #064e3b35;
    border-color: #059669;
    color: #34d399;
}

/* Analytics Dashboard Card */
.gb-analytics-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
    margin-bottom: 1.5rem;
    display: none;
}
html.dark-mode .gb-analytics-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 25px -2px rgba(0, 0, 0, 0.35);
}
.gb-stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1rem;
}
.gb-stat-box {
    padding: 0.75rem 1rem;
    border-radius: 14px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    display: flex;
    flex-direction: column;
    justify-content: center;
}
html.dark-mode .gb-stat-box {
    background: #171a2a;
    border-color: #2a314b;
}
.gb-stat-label {
    font-size: 0.72rem;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    margin-bottom: 0.25rem;
}
.gb-stat-value {
    font-size: 1.45rem;
    font-weight: 800;
    line-height: 1.1;
    color: #0f172a;
}
html.dark-mode .gb-stat-value { color: #f8fafc; }

/* Progress Meter */
.gb-progress-wrap {
    margin-top: 1rem;
    padding-top: 0.75rem;
    border-top: 1px solid #f1f5f9;
}
html.dark-mode .gb-progress-wrap { border-top-color: #293049; }
.gb-progress-info {
    display: flex;
    justify-content: space-between;
    font-size: 0.78rem;
    font-weight: 600;
    color: #64748b;
    margin-bottom: 0.4rem;
}
.gb-progress-track {
    width: 100%;
    height: 8px;
    border-radius: 9999px;
    background: #e2e8f0;
    overflow: hidden;
}
html.dark-mode .gb-progress-track { background: #2c334b; }
.gb-progress-bar {
    height: 100%;
    border-radius: 9999px;
    background: linear-gradient(90deg, #6366f1, #10b981);
    transition: width 0.3s ease;
    width: 0%;
}

/* Toolbar & Filter Bar */
.gb-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 0.75rem;
    margin-bottom: 1rem;
}
.gb-search-box {
    position: relative;
    flex: 1;
    min-width: 240px;
}
.gb-search-icon {
    position: absolute;
    left: 0.9rem;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 0.85rem;
    pointer-events: none;
}
.gb-search-input {
    width: 100%;
    height: 42px;
    padding: 0.5rem 1rem 0.5rem 2.4rem;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    font-size: 0.85rem;
    outline: none;
    transition: all 0.2s ease;
}
.gb-search-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
}
html.dark-mode .gb-search-input {
    background: #171a2a;
    border-color: #2e3650;
    color: #f1f5f9;
}

.gb-filter-pills {
    display: flex;
    gap: 0.35rem;
}
.gb-pill {
    padding: 0.45rem 0.9rem;
    border-radius: 10px;
    font-size: 0.78rem;
    font-weight: 600;
    background: #f1f5f9;
    border: 1.5px solid transparent;
    color: #64748b;
    cursor: pointer;
    transition: all 0.18s ease;
}
.gb-pill:hover { background: #e2e8f0; color: #334155; }
.gb-pill.active {
    background: #6366f1;
    color: #ffffff;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}
html.dark-mode .gb-pill { background: #22273d; color: #94a3b8; }
html.dark-mode .gb-pill:hover { background: #2e3552; color: #f8fafc; }
html.dark-mode .gb-pill.active { background: #6366f1; color: #fff; }

.gb-tools-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.gb-tool-btn {
    height: 42px;
    padding: 0 0.9rem;
    border-radius: 12px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    transition: all 0.18s ease;
}
.gb-tool-btn:hover {
    border-color: #6366f1;
    color: #6366f1;
    background: rgba(99, 102, 241, 0.05);
}
html.dark-mode .gb-tool-btn {
    background: #171a2a;
    border-color: #2e3650;
    color: #94a3b8;
}
html.dark-mode .gb-tool-btn:hover {
    border-color: #818cf8;
    color: #818cf8;
}

/* Quick Fill Drawer */
.gb-quickfill-drawer {
    display: none;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    padding: 0.85rem 1.25rem;
    background: linear-gradient(135deg, #eef2ff, #f5f3ff);
    border: 1.5px solid #c7d2fe;
    border-radius: 14px;
    margin-bottom: 1rem;
    animation: fadeIn 0.2s ease;
}
html.dark-mode .gb-quickfill-drawer {
    background: linear-gradient(135deg, #1e1f3a, #261f3d);
    border-color: #4338ca;
}
.gb-quickfill-drawer.active { display: flex; }
.gb-qf-label { font-size: 0.82rem; font-weight: 700; color: #4338ca; }
html.dark-mode .gb-qf-label { color: #c7d2fe; }

/* Student Table Sheet */
.gb-sheet-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 20px;
    box-shadow: 0 4px 25px -4px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    margin-bottom: 1.5rem;
    display: none;
}
html.dark-mode .gb-sheet-card {
    background: #1e2235;
    border-color: #2e354f;
    box-shadow: 0 4px 30px -4px rgba(0, 0, 0, 0.4);
}
.gb-table-wrap {
    overflow-x: auto;
    width: 100%;
}
.gb-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.88rem;
}
.gb-table thead th {
    padding: 0.85rem 1.25rem;
    background: #f8fafc;
    color: #475569;
    font-size: 0.74rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    border-bottom: 1.5px solid #e2e8f0;
    white-space: nowrap;
}
html.dark-mode .gb-table thead th {
    background: #171a2a;
    color: #94a3b8;
    border-bottom-color: #2a314b;
}
.gb-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.15s ease;
}
html.dark-mode .gb-table tbody tr { border-bottom-color: #272e45; }
.gb-table tbody tr:hover { background: #f8faff; }
html.dark-mode .gb-table tbody tr:hover { background: #232840; }
.gb-table td {
    padding: 0.85rem 1.25rem;
    vertical-align: middle;
}

/* Roll Number Pill */
.gb-roll-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 38px;
    height: 28px;
    padding: 0 0.6rem;
    border-radius: 8px;
    background: #f1f5f9;
    color: #334155;
    font-size: 0.78rem;
    font-weight: 700;
    border: 1px solid #e2e8f0;
}
html.dark-mode .gb-roll-pill {
    background: #242b42;
    border-color: #333d5d;
    color: #cbd5e1;
}

/* Student Profile Cell */
.gb-student-cell {
    display: flex;
    align-items: center;
    gap: 0.85rem;
}
.gb-student-avatar {
    width: 40px;
    height: 40px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 0.85rem;
    color: #ffffff;
    flex-shrink: 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    object-fit: cover;
}
.gb-student-name {
    font-weight: 700;
    font-size: 0.92rem;
    color: #0f172a;
    line-height: 1.2;
}
html.dark-mode .gb-student-name { color: #f8fafc; }
.gb-student-meta {
    font-size: 0.74rem;
    color: #64748b;
}

/* Interactive Score Input */
.gb-score-box {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
.gb-score-input {
    width: 90px;
    height: 42px;
    padding: 0.4rem 0.6rem;
    border-radius: 10px;
    border: 2px solid #cbd5e1;
    font-size: 1rem;
    font-weight: 800;
    text-align: center;
    outline: none;
    background: #ffffff;
    color: #0f172a;
    transition: all 0.18s ease;
}
.gb-score-input:focus {
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
}
html.dark-mode .gb-score-input {
    background: #171a2a;
    border-color: #313a54;
    color: #f8fafc;
}

/* Grade badges */
.gb-grade-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 28px;
    padding: 0 0.55rem;
    border-radius: 8px;
    font-size: 0.78rem;
    font-weight: 800;
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #e2e8f0;
}
.gb-grade-A-plus { background: #dcfce7; color: #15803d; border-color: #86efac; }
.gb-grade-A      { background: #ecfdf5; color: #047857; border-color: #a7f3d0; }
.gb-grade-B-plus { background: #e0e7ff; color: #4338ca; border-color: #a5b4fc; }
.gb-grade-B      { background: #eff6ff; color: #1d4ed8; border-color: #bfdbfe; }
.gb-grade-C      { background: #fef9c3; color: #854d0e; border-color: #fde047; }
.gb-grade-D      { background: #ffedd5; color: #c2410c; border-color: #fdba74; }
.gb-grade-F      { background: #fee2e2; color: #b91c1c; border-color: #fca5a5; }
html.dark-mode .gb-grade-badge { border-color: transparent; }
html.dark-mode .gb-grade-A-plus { background: #064e3b40; color: #4ade80; }
html.dark-mode .gb-grade-A      { background: #064e3b30; color: #34d399; }
html.dark-mode .gb-grade-B-plus { background: #312e8140; color: #a5b4fc; }
html.dark-mode .gb-grade-B      { background: #1e3a8a40; color: #93c5fd; }
html.dark-mode .gb-grade-C      { background: #713f1240; color: #fde047; }
html.dark-mode .gb-grade-D      { background: #7c2d1240; color: #fb923c; }
html.dark-mode .gb-grade-F      { background: #7f1d1d40; color: #f87171; }

/* Remark and Preset Tags */
.gb-remark-wrap {
    display: flex;
    flex-direction: column;
    gap: 0.35rem;
    min-width: 170px;
}
.gb-remark-input {
    width: 100%;
    height: 36px;
    padding: 0.35rem 0.75rem;
    border-radius: 8px;
    border: 1.5px solid #cbd5e1;
    font-size: 0.8rem;
    outline: none;
    background: #ffffff;
    color: #0f172a;
    transition: border-color 0.15s ease;
}
.gb-remark-input:focus { border-color: #6366f1; }
html.dark-mode .gb-remark-input {
    background: #171a2a;
    border-color: #313a54;
    color: #f1f5f9;
}
.gb-tags-wrap {
    display: flex;
    gap: 0.25rem;
    flex-wrap: wrap;
}
.gb-tag {
    font-size: 0.68rem;
    padding: 0.1rem 0.45rem;
    border-radius: 6px;
    background: #f1f5f9;
    color: #64748b;
    cursor: pointer;
    border: 1px solid #e2e8f0;
    transition: all 0.15s ease;
    user-select: none;
}
.gb-tag:hover { background: #e0e7ff; color: #4338ca; border-color: #c7d2fe; }
html.dark-mode .gb-tag {
    background: #23293f;
    border-color: #313a57;
    color: #94a3b8;
}

/* Floating Modern Save Dock */
.gb-save-dock {
    position: fixed;
    bottom: 2rem;
    left: 50%;
    transform: translateX(-50%) translateY(120%);
    background: rgba(15, 23, 42, 0.92);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    border-radius: 9999px;
    padding: 0.65rem 1.25rem 0.65rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.5);
    z-index: 1040;
    color: #ffffff;
    transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
}
.gb-save-dock.show {
    transform: translateX(-50%) translateY(0);
}
.gb-dock-status {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    font-size: 0.85rem;
    font-weight: 600;
}
.gb-dock-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #f59e0b;
    box-shadow: 0 0 10px #f59e0b;
}
.gb-dock-btn {
    height: 40px;
    padding: 0 1.35rem;
    border-radius: 9999px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #ffffff;
    font-size: 0.85rem;
    font-weight: 700;
    border: none;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.45rem;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    transition: transform 0.15s ease, box-shadow 0.15s ease;
}
.gb-dock-btn:hover {
    transform: scale(1.03);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.55);
}
.gb-dock-kbd {
    padding: 0.15rem 0.45rem;
    border-radius: 6px;
    background: rgba(255, 255, 255, 0.2);
    font-size: 0.7rem;
    font-family: inherit;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@section('content')
<div class="content-header pb-0">
    <div class="gb-wrapper">

        {{-- ── Hero Section ───────────────────────────────────────────── --}}
        <div class="gb-hero">
            <div class="gb-hero-left">
                <div class="gb-hero-icon">
                    <i class="fas fa-file-signature"></i>
                </div>
                <div>
                    <h1 class="gb-hero-title">{{ __('Gradebook & Marks') }}</h1>
                    <p class="gb-hero-sub">{{ __('Seamless mark entry workspace • auto-syncs as you select criteria') }}</p>
                </div>
            </div>
            <ol class="breadcrumb bg-transparent p-0 mb-0" style="font-size: 0.8rem;">
                <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home mr-1"></i>{{ __('Home') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('exams_list.index') }}">{{ __('Exams') }}</a></li>
                <li class="breadcrumb-item active">{{ __('Manage Marks') }}</li>
            </ol>
        </div>

        {{-- Flash notifications --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-xl mb-4" role="alert" style="border-radius:14px;">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show rounded-xl mb-4" role="alert" style="border-radius:14px;">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ $errors->first() }}
                <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
            </div>
        @endif

        {{-- ── Criteria Selection Bar (NO BUTTON NEEDED!) ───────────── --}}
        <div class="gb-criteria-bar">
            <div class="gb-criteria-header">
                <div class="gb-criteria-title">
                    <i class="fas fa-sliders-h" style="color:#6366f1;"></i>
                    {{ __('Grading Criteria') }}
                </div>
                <div id="gb-sync-status" class="gb-sync-status gb-sync-waiting">
                    <i class="fas fa-clock"></i>
                    <span id="gb-sync-text">{{ __('Waiting for selection') }}</span>
                </div>
            </div>

            <div class="gb-criteria-grid">
                {{-- 1. Examination --}}
                <div class="gb-field-group">
                    <label class="gb-field-label" for="gb-exam">
                        <i class="fas fa-calendar-check" style="color:#6366f1;"></i>
                        {{ __('1. Examination') }} <span class="text-danger">*</span>
                    </label>
                    <div class="gb-select-wrap">
                        <select id="gb-exam" class="gb-select">
                            <option value="">{{ __('-- Select Exam --') }}</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->exam_id }}">
                                    {{ $exam->name }} @if(!empty($exam->date)) · {{ date('M d, Y', strtotime($exam->date)) }} @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- 2. Class / Grade --}}
                <div class="gb-field-group">
                    <label class="gb-field-label" for="gb-class">
                        <i class="fas fa-graduation-cap" style="color:#0ea5e9;"></i>
                        {{ __('2. Class / Grade') }} <span class="text-danger">*</span>
                    </label>
                    <div class="gb-select-wrap">
                        <select id="gb-class" class="gb-select">
                            <option value="">{{ __('-- Select Class --') }}</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- 3. Subject --}}
                <div class="gb-field-group">
                    <label class="gb-field-label" for="gb-subject">
                        <i class="fas fa-book" style="color:#10b981;"></i>
                        {{ __('3. Subject') }} <span class="text-danger">*</span>
                    </label>
                    <div class="gb-select-wrap">
                        <select id="gb-subject" class="gb-select">
                            <option value="">{{ __('-- Select Subject --') }}</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- 4. Maximum Marks --}}
                <div class="gb-field-group">
                    <label class="gb-field-label" for="gb-max-marks">
                        <i class="fas fa-bullseye" style="color:#f59e0b;"></i>
                        {{ __('Max Score') }}
                    </label>
                    <input type="number" id="gb-max-marks" class="gb-input" value="100" min="1" max="1000">
                </div>
            </div>
        </div>

        {{-- ── Guided Step Empty State (Before Criteria Completed) ───── --}}
        <div class="gb-guided-state" id="gb-empty-guide">
            <div class="gb-guided-icon">
                <i class="fas fa-magic"></i>
            </div>
            <h3 style="font-weight:800; font-size:1.35rem; margin-bottom:0.4rem;">
                {{ __('Select Exam, Class & Subject above') }}
            </h3>
            <p style="color:#64748b; max-width:480px; margin:0 auto; font-size:0.9rem;">
                {{ __('No extra buttons to click! Once you choose your criteria, your class roster and existing marks load instantly.') }}
            </p>
            <div class="gb-guided-steps">
                <div class="gb-step-pill" id="step-pill-1">
                    <i class="fas fa-circle" style="font-size:0.6rem;"></i>
                    <span>{{ __('1. Exam') }}</span>
                </div>
                <div class="gb-step-pill" id="step-pill-2">
                    <i class="fas fa-circle" style="font-size:0.6rem;"></i>
                    <span>{{ __('2. Class') }}</span>
                </div>
                <div class="gb-step-pill" id="step-pill-3">
                    <i class="fas fa-circle" style="font-size:0.6rem;"></i>
                    <span>{{ __('3. Subject') }}</span>
                </div>
            </div>
        </div>

        {{-- ── Real-Time Analytics & Grade Progress ─────────────────── --}}
        <div class="gb-analytics-card" id="gb-analytics">
            <div class="gb-stats-grid">
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Students') }}</span>
                    <span class="gb-stat-value" id="stat-total" style="color:#6366f1;">0</span>
                </div>
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Graded') }}</span>
                    <span class="gb-stat-value" id="stat-graded" style="color:#10b981;">0</span>
                </div>
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Pending') }}</span>
                    <span class="gb-stat-value" id="stat-pending" style="color:#f59e0b;">0</span>
                </div>
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Class Average') }}</span>
                    <span class="gb-stat-value" id="stat-avg" style="color:#0ea5e9;">—</span>
                </div>
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Highest Score') }}</span>
                    <span class="gb-stat-value" id="stat-high" style="color:#8b5cf6;">—</span>
                </div>
                <div class="gb-stat-box">
                    <span class="gb-stat-label">{{ __('Passing Rate') }}</span>
                    <span class="gb-stat-value" id="stat-pass" style="color:#14b8a6;">—</span>
                </div>
            </div>

            <div class="gb-progress-wrap">
                <div class="gb-progress-info">
                    <span>{{ __('Grading Completion') }}</span>
                    <span id="gb-progress-pct">0%</span>
                </div>
                <div class="gb-progress-track">
                    <div class="gb-progress-bar" id="gb-progress-bar"></div>
                </div>
            </div>
        </div>

        {{-- ── Toolbar (Search, Filter Tabs, Quick Fill Toggle) ────── --}}
        <div class="gb-toolbar" id="gb-toolbar" style="display:none;">
            <div class="gb-search-box">
                <i class="fas fa-search gb-search-icon"></i>
                <input type="text" id="gb-search" class="gb-search-input" placeholder="{{ __('Filter students by name or roll number…') }}">
            </div>

            <div class="gb-filter-pills">
                <button type="button" class="gb-pill active" data-filter="all">{{ __('All') }} <span id="count-all">(0)</span></button>
                <button type="button" class="gb-pill" data-filter="graded">{{ __('Graded') }} <span id="count-graded">(0)</span></button>
                <button type="button" class="gb-pill" data-filter="pending">{{ __('Pending') }} <span id="count-pending">(0)</span></button>
            </div>

            <div class="gb-tools-right">
                <button type="button" class="gb-tool-btn" id="btn-toggle-qf" title="{{ __('Quick fill presets') }}">
                    <i class="fas fa-magic"></i>
                    <span>{{ __('Quick Fill') }}</span>
                </button>
                <button type="button" class="gb-tool-btn" onclick="window.print()" title="{{ __('Print current grade sheet') }}">
                    <i class="fas fa-print"></i>
                    <span>{{ __('Print') }}</span>
                </button>
            </div>
        </div>

        {{-- Quick Fill Drawer --}}
        <div class="gb-quickfill-drawer" id="gb-qf-drawer">
            <span class="gb-qf-label"><i class="fas fa-bolt mr-1"></i>{{ __('Quick Fill:') }}</span>
            <input type="number" id="gb-qf-input" class="gb-input" style="width:110px; height:38px;" placeholder="{{ __('Score') }}" min="0">
            <button type="button" class="gb-tool-btn" id="btn-qf-empty">{{ __('Fill Empty Only') }}</button>
            <button type="button" class="gb-tool-btn" id="btn-qf-all">{{ __('Fill All Students') }}</button>
            <button type="button" class="gb-tool-btn text-danger" id="btn-qf-clear">{{ __('Clear All Marks') }}</button>
        </div>

        {{-- ── Mark Entry Sheet Form ────────────────────────────────── --}}
        <form method="POST" action="{{ route('marks.assign') }}" id="gb-form">
            @csrf
            <input type="hidden" name="exam_id"    id="form-exam-id">
            <input type="hidden" name="subject_id" id="form-subject-id">
            <input type="hidden" name="mark_total" id="form-mark-total">

            <div class="gb-sheet-card" id="gb-sheet">
                <div class="gb-table-wrap">
                    <table class="gb-table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">{{ __('Roll #') }}</th>
                                <th>{{ __('Student Name') }}</th>
                                <th style="width: 170px;">{{ __('Mark') }} / <span id="th-max-mark">100</span></th>
                                <th style="width: 100px;">{{ __('Grade') }}</th>
                                <th>{{ __('Remarks & Feedback') }}</th>
                                <th style="width: 110px; text-align:right;">{{ __('Status') }}</th>
                            </tr>
                        </thead>
                        <tbody id="gb-tbody">
                            {{-- Dynamically populated via AJAX --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Floating Save Dock --}}
            <div class="gb-save-dock" id="gb-dock">
                <div class="gb-dock-status">
                    <span class="gb-dock-dot"></span>
                    <span id="dock-changes-text">{{ __('Ready to save') }}</span>
                </div>
                <div style="font-size:0.8rem; opacity:0.85; border-left:1px solid rgba(255,255,255,0.2); padding-left:0.75rem;">
                    {{ __('Avg:') }} <strong id="dock-avg-val">0</strong>
                </div>
                <button type="submit" class="gb-dock-btn" id="gb-save-btn">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <span>{{ __('Save Marks') }}</span>
                    <kbd class="gb-dock-kbd">Ctrl+S</kbd>
                </button>
            </div>
        </form>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    /* ─── State ──────────────────────────────────────────────────────── */
    let currentStudents = [];
    let currentMarks    = {};
    let activeFilter    = 'all';
    let searchQuery     = '';
    let unsavedChanges  = false;

    /* ─── DOM Elements ───────────────────────────────────────────────── */
    const selExam      = document.getElementById('gb-exam');
    const selClass     = document.getElementById('gb-class');
    const selSubject   = document.getElementById('gb-subject');
    const inpMaxMarks  = document.getElementById('gb-max-marks');
    const syncStatus   = document.getElementById('gb-sync-status');
    const syncText     = document.getElementById('gb-sync-text');
    const emptyGuide   = document.getElementById('gb-empty-guide');
    const analyticsBox = document.getElementById('gb-analytics');
    const toolbarBox   = document.getElementById('gb-toolbar');
    const sheetBox     = document.getElementById('gb-sheet');
    const tbody        = document.getElementById('gb-tbody');
    const formExamId   = document.getElementById('form-exam-id');
    const formSubjId   = document.getElementById('form-subject-id');
    const formMaxMarks = document.getElementById('form-mark-total');
    const thMaxMark    = document.getElementById('th-max-mark');
    const searchInput  = document.getElementById('gb-search');
    const qfDrawer     = document.getElementById('gb-qf-drawer');
    const saveDock     = document.getElementById('gb-dock');
    const saveBtn      = document.getElementById('gb-save-btn');
    const dockChanges  = document.getElementById('dock-changes-text');
    const dockAvgVal   = document.getElementById('dock-avg-val');

    /* ─── Grading Scale ──────────────────────────────────────────────── */
    const gradeScales = [
        { min: 90, label: 'A+', cls: 'gb-grade-A-plus' },
        { min: 80, label: 'A',  cls: 'gb-grade-A'      },
        { min: 70, label: 'B+', cls: 'gb-grade-B-plus' },
        { min: 60, label: 'B',  cls: 'gb-grade-B'      },
        { min: 50, label: 'C',  cls: 'gb-grade-C'      },
        { min: 40, label: 'D',  cls: 'gb-grade-D'      },
        { min: 0,  label: 'F',  cls: 'gb-grade-F'      },
    ];

    function calculateGrade(score, max) {
        if (score === '' || score === null || isNaN(score)) return { label: '—', cls: '' };
        const pct = (parseFloat(score) / parseFloat(max)) * 100;
        for (const g of gradeScales) {
            if (pct >= g.min) return g;
        }
        return { label: 'F', cls: 'gb-grade-F' };
    }

    function getInitials(name) {
        return (name || '').trim().split(/\s+/).slice(0, 2).map(w => w[0]).join('').toUpperCase() || 'ST';
    }

    function getAvatarColor(name) {
        const palettes = ['#6366f1', '#8b5cf6', '#ec4899', '#f59e0b', '#10b981', '#0ea5e9', '#06b6d4'];
        let hash = 0;
        for (let i = 0; i < (name || '').length; i++) hash = name.charCodeAt(i) + ((hash << 5) - hash);
        return palettes[Math.abs(hash) % palettes.length];
    }

    /* ─── Auto-Trigger on Criteria Change ────────────────────────────── */
    function checkAndAutoLoad() {
        const examId  = selExam.value;
        const classId = selClass.value;
        const subjId  = selSubject.value;

        // Update step pills visually
        document.getElementById('step-pill-1').classList.toggle('done', !!examId);
        document.getElementById('step-pill-2').classList.toggle('done', !!classId);
        document.getElementById('step-pill-3').classList.toggle('done', !!subjId);

        if (!examId || !classId || !subjId) {
            // Not all ready
            syncStatus.className = 'gb-sync-status gb-sync-waiting';
            syncStatus.innerHTML = '<i class="fas fa-clock"></i> <span>{{ __("Waiting for selection") }}</span>';
            emptyGuide.style.display   = '';
            analyticsBox.style.display = 'none';
            toolbarBox.style.display   = 'none';
            sheetBox.style.display     = 'none';
            saveDock.classList.remove('show');
            return;
        }

        // All 3 selected -> Auto load immediately!
        fetchStudentsAutomatically(examId, classId, subjId);
    }

    selExam.addEventListener('change', checkAndAutoLoad);
    selClass.addEventListener('change', checkAndAutoLoad);
    selSubject.addEventListener('change', checkAndAutoLoad);
    inpMaxMarks.addEventListener('input', function () {
        const max = parseInt(this.value) || 100;
        thMaxMark.textContent = max;
        formMaxMarks.value = max;
        recalculateAllRows();
    });

    /* ─── Fetch Students AJAX ────────────────────────────────────────── */
    async function fetchStudentsAutomatically(examId, classId, subjId) {
        syncStatus.className = 'gb-sync-status gb-sync-loading';
        syncStatus.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>{{ __("Syncing students…") }}</span>';

        const maxScore = parseInt(inpMaxMarks.value) || 100;
        formExamId.value   = examId;
        formSubjId.value   = subjId;
        formMaxMarks.value = maxScore;
        thMaxMark.textContent = maxScore;

        try {
            const url = `/get-students-for-exam?exam_id=${examId}&class_id=${classId}&subject_id=${subjId}`;
            const res = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            const data = await res.json();

            if (data.error) throw new Error(data.error);

            currentStudents = data.students || [];
            currentMarks    = data.marks || {};

            renderGradeSheet(currentStudents, currentMarks, maxScore);

            // Update UI state
            syncStatus.className = 'gb-sync-status gb-sync-ready';
            syncStatus.innerHTML = `<i class="fas fa-check-circle"></i> <span>{{ __("Synced") }}: ${currentStudents.length} {{ __("students") }}</span>`;

            emptyGuide.style.display   = 'none';
            analyticsBox.style.display = '';
            toolbarBox.style.display   = 'flex';
            sheetBox.style.display     = 'block';

            updateAnalytics();
            saveDock.classList.add('show');
            unsavedChanges = false;
            dockChanges.textContent = '{{ __("Ready to grade") }}';

        } catch (err) {
            syncStatus.className = 'gb-sync-status gb-sync-waiting';
            syncStatus.innerHTML = `<i class="fas fa-exclamation-triangle text-danger"></i> <span>${err.message}</span>`;
        }
    }

    /* ─── Render Student Rows ────────────────────────────────────────── */
    function renderGradeSheet(students, marks, maxScore) {
        if (!students.length) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center; padding:3.5rem 1rem; color:#94a3b8;">
                        <i class="fas fa-user-slash" style="font-size:2.5rem; margin-bottom:0.75rem; display:block; opacity:0.5;"></i>
                        <h4 style="font-weight:700; margin:0;">{{ __('No students enrolled in this class') }}</h4>
                    </td>
                </tr>
            `;
            return;
        }

        tbody.innerHTML = students.map((s, idx) => {
            const existing  = marks[s.student_class_id];
            const scoreVal  = existing ? existing.mark_obtained : '';
            const remarkVal = existing ? (existing.comment || '') : '';
            const isGraded  = scoreVal !== '' && scoreVal !== null;
            const gradeInfo = calculateGrade(scoreVal, maxScore);

            const avatarImg = s.photo
                ? `<img src="/student_images/${s.photo}" class="gb-student-avatar" alt="${s.name}" onerror="this.outerHTML='<div class=\\'gb-student-avatar\\' style=\\'background:${getAvatarColor(s.name)}\\'>${getInitials(s.name)}</div>'">`
                : `<div class="gb-student-avatar" style="background:${getAvatarColor(s.name)}">${getInitials(s.name)}</div>`;

            return `
                <tr data-student-id="${s.student_class_id}" data-graded="${isGraded ? '1' : '0'}" data-name="${s.name.toLowerCase()}" data-roll="${(s.roll || '').toLowerCase()}">
                    <td>
                        <span class="gb-roll-pill">${s.roll || '—'}</span>
                    </td>
                    <td>
                        <div class="gb-student-cell">
                            ${avatarImg}
                            <div>
                                <div class="gb-student-name">${escapeHtml(s.name)}</div>
                                <div class="gb-student-meta">{{ __('Roll') }} #${s.roll || 'N/A'}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="gb-score-box">
                            <input type="number"
                                   name="marks[${s.student_class_id}][mark_obtained]"
                                   class="gb-score-input"
                                   value="${scoreVal}"
                                   min="0"
                                   max="${maxScore}"
                                   data-scid="${s.student_class_id}"
                                   placeholder="0"
                                   tabindex="${idx + 1}"
                                   autocomplete="off">
                        </div>
                    </td>
                    <td>
                        <span class="gb-grade-badge ${gradeInfo.cls}" id="grade-badge-${s.student_class_id}">
                            ${gradeInfo.label}
                        </span>
                    </td>
                    <td>
                        <div class="gb-remark-wrap">
                            <input type="text"
                                   name="marks[${s.student_class_id}][comment]"
                                   class="gb-remark-input"
                                   id="remark-${s.student_class_id}"
                                   value="${escapeHtml(remarkVal)}"
                                   placeholder="{{ __('Optional remark…') }}">
                            <div class="gb-tags-wrap">
                                <span class="gb-tag" onclick="applyRemark('${s.student_class_id}', 'Excellent')">Excellent</span>
                                <span class="gb-tag" onclick="applyRemark('${s.student_class_id}', 'Good job')">Good job</span>
                                <span class="gb-tag" onclick="applyRemark('${s.student_class_id}', 'Needs work')">Needs work</span>
                                <span class="gb-tag" onclick="applyRemark('${s.student_class_id}', 'Absent')">Absent</span>
                            </div>
                        </div>
                    </td>
                    <td style="text-align:right;">
                        <span class="gb-sync-status ${isGraded ? 'gb-sync-ready' : 'gb-sync-waiting'}" id="status-pill-${s.student_class_id}">
                            ${isGraded ? '● {{ __("Graded") }}' : '○ {{ __("Pending") }}'}
                        </span>
                    </td>
                </tr>
            `;
        }).join('');

        // Attach live input events
        tbody.querySelectorAll('.gb-score-input').forEach(input => {
            input.addEventListener('input', () => onScoreChange(input));
            input.addEventListener('keydown', onArrowNavigation);
        });

        applyFilterAndSearch();
    }

    window.applyRemark = function (scid, text) {
        const inp = document.getElementById(`remark-${scid}`);
        if (inp) {
            inp.value = text;
            markAsUnsaved();
        }
    };

    /* ─── Live Score Changes & Real-Time Calculation ─────────────────── */
    function onScoreChange(input) {
        const scid    = input.dataset.scid;
        const max     = parseInt(inpMaxMarks.value) || 100;
        let   val     = input.value;

        // Auto clamp max/min
        if (val !== '' && parseFloat(val) > max) { input.value = max; val = max; }
        if (val !== '' && parseFloat(val) < 0)   { input.value = 0;   val = 0;   }

        const gradeInfo = calculateGrade(val, max);
        const gradeBadge = document.getElementById(`grade-badge-${scid}`);
        const statusPill = document.getElementById(`status-pill-${scid}`);
        const tr = input.closest('tr');

        if (gradeBadge) {
            gradeBadge.textContent = gradeInfo.label;
            gradeBadge.className = `gb-grade-badge ${gradeInfo.cls}`;
        }

        if (val !== '') {
            tr.dataset.graded = '1';
            if (statusPill) {
                statusPill.className = 'gb-sync-status gb-sync-ready';
                statusPill.textContent = '● {{ __("Graded") }}';
            }
        } else {
            tr.dataset.graded = '0';
            if (statusPill) {
                statusPill.className = 'gb-sync-status gb-sync-waiting';
                statusPill.textContent = '○ {{ __("Pending") }}';
            }
        }

        markAsUnsaved();
        updateAnalytics();
    }

    function recalculateAllRows() {
        tbody.querySelectorAll('.gb-score-input').forEach(input => onScoreChange(input));
    }

    function onArrowNavigation(e) {
        const inputs = Array.from(tbody.querySelectorAll('.gb-score-input'));
        const idx = inputs.indexOf(e.target);
        if (e.key === 'Enter' || e.key === 'ArrowDown') {
            e.preventDefault();
            if (inputs[idx + 1]) inputs[idx + 1].focus();
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (inputs[idx - 1]) inputs[idx - 1].focus();
        }
    }

    function markAsUnsaved() {
        unsavedChanges = true;
        saveDock.classList.add('show');
        dockChanges.innerHTML = '<span class="text-warning"><i class="fas fa-edit mr-1"></i>{{ __("Unsaved changes") }}</span>';
    }

    /* ─── Real-Time Analytics Calculations ───────────────────────────── */
    function updateAnalytics() {
        const rows   = Array.from(tbody.querySelectorAll('tr[data-student-id]'));
        const total  = rows.length;
        const inputs = Array.from(tbody.querySelectorAll('.gb-score-input'));
        const scores = inputs.map(i => i.value).filter(v => v !== '').map(v => parseFloat(v));
        const graded = scores.length;
        const pending = total - graded;

        document.getElementById('stat-total').textContent   = total;
        document.getElementById('stat-graded').textContent  = graded;
        document.getElementById('stat-pending').textContent = pending;

        document.getElementById('count-all').textContent     = `(${total})`;
        document.getElementById('count-graded').textContent  = `(${graded})`;
        document.getElementById('count-pending').textContent = `(${pending})`;

        // Average score
        const avg = scores.length ? (scores.reduce((a, b) => a + b, 0) / scores.length).toFixed(1) : '—';
        document.getElementById('stat-avg').textContent = avg;
        dockAvgVal.textContent = avg;

        // Highest score
        const high = scores.length ? Math.max(...scores) : '—';
        document.getElementById('stat-high').textContent = high;

        // Passing Rate (>= 40%)
        const maxScore = parseInt(inpMaxMarks.value) || 100;
        const passingCount = scores.filter(s => (s / maxScore) >= 0.4).length;
        const passRate = scores.length ? Math.round((passingCount / scores.length) * 100) + '%' : '—';
        document.getElementById('stat-pass').textContent = passRate;

        // Progress bar
        const pct = total > 0 ? Math.round((graded / total) * 100) : 0;
        document.getElementById('gb-progress-pct').textContent = `${pct}%`;
        document.getElementById('gb-progress-bar').style.width = `${pct}%`;
    }

    /* ─── Search & Tab Filters ───────────────────────────────────────── */
    function applyFilterAndSearch() {
        const rows = tbody.querySelectorAll('tr[data-student-id]');
        rows.forEach(tr => {
            const isGraded = tr.dataset.graded === '1';
            const name = tr.dataset.name || '';
            const roll = tr.dataset.roll || '';

            const matchesFilter =
                activeFilter === 'all' ||
                (activeFilter === 'graded'  &&  isGraded) ||
                (activeFilter === 'pending' && !isGraded);

            const matchesSearch = !searchQuery || name.includes(searchQuery) || roll.includes(searchQuery);

            tr.style.display = (matchesFilter && matchesSearch) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', e => {
        searchQuery = e.target.value.trim().toLowerCase();
        applyFilterAndSearch();
    });

    document.querySelectorAll('.gb-pill').forEach(pill => {
        pill.addEventListener('click', () => {
            document.querySelectorAll('.gb-pill').forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            activeFilter = pill.dataset.filter;
            applyFilterAndSearch();
        });
    });

    /* ─── Quick Fill Drawer ──────────────────────────────────────────── */
    document.getElementById('btn-toggle-qf').addEventListener('click', () => {
        qfDrawer.classList.toggle('active');
    });

    document.getElementById('btn-qf-empty').addEventListener('click', () => {
        const val = document.getElementById('gb-qf-input').value;
        if (val === '') return;
        tbody.querySelectorAll('.gb-score-input').forEach(input => {
            if (input.value === '') { input.value = val; onScoreChange(input); }
        });
    });

    document.getElementById('btn-qf-all').addEventListener('click', () => {
        const val = document.getElementById('gb-qf-input').value;
        if (val === '') return;
        tbody.querySelectorAll('.gb-score-input').forEach(input => {
            input.value = val; onScoreChange(input);
        });
    });

    document.getElementById('btn-qf-clear').addEventListener('click', () => {
        if (!confirm('{{ __("Clear all marks on this sheet?") }}')) return;
        tbody.querySelectorAll('.gb-score-input').forEach(input => {
            input.value = ''; onScoreChange(input);
        });
    });

    /* ─── Keyboard Shortcut: Ctrl + S / Cmd + S to Save ─────────────── */
    document.addEventListener('keydown', function (e) {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 's') {
            e.preventDefault();
            document.getElementById('gb-form').requestSubmit();
        }
    });

    document.getElementById('gb-form').addEventListener('submit', function (e) {
        const inputs = Array.from(tbody.querySelectorAll('.gb-score-input'));
        const filled = inputs.filter(i => i.value !== '').length;
        if (filled === 0) {
            e.preventDefault();
            alert('{{ __("Please enter at least one mark before saving.") }}');
            return;
        }
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{ __("Saving…") }}';
    });

    function escapeHtml(s) {
        return String(s || '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
});
</script>
@endpush

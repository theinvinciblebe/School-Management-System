@extends('layout.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="grade-header-icon mr-3">
                            <i class="fas fa-graduation-cap text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold text-dark-emphasis">{{ __('Exam Grade Management') }}</h3>
                            <p class="text-muted small mb-0">{{ __('Define grading scales, marks ranges, and GPA points') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home mr-1"></i>{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exams_list.index') }}">{{ __('Exam List') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exam_marks.index') }}">{{ __('Manage Marks') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Exam Grades') }}</li>
                    </ol>
                </div>
            </div>

            <!-- Grade Metrics Ribbon -->
            @php
                $totalGrades = count($grades ?? []);
                $highestPoint = 0;
                $lowestPoint = 0;
                if ($totalGrades > 0) {
                    $points = array_map(fn($g) => floatval($g->grade_point ?? 0), is_array($grades) ? $grades : $grades->toArray());
                    $highestPoint = max($points);
                    $lowestPoint = min($points);
                }
            @endphp
            <div class="row mb-3">
                <div class="col-12 col-sm-4">
                    <div class="info-box shadow-sm rounded-lg border-0 grade-stat-box">
                        <span class="info-box-icon bg-gradient-primary elevation-1 rounded-circle"><i class="fas fa-award"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Grading Scales') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0">{{ $totalGrades }} {{ __('Grades') }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box shadow-sm rounded-lg border-0 grade-stat-box">
                        <span class="info-box-icon bg-gradient-success elevation-1 rounded-circle"><i class="fas fa-star"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Highest GPA') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0 text-success">{{ number_format($highestPoint, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box shadow-sm rounded-lg border-0 grade-stat-box">
                        <span class="info-box-icon bg-gradient-info elevation-1 rounded-circle"><i class="fas fa-sliders-h"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Passing Floor GPA') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0 text-info">{{ number_format($lowestPoint, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Table Card -->
    <div class="card shadow-sm border-0 rounded-lg modern-grade-card">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
            <div class="d-flex align-items-center">
                <span class="grade-title-badge mr-2"><i class="fas fa-layer-group"></i></span>
                <h4 class="card-title font-weight-bold mb-0">{{ __('Grading Rubric') }}</h4>
            </div>
            
            @if (Auth::user()->role == 0)
            <div class="card-tools">
                <button type="button" class="btn btn-primary btn-sm rounded-pill font-weight-semibold shadow-sm px-3" data-toggle="modal" data-target="#addGradeModal">
                    <i class="fas fa-plus-circle mr-1"></i>{{ __('Add Grade Scale') }}
                </button>
            </div>
            @endif
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example1" class="table table-hover align-middle mb-0 modern-grade-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th>{{ __('Grade Name') }}</th>
                            <th>{{ __('GPA Point') }}</th>
                            <th>{{ __('Marks Range') }}</th>
                            <th>{{ __('Comment / Remarks') }}</th>
                            <th class="text-center" style="width: 140px;">{{ __('Options') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($grades as $index => $grade)
                            @php
                                $point = floatval($grade->grade_point ?? 0);
                                $badgeClass = match(true) {
                                    $point >= 3.5 => 'badge-emerald',
                                    $point >= 3.0 => 'badge-blue',
                                    $point >= 2.0 => 'badge-amber',
                                    default => 'badge-rose'
                                };
                            @endphp
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="grade-pill-badge {{ $badgeClass }} mr-2">
                                            {{ $grade->name }}
                                        </span>
                                        <span class="font-weight-bold text-dark-emphasis">{{ __('Grade') }} {{ $grade->name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-light border px-3 py-1 font-weight-bold text-md shadow-xs">
                                        {{ number_format($point, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="font-weight-semibold text-primary mr-1">{{ $grade->mark_from }}%</span>
                                        <span class="text-muted mx-1">&rarr;</span>
                                        <span class="font-weight-semibold text-success">{{ $grade->mark_upto }}%</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ !empty($grade->comment) ? $grade->comment : __('Standard grade bracket') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if (Auth::user()->role == 0)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 dropdown-toggle shadow-xs" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog text-muted mr-1"></i>{{ __('Action') }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 rounded-lg p-2 modern-dropdown-menu">
                                            <button type="button" class="dropdown-item rounded py-2 text-primary" data-toggle="modal" data-target="#editGradeModal{{ $grade->grade_id }}">
                                                <i class="fas fa-edit mr-2"></i>{{ __('Edit Grade') }}
                                            </button>
                                            <div class="dropdown-divider my-1"></div>
                                            <form action="{{ route('exams_grade.destroy', $grade->grade_id) }}" method="POST" onsubmit="showOverlay();" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item rounded py-2 text-danger" onclick="return confirm('{{ __('Are you sure you want to delete this grade scale?') }}');">
                                                    <i class="fas fa-trash-alt mr-2"></i>{{ __('Delete Grade') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                        <span class="text-muted small">{{ __('Read Only') }}</span>
                                    @endif
                                </td>
                            </tr>

                            <!-- Edit Grade Modal -->
                            <div class="modal fade" id="editGradeModal{{ $grade->grade_id }}" tabindex="-1" aria-labelledby="editGradeModalLabel{{ $grade->grade_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-xl">
                                        <form action="{{ route('exams_grade.update', $grade->grade_id) }}" method="POST" onsubmit="showOverlay();">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-bottom py-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="grade-modal-badge bg-primary mr-2"><i class="fas fa-edit text-white"></i></span>
                                                    <h5 class="modal-title font-weight-bold mb-0" id="editGradeModalLabel{{ $grade->grade_id }}">{{ __('Edit Grade Bracket') }}</h5>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Grade Name') }} <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control rounded-lg" value="{{ $grade->name }}" placeholder="{{ __('e.g. A+') }}" required>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-semibold text-muted small text-uppercase">{{ __('GPA Point') }} <span class="text-danger">*</span></label>
                                                        <input type="number" step="0.01" name="grade_point" class="form-control rounded-lg" value="{{ $grade->grade_point }}" placeholder="{{ __('e.g. 4.00') }}" required>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Mark From (%)') }} <span class="text-danger">*</span></label>
                                                        <input type="number" name="mark_from" class="form-control rounded-lg" value="{{ $grade->mark_from }}" required>
                                                    </div>
                                                    <div class="col-md-6 form-group mb-3">
                                                        <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Mark Upto (%)') }} <span class="text-danger">*</span></label>
                                                        <input type="number" name="mark_upto" class="form-control rounded-lg" value="{{ $grade->mark_upto }}" required>
                                                    </div>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Performance Comment') }}</label>
                                                    <textarea class="form-control rounded-lg" rows="2" name="comment" placeholder="{{ __('e.g. Excellent / Outstanding Performance') }}">{{ $grade->comment }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top py-2 bg-light rounded-bottom">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-semibold">
                                                    <i class="fas fa-save mr-1"></i>{{ __('Update Grade') }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <i class="fas fa-award fa-3x text-muted mb-3 opacity-50"></i>
                                        <h5 class="font-weight-bold">{{ __('No Grading Scales Configured') }}</h5>
                                        <p class="text-muted small mb-3">{{ __('Add your school grading rubrics to compute GPAs automatically.') }}</p>
                                        @if (Auth::user()->role == 0)
                                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#addGradeModal">
                                            <i class="fas fa-plus-circle mr-1"></i>{{ __('Add Grade') }}
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Grade Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-xl">
                <form action="{{ route('exams_grade.store') }}" method="POST" onsubmit="showOverlay();">
                    @csrf
                    <div class="modal-header border-bottom py-3">
                        <div class="d-flex align-items-center">
                            <span class="grade-modal-badge bg-primary mr-2"><i class="fas fa-plus text-white"></i></span>
                            <h5 class="modal-title font-weight-bold mb-0" id="addGradeModalLabel">{{ __('New Grading Rule') }}</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Grade Name') }} <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control rounded-lg" placeholder="{{ __('e.g. A') }}" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Grade Point') }} <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="grade_point" class="form-control rounded-lg" placeholder="{{ __('e.g. 4.00') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Mark From (%)') }} <span class="text-danger">*</span></label>
                                <input type="number" name="mark_from" class="form-control rounded-lg" placeholder="{{ __('e.g. 80') }}" required>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Mark Upto (%)') }} <span class="text-danger">*</span></label>
                                <input type="number" name="mark_upto" class="form-control rounded-lg" placeholder="{{ __('e.g. 100') }}" required>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Performance Comment') }}</label>
                            <textarea class="form-control rounded-lg" rows="2" name="comment" placeholder="{{ __('e.g. Very Good / Pass') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2 bg-light rounded-bottom">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-semibold">
                            <i class="fas fa-check-circle mr-1"></i>{{ __('Save Grade Rule') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .grade-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(99, 102, 241, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .grade-stat-box {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .grade-stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
    }
    .grade-title-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: rgba(99, 102, 241, 0.12);
        color: #4f46e5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
    }
    .grade-pill-badge {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.95rem;
        flex-shrink: 0;
    }
    .badge-emerald {
        background: rgba(16, 185, 129, 0.15);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
    }
    .badge-blue {
        background: rgba(59, 130, 246, 0.15);
        color: #2563eb;
        border: 1px solid rgba(59, 130, 246, 0.3);
    }
    .badge-amber {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
    }
    .badge-rose {
        background: rgba(239, 68, 68, 0.15);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
    }
    .grade-modal-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .modern-grade-table thead th {
        border-top: none;
        border-bottom: 2px solid rgba(0,0,0,0.06);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        color: #64748b;
        padding: 0.85rem 1rem;
    }
    .modern-grade-table tbody td {
        padding: 0.95rem 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        vertical-align: middle;
    }
    .rounded-xl {
        border-radius: 16px !important;
    }

    /* Dark Mode Compatibility */
    html.dark-mode .modern-grade-card {
        background-color: #2b2b2b !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .modern-grade-table thead th {
        border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        color: #94a3b8 !important;
        background: rgba(255, 255, 255, 0.02);
    }
    html.dark-mode .modern-grade-table tbody td {
        border-bottom-color: rgba(255, 255, 255, 0.04) !important;
        color: #f1f5f9 !important;
    }
    html.dark-mode .modal-content {
        background-color: #2b2b2b !important;
        border: 1px solid rgba(255, 255, 255, 0.12) !important;
    }
    html.dark-mode .modal-footer.bg-light {
        background-color: #222222 !important;
        border-top-color: rgba(255, 255, 255, 0.08) !important;
    }
</style>
@endpush

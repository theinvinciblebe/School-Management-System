@extends('layout.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row align-items-center mb-3">
                <div class="col-sm-6">
                    <div class="d-flex align-items-center">
                        <div class="exam-header-icon mr-3">
                            <i class="fas fa-file-signature text-primary"></i>
                        </div>
                        <div>
                            <h3 class="mb-0 font-weight-bold text-dark-emphasis">{{ __('Exam Management') }}</h3>
                            <p class="text-muted small mb-0">{{ __('Schedule, manage, and review school examination sessions') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right bg-transparent p-0 mb-0">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home mr-1"></i>{{ __('Home') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exams_grade.index') }}">{{ __('Exam Grades') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('exam_marks.index') }}">{{ __('Manage Marks') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('Exam List') }}</li>
                    </ol>
                </div>
            </div>

            <!-- Stats Ribbon -->
            @php
                $totalExams = count($exams ?? []);
                $todayDate = date('Y-m-d');
                $upcomingExams = 0;
                $pastExams = 0;
                foreach ($exams ?? [] as $ex) {
                    if (!empty($ex->date) && $ex->date >= $todayDate) {
                        $upcomingExams++;
                    } else {
                        $pastExams++;
                    }
                }
            @endphp
            <div class="row mb-3">
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box shadow-sm rounded-lg border-0 exam-stat-box">
                        <span class="info-box-icon bg-gradient-primary elevation-1 rounded-circle"><i class="fas fa-scroll"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Total Exams') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0">{{ $totalExams }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box shadow-sm rounded-lg border-0 exam-stat-box">
                        <span class="info-box-icon bg-gradient-success elevation-1 rounded-circle"><i class="fas fa-calendar-check"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Upcoming / Active') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0 text-success">{{ $upcomingExams }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="info-box shadow-sm rounded-lg border-0 exam-stat-box">
                        <span class="info-box-icon bg-gradient-secondary elevation-1 rounded-circle"><i class="fas fa-history"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-muted font-weight-medium">{{ __('Completed Sessions') }}</span>
                            <span class="info-box-number font-weight-bold text-lg mb-0 text-secondary">{{ $pastExams }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Card -->
    <div class="card shadow-sm border-0 rounded-lg modern-exam-card">
        <div class="card-header bg-transparent border-bottom d-flex align-items-center justify-content-between py-3">
            <div class="d-flex align-items-center">
                <span class="exam-title-badge mr-2"><i class="fas fa-list-alt"></i></span>
                <h4 class="card-title font-weight-bold mb-0">{{ __('Registered Exams') }}</h4>
            </div>
            
            @if (Auth::user()->role == 0 || Auth::user()->role == 1)
            <div class="card-tools d-flex align-items-center">
                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill mr-2 font-weight-semibold shadow-sm" data-toggle="modal" data-target="#addExamModal">
                    <i class="fas fa-plus-circle mr-1"></i>{{ __('Quick Add') }}
                </button>
                <a href="{{ route('exams.create') }}" class="btn btn-primary btn-sm rounded-pill font-weight-semibold shadow-sm">
                    <i class="fas fa-calendar-plus mr-1"></i>{{ __('Create Full Exam') }}
                </a>
            </div>
            @endif
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example1" class="table table-hover align-middle mb-0 modern-exam-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">#</th>
                            <th>{{ __('Exam Name') }}</th>
                            <th>{{ __('Date & Timeline') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Notes / Comment') }}</th>
                            <th class="text-center" style="width: 140px;">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exams as $index => $exam)
                            @php
                                $examDate = !empty($exam->date) ? date('Y-m-d', strtotime($exam->date)) : null;
                                $isToday = ($examDate === $todayDate);
                                $isUpcoming = ($examDate && $examDate > $todayDate);
                                $isPast = ($examDate && $examDate < $todayDate);
                            @endphp
                            <tr>
                                <td class="text-center font-weight-bold text-muted">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="exam-avatar-mini mr-2">
                                            <i class="fas fa-scroll text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark-emphasis">{{ $exam->name }}</div>
                                            <small class="text-muted">ID: #EX-{{ $exam->exam_id }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center text-nowrap">
                                        <i class="far fa-calendar-alt text-muted mr-2"></i>
                                        <span class="font-weight-medium">{{ !empty($exam->date) ? date('M d, Y', strtotime($exam->date)) : __('Unset') }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($isToday)
                                        <span class="badge badge-pill badge-primary px-3 py-1 font-weight-semibold shadow-xs">
                                            <i class="fas fa-hourglass-half mr-1"></i>{{ __('Today') }}
                                        </span>
                                    @elseif($isUpcoming)
                                        <span class="badge badge-pill badge-success px-3 py-1 font-weight-semibold shadow-xs">
                                            <i class="fas fa-clock mr-1"></i>{{ __('Upcoming') }}
                                        </span>
                                    @else
                                        <span class="badge badge-pill badge-secondary px-3 py-1 font-weight-semibold shadow-xs">
                                            <i class="fas fa-check-circle mr-1"></i>{{ __('Completed') }}
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted small">
                                        {{ !empty($exam->comment) ? Str::limit($exam->comment, 60) : __('No additional notes') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if (Auth::user()->role == 0)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-light border rounded-pill px-3 dropdown-toggle shadow-xs" data-toggle="dropdown" aria-expanded="false">
                                            <i class="fas fa-cog text-muted mr-1"></i>{{ __('Options') }}
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 rounded-lg p-2 modern-dropdown-menu">
                                            <button type="button" class="dropdown-item rounded py-2 text-primary" data-toggle="modal" data-target="#editExamModal{{ $exam->exam_id }}">
                                                <i class="fas fa-edit mr-2"></i>{{ __('Edit Exam') }}
                                            </button>
                                            <a href="{{ route('exam.questions', $exam->exam_id) }}" class="dropdown-item rounded py-2 text-info">
                                                <i class="fas fa-question-circle mr-2"></i>{{ __('View Questions') }}
                                            </a>
                                            <div class="dropdown-divider my-1"></div>
                                            <form action="{{ route('exams_list.destroy', $exam->exam_id) }}" method="POST" onsubmit="showOverlay();" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item rounded py-2 text-danger" onclick="return confirm('{{ __('Are you sure you want to delete this examination session?') }}');">
                                                    <i class="fas fa-trash-alt mr-2"></i>{{ __('Delete Exam') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                        <a href="{{ route('exam.questions', $exam->exam_id) }}" class="btn btn-sm btn-outline-info rounded-pill px-3">
                                            <i class="fas fa-eye mr-1"></i>{{ __('View') }}
                                        </a>
                                    @endif
                                </td>
                            </tr>

                            <!-- Edit Modal for this Exam -->
                            <div class="modal fade" id="editExamModal{{ $exam->exam_id }}" tabindex="-1" aria-labelledby="editExamModalLabel{{ $exam->exam_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0 rounded-xl">
                                        <form action="{{ route('exams_list.update', $exam->exam_id) }}" method="POST" onsubmit="showOverlay();">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header border-bottom py-3">
                                                <div class="d-flex align-items-center">
                                                    <span class="exam-modal-badge bg-primary mr-2"><i class="fas fa-edit text-white"></i></span>
                                                    <h5 class="modal-title font-weight-bold mb-0" id="editExamModalLabel{{ $exam->exam_id }}">{{ __('Edit Examination') }}</h5>
                                                </div>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="form-group mb-3">
                                                    <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Exam Title') }} <span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control rounded-lg" value="{{ $exam->name }}" placeholder="{{ __('e.g. Midterm Examination 2026') }}" required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Scheduled Date') }} <span class="text-danger">*</span></label>
                                                    <input type="date" name="date" class="form-control rounded-lg" value="{{ $exam->date }}" required>
                                                </div>

                                                <div class="form-group mb-0">
                                                    <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Notes / Instructions') }}</label>
                                                    <textarea class="form-control rounded-lg" rows="3" name="comment" placeholder="{{ __('Optional instructions or remarks...') }}">{{ $exam->comment }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer border-top py-2 bg-light rounded-bottom">
                                                <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                                                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-semibold">
                                                    <i class="fas fa-save mr-1"></i>{{ __('Save Changes') }}
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
                                        <i class="fas fa-folder-open fa-3x text-muted mb-3 opacity-50"></i>
                                        <h5 class="font-weight-bold">{{ __('No Exams Found') }}</h5>
                                        <p class="text-muted small mb-3">{{ __('Get started by adding your first examination session.') }}</p>
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 1)
                                        <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-toggle="modal" data-target="#addExamModal">
                                            <i class="fas fa-plus-circle mr-1"></i>{{ __('Add Exam') }}
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

    <!-- Quick Add Exam Modal -->
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0 rounded-xl">
                <form action="{{ route('exams_list.store') }}" method="POST" onsubmit="showOverlay();">
                    @csrf
                    <div class="modal-header border-bottom py-3">
                        <div class="d-flex align-items-center">
                            <span class="exam-modal-badge bg-success mr-2"><i class="fas fa-plus text-white"></i></span>
                            <h5 class="modal-title font-weight-bold mb-0" id="addExamModalLabel">{{ __('Add New Exam') }}</h5>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="form-group mb-3">
                            <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Exam Title') }} <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-lg" placeholder="{{ __('e.g. Final Semester Examination') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Scheduled Date') }} <span class="text-danger">*</span></label>
                            <input type="date" name="date" class="form-control rounded-lg" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="font-weight-semibold text-muted small text-uppercase">{{ __('Notes / Instructions') }}</label>
                            <textarea class="form-control rounded-lg" rows="3" name="comment" placeholder="{{ __('Optional instructions or guidelines...') }}"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2 bg-light rounded-bottom">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-success rounded-pill px-4 shadow-sm font-weight-semibold">
                            <i class="fas fa-check-circle mr-1"></i>{{ __('Create Exam') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
<style>
    .exam-header-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: rgba(99, 102, 241, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
    }
    .exam-stat-box {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .exam-stat-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.08) !important;
    }
    .exam-title-badge {
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
    .exam-avatar-mini {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: rgba(99, 102, 241, 0.08);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .exam-modal-badge {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.9rem;
    }
    .modern-exam-table thead th {
        border-top: none;
        border-bottom: 2px solid rgba(0,0,0,0.06);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.04em;
        font-weight: 700;
        color: #64748b;
        padding: 0.85rem 1rem;
    }
    .modern-exam-table tbody td {
        padding: 0.95rem 1rem;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        vertical-align: middle;
    }
    .rounded-xl {
        border-radius: 16px !important;
    }

    /* Dark Mode Compatibility */
    html.dark-mode .modern-exam-card {
        background-color: #2b2b2b !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    html.dark-mode .modern-exam-table thead th {
        border-bottom-color: rgba(255, 255, 255, 0.08) !important;
        color: #94a3b8 !important;
        background: rgba(255, 255, 255, 0.02);
    }
    html.dark-mode .modern-exam-table tbody td {
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

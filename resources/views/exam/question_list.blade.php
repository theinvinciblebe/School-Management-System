@extends('layout.main')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('exams_list.index') }}" class="btn btn-outline-secondary btn-sm rounded-pill mr-2 shadow-sm" title="{{ __('Back to Exam List') }}">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h1 class="m-0 text-bold" style="font-size: 1.55rem; letter-spacing: -0.02em;">
                            {{ __('Exam Questions') }}
                        </h1>
                        <p class="text-muted mb-0" style="font-size: 0.85rem;">
                            {{ __('Reviewing questions for:') }} <span class="font-weight-bold text-primary">{{ $exam->name ?? __('Exam') }}</span>
                            @if(!empty($exam->date))
                                <span class="badge badge-light ml-2 border"><i class="far fa-calendar-alt mr-1"></i>{{ $exam->date }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right mb-0" style="font-size: 0.84rem;">
                    <li class="breadcrumb-item"><a href="/dashboard">{{ __('Home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('exams_list.index') }}">{{ __('Exams') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Questions') }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <!-- Hero Header Summary Card -->
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; background: linear-gradient(135deg, #1e1b4b 0%, #312e81 50%, #4338ca 100%); color: #ffffff;">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge badge-pill badge-primary mr-2 px-3 py-1" style="font-size: 0.75rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(4px);">
                                <i class="fas fa-file-alt mr-1"></i>{{ __('Question Roster') }}
                            </span>
                            <span class="badge badge-pill badge-light text-dark font-weight-bold px-3 py-1" style="font-size: 0.75rem;">
                                {{ count($questions) }} {{ count($questions) === 1 ? __('Question') : __('Questions') }}
                            </span>
                        </div>
                        <h2 class="text-white font-weight-bold mb-1" style="font-size: 1.6rem; letter-spacing: -0.015em;">
                            {{ $exam->name }}
                        </h2>
                        @if(!empty($exam->comment))
                            <p class="mb-0 text-white-50" style="font-size: 0.9rem;">
                                <i class="fas fa-info-circle mr-1"></i>{{ $exam->comment }}
                            </p>
                        @endif
                    </div>
                    <div class="col-md-4 text-md-right mt-3 mt-md-0">
                        <a href="{{ route('exams_list.index') }}" class="btn btn-light rounded-pill px-4 font-weight-bold shadow-sm">
                            <i class="fas fa-arrow-left mr-1"></i> {{ __('Back to Exams') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert" style="border-radius: 12px;">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert" style="border-radius: 12px;">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <!-- Question Cards Grid -->
        <div class="row">
            @forelse ($questions as $index => $question)
                @php
                    $qType = strtolower($question->question_type ?? 'multiple_choice');
                    $typeBadge = match($qType) {
                        'multiple_choice' => ['label' => __('Multiple Choice'), 'class' => 'badge-info', 'icon' => 'fa-list-ul'],
                        'short_answer' => ['label' => __('Short Answer'), 'class' => 'badge-warning text-dark', 'icon' => 'fa-pencil-alt'],
                        'file_upload' => ['label' => __('File Upload'), 'class' => 'badge-success', 'icon' => 'fa-cloud-upload-alt'],
                        default => ['label' => ucfirst($qType), 'class' => 'badge-secondary', 'icon' => 'fa-question'],
                    };

                    $options = [];
                    if (!empty($question->options)) {
                        $decoded = json_decode($question->options, true);
                        if (is_array($decoded)) {
                            $options = $decoded;
                        }
                    }
                @endphp
                <div class="col-12 mb-3">
                    <div class="card shadow-sm border-0 h-100 question-card" style="border-radius: 14px; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start justify-content-between mb-2">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="q-number-pill mr-2 font-weight-bold d-inline-flex align-items-center justify-content-center" 
                                         style="width: 32px; height: 32px; border-radius: 10px; background: rgba(99, 102, 241, 0.15); color: #4f46e5; font-size: 0.95rem;">
                                        {{ $index + 1 }}
                                    </div>
                                    <span class="badge {{ $typeBadge['class'] }} px-2 py-1 rounded-pill" style="font-size: 0.72rem; font-weight: 600;">
                                        <i class="fas {{ $typeBadge['icon'] }} mr-1"></i>{{ $typeBadge['label'] }}
                                    </span>
                                </div>
                                <span class="text-muted" style="font-size: 0.78rem;">
                                    <i class="far fa-clock mr-1"></i>{{ __('Q#') }}{{ $index + 1 }}
                                </span>
                            </div>

                            <div class="q-text-content mt-2 mb-3 font-weight-bold" style="font-size: 1.05rem; line-height: 1.5; color: inherit;">
                                {{ $question->question_text }}
                            </div>

                            @if($qType === 'multiple_choice' && !empty($options))
                                <div class="q-options-wrap p-3 rounded" style="background: rgba(0, 0, 0, 0.03); border: 1px solid rgba(0, 0, 0, 0.06);">
                                    <div class="text-uppercase text-muted font-weight-bold mb-2" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                                        <i class="fas fa-check-square mr-1"></i>{{ __('Options') }}
                                    </div>
                                    <div class="row">
                                        @foreach($options as $optIndex => $optVal)
                                            <div class="col-md-6 mb-2">
                                                <div class="d-flex align-items-center p-2 rounded bg-white shadow-xs border" style="border-radius: 8px !important;">
                                                    <span class="badge badge-light border font-weight-bold mr-2 px-2" style="font-size: 0.75rem;">
                                                        {{ chr(65 + $optIndex) }}
                                                    </span>
                                                    <span style="font-size: 0.88rem;">{{ $optVal }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($qType === 'short_answer')
                                <div class="p-3 rounded text-muted font-italic" style="background: rgba(0, 0, 0, 0.02); border: 1px dashed rgba(0, 0, 0, 0.1); font-size: 0.85rem;">
                                    <i class="fas fa-align-left mr-1"></i>{{ __('Students submit an open-ended text response.') }}
                                </div>
                            @elseif($qType === 'file_upload')
                                <div class="p-3 rounded text-muted font-italic" style="background: rgba(0, 0, 0, 0.02); border: 1px dashed rgba(0, 0, 0, 0.1); font-size: 0.85rem;">
                                    <i class="fas fa-paperclip mr-1"></i>{{ __('Students submit an attachment or document.') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-sm border-0 text-center py-5" style="border-radius: 16px;">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="d-inline-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 50%; background: rgba(99, 102, 241, 0.1); color: #6366f1; font-size: 2rem;">
                                    <i class="fas fa-question"></i>
                                </span>
                            </div>
                            <h4 class="font-weight-bold mb-1">{{ __('No Questions Added Yet') }}</h4>
                            <p class="text-muted mb-4" style="max-width: 420px; margin: 0 auto; font-size: 0.9rem;">
                                {{ __('This exam does not have any questions registered in the system roster.') }}
                            </p>
                            <a href="{{ route('exams_list.index') }}" class="btn btn-primary rounded-pill px-4 shadow-sm font-weight-bold">
                                <i class="fas fa-arrow-left mr-1"></i> {{ __('Return to Exam List') }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

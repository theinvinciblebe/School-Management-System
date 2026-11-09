@extends('layout.main')
@section('content')
    <div class="card col-md-6 mx-auto my-3">
        <div class="card-header text-center">
            <h3>{{ __('Add Student to Class:') }} {{ $class->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('students.add_to_class') }}" method="POST">
                @csrf
                <input type="hidden" name="class_id" value="{{ $class_id }}">
                <div class="form-group">
                    <label>{{ __('Select Student') }}</label>
                    <select name="student_id" class="form-control select2bs4" required>
                        <option value="">{{ __('Select Student') }}</option>
                        @foreach($allStudents as $student)
                            <option value="{{ $student->student_id }}">{{ $student->name }} ({{ $student->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('Select Section') }}</label>
                    <select name="section_id" class="form-control select2bs4" required>
                        <option value="">{{ __('Select Section') }}</option>
                        @foreach($sections as $section)
                            <option value="{{ $section->section_id }}">{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>{{ __('Roll Number') }}</label>
                    <input type="text" name="roll" class="form-control" placeholder="{{ __('Enter Roll Number') }}" required>
                </div>

                <button type="submit" class="btn btn-success">{{ __('Add Student') }}</button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


            </form>
        </div>
    </div>
@endsection

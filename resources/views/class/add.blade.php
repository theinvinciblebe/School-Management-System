@extends('layout.main')
@section('content')

    <style>
        .scrollable-card {
            max-height: 500px; /* You can set any height */
            overflow-y: auto;  /* Adds vertical scrolling when content exceeds height */
        }
    </style>

    <div class="container">
        <div class="card col-md-8 mx-auto my-3">
            <div class="card card-info">
                <div class="card-header text-center">
                    <div class="card-title">
                        <h3>
                            Add New Class
                        </h3>
                    </div>
                </div>
            </div>
            <div class="card-body scrollable-card">
                <form action="{{ route('class.store') }}" method="POST" onsubmit="showOverlay();">
                    @csrf
                    <!-- Class Name -->
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>
                            </div>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Class Name" required>
                        </div>
                    </div>
                    <!-- Class Code -->
                    <div class="form-group">
                        <label for="class_code">Class Code</label>
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                            </div>
                            <input type="text" name="class_code" id="class_code" class="form-control" placeholder="Enter Class Code" required>
                        </div>
                    </div>
                    <!-- Class Room -->
                    <div class="form-group">
                        <label for="class_room">Class Room</label>
                        <div class="input-group mb-3 ">
                            <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-university"></i>
                                    </span>
                            </div>
                            <input type="text" name="class_room" id="class_room" class="form-control" placeholder="Enter Class Room">
                        </div>
                    </div>
                    <!-- Teacher -->
                    <div class="form-group">
                        <label for="teacher_id">Teacher</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-users"></i>
                                </span>
                            </div>
                            <select class="form-control select2bs4" id="teacher_id" name="teacher_id">
                                <option value="">Select Teacher</option>
                                @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!-- Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="submit" class="btn btn-success add-btn">Add Class</button>
                        <a href="{{ route('class.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

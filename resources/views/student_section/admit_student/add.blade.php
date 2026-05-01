@extends('layout.main')
@section('content')
{{--    <style>--}}
{{--        .scrollable-card {--}}
{{--            max-height: 500px; /* You can set any height */--}}
{{--            overflow-y: auto;  /* Adds vertical scrolling when content exceeds height */--}}
{{--        }--}}
{{--    </style>--}}
    <div class="row">
        <div class="card col-md-8 mx-auto my-3">
            <div class="card card-info">
                <div class="card-header text-center">
                    <h3 class="card-title">Admit New Student</h3>
                </div>
                <div class="card-body scrollable-card">
                    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Name</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="Student Name" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="birthday">Date Of Birth</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar"></i>
                                    </span>
                                    </div>
                                    <input type="date" name="birthday" class="form-control" placeholder="Birthday" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="sex">Sex</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-venus-mars"></i>
                                    </span>
                                    </div>
                                    <select name="sex" class="form-control" required>
                                        <option value="1">Male</option>
                                        <option value="0">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-location-arrow"></i>
                                </span>
                                    </div>
                                    <input type="text" name="address" class="form-control" placeholder="123 Main st" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Telephone</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" placeholder="0123-456-789" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="address">Email</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                    </div>
                                    <input type="text" name="email" class="form-control" placeholder="example@gmail.com" required>
                                </div>
                            </div>
                        </div>


                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="class_id">Class</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-university"></i>
                                        </span>
                                    </div>
                                    <select name="class_id" id="class_id" class="form-control" required>
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                            <option value="{{ $class->class_id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="section_id">Section</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-puzzle-piece"></i>
                                </span>
                                    </div>
                                    <select name="section_id" id="section_id" class="form-control" required>
                                        <option value="">Select Class First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="parent_name">Parent Name</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                    </div>
                                    <input type="text" name="parent_name" class="form-control" placeholder="Enter Parent Name">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="parent_phone">Parent Telephone</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                    </div>
                                    <input type="text" name="parent_phone" class="form-control" placeholder="Enter Parent Telephone">
                                </div>
                            </div>
                            <input type="hidden" name="roll" value="{{ old('roll', $student->roll ?? '') }}">

                            {{--                            <div class="form-group col-md-6">--}}
{{--                                <label for="roll">Roll</label>--}}
{{--                                <div class="input-group mb-3">--}}
{{--                                    <div class="input-group-prepend">--}}
{{--                                <span class="input-group-text">--}}
{{--                                    <i class="fas fa-id-badge"></i>--}}
{{--                                </span>--}}
{{--                                    </div>--}}
{{--                                    <input type="number" name="roll" class="form-control" required>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="file" accept="image/*" class="custom-file-input" id="exampleInputFile" onchange="previewFile()">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                            <!-- Preview Image -->
                            <img id="previewImage" src="#" alt="Image Preview" style="max-width: 150px; display: none; margin-top: 10px;">
                        </div>


                        <p class="text-muted">
                            Note: The default password for the newly created user will be <strong>123456</strong>.
                            The user can change it later from their account settings.
                        </p>


                        <button type="submit" class="btn btn-success">Admit Student</button>
                        <a href="{{ url()->previous() }}" class="btn btn-secondary float-right">Back</a>
                    </form>
                </div>
            </div>
        </div>

    </div>


    <!-- AJAX to load sections based on selected class -->
    <script>
        document.getElementById('class_id').addEventListener('change', function () {
            const classId = this.value;
            const sectionSelect = document.getElementById('section_id');
            sectionSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`/get-sections-by-class/${classId}`)
                .then(response => response.json())
                .then(data => {
                    sectionSelect.innerHTML = '<option value="">Select Section</option>';
                    data.sections.forEach(section => {
                        sectionSelect.innerHTML += `<option value="${section.section_id}">${section.name}</option>`;
                    });
                });
        });
    </script>
@endsection

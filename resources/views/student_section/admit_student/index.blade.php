@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Student Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('sessions.index') }}">Academic Session</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Admit Student List
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">

                <h3><i class="fas fa-user-graduate"></i> Admit Student</h3>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0 || Auth::user()->role == 3 || Auth::user()->role == 4) <!-- Admin Only -->
            <a href="{{ route('students.create') }}" class="btn btn-primary mb-3 float-right">
                <i class="fa fa-plus"></i> Add New Student
            </a>

            <a href="{{ route('students.create') }}" class="Floating-button">
                <i class="fa fa-plus"></i>
            </a>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th >#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="descending">Student Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Parent Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Parent Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Class</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Section</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Roll</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Birthday</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Gender</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Address</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Photo</th>
                                <th tabindex="0" aria-controls="example1" width="50px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $index => $student)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                    <td class="sorting_1">{{ $student->student_name}}</td>
                                    <td class="sorting_1">{{ $student->parent_name ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $student->parent_phone ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $student->class_name ?? 'N/A' }}</td>
                                    <td class="sorting_1">{{ $student->section_name ?? 'N/A' }}</td>
                                    <td class="sorting_1">{{ $student->roll ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $student->birthday ?? 'N/A'}}</td>
                                    <td class="sorting_1">
                                        @if($student->sex)
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                    <td class="sorting_1">{{ $student->address ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $student->phone ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $student->email ?? 'N/A'}}</td>
                                    <td>
                                        <img src="{{ asset('students_image/' . ($student->photo ?? 'noimg.jpg')) }}"
                                             alt="Student Photo"
                                             width="50" height="50"
                                             class="rounded-circle">

                                    </td>

                                    <td>
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 3 || Auth::user()->role == 4) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal"
                                                        data-target="#editStudentModal{{ $student->student_id }}"
                                                        data-student-class-id="{{ $student->class_id }}"
                                                        data-student-section-id="{{ $student->section_id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('students.destroy', $student->student_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                            <span class="text-muted">No Actions Available</span>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editStudentModal{{ $student->student_id }}" tabindex="-1" role="dialog" aria-labelledby="editStudentModalLabel{{ $student->student_id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form action="{{ route('students.update', $student->student_id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editStudentModalLabel{{ $student->student_id }}">Edit Student</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $student->student_name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Date of Birth</label>
                                                        <input type="date" name="birthday" class="form-control" value="{{ $student->birthday }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sex</label>
                                                        <select name="sex" class="form-control" required>
                                                            <option value="1" {{ $student->sex == 1 ? 'selected' : '' }}>Male</option>
                                                            <option value="0" {{ $student->sex == 0 ? 'selected' : '' }}>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" name="address" class="form-control" value="{{ $student->address }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $student->phone }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $student->email ?? 'No Email'}}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Class</label>
                                                        <select name="class_id" class="form-control class-select" id="class-select-{{ $student->student_id }}" data-student-id="{{ $student->student_id }}" required>
                                                            <option value="">Select Class</option>
                                                            @foreach($classes as $class)
                                                                <option value="{{ $class->class_id }}" {{ $student->class_id == $class->class_id ? 'selected' : '' }}>{{ $class->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Section</label>
                                                        <select name="section_id" class="form-control edit-section-select" id="section-select-{{ $student->student_id }}" required>
                                                            <option value="">Select Section</option>
                                                            @foreach($sections as $section)
                                                                @if($section->class_id == $student->class_id)
                                                                    <option value="{{ $section->section_id }}" {{ $student->section_id == $section->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
                                                                @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Parent</label>
                                                        <select name="parent_id" class="form-control">
                                                            <option value="">Select Parent</option>
                                                            @foreach($parents as $parent)
                                                                <option value="{{ $parent->parent_id }}" {{ $student->parent_id == $parent->parent_id ? 'selected' : '' }}>{{ $parent->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Current Photo:</label><br>
                                                        <img id="photoPreview-{{ $student->student_id }}"
                                                             src="{{ asset('students_image/' . ($student->photo ?? 'noimg.jpg')) }}"
                                                             alt="Student Photo"
                                                             width="100" height="100"
                                                             class="rounded-circle photoPreview"
                                                             data-student-id="{{ $student->student_id }}">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="file">Upload New Photo:</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="file" accept="image/*"
                                                                       class="custom-file-input fileInput"
                                                                       data-student-id="{{ $student->student_id }}">
                                                                <label class="custom-file-label" for="fileInput">Choose file</label>
                                                            </div>
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">Upload</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection

<!-- Consolidated Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.class-select').forEach(function (classSelect) {
            classSelect.addEventListener('change', function () {
                const classId = this.value; // Get the selected class ID
                const studentId = this.getAttribute('data-student-id'); // Get the student ID from data attribute
                const sectionSelect = document.getElementById(`section-select-${studentId}`); // Target the correct section dropdown

                sectionSelect.innerHTML = '<option value="">Loading...</option>'; // Show loading message

                // If no class is selected, show default message
                if (!classId) {
                    sectionSelect.innerHTML = '<option value="">Select Class First</option>';
                    return;
                }

                // Fetch the sections for the selected class
                fetch(`/get-sections-by-class/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        sectionSelect.innerHTML = '<option value="">Select Section</option>';
                        data.sections.forEach(section => {
                            sectionSelect.innerHTML += `<option value="${section.section_id}">${section.name}</option>`;
                        });
                    })
                    .catch(error => {
                        sectionSelect.innerHTML = '<option value="">Error loading sections</option>';
                        console.error('Error:', error);
                    });
            });
        });

        // When the modal is shown, ensure the correct sections are pre-selected
        document.querySelectorAll('.modal').forEach(function (modal) {
            modal.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const classId = button.getAttribute('data-student-class-id'); // Get the class ID
                const sectionId = button.getAttribute('data-student-section-id'); // Get the pre-selected section ID
                const modalBody = this.querySelector('.modal-body');
                const sectionSelect = modalBody.querySelector('.edit-section-select');

                // Load the sections for the selected class
                fetch(`/get-sections-by-class/${classId}`)
                    .then(response => response.json())
                    .then(data => {
                        let sectionOptions = '<option value="">Select Section</option>';
                        data.sections.forEach(section => {
                            const selected = section.section_id == sectionId ? 'selected' : '';
                            sectionOptions += `<option value="${section.section_id}" ${selected}>${section.name}</option>`;
                        });
                        sectionSelect.innerHTML = sectionOptions;
                    })
                    .catch(error => {
                        sectionSelect.innerHTML = '<option value="">Error loading sections</option>';
                        console.error('Error:', error);
                    });
            });
        });

        document.querySelectorAll('.fileInput').forEach(function (fileInput) {
            fileInput.addEventListener('change', function (event) {
                // const studentId = this.dataset.studentId;
                const studentId = this.getAttribute('data-student-id'); // Get the correct student ID
                const photoPreview = document.getElementById(`photoPreview-${studentId}`);

                if (event.target.files.length > 0) {
                    const file = event.target.files[0];
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        photoPreview.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

});
</script>


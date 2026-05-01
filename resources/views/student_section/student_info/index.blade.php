@extends('layout.main')
@section('content')
    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-all-users" role="tab" aria-controls="custom-tabs-four-home" aria-selected="false">All Students</a>
                </li>
                <!-- Tabs for Sections -->
                @foreach($sections as $section)
                    <li class="nav-item">
                        <a class="nav-link" id="section-tab-{{ $section->section_id }}" data-toggle="pill" href="#section-{{ $section->section_id }}" role="tab" aria-controls="section-{{ $section->section_id }}" aria-selected="false">
                            {{ $section->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="tab-custom-content">
            <p class="lead mb-0">&nbsp;&nbsp;&nbsp;&nbsp; Student Information for Class: {{ $class->name }}</p>
        </div>
        <div class="card-body">
            <div class="dataTables_wrapper dt-bootstrap4 tab-content" id="example1_wrapper custom-tabs-four-tabContent">
                <!-- Tab 1: All Students -->
                <div class="tab-pane fade active show" id="custom-all-users" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                    @if (Auth::user()->role == 0) <!-- Admin Only -->
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <a href="{{ route('students.add_to_class_view', $class->class_id) }}" class="btn btn-success float-left">
                                <i class="fa fa-plus"></i> Add Student to Class: {{ $class->name }}
                            </a>
                        </div>
                    </div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @endif

                    <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                        <thead>
                        <tr>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">#</th>
                            <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="descending">Student Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Parent Name</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Section</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Roll</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Phone</th>
                            <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Email</th>
                            <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($students as $index => $student)
                            <tr class="odd">
                                <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                <td class="sorting_1">{{ $student->name }}</td>
                                <td class="sorting_1">{{ $student->parent_name }}</td>
                                <td class="sorting_1">{{ $student->section_name ?? 'N/A' }}</td>
                                <td class="sorting_1">{{ $student->roll }}</td>
                                <td class="sorting_1">{{ $student->phone }}</td>
                                <td class="sorting_1">{{ $student->email }}</td>
                                <td>
                                    @if (Auth::user()->role == 0) <!-- Admin Only -->
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Actions</button>
                                        <div class="dropdown-menu">
                                            <a href="#" class="dropdown-item text-primary" data-toggle="modal" data-target="#editStudentModal{{ $student->student_id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('students.remove_from_class', ['student_id' => $student->student_id, 'class_id' => $class->class_id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger delete-btn">
                                                    <i class="fas fa-trash"></i> Remove from Class
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                        <span class="text-muted">No Actions Available</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No students found for {{ $class->name }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Section-Specific Tabs -->
                @foreach($sections as $section)
                    <div class="tab-pane fade" id="section-{{ $section->section_id }}" role="tabpanel" aria-labelledby="section-tab-{{ $section->section_id }}">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Student Name</th>
                                <th>Parent Name</th>
                                <th>Roll</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $sectionStudents = $students->where('section_id', $section->section_id); @endphp
                            @forelse($sectionStudents as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->parent_name }}</td>
                                    <td>{{ $student->roll }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">Actions</button>
                                            <div class="dropdown-menu">
                                                    <a href="#" class="dropdown-item text-primary" data-toggle="modal" data-target="#editStudentModal{{ $student->student_id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                <div class="dropdown-divider"></div>
                                                <form action="{{ route('students.remove_from_class', ['student_id' => $student->student_id, 'class_id' => $class->class_id]) }}"
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger delete-btn">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                            <span class="text-muted">No Actions Available</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No students found for {{ $section->name }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- Edit Student Modal -->
                    @foreach($students as $student)
                        <div class="modal fade" id="editStudentModal{{ $student->student_id }}" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="{{ route('students.update_class_assignment', ['student_id' => $student->student_id, 'class_id' => $class->class_id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editStudentModalLabel">Edit Student Class Assignment</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Student</label>
                                                <input type="text" class="form-control" value="{{ $student->name }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label>Section</label>
                                                <select name="section_id" class="form-control" required>
                                                    @foreach($sections as $section)
                                                        <option value="{{ $section->section_id }}" {{ $student->section_id == $section->section_id ? 'selected' : '' }}>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Roll Number</label>
                                                <input type="text" name="roll" class="form-control" value="{{ $student->roll }}" required>
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

                @endforeach
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
@endsection

<script>
    document.getElementById('class_id_modal').addEventListener('change', function () {
        const classId = this.value;
        const sectionSelect = document.getElementById('section_id_modal');
        sectionSelect.innerHTML = '<option value="">Loading...</option>';

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
</script>



@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Teacher Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">
                            Teacher List
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">

                <h3><i class="fa fa-list-ul"></i> Teacher List</h3>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0) <!-- Admin Only -->
            <a class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addTeacherModal">
                <i class="fa fa-plus"></i> Add Teacher
            </a>

            <a class="floating-button" data-toggle="modal" data-target="#addTeacherModal">
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
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"aria-sort="descending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Birthday</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Sex</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Address</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Photo</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teachers as $index => $teacher)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{$index + 1}}</td>
                                    <td class="sorting_1">{{ $teacher->name }}</td>
                                    <td class="sorting_1">{{ $teacher->birthday }}</td>
                                    <td class="sorting_1">
                                        @if($teacher->sex)
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                    <td class="sorting_1">{{ $teacher->address }}</td>
                                    <td class="sorting_1">{{ $teacher->phone }}</td>
                                    <td class="sorting_1">{{ $teacher->email }}</td>
                                    <td>
                                        <img src="{{ asset('teachers_image/' . ($teacher->photo ?? 'noimg.jpg')) }}"
                                             alt="Teacher Photo"
                                             width="50" height="50"
                                             class="rounded-circle">

                                    </td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editTeacherModal{{ $teacher->teacher_id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('teachers.destroy', $teacher->teacher_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
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
                                <div class="modal fade" id="editTeacherModal{{ $teacher->teacher_id }}" tabindex="-1" aria-labelledby="editTeacherModalLabel{{ $teacher->teacher_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('teachers.update', $teacher->teacher_id) }}" method="POST" onsubmit="showOverlay();" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editTeacherModalLabel{{ $teacher->teacher_id }}">Edit Teacher</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&<times></times>;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Teacher Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $teacher->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="birthday">Birthday</label>
                                                        <input type="date" name="birthday" class="form-control" value="{{ $teacher->birthday }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Sex</label>
                                                        <select class="form-control" name="sex" required>
                                                            <option value="1" {{ $teacher->sex == 1 ? 'selected' : '' }}>Male</option>
                                                            <option value="0" {{ $teacher->sex == 0 ? 'selected' : '' }}>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" name="address" class="form-control" value="{{ $teacher->address }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $teacher->phone }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="text" name="email" class="form-control" value="{{ $teacher->email }}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Current Photo:</label><br>
                                                        <img id="photoPreview-{{ $teacher->teacher_id }}"
                                                             src="{{ asset('teachers_image/' . ($teacher->photo ?? 'noimg.jpg')) }}"
                                                             alt="Teacher Photo"
                                                             width="100" height="100"
                                                             class="rounded-circle photoPreview"
                                                             data-teacher-id="{{ $teacher->teacher_id }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="file">Upload New Photo:</label>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" name="file" accept="image/*"
                                                                       class="custom-file-input fileInput"
                                                                       data-teacher-id="{{ $teacher->teacher_id }}">
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

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Teacher Name" required>
                        </div>
                        <div class="form-group">
                            <label for="birthday">Birthday</label>
                            <input type="date" name="birthday" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Sex</label>
                            <select class="form-control" name="sex" required>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Email</label>
                            <input type="text" name="email" class="form-control" required>
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
                    </div>
                    <div class="modal-footer">
                        <p class="text-muted">
                            Note: The default password for the newly created user will be <strong>123456</strong>.
                            The user can change it later from their account settings.
                        </p>

                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Teacher</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.fileInput').forEach(function (fileInput) {
            fileInput.addEventListener('change', function (event) {
                const teacherId = this.getAttribute('data-teacher-id'); // Get the correct teacher ID
                const photoPreview = document.getElementById(`photoPreview-${teacherId}`);

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


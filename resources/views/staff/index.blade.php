@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Staff Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('departments.index') }}">Department List</a></li>
                        <li class="breadcrumb-item active">Staff List</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Staff List</h3>
            </div>
            <!-- Add Button -->
            <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addStaffModal">
                <i class="fa fa-plus"></i> Add Staff
            </button>

            <button class="floating-button" data-toggle="modal" data-target="#addStaffModal">
                <i class="fa fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Staff Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Sex</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Address</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">ID Card</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Department</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Position</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Hire Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Photo</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($staffs as $index => $item)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                    <td class="sorting_1">{{ $item->name }}</td>
                                    <td class="sorting_1">{{ $item->sex }}</td>
                                    <td class="sorting_1">{{ $item->email ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->phone ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->address ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->id_card ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->department_name ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->position ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $item->hire_date ?? 'N/A'}}</td>
                                    <td>
                                        <img src="{{ asset('staffs_image/' . ($item->photo ?? 'noimg.jpg')) }}"
                                             alt="Teacher Photo"
                                             width="50" height="50"
                                             class="rounded-circle">

                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editModal{{ $item->staff_id }}"><i class="fas fa-edit"></i> Edit</button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('staffs.destroy', $item->staff_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <div class="card-footer">

        </div>
        <!-- Update Modal -->
        @foreach ($staffs as $item)
            <div class="modal fade" id="editModal{{ $item->staff_id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->staff_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('staffs.update', $item->staff_id) }}" method="POST" enctype="multipart/form-data" onsubmit="showOverlay()">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->staff_id }}">Edit for staff: {{ $item->name }}</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Staff Name</label>
                                        <div class="input-group mb-3 ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user"></i>
                                                </span>
                                            </div>
                                            <input type="text" id="name" name="name" class="form-control" value="{{ $item->name }}" required>
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
                                                <option value="Male" {{ $item->sex == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $item->sex == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="email">Email</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-envelope"></i>
                                            </span>
                                            </div>
                                            <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $item->email }}" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="position">Position</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            </div>
                                            <input type="text" name="position" class="form-control" placeholder="Enter Position" value="{{$item->position}}" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="address">Telephone</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                            </div>
                                            <input type="text" name="phone" class="form-control" placeholder="Telephone" value="{{$item->phone}}" required>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="department_id">Department</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-university"></i>
                                        </span>
                                            </div>
                                            <select name="department_id" id="department_id" class="form-control" required>
                                                <option value="">Select Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}" {{ $item->department_id == $department->id ? 'selected' : '' }}>
                                                        {{ $department->name }}
                                                    </option>
                                                @endforeach
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
                                            <input type="text" name="address" class="form-control" placeholder="Address" value="{{$item->address}}" required>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="hire_date">Hire Date</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                            </div>
                                            <input type="date" name="hire_date" class="form-control" placeholder="Enter Hire Date" value="{{$item->hire_date}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Current Photo:</label><br>
                                    <img id="photoPreview-{{ $item->staff_id }}"
                                         src="{{ asset('staffs_image/' . ($item->photo ?? 'noimg.jpg')) }}"
                                         alt="Staff Photo"
                                         width="100" height="100"
                                         class="rounded-circle photoPreview"
                                         data-staff-id="{{ $item->staff_id }}">
                                </div>
                                <div class="form-group">
                                    <label for="file">Upload New Photo:</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" name="file"
                                                   accept=".jpeg,.jpg,.png,.gif,.ico"
                                                   class="custom-file-input fileInput"
                                                   data-staff-id="{{ $item->staff_id }}">
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
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>


   <!-- Add Department Modal -->
    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('staffs.store') }}" method="POST" enctype="multipart/form-data" onsubmit="showOverlay()">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addStaffModalLabel">Add Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_card" value="{{ old('id_card', $staff->id_card ?? '') }}">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Staff Name</label>
                                <div class="input-group mb-3 ">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    </div>
                                    <input type="text" name="name" class="form-control" placeholder="Staff Name" required>
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
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email">Email</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="position">Position</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-user"></i>
                                </span>
                                    </div>
                                    <input type="text" name="position" class="form-control" placeholder="Enter Position" required>
                                </div>
                            </div>


                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="address">Telephone</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="fas fa-phone"></i>
                                </span>
                                    </div>
                                    <input type="text" name="phone" class="form-control" placeholder="Telephone" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="department_id">Department</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-university"></i>
                                        </span>
                                    </div>
                                    <select name="department_id" id="department_id" class="form-control" required>
                                        <option value="">Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
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
                                    <input type="text" name="address" class="form-control" placeholder="Address" required>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hire_date">Hire Date</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <input type="date" name="hire_date" class="form-control" placeholder="Enter Hire Date" required>
                                </div>
                            </div>
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
                            Note: If a staff member's position is <strong>Accountant</strong> or <strong>Receptionist</strong>, a user account will be created automatically.
                        </p>

                        <p class="text-muted">
                            Note: The default password for the newly created user will be <strong>123456</strong>.
                            The user can change it later from their account settings.
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.fileInput').forEach(function (fileInput) {
                fileInput.addEventListener('change', function (event) {
                    const staffId = this.getAttribute('data-staff-id'); // Get the correct staff ID
                    const photoPreview = document.getElementById(`photoPreview-${staffId}`);

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
@endsection


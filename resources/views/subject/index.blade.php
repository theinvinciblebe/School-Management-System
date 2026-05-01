@extends('layout.main')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Subject Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item {{ request()->is('subjects/'.$class->class_id) ? 'active' : '' }}">
                            <a href="{{ route('subject.index', ['class_id' => $class->class_id]) }}">{{ $class->name }}</a>
                        </li>
{{--                        @forelse($classes as $item)--}}
{{--                            <li class="breadcrumb-item {{ request()->is('subjects/'.$item->class_id) ? 'active' : '' }}">--}}
{{--                                <a href="{{ route('subject.index', ['class_id' => $item->class_id]) }}">{{ $item->name }}</a>--}}
{{--                            </li>--}}
{{--                        @empty--}}
{{--                            <li class="nav-item">--}}
{{--                                <p class="text-center text-muted">No subjects assigned yet</p>--}}
{{--                            </li>--}}
{{--                        @endforelse--}}
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

<div class="card">
    <div class="card-header">
        <div class="card-title">
            <h3>Manage Subjects for Class: <b>{{ $class->name }}</b></h3>
        </div>
        <!-- Add Button (visible only to admin) -->
        @if (Auth::user()->role == 0 || Auth::user()->role == 4)
            <a data-toggle="modal" data-target="#addSubjectModal" class="btn btn-primary mb-3 float-right">
                <i class="fa fa-plus"></i> Add Subject
            </a>
            <a data-toggle="modal" data-target="#addSubjectModal" class="floating-button">
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
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Subject Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Teacher</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $index => $subject)
                            <tr class="odd">
                                <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                <td class="sorting_1" >{{ $subject->name ?? 'No Subject Name' }}</td>
                                <td>{{ $subject->teacher_name ?? 'No Teacher Assigned' }}</td>
                                <td>
                                    <!-- Show Options Dropdown Only for Admin -->
                                    @if (Auth::user()->role == 0 || Auth::user()->role == 4) <!-- Admin Only -->
                                   <div class="btn-group">
                                        <button type="button" class="btn btn-success">Action</button>
                                        <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                          <div class="dropdown-menu" role="menu">
                                            <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editSubjectModal{{ $subject->subject_id }}"><i class="fas fa-edit"></i> Edit</button>
                                            <div class="dropdown-divider"></div>
                                            <form action="{{ route('subject.destroy', ['id' => $subject->subject_id]) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger delete-btn">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @else
                                        <span class="text-muted">No Actions Available</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
@endsection

<!-- Add Subject Modal -->
<div class="modal fade" id="addSubjectModal" tabindex="-1" aria-labelledby="addSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('subject.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Subject</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="class_id" value="{{ $class->class_id }}">
                    <div class="form-group">
                        <label for="subject_name">Subject Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="teacher_id">Teacher</label>
                        <select class="form-control" name="teacher_id" required>
                            <option value="">Select Teacher</option>
                            @foreach($teachers as $teacher)
                            <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Subject Modal -->
            @forelse($subjects as $subject)
            <div class="modal fade" id="editSubjectModal{{ $subject->subject_id }}" tabindex="-1" role="dialog" aria-labelledby="editSubjectModalLabel{{ $subject->subject_id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{ route('subject.update', ['id' => $subject->subject_id]) }}" method="POST">
                            @csrf
                            @method('PUT') <!-- This sets the HTTP method to PUT for update -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSubjectModalLabel{{ $subject->subject_id }}">Edit Subject</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <!-- Subject Name Input -->
                                <div class="form-group">
                                    <label for="name">Subject Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $subject->name }}" required>
                                </div>

                                <!-- Teacher Dropdown -->
                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select class="form-control" name="teacher_id" required>
                                        <option value="">Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->teacher_id }}" {{ isset($subject->teacher_id) && $teacher->teacher_id == $subject->teacher_id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
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
            @empty
                        <!-- No subjects for this class -->
            @endforelse

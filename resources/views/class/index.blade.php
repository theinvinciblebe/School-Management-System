@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Class Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('sections.index') }}">Section List</a></li>
                        <li class="breadcrumb-item active">Class List</li>


                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Class List</h3>
            </div>
            @if (in_array(Auth::user()->role, [0, 3]))
                <!-- Add Button -->
                <a href="{{ route('class.create') }}" class="btn btn-primary mb-3 float-right">
                    <i class="fa fa-plus"></i> Add Class
                </a>

                <a href="{{ route('class.create') }}" class="floating-button">
                    <i class="fa fa-plus"></i>
                </a>
            @endif
        </div>
        <div class="card-body">
            <div id="classTable_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="classTable" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                                <tr>
                                    <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                    <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Class Name</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Class Code</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Class Room</th>
                                    <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Teacher</th>
                                    <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tbl as $item)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $i++ }}</td>
                                    <td class="sorting_1">{{ $item->name }}</td>
                                    <td>{{ $item->class_code ?? 'N/A'}}</td>
                                    <td>{{ $item->class_room ?? 'N/A'}}</td>
                                    <td>{{ $item->teacher_name ?? 'N/A' }}</td>
                                    <td>
                                        @if (Auth::user()->role == 0 || Auth::user()->role == 3)
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editModal{{ $item->class_id }}"><i class="fas fa-edit"></i> Edit</button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('class.destroy', $item->class_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
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
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <!-- Update Modal -->
        @foreach ($tbl as $item)
            <div class="modal fade" id="editModal{{ $item->class_id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->class_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('class.update', $item->class_id) }}" method="POST" onsubmit="showOverlay()">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->class_id }}">Edit Class</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Class Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="class_code">Class Code</label>
                                    <input type="text" class="form-control" id="class_code" name="class_code" value="{{ $item->class_code ?? 'No Code Assigned'}}">
                                </div>
                                <div class="form-group">
                                    <label for="class_room">Class Room</label>
                                    <input type="text" class="form-control" id="class_room" name="class_room" value="{{ $item->class_room ?? 'No Room Assigned'}}">
                                </div>
                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select class="form-control select2bs4" id="teacher_id" name="teacher_id">
                                        <option value="">No Teacher Assigned</option> <!-- Option to store null -->
                                        @foreach ($teachers as $teacher)
                                            <option value="{{ $teacher->teacher_id }}" {{ $item->teacher_id == $teacher->teacher_id ? 'selected' : '' }}>
                                                {{ $teacher->name }}
                                            </option>
                                        @endforeach
                                    </select>
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

@endsection



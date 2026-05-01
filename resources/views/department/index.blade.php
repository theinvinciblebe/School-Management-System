@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Department Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('staffs.index')}}">Staff List</a></li>
                        <li class="breadcrumb-item active">Department List</li>

                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Department List</h3>
            </div>
            <!-- Add Button -->
            <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fa fa-plus"></i> Add Department
            </button>

            <a class="floating-button" data-toggle="modal" data-target="#addDepartmentModal">
                <i class="fa fa-plus"></i>
            </a>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Department Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Created Date</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($departments as $index => $item)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                    <td class="sorting_1">{{ $item->name }}</td>
                                    <td>{{ $item->created_at ?? 'N/A'}}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editModal{{ $item->id }}"><i class="fas fa-edit"></i> Edit</button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('departments.destroy', $item->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
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

        <!-- Update Modal -->
        @foreach ($departments as $item)
            <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('departments.update', $item->id) }}" method="POST" onsubmit="showOverlay()">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $item->id }}">Edit Department</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="name">Department Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $item->name }}" required>
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
    <div class="modal fade" id="addDepartmentModal" tabindex="-1" aria-labelledby="addDepartmentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('departments.store') }}" method="POST" onsubmit="showOverlay()";>
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addDepartmentModalLabel">Add Department</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="section_name">Department Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Department</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



@endsection


@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Parent Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item {{ request()->is('parents*') ? 'active' : '' }}">
                            <a href="{{ route('parents.index') }}">Parent List</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Student's Parent</h3>
            </div>
            @if (Auth::user()->role == 0) <!-- Admin Only -->
            <a class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addParentModal">
                <i class="fa fa-plus"></i> Add Parent
            </a>

            <a class="floating-button" data-toggle="modal" data-target="#addParentModal">
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
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Phone</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Address</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Profession</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($parents as $parent)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{$i++}}</td>
                                    <td class="sorting_1">{{ $parent->name }}</td>
                                    <td class="sorting_1">{{ $parent->email ?? 'N/A'}}</td>
                                    <td>{{$parent->phone ?? 'N/A'}}</td>
                                    <td class="sorting_1">{{ $parent->address ?? 'N/A'}}</td>
                                    <td>{{$parent->profession ?? 'N/A' }}</td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editParentModal{{ $parent->parent_id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('parent.destroy', $parent->parent_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                            @else
                                                <span class="text-muted">No Actions Available</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editParentModal{{ $parent->parent_id }}" tabindex="-1" aria-labelledby="editParentModalLabel{{ $parent->parent_id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('parent.update', $parent->parent_id) }}" method="POST" onsubmit="showOverlay();">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editParentModalLabel{{ $parent->parent_id }}">Edit Parent</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&<times></times>;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $parent->name }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" name="email" class="form-control" value="{{ $parent->email }}">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone">Phone</label>
                                                        <input type="text" name="phone" class="form-control" value="{{ $parent->phone }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Address</label>
                                                        <input type="text" name="address" class="form-control" value="{{ $parent->address }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="profession">Profession</label>
                                                        <input type="text" name="profession" class="form-control" value="{{ $parent->profession }}">
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

    <!-- Add Parent Modal -->
    <div class="modal fade" id="addParentModal" tabindex="-1" aria-labelledby="addParentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('parent.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addParentModalLabel">Add New Parent</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="profession">Profession</label>
                            <input type="text" name="profession" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Parent</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


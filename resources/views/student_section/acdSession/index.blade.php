@extends('layout.main')
@section('content')

    <style>
        .badge-status {
            font-size: 1.0rem;   /* Adjust font size for better readability */
            padding: 0.5rem 1rem; /* Adjust padding for consistent size */
            border-radius: 8px;  /* Rounded corners for a modern look */
            width: 100px;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Academic Session</h3>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0) <!-- Admin Only -->
            <a href="" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addSessionModal">
                <i class="fa fa-plus"></i> New Session
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
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Status</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Start Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">End Date</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sessions as $session)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{$i++}}</td>
                                    <td class="sorting_1">{{ $session->name }}</td>
                                    <td>
                                        @if($session->is_open)
                                            <span class="badge badge-success">Open</span>
                                        @else
                                            <span class="badge badge-danger">Closed</span>
                                        @endif
                                    </td>
                                    <td>{{{$session->strt_dt}}}</td>
                                    <td>{{{$session->end_dt}}}</td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editSessionModal{{ $session->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
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
                                <div class="modal fade" id="editSessionModal{{ $session->id }}" tabindex="-1" aria-labelledby="editSessionModalLabel{{ $session->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('sessions.update', $session->id) }}" method="POST" onsubmit="showOverlay();">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editSessionModalLabel{{ $session->id }}">Edit Session</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&<times></times>;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $session->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Status</label>
                                                        <select class="form-control" name="is_open" required>
                                                            <option value="1" {{ $session->is_open == 1 ? 'selected' : '' }}>Open</option>
                                                            <option value="0" {{ $session->is_open == 0 ? 'selected' : '' }}>Closed</option>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="phone">Start Date</label>
                                                        <input type="date" name="strt_dt" class="form-control" value="{{ $session->strt_dt }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">End Date</label>
                                                        <input type="date" name="end_dt" class="form-control" value="{{ $session->end_dt }}" required>
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
    <div class="modal fade" id="addSessionModal" tabindex="-1" aria-labelledby="addSessionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('sessions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSessionModalLabel">Add New Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Session Name" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="is_open" required>
                                <option value="1">Open</option>
                                <option value="0">Closed</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Start Date</label>
                            <input type="date" name="strt_dt" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="address">End Date</label>
                            <input type="date" name="end_dt" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Session</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection


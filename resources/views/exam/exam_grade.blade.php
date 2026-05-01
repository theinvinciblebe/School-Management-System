@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Manage Exam Grade</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exams_list.index') }}">Exam List</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exam_marks.index') }}">Manage Mark</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Grade Details
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h4><i class="fas fa-graduation-cap"></i> Grade List</h4>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0) <!-- Admin Only -->
            <a href="" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addGradeModal">
                <i class="fa fa-plus"></i> Add grade
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
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"aria-sort="descending">Grade Name</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"aria-sort="descending">Grade Point</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Mark From</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Mark Upto</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Comment</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($grades as $index => $grade)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{$index + 1}}</td>
                                    <td class="sorting_1">{{ $grade->name }}</td>
                                    <td class="sorting_1">{{ $grade->grade_point }}</td>
                                    <td class="sorting_1">{{ $grade->mark_from }}</td>
                                    <td class="sorting_1">{{ $grade->mark_upto }}</td>
                                    <td>
                                        {{ $grade->comment ?? 'None'}}
                                    </td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success">Action</button>
                                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editGradeModal{{ $grade->grade_id }}">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </button>

                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('exams_grade.destroy', $grade->grade_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this grade?');"><i class="fas fa-trash"></i> Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">No Actions Available</span>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editGradeModal{{ $grade->grade_id }}" tabindex="-1" aria-labelledby="editGradeModalLabel{{ $grade->grade_id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('exams_grade.update', $grade->grade_id) }}" method="POST" onsubmit="showOverlay();">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editGradeModalLabel{{ $grade->grade_id }}">Edit Grade</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&<times></times>;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Grade Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $grade->name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="grade_point">Grade Point</label>
                                                        <input type="text" name="grade_point" class="form-control" value="{{ $grade->grade_point}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="mark_from">Mark From</label>
                                                        <input type="number" name="mark_from" class="form-control" value="{{ $grade->mark_from}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="mark_upto">Mark Upto</label>
                                                        <input type="number" name="mark_upto" class="form-control" value="{{ $grade->mark_upto}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <textarea class="form-control" rows="3" name="comment" placeholder="{{$grade->comment}}"></textarea>
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

    <!-- Add Modal -->
    <div class="modal fade" id="addGradeModal" tabindex="-1" aria-labelledby="addGradeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('exams_grade.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addGradeModalLabel">Add New Grade</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Grade Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Exam Name" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Grade Point</label>
                            <input type="text" name="grade_point" class="form-control" placeholder="Grade Point" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Mark From</label>
                            <input type="number" name="mark_from" class="form-control" placeholder="Mark From" required>
                        </div>
                        <div class="form-group">
                            <label for="name">Mark Upto</label>
                            <input type="number" name="mark_upto" class="form-control" placeholder="Mark Upto" required>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" rows="3" name="comment" placeholder="Enter comments ..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Add Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection


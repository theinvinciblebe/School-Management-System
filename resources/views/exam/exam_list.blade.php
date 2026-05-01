@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Manage Examination</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exams_grade.index') }}">Exam Grade</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('exam_marks.index') }}">Manage Mark</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Exam List
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3><i class="fas fa-scroll"></i> Exam List</h3>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0 || Auth::user()->role == 1) <!-- Admin Only -->
{{--            <a href="" class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addExamModal">--}}
{{--                <i class="fa fa-plus"></i> Add Exam--}}
{{--            </a>--}}

            <a href="{{route('exams.create')}}" class="floating-button">
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
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1"aria-sort="descending">Exam Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Comment</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exams as $index => $exam)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{$index + 1}}</td>
                                    <td class="sorting_1">{{ $exam->name }}</td>
                                    <td>{{$exam->date}}</td>
                                    <td>
                                        @if(!empty($exam))
                                            {{ $exam->comment }}
                                        @endif
                                        ...
                                    </td>
                                    <td>
                                        @if (Auth::user()->role == 0) <!-- Admin Only -->
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success">Action</button>
                                            <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                <span class="sr-only">Toggle Dropdown</span>
                                            </button>
                                            <div class="dropdown-menu" role="menu">
                                                <button type="button" class="dropdown-item text-primary" data-toggle="modal" data-target="#editExamModal{{ $exam->exam_id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>

                                                <div class="dropdown-divider"></div>
                                                <a href="{{ route('exam.questions', $exam->exam_id) }}" class="dropdown-item text-secondary" >
                                                    <i class="fas fa-eye"></i> View

                                                </a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{ route('exams_list.destroy', $exam->exam_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this session?');"><i class="fas fa-trash"></i> Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                        @else
                                            <span class="text-muted">No Actions Available</span>
                                        @endif
                                    </td>
                                </tr>
                                <!-- Edit Modal -->
                                <div class="modal fade" id="editExamModal{{ $exam->exam_id }}" tabindex="-1" aria-labelledby="editExamModalLabel{{ $exam->exam_id}}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('exams_list.update', $exam->exam_id) }}" method="POST" onsubmit="showOverlay();">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editExamModalLabel{{ $exam->exam_id }}">Edit Exam</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&<times></times>;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">Name</label>
                                                        <input type="text" name="name" class="form-control" value="{{ $exam->name}}" required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" name="date" class="form-control" value="{{ $exam->date }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Comment</label>
                                                        <textarea class="form-control" rows="3" name="comment" placeholder="{{$exam->comment}}"></textarea>
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
    <div class="modal fade" id="addExamModal" tabindex="-1" aria-labelledby="addExamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('exams_list.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExamModalLabel">Add New Exam</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Exam Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Exam Name" required>
                        </div>
                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" name="date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Comment</label>
                            <textarea class="form-control" rows="3" name="comment" placeholder="Enter comments ..."></textarea>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <label for="comment">Comment</label>--}}
{{--                            <input type="text" name="comment" class="form-control" required>--}}
{{--                        </div>--}}
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


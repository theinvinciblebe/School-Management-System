@extends('layout.main')
@section('content')
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
<div class="container"><br>
    <h3>Class Routine for : <b>{{ $class->name }}</b> </h3><br>
    <div class="card">
      <div class="card-header clearfix">
          @if (Auth::user()->role == 0 || Auth::user()->role == 4) <!-- Admin Only -->
          <a href="" class="btn btn-info float-left" data-toggle="modal" data-target="#addRoutineModal" ><i class="fa fa-plus"></i> Add Class Routine</a>
          @endif
          <a href="{{ route('class_routines.show_classes') }}" class="btn btn-secondary float-right"><i class="fa fa-arrow-left"></i> Back</a>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
          @foreach (['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day)
        <div id="accordion">
          <div class="card {{ $routines->where('day', $day)->isEmpty() ? 'card-primary' : 'card-success' }}">
            <div class="card-header id="heading-{{ $day }}">
              <h4 class="card-title w-100">
                <a class="d-block w-100" data-toggle="collapse" data-target="#collapse-{{ $day }}" href="#collapseOne">
                    <i class="fa fa-caret-down"> </i>
                    Routine in {{ $day }}
                </a>
              </h4>
            </div>
            <div id="collapse-{{ $day }}" class="collapse show" data-parent="#accordion">
                <div class="card-body">
                    @if($routines->where('day', $day)->isEmpty())
                        <span class="text-muted">No routines scheduled for {{ $day }}</span>
                    @else
                        @foreach ($routines->where('day', $day) as $routine)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4>
                                    <span class="badge badge-primary">
                                        {{ $routine->subject_name }} ({{ $routine->time_start }}:00 - {{ $routine->time_end }}:00)
                                    </span>
                                </h4>

                                <div>
                                    @if (Auth::user()->role == 0 || Auth::user()->role == 4) <!-- Admin Only -->
                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editRoutineModal{{ $routine->class_routine_id }}"><i class="fa fa-edit"></i> Edit</button> ||
                                        <form action="{{ route('class_routines.destroy', $routine->class_routine_id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger delete-btn" onsubmit="showOverlay()"><i class="fa fa-trash"></i> Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
              @endforeach
          </div>
      <!-- /.card-body -->
    </div>
</div>

<!-- Add Routine Modal -->
<div class="modal fade" id="addRoutineModal" tabindex="-1" aria-labelledby="addRoutineModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('class_routines.store') }}" method="POST" onsubmit="showOverlay()";>
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Class Routine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="class_id" value="{{ $class->class_id }}">
                    <div class="form-group">
                        <label for="subject_id">Subject</label>
                        <select class="form-control" name="subject_id" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time_start">Start Time (Hour)</label>
                        <input type="number" class="form-control" name="time_start" required>
                    </div>
                    <div class="form-group">
                        <label for="time_end">End Time (Hour)</label>
                        <input type="number" class="form-control" name="time_end" required>
                    </div>
                    <div class="form-group">
                        <label for="day">Day</label>
                        <select class="form-control" name="day" required>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
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

@foreach($routines as $routine)
<div class="modal fade" id="editRoutineModal{{ $routine->class_routine_id }}" tabindex="-1" role="dialog" aria-labelledby="editRoutineModalLabel{{ $routine->class_routine_id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('class_routines.update', $routine->class_routine_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Class Routine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="class_id" value="{{ $routine->class_id }}">
                    <div class="form-group">
                        <label for="subject_id">Subject</label>
                        <select class="form-control" name="subject_id" required>
                            <option value="">Select Subject</option>
                            @foreach($subjects as $subject)
                            <option value="{{ $subject->subject_id }}" {{ $routine->subject_id == $subject->subject_id ? 'selected' : '' }}>{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="time_start">Start Time (Hour)</label>
                        <input type="number" class="form-control" name="time_start" value="{{ $routine->time_start }}" required>
                    </div>
                    <div class="form-group">
                        <label for="time_end">End Time (Hour)</label>
                        <input type="number" class="form-control" name="time_end" value="{{ $routine->time_end }}" required>
                    </div>
                    <div class="form-group">
                        <label for="day">Day</label>
                        <select class="form-control" name="day" required>
                            @foreach($daysOfWeek as $day)
                            <option value="{{ $day }}" {{ $routine->day == $day ? 'selected' : '' }}>{{ $day }}</option>
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
@endforeach

@endsection

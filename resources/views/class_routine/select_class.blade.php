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

    <div class="card">
      <div class="card-header">
        <h3>Select a Class to View Routine</h3>
      </div>
      <div class="card-body">
      @foreach($classes as $class)
        <a href="{{ route('class_routines.index', $class->class_id) }}" class="btn btn-app bg-primary" onclick="showOverlay()">
          <!--<span class="badge bg-success">300</span>-->
          <i class="fas fa-calendar"></i> {{ $class->name }} Routine
        </a>
        @endforeach
      </div>
      <!-- /.card-body -->
    </div>

@endsection

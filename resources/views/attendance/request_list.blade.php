@extends('layout.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Manage Edit Requests</h3>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Teacher Name</th>
                    <th>Section Name</th>
                    <th>Date Requested</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($requests as $request)
                    <tr>
                        <td>{{ $request->class_name }}</td>
                        <td>{{ $request->teacher_name }}</td>
                        <td>{{ $request->section_name }}</td>
                        <td>{{ $request->date }}</td>
                        <td>{{ $request->reason }}</td>
                        <td>
                        <span class="badge badge-{{ $request->status === 'Pending' ? 'warning' : ($request->status === 'Approved' ? 'success' : ($request->status === 'Completed' ? 'primary' : 'danger')) }}">
                            {{ $request->status }}
                        </span>

                        </td>
                        <td>
                            <form method="POST" action="{{ route('attendance.updateRequestStatus', $request->id) }}">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control" required>
                                    <option value="" disabled selected>Select</option>
                                    <option value="Approved" {{ $request->status === 'Approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="Rejected" {{ $request->status === 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                <button type="submit" class="btn btn-primary mt-2">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>
@endsection

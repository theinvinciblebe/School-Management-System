@php use Carbon\Carbon; @endphp
@extends('layout.main')

@section('content')

    <style>
        .badge-status {
            font-size: 1.2rem;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            width: 70px;
        }
    </style>


    <div class="card">
        <div class="card-header">
            <h3 align="center">Staff Attendance Management</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label for="date_picker">Pick a Date:</label>
                    <div class="input-group">
                        <input type="date" id="date_picker" name="date" class="form-control" value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="department_picker">Pick a Department:</label>
                    <select id="department_picker" class="form-control" required>
                        <option value="" selected>All Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h4>Attendance List</h4>
{{--            <a href="{{ route('staffAttendance.view', $staff->date) }}" class="float-right"><i class="fas fa-eye">View</i></a>--}}
            <button id="view_attendance_btn" class="btn btn-primary mt-3 float-right"><i class="fas fa-eye"></i> View Attendance</button>

        </div>
        <div class="card-body">
            <div id="attendance-container">
                <p>Please select a date and department to view attendance records.</p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const datePicker = document.getElementById('date_picker');
            const hiddenDateInput = document.getElementById('hidden_date');
            const departmentPicker = document.getElementById('department_picker');
            const attendanceContainer = document.getElementById('attendance-container');

            // datePicker.addEventListener('change', function () {
            //     document.getElementById('hidden_date').value = this.value; // Sync hidden input value with the selected date
            // });

            // Update hidden input when date picker changes
            datePicker.addEventListener('change', function () {
                hiddenDateInput.value = this.value; // Sync hidden input value
            });

            document.getElementById('view_attendance_btn').addEventListener('click', function () {
                const selectedDate = document.getElementById('date_picker').value;

                if (!selectedDate) {
                    alert('Please select a date first.');
                    return;
                }

                // Redirect to Laravel route with the selected date
                window.location.href = `/staff/attendance/view/${selectedDate}`;
            });


            function loadAttendance() {
                const date = datePicker.value || '{{ Carbon::now()->format("Y-m-d") }}'; // Default to today's date
                const departmentId = departmentPicker.value || 'all'; // Default to "all"

                if (!date) {
                    attendanceContainer.innerHTML = '<p>Please select a date to view attendance records.</p>';
                    return;
                }

                attendanceContainer.innerHTML = '<div class="overlay"><i class="fas fa-3x fa-sync-alt fa-spin"></i></div>';

                fetch(`/get-staffAttendance?date=${date}&department_id=${departmentId}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.staff.length === 0) {
                            attendanceContainer.innerHTML = '<p>No staff found for this department.</p>';
                            return;
                        }

                        let tableRows = '';
                        data.staff.forEach(staff => {
                            tableRows += `
                            <tr>
                                <td>${staff.name}</td>
                                <td>
                                    <select name="attendance[${staff.staff_id}][status]" class="form-control status-dropdown" data-id="${staff.staff_id}">
                                        <option value="Undefined" ${staff.status === 'Undefined' ? 'selected' : ''}>Undefined</option>
                                        <option value="Present" ${staff.status === 'Present' ? 'selected' : ''}>Present</option>
                                        <option value="Absent" ${staff.status === 'Absent' ? 'selected' : ''}>Absent</option>
                                    </select>
                                </td>
                                    <td>
                                        <input type="time" name="attendance[${staff.staff_id}][time_in]"
                                               class="form-control time-in"
                                               value="${staff.time_in || ''}"
                                               data-id="${staff.staff_id}"
                                               ${staff.status === 'Present' ? '' : 'disabled'}>
                                    </td>
                                    <td>
                                        <input type="time" name="attendance[${staff.staff_id}][time_out]"
                                               class="form-control time-out"
                                               value="${staff.time_out || ''}"
                                               data-id="${staff.staff_id}"
                                               ${staff.status === 'Present' ? '' : 'disabled'}>
                                    </td>

                            </tr>`;
                        });

                        attendanceContainer.innerHTML = `
                        <form method="POST" action="/staffAttendance/save">
                            @csrf
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name="csrf-token"]').getAttribute('content')}">
                            <input type="hidden" name="date" id="hidden_date" value="${date}">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Staff Name</th>
                                        <th>Status</th>
                                        <th>Time In</th>
                                        <th>Time Out</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    ${tableRows}
                                </tbody>
                            </table>
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Attendance</button>
                        </form>`;

                        document.querySelectorAll('.status-dropdown').forEach(dropdown => {
                            dropdown.addEventListener('change', function () {
                                const id = this.getAttribute('data-id');
                                const timeIn = document.querySelector(`.time-in[data-id="${id}"]`);
                                const timeOut = document.querySelector(`.time-out[data-id="${id}"]`);

                                if (this.value === 'Present') {
                                    timeIn.disabled = false;
                                    timeOut.disabled = false;
                                } else {
                                    timeIn.disabled = true;
                                    timeOut.disabled = true;
                                    timeIn.value = '';
                                    timeOut.value = '';
                                }
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching attendance data:', error);
                        attendanceContainer.innerHTML = '<p class="text-danger">Failed to load attendance. Please try again.</p>';
                    });
            }

            // Load attendance for all staff on page load
            loadAttendance();

            // Reload attendance when department or date changes
            datePicker.addEventListener('change', loadAttendance);
            departmentPicker.addEventListener('change', loadAttendance);
        });
    </script>


@endsection

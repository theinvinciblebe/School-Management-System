@extends('layout.main')

@section('content')

    <style>
        .badge-status {
            font-size: 1.2rem;   /* Adjust font size for better readability */
            padding: 0.5rem 1rem; /* Adjust padding for consistent size */
            border-radius: 8px;  /* Rounded corners for a modern look */
            width: 70px;
        }
    </style>

    <style>
        #loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="card">
        <div class="card-header">
            <h3 align="center">Attendance Management</h3>
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
                    @if($classes->isEmpty())
                        <label for="classpicker">Pick a Class:
                        <a class="text-danger ">You are not assigned to any classes.</a>
                        </label>
                    @else
                        <label for="classpicker">Pick a Class:</label>
                        <select id="classpicker" class="form-control" required>
                            <option value="" disabled {{ !$selectedClass ? 'selected' : '' }}>Select Class</option>
                            @foreach($classes as $class)
                                <option value="{{ $class->class_id }}" {{ $class->class_id == $selectedClass ? 'selected' : '' }}>
                                    {{ $class->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h4>Attendance List</h4>
            <!-- Request Edit Button -->
            @if (Auth::user()->role == 1) <!-- Teacher Only -->
            <button type="button" id="request-edit-btn" class="btn btn-warning mt-3 float-right"
                    data-toggle="modal" data-target="#requestEditModal">
                Request Edit
            </button>
            @endif
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <!-- Sections Tabs -->
                    <div id="section-tabs-container" style="display: none;">
                        <ul class="nav nav-tabs mt-3" id="sections-tab" role="tablist"></ul>
                        <div class="tab-content" id="sections-tabContent"></div>

                        <div id="loading-overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999; align-items: center; justify-content: center;">
                            <div class="spinner-border text-light" role="status" style="width: 3rem; height: 3rem;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

{{--    view atd detail--}}
    <div class="modal fade" id="attendanceModal" tabindex="-1" role="dialog" aria-labelledby="attendanceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="attendanceModalLabel">Attendance Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="attendance-details">
                        <p>Loading attendance details...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Request Edit Modal -->
    <div class="modal fade" id="requestEditModal" tabindex="-1" aria-labelledby="requestEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="requestEditModalLabel">Request Attendance Edit</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('attendance.requestEdit') }}">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="request-edit-date" name="date">

                        <div class="mb-3">
                            <label for="edit-reason" class="form-label">Reason for Edit</label>
                            <textarea class="form-control" id="edit-reason" name="reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    document.addEventListener('DOMContentLoaded', function () {

        setTimeout(function () {
            const alertBox = document.getElementById('success-alert');
            if (alertBox) {
                alertBox.style.opacity = '0'; // Start fading
                setTimeout(() => alertBox.style.display = 'none', 500); // Hide after fade
            }
        }, 4000);

        const requestEditButton = document.getElementById('request-edit-btn');
        const classPicker = document.getElementById('classpicker');
        const datePicker = document.getElementById('date_picker');
        const loadingOverlay = document.getElementById('loading-overlay');

        // Function to reload sections and students based on the selected class and date
        function reloadAttendanceData() {
            const classId = classPicker.value;
            const date = datePicker.value;

            if (!classId || !date) return;

            // Show the loading overlay
            loadingOverlay.style.display = 'flex';

            fetch(`/get-sections/${classId}`)
                .then(response => response.json())
                .then(data => {
                    const tabsContainer = document.getElementById('sections-tab');
                    const contentContainer = document.getElementById('sections-tabContent');

                    tabsContainer.innerHTML = '';
                    contentContainer.innerHTML = '';

                    if (data.sections.length === 0) {
                        tabsContainer.innerHTML = '<li class="nav-item"><span class="nav-link text-danger">No sections found</span></li>';
                        loadingOverlay.style.display = 'none';
                        return;
                    }

                    data.sections.forEach((section, index) => {
                        tabsContainer.innerHTML += `
                        <li class="nav-item">
                            <a class="nav-link ${index === 0 ? 'active' : ''}"
                                id="tab-${section.section_id}"
                                data-toggle="tab" href="#section-${section.section_id}">

                                ${section.name}
                            </a>
                        </li>`;

                        contentContainer.innerHTML += `
                        <div class="tab-pane fade ${index === 0 ? 'show active' : ''}" id="section-${section.section_id}">
                            <h5 class="mt-3">Students in ${section.name}</h5>

                            <form method="POST" action="{{ route('attendance.update') }}">
                                @csrf
                                <input type="hidden" name="class_id" value="${classId}">
                                <input type="hidden" name="date" value="${date}">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Roll</th>
                                            <th width="300px">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="students-${section.section_id}"></tbody>
                                </table>

                                <button type="submit" class="btn btn-success save-atd" id="saveAttendanceBtn">
                                    <i class="fas fa-save"></i> Save Attendance
                                </button>
                                         <!-- View Attendance Button -->
                                <button type="button" class="btn btn-info view-attendance-btn mt-3 ml-2 float-right">
                                    <i class="fas fa-eye"></i> View Attendance
                                </button>
                            </form>

                        </div>`;

                        // Fetch students for each section
                        fetch(`/get-students/${section.section_id}?date=${date}`)
                            .then(response => response.json())
                            .then(studentData => {
                                const studentsTableBody = document.getElementById(`students-${section.section_id}`);
                                studentsTableBody.innerHTML = '';

                                if (studentData.students.length === 0) {
                                    studentsTableBody.innerHTML = '<tr><td colspan="3" class="text-center">No students found</td></tr>';
                                } else {
                                    studentData.students.forEach(student => {
                                        studentsTableBody.innerHTML += `
                                        <tr>
                                            <td>${student.name}</td>
                                            <td>${student.roll}</td>
                                            <td>
                                                <select name="attendance[${student.student_class_id}][status]" class="form-control">
                                                    <option value="0" ${student.status === 0 ? 'selected' : ''}>Undefined</option>
                                                    <option value="1" ${student.status === 1 ? 'selected' : ''}>Present</option>
                                                    <option value="2" ${student.status === 2 ? 'selected' : ''}>Absent</option>
                                                    <option value="3" ${student.status === 3 ? 'selected' : ''}>Medical</option>
                                                    <option value="4" ${student.status === 4 ? 'selected' : ''}>Late</option>
                                                </select>
                                                <input type="hidden" name="attendance[${student.student_class_id}][student_class_id]" value="${student.student_class_id}">
                                            </td>
                                        </tr>`;
                                    });
                                }
                            })
                    .finally(() => {
                            // Hide the loading overlay once students are fetched
                            loadingOverlay.style.display = 'none';
                        });
                    });

                    document.getElementById('section-tabs-container').style.display = 'block';
                })
        .catch(error => {
                console.error('Error loading sections:', error);
                // Hide the loading overlay in case of an error
                loadingOverlay.style.display = 'none';
            });
        }

        // Trigger reloadAttendanceData when class or date changes
        classPicker.addEventListener('change', reloadAttendanceData);
        datePicker.addEventListener('change', reloadAttendanceData);

        // Trigger initial load if class and date are already selected
        if (classPicker.value && datePicker.value) {
            reloadAttendanceData();
        }

        // Add event listener for the Request Edit button
        requestEditButton.addEventListener('click', function () {
            // Get the selected date and class
            const selectedDate = datePicker.value;
            const selectedClass = classPicker.value;
            const activeSectionTab = document.querySelector('.nav-link.active'); // Active section tab

            if (!selectedDate || !selectedClass || !activeSectionTab) {
                alert('Please select a valid date, class, and section before requesting an edit.');
                return;
            }

            const selectedSection = activeSectionTab.getAttribute('data-section-id'); // Custom data attribute for section ID

            // Fill the hidden inputs in the modal form
            document.getElementById('request-edit-date').value = selectedDate;
            document.getElementById('request-edit-class-id').value = selectedClass;
            document.getElementById('request-edit-section-id').value = selectedSection;
        });
    });

</script>

{{--view atd--}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.addEventListener('click', function (event) {
            const button = event.target.closest('.view-attendance-btn');  // Check if the clicked element is the view button
            if (!button) return;  // Exit if it's not a view-attendance-btn

            const classId = document.getElementById('classpicker').value;  // Get class ID from the form
            const date = document.getElementById('date_picker').value;  // Get date from date picker
            const sectionName = button.closest('.tab-pane').querySelector('h5').textContent.replace("Students in ", "");  // Extract section name

            if (!classId || !date) {
                alert('Class ID or date is missing!');
                return;
            }

            const modalBody = document.getElementById('attendance-details');
            modalBody.innerHTML = '<p>Loading...</p>'; // Show loading message

            // Fetch attendance data
            fetch(`/attendance/class/${classId}/date/${date}`)
                .then(response => response.json())
                .then(data => {
                    if (data.attendance.length === 0) {
                        modalBody.innerHTML = '<p class="text-center text-muted">No attendance records found.</p>';
                        return;
                    }

                    let tableRows = '';
                    data.attendance.forEach(record => {
                        const statusClass = getStatusClass(record.status);  // Get the appropriate class for the status
                        tableRows += `
                    <tr>
                        <td>${record.student_name}</td>
                        <td>${record.roll}</td>
                        <td align="center">
                            <span class="badge badge-status ${statusClass} p-2" style="font-size: 1rem;">${getStatusText(record.status)}</span>
                        </td>
                    </tr>`;
                    });

                    modalBody.innerHTML = `
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <strong>Date:</strong> ${date}
                            </div>

                            <div class="col-4">
                                <strong>Class:</strong> ${document.querySelector(`#classpicker option[value="${classId}"]`).textContent}
                            </div>
                            <div class="col-4">
                                <strong>Section:</strong> ${sectionName}
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Roll</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableRows}
                    </tbody>
                </table>
                `;

                    $('#attendanceModal').modal('show');  // Open the modal
                })
                .catch(error => {
                    console.error('Error loading attendance:', error);
                    modalBody.innerHTML = '<p class="text-danger">Failed to load attendance. Please try again.</p>';
                });
        });

        // Function to get status text
        function getStatusText(status) {
            switch (status) {
                case 0: return 'Undefined';
                case 1: return 'Present';
                case 2: return 'Absent';
                case 3: return 'Medical';
                case 4: return 'Late';
                default: return 'Unknown';
            }
        }
        // Function to get status class for badge
        function getStatusClass(status) {
            switch (status) {
                case 0: return 'badge-secondary';  // Gray for "Undefined"
                case 1: return 'badge-success';    // Green for "Present"
                case 2: return 'badge-danger';     // Red for "Absent"
                case 3: return 'badge-info';       // Blue for "Medical"
                case 4: return 'badge-warning';    // Yellow for "Late"
                default: return 'badge-dark';      // Default dark color for "Unknown"
            }
        }

    });

</script>

{{--    <script>--}}
{{--        // Handle save button click--}}
{{--        $(document).on('click', '.save-atd', function (e) {--}}
{{--            e.preventDefault();--}}
{{--            let form = $(this).closest("form");--}}
{{--            Swal.fire({--}}
{{--                title: "Save Class Attendance",--}}
{{--                text: "Are you sure you want to save attendance?",--}}
{{--                icon: "question",--}}
{{--                showCancelButton: true,--}}
{{--                confirmButtonColor: "#3085d6",--}}
{{--                cancelButtonColor: "#d33",--}}
{{--                confirmButtonText: "Yes, save it!",--}}
{{--                inputValidator: (value) => {--}}
{{--                    // Validate the input--}}
{{--                    if (!value) {--}}
{{--                        return "You need to enter something!";--}}
{{--                    }--}}
{{--                }--}}
{{--            }).then((result) => {--}}
{{--                if (result.isConfirmed) {--}}
{{--                    $.ajax({--}}
{{--                        url: form.attr("action"),--}}
{{--                        method: form.attr("method"),--}}
{{--                        data: form.serialize(),--}}
{{--                        success: function(response) {--}}
{{--                            Swal.fire({--}}
{{--                                title: "Success",--}}
{{--                                text: "Data added successfully!",--}}
{{--                                icon: "success",--}}
{{--                                confirmButtonColor: "#3085d6",--}}
{{--                            }).then(() => {--}}
{{--                                // Redirect or reload the page--}}
{{--                                window.location.reload();--}}
{{--                            });--}}
{{--                        },--}}
{{--                        error: function(error) {--}}
{{--                            Swal.fire({--}}
{{--                                title: "Error",--}}
{{--                                text: "An error occurred while adding the data.",--}}
{{--                                icon: "error",--}}
{{--                                confirmButtonColor: "#3085d6",--}}
{{--                            });--}}
{{--                        }--}}
{{--                    });--}}
{{--                    // Redirect to the add page or perform the add action--}}
{{--                    //window.location.href = "/add-item"; // Replace with your actual URL--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

@endsection

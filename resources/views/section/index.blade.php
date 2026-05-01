@extends('layout.main')

@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Section Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('class.index') }}">Class List</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Section List
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="card">
        <div class="card-header">
            <div class="form-group">
                <label for="classSelect">Select Class</label>
                <select id="classSelect" name="classSelect" class="form-control">
                    <option value="" disabled>Select a class</option>
                    @foreach ($classes as $class)
                        <option value="{{ $class->class_id }}" {{ $loop->first ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <h3>List of Section</h3>
                </div>
                <!-- Add Section Button -->
                <button class="btn btn-primary mb-3 float-right" data-toggle="modal" data-target="#addSectionModal">
                    <i class="fa fa-plus"></i> Add Section
                </button>

                <button class="floating-button" data-toggle="modal" data-target="#addSectionModal">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="card-body">
                <div>
                    <table class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Section Name</th>
                                <th>Nick Name</th>
                                <th>Teacher</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Time In</th>
                                <th>Time Out</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody id="sectionTableBody">
                        <!-- Rows will be dynamically inserted here -->

                        </tbody>
                    </table>
                </div>
                <!-- Sections Table -->
            </div>
        </div>
    </div>

    <!-- Add Section Modal -->
    <div class="modal fade" id="addSectionModal" tabindex="-1" aria-labelledby="addSectionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('section.store') }}" method="POST" onsubmit="showOverlay()">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addSectionModalLabel">Add Section</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="section_name">Section Name</label>
                            <input type="text" class="form-control" id="section_name" name="section_name" required>
                        </div>
                        <div class="form-group">
                            <label for="nick_name">Nick Name</label>
                            <input type="text" class="form-control" id="nick_name" name="nick_name">
                        </div>
                        <div class="form-group">
                            <label for="teacher_id">Teacher</label>
                            <select class="form-control select2bs4" id="teacher_id" name="teacher_id">
                                <option value="">Select Teacher</option>
                            @foreach ($teachers as $teacher)
                                    <option value="{{ $teacher->teacher_id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- Date Range Picker -->
                        <div class="form-group">
                            <label>Date Range (Start - End):</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control float-right" id="date_range" name="date_range" autocomplete="off" placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <!-- Time Range Picker -->
                        <div class="row">
                            <!-- Start Time -->
                            <div class="col-md-6">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>Start Time:</label>
                                        <div class="input-group date" id="startTimePicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="start_time"
                                                   data-target="#startTimePicker"
                                                   autocomplete="off" placeholder="24H">
                                            <div class="input-group-append" data-target="#startTimePicker" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- End Time -->
                            <div class="col-md-6">
                                <div class="bootstrap-timepicker">
                                    <div class="form-group">
                                        <label>End Time:</label>
                                        <div class="input-group date" id="endTimePicker" data-target-input="nearest">
                                            <input type="text" class="form-control datetimepicker-input" name="end_time" data-target="#endTimePicker" autocomplete="off" placeholder="24H">
                                            <div class="input-group-append" data-target="#endTimePicker" data-toggle="datetimepicker">
                                                <div class="input-group-text"><i class="far fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="class_id" value="{{ $selectedClassId }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Section</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <script>
        $(document).ready(function () {
            $("#addSectionModal").on("show.bs.modal", function () {
                let selectedClassId = $("#classSelect").val(); // Get selected class from dropdown
                $(this).find("input[name='class_id']").val(selectedClassId); // Set hidden field in modal
            });
        });

        $(document).ready(function () {
            $(document).on("click", ".edit-section-btn", function () {
                let sectionId = $(this).data("id");
                $("#editSectionModal" + sectionId).modal("show");
            });
        });


        $(document).ready(function () {
            // Date range picker
            $('#date_range').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    format: 'YYYY-MM-DD',
                    cancelLabel: 'Clear'
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            // Initialize Start Time Picker
            $('#startTimePicker').datetimepicker({
                format: 'HH:mm',  // 24-hour format
                stepping: 5,      // 5-minute increments
                useCurrent: false // Prevent auto-filling the field
            });

            // Initialize End Time Picker
            $('#endTimePicker').datetimepicker({
                format: 'HH:mm',
                stepping: 5,
                useCurrent: false
            });

            // Prevent selecting an End Time before the Start Time
            $("#startTimePicker").on("change.datetimepicker", function (e) {
                $('#endTimePicker').datetimepicker('minDate', e.date);
            });

            // Prevent selecting a Start Time after the End Time
            $("#endTimePicker").on("change.datetimepicker", function (e) {
                $('#startTimePicker').datetimepicker('maxDate', e.date);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            $(document).on("show.bs.modal", ".modal", function () {
                let dateRangeInput = $(this).find('.date-range-picker');

                let startDate = dateRangeInput.data('start-date');
                let endDate = dateRangeInput.data('end-date');

                if (!startDate || startDate === 'N/A') startDate = moment().format('YYYY-MM-DD'); // Default to today
                if (!endDate || endDate === 'N/A') endDate = moment().add(7, 'days').format('YYYY-MM-DD'); // Default to 7 days later

                dateRangeInput.daterangepicker({
                    autoUpdateInput: false,
                    startDate: startDate,
                    endDate: endDate,
                    locale: {
                        format: 'YYYY-MM-DD',
                        cancelLabel: 'Clear'
                    }
                }).on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                }).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });

                // If the input was previously empty, show default values
                if ($(this).find('.date-range-picker').val() === '') {
                    $(this).find('.date-range-picker').val(startDate + ' - ' + endDate);
                }

                // Initialize Date Range Picker
                $(this).find('.date-range-picker').daterangepicker({
                    autoUpdateInput: false,
                    locale: {
                        format: 'YYYY-MM-DD',
                        cancelLabel: 'Clear'
                    }
                }).on('apply.daterangepicker', function(ev, picker) {
                    $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                }).on('cancel.daterangepicker', function(ev, picker) {
                    $(this).val('');
                });


                // Initialize Start Time Picker
                $(this).find('.start-time-picker').datetimepicker({
                    format: 'HH:mm',
                    stepping: 5,
                    useCurrent: false
                });

                // Initialize End Time Picker
                $(this).find('.end-time-picker').datetimepicker({
                    format: 'HH:mm',
                    stepping: 5,
                    useCurrent: false
                });

                // Ensure End Time is after Start Time
                $(this).find(".start-time-picker").on("change.datetimepicker", function (e) {
                    $(this).closest('.modal').find('.end-time-picker').datetimepicker('minDate', e.date);
                });

                $(this).find(".end-time-picker").on("change.datetimepicker", function (e) {
                    $(this).closest('.modal').find('.start-time-picker').datetimepicker('maxDate', e.date);
                });
            });
        });



    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const classSelect = document.getElementById('classSelect');
            const tableBody = document.getElementById('sectionTableBody');
            const modalContainer = document.createElement('div'); // Container for dynamic modals
            document.body.appendChild(modalContainer); // Append to the body

            if (!classSelect) return; // Exit if the dropdown doesn't exist

            // Function to fetch and display sections
            const fetchSections = (classId) => {
                // Show loading spinner
                tableBody.innerHTML = `
            <tr>
                <td colspan="9" class="text-center">
                    <i class="fa fa-spinner fa-spin"></i> Loading...
                </td>
            </tr>`;

                fetch(`/sections/${classId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to fetch sections.');
                        }
                        return response.json();
                    })
                    .then(data => {
                        //console.log(data);
                        if (!data.teachers || !Array.isArray(data.teachers)) {
                            console.error("Teachers list is missing or incorrect.");
                            return;
                        }

                        tableBody.innerHTML = ''; // Clear the table body
                        modalContainer.innerHTML = ''; // Clear previous modals

                        if (data.sections.length > 0) {
                            data.sections.forEach((section, index) => {
                                // Generate table row
                                const row = document.createElement('tr');
                                row.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${section.section_name || 'N/A'}</td>
                            <td>${section.nick_name || 'N/A'}</td>
                            <td>${section.teacher_name || 'No Teacher Assigned'}</td>
                            <td>${section.start_date || 'N/A'}</td>
                            <td>${section.end_date || 'N/A'}</td>
                            <td>${section.time_in || 'N/A'}</td>
                            <td>${section.time_out || 'N/A'}</td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <button type="button" class="dropdown-item text-primary edit-section-btn"
                                            data-id="${section.section_id}"
                                            data-toggle="modal"
                                            data-target="#editSectionModal${section.section_id}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <div class="dropdown-divider"></div>
                                        <form action="/section/destroy/${section.section_id}" method="POST" class="delete-form">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="dropdown-item text-danger delete-btn">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        `;
                                tableBody.appendChild(row);

                                // Generate edit modal for this section
                                const modal = document.createElement('div');
                                modal.innerHTML = `
                            <div class="modal fade" id="editSectionModal${section.section_id}" tabindex="-1" aria-labelledby="editSectionModalLabel${section.section_id}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="/section/update/${section.section_id}" method="POST" onsubmit="showOverlay()">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="PUT">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editSectionModalLabel${section.section_id}">Edit Section</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="section_name">Section Name</label>
                                                    <input type="text" class="form-control" id="section_name" name="section_name" value="${section.section_name}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="nick_name">Nick Name</label>
                                                    <input type="text" class="form-control" id="nick_name" name="nick_name" value="${section.nick_name || ''}">
                                                </div>
                                                <div class="form-group">
                                                    <label for="teacher_id">Teacher</label>
                                                    <select class="form-control teacher-select" name="teacher_id">
                                                        <option value="">No Teacher Assigned</option>
                                                        ${data.teachers.map(teacher => `
                                                            <option value="${teacher.teacher_id}" ${teacher.teacher_id == section.teacher_id ? 'selected' : ''}>
                                                                ${teacher.name}
                                                            </option>
                                                        `).join('')}
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>Date Range (Start - End):</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                                        </div>
                                        <input type="text" class="form-control date-range-picker"
                                           name="date_range"
                                           data-start-date="${section.start_date && section.start_date !== 'N/A' ? section.start_date : ''}"
                                           data-end-date="${section.end_date && section.end_date !== 'N/A' ? section.end_date : ''}"
                                           value="${section.start_date && section.end_date && section.start_date !== 'N/A' && section.end_date !== 'N/A'
                                                                        ? section.start_date + ' - ' + section.end_date : ''}" placeholder="YYYY-MM-DD">

                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="bootstrap-timepicker">
                                                            <div class="form-group">
                                                                <label>Start Time:</label>
                                                                <div class="input-group date start-time-picker" data-target-input="nearest">
                                                                    <input type="text" class="form-control time-picker"
                                                                           name="start_time" data-target=".start-time-picker"
                                                                           value="${section.time_in || ''}" placeholder="24H">
                                                                    <div class="input-group-append" data-target=".start-time-picker" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="bootstrap-timepicker">
                                                            <div class="form-group">
                                                                <label>End Time:</label>
                                                                <div class="input-group date end-time-picker" data-target-input="nearest">
                                                                    <input type="text" class="form-control time-picker"
                                                                           name="end_time" data-target=".end-time-picker"
                                                                           value="${section.time_out || ''}" placeholder="24H">
                                                                    <div class="input-group-append" data-target=".end-time-picker" data-toggle="datetimepicker">
                                                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                        `;
                                modalContainer.appendChild(modal);

                                // Initialize date and time pickers for the modal
                                // $(modal).find('.date-range-picker').daterangepicker({
                                //     autoUpdateInput: false,
                                //     locale: {
                                //         format: 'YYYY-MM-DD',
                                //         cancelLabel: 'Clear'
                                //     }
                                // });
                                //
                                // $(modal).find('.time-picker').datetimepicker({
                                //     format: 'HH:mm',
                                //     stepping: 5,
                                //     useCurrent: false
                                // });
                            });
                        } else {
                            tableBody.innerHTML = `
                        <tr>
                            <td colspan="9" class="text-center">No sections found for this class.</td>
                        </tr>`;
                        }
                    })
                    .catch(error => {
                        console.error(error);

                        tableBody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center text-danger">Error loading sections.</td>
                    </tr>`;
                    });
            };

            // Trigger the change event on page load
            if (classSelect.value) {
                fetchSections(classSelect.value); // Fetch sections for the first class
            }

            // Add event listener for manual class selection
            classSelect.addEventListener('change', function () {
                const classId = this.value;
                if (classId) {
                    fetchSections(classId);
                } else {
                    tableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="text-center">Please select a class.</td>
                </tr>`;
                }
            });
        });
    </script>



@endsection

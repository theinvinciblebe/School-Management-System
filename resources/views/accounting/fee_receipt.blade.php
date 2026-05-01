@extends('layout.main')

@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Fee Receipt List</h3>
            </div>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addFeeReceiptModal">
                <i class="fas fa-plus-square"></i>
                Make New Fee Receipt
            </button>
            <button type="button" class="floating-button" data-toggle="modal" data-target="#addFeeReceiptModal">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <div class="card-body">
            <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" width="50px" aria-controls="example1" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Student Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Gender</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Roll</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Class</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Section</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Section Duration</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Receipt No</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Receipt Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Start Date</th>
                                <th>Approvement</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($fees as $index => $item)
                                <tr class="odd">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->student_name }}</td>
                                    <td>
                                        @if($item->sex)
                                            Male
                                        @else
                                            Female
                                        @endif
                                    </td>
                                    <td>{{ $item->roll }}</td>
                                    <td>{{ $item->class_name  ?? 'N/A'}}</td>
                                    <td>{{ $item->section_name ?? 'N/A' }}</td>
                                    <td>{{ $item->section_duration_months ?? 'N/A'}} Months</td>
                                    <td>{{ $item->receipt_no }}</td>
                                    <td>{{ $item->receipt_date }}</td>
                                    <td>{{ $item->start_date ?? 'N/A'}}</td>
                                    <td>
                                        @if(Auth::user()->role == 0 && $item->status == 'pending')
                                            <button class="btn btn-success btn-sm approve-btn" data-id="{{ $item->receipt_id  }}"><i class="fas fa-check"></i> Approve</button>
                                            <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $item->receipt_id  }}"><i class="fas fa-times"></i> Reject</button>
                                        @elseif($item->status == 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($item->status == 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Actions</button>
                                            <div class="dropdown-menu dropdown-menu-right">

                                                @if ( Auth::user()->role == 0 ||
                                                      ((Auth::user()->role == 3 || Auth::user()->role == 4) && $item->status == 'approved')
                                                  )
                                                    <!-- View Request Button -->
                                                    <a href="{{ route('fee_receipt.show', $item->receipt_id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                @endif

                                                @if(Auth::user()->role !=4 )
                                                <!-- Edit Button -->
                                                <button class="btn btn-warning btn-sm edit-btn"
                                                        data-id="{{ $item->receipt_id }}"
                                                        data-student-id="{{ $item->student_class_id }}"
                                                        data-name="{{ $item->student_name }}"
                                                        data-sex="{{ $item->sex }}"
                                                        data-roll="{{ $item->roll }}"
                                                        data-receipt-no="{{ $item->receipt_no }}"
                                                        data-class="{{ $item->class_name }}"
                                                        data-section="{{ $item->section_name }}"
                                                        data-duration="{{ $item->section_duration_months }}"
                                                        data-receipt-date="{{ $item->receipt_date }}"
                                                        data-start-date="{{ $item->start_date }}"
                                                        {{-- data-paid="{{ $item->paid }}"--}}
                                                        {{-- data-previous-balance="{{ $item->previous_balance }}"--}}
                                                        data-toggle="modal" data-target="#editFeeModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <div class="dropdown-divider"></div>

                                                <!-- Delete Button -->
                                                <form action="{{ route('fee_receipt.destroy', $item->receipt_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                                    @endif
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="modal fade" id="editFeeModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Fee Receipt</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editForm" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" id="edit_id">

                                            <div class="row">
                                                <label for="edit_student_class_id" class="form-label">Student</label>
                                                <select name="student_class_id" id="edit_student_class_id" class="form-control" required>
                                                    <option value="" disabled>Select Student</option>
                                                    @foreach($students as $student)
                                                        <option value="{{ $student->student_class_id }}">
                                                            {{ $student->student_name }} - Roll: {{ $student->roll }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <input type="hidden" id="edit_student_name">

                                            </div>
                                            <hr class="border border-primary border-3 opacity-75">

                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label>Sex:</label>
                                                    <input type="text" id="edit_sex" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Receipt No:</label>
                                                    <input type="text" id="edit_receipt_no" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Roll No:</label>
                                                    <input type="text" id="edit_roll" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Class:</label>
                                                    <input type="text" id="edit_class" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Section:</label>
                                                    <input type="text" id="edit_section" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Duration:</label>
                                                    <input type="text" id="edit_section_duration" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-md-6">
                                                    <label for="date" class="form-label">Receipt Date</label>
                                                    <input type="date" id="edit_receipt_date" class="form-control" name="date" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label>Previous Balance:</label>
                                                    <input type="number" step="0.01" id="edit_previous_balance" name="previous_balance" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Paid Amount:</label>
                                                    <input type="number" step="0.01" id="edit_paid" name="paid" class="form-control">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Paid Via:</label>
                                                        <select class="form-control" id="edit_paid_via" name="paid_via">
                                                            <option value="Cash">Cash</option>
                                                            <option value="Bank Transfer">Bank Transfer</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Remaining Balance:</label>
                                                    <input type="number" step="0.01" id="edit_remaining_balance" name="remaining_balance" class="form-control" readonly>
                                                </div>
                                            </div>
                                            <hr class="border border-primary border-3 opacity-75">
                                            <table class="table" id="editItemsTable">
                                                <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Discount</th>
                                                    <th>Duration</th>
                                                    <th>Total Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="editItemsBody">
                                                </tbody>
                                            </table>

                                            <button type="button" class="btn btn-success" id="addEditItem"><i class="fas fa-plus-square"></i> Item</button>

                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>

    <!-- Add Fee Receipt Modal -->
    <div class="modal fade" id="addFeeReceiptModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Create New Fee Receipt</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fee_receipt.store') }}" method="POST">
                        @csrf

                        <!-- Hidden Receipt No (Auto-generated) -->
                        <input type="hidden" name="receipt_no" id="receipt_no" value="{{ 'REC-' . substr(uniqid(), -6) }}">

                        <div class="row">
                            <!-- Select Student -->
                            <label for="student_class_id" class="form-label">Student</label>
                            <select name="student_class_id" id="student_class_id" class="form-control" required>
                                <option value="">Select Student</option>
                                @foreach($students as $student)
                                    <option value="{{ $student->student_class_id }}">
                                        {{ $student->student_name }} - Roll: {{ $student->roll }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Hidden Fields to Store Student Data -->
                            <input type="hidden" id="student_name">
                            <input type="hidden" id="student_sex">
                            <input type="hidden" id="student_roll">
                            <input type="hidden" id="student_class">
                            <input type="hidden" id="student_section">
                            <input type="hidden" id="student_section_duration">

                            <!-- Display Student Details -->
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label>Sex:</label>
                                    <input type="text" id="display_sex" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Roll No:</label>
                                    <input type="text" id="display_roll" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Class:</label>
                                    <input type="text" id="display_class" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Section:</label>
                                    <input type="text" id="display_section" class="form-control" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label>Paid:</label>
                                    <input type="number" step="0.01" name="paid" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Paid Via:</label>
                                        <select class="form-control" name="paid_via">
                                            <option value="Cash">Cash</option>
                                            <option value="Bank Transfer">Bank Transfer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Section Duration (Months):</label>
                                    <input type="text" id="display_section_duration" class="form-control">
                                </div>

                                <!-- Receipt Date -->
                                <div class="col-md-6">
                                    <label for="date" class="form-label">Receipt Date</label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="previous_balance" class="form-label">Previous Balance</label>
                                    <input type="number" class="form-control" name="previous_balance" id="previous_balance" readonly>
                                </div>

                            </div>
                        </div>

                        <hr class="border border-primary border-3 opacity-75">

                        <!-- Fee Receipt Items Table -->
                        <table class="table" id="feeItemsTable">
                            <thead>
                            <tr>
                                <th>Description</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>Duration</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="feeItemsBody">
                            <tr>
                                <td><input type="text" name="items[0][description]" class="form-control" required></td>
                                <td><input type="number" name="items[0][qty]" class="form-control qty" required></td>
                                <td><input type="number" step="0.01" name="items[0][price]" class="form-control price" required></td>
                                <td><input type="text" name="items[0][discount]" class="form-control"></td>
                                <td><input type="text" name="items[0][duration]" class="form-control"></td>
                                <td><input type="number" step="0.01" name="items[0][total]" class="form-control total" readonly></td>
                                <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="addFeeItem"><i class="fas fa-plus-square"></i> Add Item</button>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save Receipt</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{--    select student - add--}}
    <script>
        document.getElementById('student_class_id').addEventListener('change', function () {
            let studentId = this.value;
            if (studentId) {
                fetch(`/get-student-details/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('student_sex').value = data.sex;
                        document.getElementById('student_roll').value = data.roll;
                        document.getElementById('student_class').value = data.class_name;
                        document.getElementById('student_section').value = data.section_name;
                        document.getElementById('student_section_duration').value = data.section_duration_months;

                        // Display values in readonly inputs
                        document.getElementById('display_sex').value = data.sex === 1 ? 'Male' : 'Female';
                        document.getElementById('display_roll').value = data.roll;
                        document.getElementById('display_class').value = data.class_name;
                        document.getElementById('display_section').value = data.section_name;
                        document.getElementById('display_section_duration').value = data.section_duration_months + " Months";

                        document.getElementById("previous_balance").value = data.previous_balance ?? 0;

                    })
                    .catch(error => console.error('Error fetching student details:', error));
            } else {
                // Clear inputs if no student selected
                document.getElementById('student_name').value = "";
                document.getElementById('student_sex').value = "";
                document.getElementById('student_roll').value = "";
                document.getElementById('student_class').value = "";
                document.getElementById('student_section').value = "";
                document.getElementById('student_section_duration').value = "";

                document.getElementById('display_sex').value = "";
                document.getElementById('display_roll').value = "";
                document.getElementById('display_class').value = "";
                document.getElementById('display_section').value = "";
                document.getElementById('display_section_duration').value = "";

                document.getElementById('previous_balance').value = 0;
            }
        });

    </script>

    {{--    select student - edit--}}
    <script>
        document.getElementById('edit_student_class_id').addEventListener('change', function () {
            let studentId = this.value;
            if (studentId) {
                fetch(`/get-student-details/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('edit_student_name').value = data.student_name;
                        document.getElementById('edit_roll').value = data.roll;
                        document.getElementById('edit_class').value = data.class_name;
                        document.getElementById('edit_section').value = data.section_name;
                        document.getElementById('edit_section_duration').value = data.section_duration_months + " Months";
                        document.getElementById('edit_sex').value = data.sex === 1 ? 'Male' : 'Female';
                    })
                    .catch(error => console.error('Error fetching student details:', error));
            } else {
                // Clear inputs if no student selected
                document.getElementById('edit_student_class_id').value = "";
                document.getElementById('edit_sex').value = "";
                document.getElementById('edit_roll').value = "";
                document.getElementById('edit_class').value = "";
                document.getElementById('edit_section').value = "";
                document.getElementById('edit_section_duration').value = "";
            }
        });

    </script>

    <script>
        let feeItemCount = 1;

        document.getElementById('addFeeItem').addEventListener('click', function() {
            let newRow = `
            <tr>
                <td><input type="text" name="items[${feeItemCount}][description]" class="form-control" required></td>
                <td><input type="number" name="items[${feeItemCount}][qty]" class="form-control qty" required></td>
                <td><input type="number" step="0.01" name="items[${feeItemCount}][price]" class="form-control price" required></td>
                <td><input type="text" name="items[${feeItemCount}][discount]" class="form-control"></td>
                <td><input type="text" name="items[${feeItemCount}][duration]" class="form-control"></td>
                <td><input type="number" step="0.01" name="items[${feeItemCount}][total]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
            </tr>
        `;
            document.getElementById('feeItemsBody').insertAdjacentHTML('beforeend', newRow);
            feeItemCount++;

            attachEventListeners(); // Attach event listeners for calculation
        });

        // Remove Item Function
        document.getElementById('feeItemsBody').addEventListener('click', function(e) {
            if (e.target.classList.contains('removeItem')) {
                e.target.closest('tr').remove();
            }
        });

        // Function to calculate total price dynamically
        function calculateTotal(input) {
            let row = input.closest('tr'); // Get the current row
            let qty = parseFloat(row.querySelector('.qty').value) || 0;
            let price = parseFloat(row.querySelector('.price').value) || 0;
            let totalField = row.querySelector('.total');

            let total = qty * price;
            totalField.value = total.toFixed(2); // Update total price
        }

        // Attach event listeners to all rows
        function attachEventListeners() {
            document.querySelectorAll('.qty, .price').forEach(input => {
                input.addEventListener('input', function() {
                    let row = this.closest('tr'); // Get the current row
                    calculateTotal(row);
                });
            });
        }
        // Attach event listeners to existing rows on page load
        attachEventListeners();
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // Add Item in Edit Modal
            document.getElementById('addEditItem').addEventListener('click', function() {
                let tbody = document.getElementById('editItemsBody');
                let currentItemCount = tbody.querySelectorAll('tr').length; // Correctly count existing rows

                let newRow = document.createElement('tr');

                newRow.innerHTML = `
            <tr>
                <td><input type="hidden" name="items[${currentItemCount}][id]" value="">
                    <input type="text" name="items[${currentItemCount}][description]" class="form-control" required></td>
                <td><input type="number" name="items[${currentItemCount}][qty]" class="form-control qty" required></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][price]" class="form-control price" required></td>
                <td><input type="text" name="items[${currentItemCount}][discount]" class="form-control"></td>
                <td><input type="text" name="items[${currentItemCount}][duration]" class="form-control"></td>
                <td><input type="number" step="0.01" name="items[${currentItemCount}][total]" class="form-control total" readonly></td>
                <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
            </tr>
        `;
                tbody.appendChild(newRow);

                attachEventListeners(); // Attach event listeners for calculation
            });

            // Remove Item in Edit Modal (Uses Event Delegation)
            document.getElementById('editItemsTable').addEventListener('click', function(event) {
                if (event.target.classList.contains('removeItem')) {
                    event.target.closest('tr').remove();
                }
            });
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');

                    fetch(`/fee-receipt/${id}/edit`)
                        .then(response => response.json())
                        .then(data => {
                            let fee = data.fee;

                            document.getElementById('edit_id').value = fee.receipt_id;
                            document.getElementById('edit_student_class_id').value = fee.student_class_id;
                            document.getElementById('edit_sex').value = fee.sex === 1 ? 'Male' : 'Female';
                            document.getElementById('edit_roll').value = fee.roll;
                            document.getElementById('edit_receipt_no').value = fee.receipt_no;
                            document.getElementById('edit_class').value = fee.class_name;
                            document.getElementById('edit_section').value = fee.section_name;
                            document.getElementById('edit_section_duration').value = fee.section_duration_months + " Months";
                            document.getElementById('edit_receipt_date').value = fee.receipt_date;
                            document.getElementById('edit_paid').value = fee.paid || 0;
                            document.getElementById('edit_paid_via').value = fee.paid_via;
                            document.getElementById('edit_previous_balance').value = fee.remaining_balance || 0;
                            document.getElementById('edit_remaining_balance').value = fee.previous_balance || 0;

                            let tbody = document.getElementById('editItemsBody');
                            tbody.innerHTML = '';

                            data.items.forEach((item, index) => {
                                let newRow = document.createElement('tr');
                                newRow.innerHTML += `
                        <tr>
                            <td><input type="hidden" name="items[${index}][id]" value="${item.id}">
                                <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}" required></td>
                            <td><input type="number" name="items[${index}][qty]" class="form-control qty" value="${item.qty}" required></td>
                            <td><input type="text" name="items[${index}][price]" class="form-control price" value="${item.price}" required></td>
                            <td><input type="text" name="items[${index}][discount]" class="form-control discount" value="${item.discount || ''}"></td>
                            <td><input type="text" name="items[${index}][duration]" class="form-control duration" value="${item.duration || ''}"></td>
                            <td><input type="number" step="0.01" name="items[${index}][total]" class="form-control total_price" value="${item.total}" readonly></td>
                            <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
                        </tr>
                    `;
                                tbody.appendChild(newRow);
                            });
                            attachEventListeners(); // Attach event listeners for calculation

                            // Show the modal
                            $('#editFeeModal').modal('show');
                        })
                        .catch(error => {
                            console.error("Error fetching fee receipt:", error);
                            alert("Failed to load fee receipt details.");
                        });
                });
            });

            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let id = this.getAttribute('data-id');

                    if (confirm("Are you sure you want to approve this fee receipt?")) {
                    fetch(`/fee-receipt/${id}/approve`, {
                        method: 'PUT',
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    })
                        .then(response => response.json())
                        .then(data => {
                            alert(data.success);
                            location.reload();
                        })
                        .catch(error => console.error('Error approving:', error));
                    }
                });
            });

            document.querySelectorAll('.reject-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let id = this.getAttribute('data-id');

                    if (confirm("Are you sure you want to reject this fee receipt?")) {
                        fetch(`/fee-receipt/${id}/reject`, {
                            method: 'PUT',
                            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                        })
                            .then(response => response.json())
                            .then(data => {
                                alert(data.success);
                                location.reload();
                            })
                            .catch(error => console.error('Error rejecting:', error));
                    }
                });
            });

        });
    </script>

    <script>
        document.getElementById('editForm').addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent default form submission

            let formData = new FormData(this);
            let id = document.getElementById('edit_id').value;

            fetch(`/fee-receipt/${id}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'X-HTTP-Method-Override': 'PUT'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Fee receipt updated successfully!");
                        location.reload();
                    } else {
                        alert("Error updating fee receipt!");
                    }
                })
                .catch(error => {
                    console.error("Update error:", error);
                    alert("Failed to update fee receipt.");
                });
        });
    </script>




@endsection

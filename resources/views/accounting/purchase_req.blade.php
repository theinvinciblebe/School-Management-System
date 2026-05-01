@extends('layout.main')
@section('content')

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3>Purchased Request List</h3>
            </div>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#addPurchaseRequestModal">
                <i class="fas fa-plus-square"></i>
                Make New Purchase Request
            </button>

            <button type="button" class="floating-button" data-toggle="modal" data-target="#addPurchaseRequestModal">
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
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">Requisitioned</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Department</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Purpose</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Vendor</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Total</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Date Prepared</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Date Needed</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">Approvement</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($purchases as $index => $item)
                                <tr class="odd">
                                    <td class="dtr-control" tabindex="0">{{ $index + 1 }}</td>
                                    <td class="sorting_1">{{ $item->requisitioner }}</td>
                                    <td>{{ $item->department ?? 'N/A'}}</td>
                                    <td>{{ $item->purpose ?? 'N/A' }} </td>
                                    <td>{{ $item->vendor ?? 'N/A' }} </td>
                                    <td>{{ $item->total ?? 'N/A' }} </td>
                                    <td>{{ $item->date_prepared }}</td>
                                    <td>{{ $item->date_needed ?? 'N/A' }}</td>
                                    <td>
                                        @if(Auth::user()->role == 0 && $item->status == 'pending')
                                            <button class="btn btn-success btn-sm approve-btn" data-id="{{ $item->id  }}"><i class="fas fa-check"></i> Approve</button>
                                            <button class="btn btn-danger btn-sm reject-btn" data-id="{{ $item->id  }}"><i class="fas fa-times"></i> Reject</button>
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
                                                <!-- View Request Button -->
                                                @if (
                                                    Auth::user()->role == 0 ||
                                                    ((Auth::user()->role == 3 || Auth::user()->role == 4) && $item->status == 'approved')
                                                )
                                                    <a href="{{ route('purchase_req.show', $item->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> View
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                @endif

                                                @if(Auth::user()->role != 4)
                                                <!-- Edit Button -->
                                                <button class="btn btn-warning btn-sm edit-btn"
                                                        data-id="{{ $item->id }}"
                                                        data-requisitioner="{{ $item->requisitioner }}"
                                                        data-department="{{ $item->department }}"
                                                        data-purpose="{{ $item->purpose }}"
                                                        data-vendor="{{ $item->vendor }}"
                                                        data-date_prepared="{{ $item->date_prepared }}"
                                                        data-date_needed="{{ $item->date_needed }}"
                                                        data-toggle="modal" data-target="#editPurchaseRequestModal">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <div class="dropdown-divider"></div>

                                                <!-- Delete Button -->
                                                <form action="{{ route('purchase_req.destroy', $item->id) }}" method="POST" class="d-inline">
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

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editPurchaseRequestModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Purchase Request</h5>
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
                                                <div class="col-md-6">
                                                    <label for="edit_requisitioner" class="form-label">Requisitioner</label>
                                                    <select name="requisitioner" id="edit_requisitioner" class="form-control" required>
                                                        <option value="">Select Requisitioner</option>
                                                        @foreach($staffs as $staff)
                                                            <option value="{{ $staff->name }}" data-department="{{ $staff->department_name }}">
                                                                {{ $staff->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="edit_department" class="form-label">Department</label>
                                                    <input type="text" class="form-control" name="department" id="edit_department" required readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="edit_vendor" class="form-label">Vendor</label>
                                                    <input type="text" class="form-control" name="vendor" id="edit_vendor"></div>
                                                <div class="col-md-6">
                                                    <label for="edit_purpose" class="form-label">Purpose</label>
                                                    <textarea class="form-control" name="purpose" id="edit_purpose"></textarea>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="edit_date_prepared" class="form-label">Date Prepared</label>
                                                    <input type="date" class="form-control" name="date_prepared" id="edit_date_prepared" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="edit_date_needed" class="form-label">Date Needed</label>
                                                    <input type="date" class="form-control" name="date_needed" id="edit_date_needed">
                                                </div>
                                            </div>

                                            <hr class="border border-primary border-3 opacity-75">

                                            <table class="table" id="editItemsTable">
                                                <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Qty</th>
                                                    <th>Unit</th>
                                                    <th>Unit Price</th>
                                                    <th>Total Price</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody id="editItemsBody">
                                                <!-- Items will be inserted dynamically -->
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

    <!--Add Modal -->
    <div class="modal fade" id="addPurchaseRequestModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add Purchase Request</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('purchase_req.store') }}" method="POST">
                        @csrf
                        <!-- Hidden Request No (Auto-generated) -->
                        <input type="hidden" name="request_no" id="request_no" value="{{ 'REQ-' . substr(uniqid(), -6) }}">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="requisitioner" class="form-label">Requisitioner</label>
                                <select name="requisitioner" id="requisitioner" class="form-control" required>
                                    <option value="">Select Requisitioner</option>
                                    @foreach($staffs as $staff)
                                        <option value="{{ $staff->name }}" data-department="{{ $staff->department_name }}">
                                            {{ $staff->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" name="department" id="department" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="vendor" class="form-label">Vendor</label>
                                <input type="text" class="form-control" name="vendor">
                            </div>
                            <div class="col-md-6">
                                <label for="purpose" class="form-label">Purpose</label>
                                <textarea class="form-control" name="purpose"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="date_prepared" class="form-label">Date Prepared</label>
                                <input type="date" class="form-control" name="date_prepared" required>
                            </div>
                            <div class="col-md-6">
                                <label for="date_needed" class="form-label">Date Needed</label>
                                <input type="date" class="form-control" name="date_needed">
                            </div>
                        </div>

                        <hr class="border border-primary border-3 opacity-75">

                        <!-- Dynamic Items -->
                        <table class="table" id="itemsTable">
                            <thead>
                            <tr>
                                <th>Description</th>
{{--                                <th>Asset Class</th>--}}
                                <th>Qty</th>
                                <th>Unit</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody id="itemsBody">
                            <tr>
                                <td><input type="text" name="items[0][description]" class="form-control" required></td>
{{--                                <td><input type="text" name="items[0][asset_class]" class="form-control"></td>--}}
                                <td><input type="number" name="items[0][qty]" class="form-control qty" required></td>
                                <td><input type="text" name="items[0][unit]" class="form-control"></td>
                                <td><input type="number" step="0.01" name="items[0][unit_price]" class="form-control unit_price" required></td>
                                <td><input type="number" step="0.01" name="items[0][total_price]" class="form-control total_price" readonly></td>
                                <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
                            </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-success" id="addItem"><i class="fas fa-plus-square"></i> Item</button>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary"><i class="far fa-save"></i> Save</button>
                        </div>
                    </form>

                    <script>
                        let itemCount = 1;

                        document.getElementById('addItem').addEventListener('click', function() {
                            let newRow = `
                                <tr>
                                    <td><input type="text" name="items[${itemCount}][description]" class="form-control" required></td>
                                    <td><input type="number" name="items[${itemCount}][qty]" class="form-control qty" required></td>
                                    <td><input type="text" name="items[${itemCount}][unit]" class="form-control"></td>
                                    <td><input type="number" step="0.01" name="items[${itemCount}][unit_price]" class="form-control unit_price" required></td>
                                    <td><input type="number" step="0.01" name="items[${itemCount}][total_price]" class="form-control total_price" readonly></td>
                                    <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
                                </tr>
                            `;
                            document.getElementById('itemsBody').insertAdjacentHTML('beforeend', newRow);
                            itemCount++;
                            // Attach event listeners for the newly added row
                            attachEventListeners();
                        });

                        // Remove Item Function
                        document.getElementById('itemsBody').addEventListener('click', function(e) {
                            if (e.target.classList.contains('removeItem')) {
                                e.target.closest('tr').remove();
                            }
                        });

                        // Function to calculate total price dynamically
                        function calculateTotal(input) {
                            let row = input.closest('tr'); // Get the current row
                            let qty = parseFloat(row.querySelector('.qty').value) || 0;
                            let unitPrice = parseFloat(row.querySelector('.unit_price').value) || 0;
                            let totalPriceField = row.querySelector('.total_price');

                            let total = qty * unitPrice;
                            totalPriceField.value = total.toFixed(2); // Update total price
                        }

                        // Attach event listeners to all rows
                        function attachEventListeners() {
                            document.querySelectorAll('.qty, .unit_price').forEach(input => {
                                input.addEventListener('input', function() {
                                    let row = this.closest('tr'); // Get the current row
                                    calculateTotal(row);
                                });
                            });
                        }
                        // Attach event listeners to existing rows on page load
                        attachEventListeners();

                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('edit_requisitioner').addEventListener('change', function () {
            let selectedOption = this.options[this.selectedIndex];
            document.getElementById('edit_department').value = selectedOption.getAttribute('data-department') || '';
        });


        // Function to set values when opening the update modal
        function openUpdateModal(requisitionerName, departmentName) {
            let requisitionerSelect = document.getElementById('edit_requisitioner');
            let departmentInput = document.getElementById('edit_department');

            // Set the selected requisitioner
            for (let i = 0; i < requisitionerSelect.options.length; i++) {
                if (requisitionerSelect.options[i].value === requisitionerName) {
                    requisitionerSelect.options[i].selected = true;
                    break;
                }
            }

            // Set the department field
            departmentInput.value = departmentName;
        }
    </script>


    <script>
        document.getElementById('requisitioner').addEventListener('change', function () {
            let selectedName = this.value;
            if (selectedName) {
                fetch(`/get-department/${selectedName}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('department').value = data.department || 'N/A';
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                document.getElementById('department').value = '';
            }
        });
    </script>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Add Item in Edit Modal
            document.getElementById('addEditItem').addEventListener('click', function() {
                let tbody = document.getElementById('editItemsBody');
                let currentItemCount = tbody.querySelectorAll('tr').length; // Correctly count existing rows

                let newRow = document.createElement('tr');
                newRow.innerHTML = `
            <td><input type="hidden" name="items[${currentItemCount}][id]" value="">
                <input type="text" name="items[${currentItemCount}][description]" class="form-control" required></td>
            <td><input type="number" name="items[${currentItemCount}][qty]" class="form-control qty" required></td>
            <td><input type="text" name="items[${currentItemCount}][unit]" class="form-control"></td>
            <td><input type="number" step="0.01" name="items[${currentItemCount}][unit_price]" class="form-control unit_price" required></td>
            <td><input type="number" step="0.01" name="items[${currentItemCount}][total_price]" class="form-control total_price" readonly></td>
            <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
        `;

                tbody.appendChild(newRow);
                attachEventListeners(); // Ensure the new row has event listeners
            });

            // Remove Item in Edit Modal (Event Delegation)
            document.getElementById('editItemsTable').addEventListener('click', function(event) {
                if (event.target.classList.contains('removeItem')) {
                    event.target.closest('tr').remove();
                }
            });

            // Function to calculate total price dynamically
            function calculateTotal(input) {
                let row = input.closest('tr');
                let qty = parseFloat(row.querySelector('.qty').value) || 0;
                let unitPrice = parseFloat(row.querySelector('.unit_price').value) || 0;
                let totalPriceField = row.querySelector('.total_price');

                totalPriceField.value = (qty * unitPrice).toFixed(2);
            }

            // Attach event listeners to all rows
            function attachEventListeners() {
                document.querySelectorAll('.qty, .unit_price').forEach(input => {
                    input.addEventListener('input', function() {
                        calculateTotal(this);
                    });
                });
            }

            // Attach event listeners to existing rows on page load
            attachEventListeners();

            // Load Items into the Edit Modal
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');

                    document.getElementById('edit_id').value = id;
                    document.getElementById('edit_requisitioner').value = this.getAttribute('data-requisitioner');
                    document.getElementById('edit_department').value = this.getAttribute('data-department');
                    document.getElementById('edit_purpose').value = this.getAttribute('data-purpose');
                    document.getElementById('edit_date_prepared').value = this.getAttribute('data-date_prepared');
                    document.getElementById('edit_date_needed').value = this.getAttribute('data-date_needed');

                    document.getElementById('editForm').action = `/purchase-req/${id}`;

                    // Fetch existing items
                    fetch(`/purchase-requests/${id}/items`)
                        .then(response => response.json())
                        .then(data => {
                            let tbody = document.getElementById('editItemsBody');
                            tbody.innerHTML = ''; // Clear old items

                            data.forEach((item, index) => {
                                let newRow = document.createElement('tr');
                                newRow.innerHTML = `
                            <td><input type="hidden" name="items[${index}][id]" value="${item.id}">
                                <input type="text" name="items[${index}][description]" class="form-control" value="${item.description}" required></td>
                            <td><input type="number" name="items[${index}][qty]" class="form-control qty" value="${item.qty}" required></td>
                            <td><input type="text" name="items[${index}][unit]" class="form-control" value="${item.unit || ''}"></td>
                            <td><input type="number" step="0.01" name="items[${index}][unit_price]" class="form-control unit_price" value="${item.unit_price}" required></td>
                            <td><input type="number" step="0.01" name="items[${index}][total_price]" class="form-control total_price" value="${item.total_price}" readonly></td>
                            <td><button type="button" class="btn btn-danger removeItem"><i class="far fa-trash-alt"></i></button></td>
                        `;
                                tbody.appendChild(newRow);
                            });

                            attachEventListeners(); // Ensure event listeners are reattached
                        })
                        .catch(error => {
                            console.error("Error fetching items:", error);
                            document.getElementById('editItemsBody').innerHTML = `<tr><td colspan="7" class="text-center text-danger">No items found</td></tr>`;
                        });
                });
            });

            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function () {
                    let id = this.getAttribute('data-id');

                    if (confirm("Are you sure you want to approve this fee receipt?")) {
                        fetch(`/purchase-req/${id}/approve`, {
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
                        fetch(`/purchase-req/${id}/reject`, {
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


@endsection

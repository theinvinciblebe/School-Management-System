@extends('layout.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>Profits & Expenses</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">
                            Profits & Expenses
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->

    </section>

    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h3><i class="fas fa-scroll"></i> Profits & Expenses List</h3><br>
                <h4>Year</h4>

                <select id="year-filter" class="form-control mb-3 w-48">
                    @foreach( $years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <!-- Add Button -->
            @if (Auth::user()->role == 0 || Auth::user()->role == 3) <!-- Admin Only -->

            <a class="floating-button" data-toggle="modal" data-target="#createTransactionModal">
                <i class="fa fa-plus"></i>
            </a>
            @endif
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="Profitdata_wrapper" class="dataTables_wrapper dt-bootstrap4">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="Profitdata" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                            <thead>
                            <tr>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">#</th>
                                <th class="sorting sorting_desc" tabindex="0" aria-controls="example1" rowspan="1" colspan="1" aria-sort="descending">Type</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Category</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Date</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Amount $</th>
                                <th class="sorting" tabindex="0" aria-controls="example1" rowspan="1" colspan="1">Note</th>
                                <th tabindex="0" aria-controls="example1" width="90px" rowspan="1" colspan="1">Options</th>
                            </tr>
                            </thead>
                            <tbody id="TableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->

        <!-- Transaction Add Modal -->
        <div class="modal fade" id="createTransactionModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('transactions.store') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createModalLabel">Add New Transaction</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="profit">Profit</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" name="category" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="date">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="amount">Amount ($)</label>
                                <input type="number" step="0.01" name="amount" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="note">Note</label>
                                <textarea name="note" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">Create</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="editModalLabel">Edit Transaction</h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <input type="hidden" name="id" id="edit-id">

                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" id="edit-type" class="form-control">
                                    <option value="profit">Profit</option>
                                    <option value="expense">Expense</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <input type="text" name="category" id="edit-category" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Date</label>
                                <input type="date" name="date" id="edit-date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" step="0.01" name="amount" id="edit-amount" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Note</label>
                                <textarea name="note" id="edit-note" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>


    <script>
        $(document).ready(function () {
            const table = $('#Profitdata').DataTable({
                responsive: true,
                lengthChange: true,
                autoWidth: false,
                searching: true,
                ordering: true,
                info: true,
                paging: true,
                pageLength: 10,
                // dom: 'Bfrtip', // Needed for buttons
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],

                ajax: {
                    url: `/transaction/data?year=${$('#year-filter').val()}`,
                    dataSrc: 'transactions'
                },

                columns: [

                    { data: null, render: (data, type, row, meta) => meta.row + 1 }, // Index
                    { data: 'type' },
                    { data: 'category' },
                    { data: 'date' },
                    { data: 'amount', render: data => `$ ${data}` },
                    { data: 'note' },
                    {
                        data: null,
                        render: (data, type, row) => `
                            <div class="btn-group">
                                <button type="button" class="btn btn-success">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <button class="dropdown-item text-primary btn-edit"
                                        data-id="${row.id}"
                                        data-type="${row.type}"
                                        data-category="${row.category}"
                                        data-date="${row.date}"
                                        data-amount="${row.amount}"
                                        data-note="${row.note}"
                                    ><i class="fas fa-edit"></i> Edit</button>
                                    <div class="dropdown-divider"></div>
                                    <form action="/transaction/delete/${row.id}" method="POST" onsubmit="showOverlay()" style="display:inline;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="dropdown-item text-danger delete-btn"><i class="fas fa-trash"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                        `
                    }
                ],
                initComplete: function () {
                    // Move buttons to desired container
                    this.api().buttons().container().appendTo('#Profitdata_wrapper .col-md-6:eq(0)');
                }
            });

            $('#year-filter').on('change', function () {
                const selectedYear = $(this).val();

                // Clear table body and show loading row manually
                $('#Profitdata tbody').html(`
        <tr>
            <td colspan="9" class="text-center">
                <i class="fa fa-spinner fa-spin"></i> Loading...
            </td>
        </tr>
    `);

                // Reload data from the new URL
                table.ajax.url(`/transaction/data?year=${selectedYear}`).load();
            });

        });

        $(document).on('click', '.btn-edit', function () {
            const button = $(this);

            $('#edit-id').val(button.data('id'));
            $('#edit-type').val(button.data('type'));
            $('#edit-category').val(button.data('category'));
            $('#edit-date').val(button.data('date'));
            $('#edit-amount').val(button.data('amount'));
            $('#edit-note').val(button.data('note'));

            // Update form action dynamically
            $('#editForm').attr('action', `/transaction/update/${button.data('id')}`);

            $('#editModal').modal('show');
        });

    </script>


@endsection

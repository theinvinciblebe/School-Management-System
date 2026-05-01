@extends('layout.main')

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <h1 align="center"><i class="fas fa-users"></i> User Management</h1>
            </div>
            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#addUserModal">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
        <div class="card-body">

            <table id="example1" class="table table-bordered table-striped dataTable dtr-inline" aria-describedby="example1_info">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $index=>$user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 0) Admin
                            @elseif($user->role == 1) Teacher
                            @elseif($user->role == 2) Student
                            @elseif($user->role == 3) Accountant
                            @elseif($user->role == 4) Receptionist
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-success">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-hover dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <button type="button" class="dropdown-item text-primary" onclick="showEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', {{ $user->role }})">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <div class="dropdown-divider"></div>

                                    <form action="{{ route('user.delete', $user->id) }}" method="POST" onsubmit="showOverlay()" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this user?');">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-user-form" method="POST" action="{{ route('user.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" id="edit-user-id">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="edit-user-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="edit-user-name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-user-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit-user-email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit-user-password" class="form-label">Password (Leave empty to keep unchanged)</label>
                            <input type="password" class="form-control" id="edit-user-password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="edit-user-role" class="form-label">Role</label>
                            <select class="form-control" id="edit-user-role" name="role" required>
                                <option value="0">Admin</option>
                                <option value="1">Teacher</option>
                                <option value="2">Student</option>
                                <option value="3">Accountant</option>
                                <option value="4">Receptionist</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('user.store') }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="email|unique" required>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="The password field must be at least 6 characters." required>
                        </div>
                        <div class="form-group">
                            <label>Role</label>
                            <select name="role" class="form-control">
                                <option value="0">Admin</option>
                                <option value="1">Teacher</option>
                                <option value="2">User</option>
                                <option value="3">Accountant</option>
                                <option value="4">Receptionist</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditModal(id, name, email, role) {
            // Set form values
            document.getElementById('edit-user-id').value = id;
            document.getElementById('edit-user-name').value = name;
            document.getElementById('edit-user-email').value = email;
            document.getElementById('edit-user-password').value = ''; // Leave blank
            document.getElementById('edit-user-role').value = role;

            // Show modal
            new bootstrap.Modal(document.getElementById('editUserModal')).show();
        }

    </script>
@endsection

@extends('dashboard.layouts.app')

@section('title')
    Users
@endsection
@section('user')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Users</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr class="hover-primary">
                                            <td>{{ $user->fullName() }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#"
                                                            onclick="editReminder({{ $user->id }}, '{{ $user->title }}', '{{ $user->note }}', '{{ $user->role }}')">Edit</a>
                                                        <a class="dropdown-item" onclick="DeleteRecord({{ $user->id }})">Delete</a> 
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Add/Edit Reminder</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="POST">
                        @csrf
                        <input type="hidden" id="form_method" name="_method" value="POST">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="edit_title" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="note">Text</label>
                            <textarea name="note" class="form-control" id="edit_note" placeholder="Enter Text"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="role">For</label>
                            <select name="role" class="form-control" id="edit_role">
                                <option value="medical">Medical</option>
                                <option value="patient">Patient</option>
                                <option value="manager">Manager</option>
                                <option value="editor">Editor</option>
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Reminder</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    @endsection
    @section('script')
        <script>
            $(function() {
                'use strict';
                $('#example1').DataTable({
                    'paging': true,
                    'lengthChange': false,
                    'searching': true,
                    'ordering': true,
                    'info': true,
                    'autoWidth': false,
                    'dom': 'Bfrtip',
                    'buttons': [{
                        text: 'Add New Reminder',
                        className: 'waves-effect waves-light btn btn-sm btn-success mb-5', // Add your custom classes here
                        action: function(e, dt, node, config) {
                            addReminder();
                        }
                    }]
                })
            });

            // Open modal to add a new user
            function addReminder() {
                $('#edit_title').val(''); // Clear the title
                $('#edit_note').val(''); // Clear the note
                $('#edit_role').val('medical'); // Set default role
                $('#editForm').attr('action', '/portal/user'); // Set form action for store
                $('#form_method').val('POST'); // Set form method for creating new user
                $('#edit_modal').modal('show'); // Show the modal
            }

            // Open modal to edit an existing user
            function editReminder(id, title, note, role) {
                $('#edit_title').val(title); // Set the title
                $('#edit_note').val(note); // Set the note
                $('#edit_role').val(role); // Set the role
                $('#editForm').attr('action', '/portal/user/' + id); // Set form action for update
                $('#form_method').val('PUT'); // Set form method for updating the user
                $('#edit_modal').modal('show'); // Show the modal
            }
            function DeleteRecord(id) {
                $.ajax({
                    url : "{{ url('portal/user') }}"+"/"+id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }

        </script>
    @endsection

@extends('dashboard.layouts.app')

@section('title')
    Meta Description
@endsection
@section('description')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Meta Description</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Meta Description</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($descriptions as $description)
                                    <tr class="hover-primary">
                                        <td>{{ $description->title }}</td>
                                        <td>{{ $description->description }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="dropdown-item" href="#"
                                                   onclick="editMetaDescription({{ $description->id }}, '{{ $description->title }}', '{{ $description->description }}')">Edit</a>
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
    <!-- Edit Modal -->
    <div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Meta Description</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="type">Title</label>
                            <input type="text" name="type" class="form-control" id="edit-title" readonly>
                        </div>
                        <div class="form-group">
                            <label for="value">Description</label>
                            <textarea name="description" class="form-control" id="edit_description" placeholder="Enter Description"></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Meta Description</button>
                </div>
                </form>
            </div>
        </div>

        <!-- /.content -->
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
                    })
                });

                function editMetaDescription(id, title, description) {
                    $('#edit-title').val(title); // Set the type as readonly
                    $('#edit_description').val(description);
                    $('#editForm').attr('action', '/portal/description/' + id); // Set the action for update route
                    $('#edit_modal').modal('show'); // Open the modal
                }
            </script>
@endsection

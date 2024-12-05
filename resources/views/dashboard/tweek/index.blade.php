@extends('dashboard.layouts.app')

@section('title')
    Tweek
@endsection
@section('tweek')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Tweek</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tweek</li>
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
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Service Fee</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tweeks as $tweek)
                                        <tr class="hover-primary">
                                            <td>{{ $tweek->type }}</td>
                                            <td>{{ $tweek->value }}</td>
                                            <td>{{ ($tweek->service_fee)?$tweek->service_fee:'0' }}%</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="dropdown-item" href="#"
                                                            onclick="editTweek({{ $tweek->id }}, '{{ $tweek->type }}', '{{ $tweek->value }}', '{{ $tweek->service_fee }}')">Edit</a>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Tweek</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="type">Type</label>
                            <input type="text" name="type" class="form-control" id="edit_type" readonly>
                        </div>
                        <div class="form-group">
                            <label for="value">Value</label>
                            <input type="text" name="value" class="form-control" id="edit_value"
                                placeholder="Enter Value">
                        </div>
                        <div class="form-group">
                            <label for="edit_service_fee">Service Fee(%)</label>
                            <input type="text" name="service_fee" class="form-control" id="edit_service_fee"
                                placeholder="Enter Service Fee">
                        </div>
                        <div class="form-group">
                            <label for="formFileMultiple" class="form-label">Media</label>
                            <input class="form-control" type="file" name="media[]" id="formFileMultiple" multiple>
                        </div>                        
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Tweek</button>
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

            function editTweek(id, type, value, service_fee) {
                $('#edit_type').val(type); // Set the type as readonly
                $('#edit_value').val(value); // Set the value to be editable
                $('#edit_service_fee').val(service_fee); // Set the value to be editable
                $('#editForm').attr('action', '/portal/tweek/' + id); // Set the action for update route
                $('#edit_modal').modal('show'); // Open the modal
            }
        </script>
    @endsection

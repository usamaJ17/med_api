@extends('dashboard.layouts.app')

@section('title')
Refund History
@endsection
@section('refund_history')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Refund History</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Refund History</li>
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
                                        <th>Sr#</th>
                                        <th>User</th>
                                        <th>Appointment Type</th>
                                        <th>Appointment Date</th>
                                        <th>Appointment Time</th>
                                        <th>Amount</th>
                                        <th>Gateway</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $refund)
                                        <tr class="hover-primary">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $refund->user->first_name ." ". $refund->user->last_name }}</td>
                                            <td>{{ $refund->appointment->appointment_type }}</td>
                                            <td>{{ $refund->appointment->appointment_date }}</td>
                                            <td>{{ $refund->appointment->appointment_time }}</td>
                                            <td>{{ $refund->amount }}</td>
                                            <td>{{ $refund->gateway }}</td>
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

            function editTweek(id, type, value) {
                $('#edit_type').val(type); // Set the type as readonly
                $('#edit_value').val(value); // Set the value to be editable
                $('#editForm').attr('action', '/portal/tweek/' + id); // Set the action for update route
                $('#edit_modal').modal('show'); // Open the modal
            }
        </script>
    @endsection

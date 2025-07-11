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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($refunds as $refund)
                                        <tr class="hover-primary">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \App\Models\User::getNameWithTrashed($refund->user_id) }}</td>
                                            <td>{{ $refund->appointment->appointment_type }}</td>
                                            <td>{{ $refund->appointment->appointment_date }}</td>
                                            <td>{{ $refund->appointment->appointment_time }}</td>
                                            <td>{{ $refund->amount }}</td>
                                            <td>{{ $refund->gateway_name }}</td>
                                            <td>
                                                @if ($refund->status == 'complete')
                                                    <span style="color: green;">Completed</span>
                                                @elseif ($refund->status == 'reject')
                                                    <span style="color: red;">Rejected</span>
                                                @else
                                                    <span style="color: #ffa800;">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        @if ($refund->status != 'complete')
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $refund->id }},'complete')">Complete</a>
                                                        @endif
                                                        @if ($refund->status != 'reject')
                                                            <a class="dropdown-item"
                                                               onclick="ChangeStatus({{ $refund->id }},'reject')">Reject</a>
                                                        @endif
                                                        @if ($refund->status != 'pending')
                                                            <a class="dropdown-item"
                                                            onclick="ChangeStatus({{ $refund->id }},'pending')">Pending</a>
                                                        @endif
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

            function ChangeStatus(id, status) {
                $.ajax({
                    url: "{{ url('portal/refund/status') }}",
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        status: status,
                        id: id
                    },
                    success: function(response) {
                        // reload page
                        location.reload();
                    }
                });
            }
        </script>
    @endsection

@extends('dashboard.layouts.app')

@section('title')
    Professionals Titles
@endsection
@section('payments')
    active
@endsection
@section('payments.payouts')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Payouts</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Payments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Payouts</li>
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
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Requested At</th>
                                        <th>Status</th>
                                        <th>Method</th>
                                        <th>Account Info</th>
                                        <th>Reject Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payouts as $item)
                                        <tr class="hover-primary">
                                            <td> <a href="{{ route('medical.show', $item->user->id) }}">{{ $item->user->first_name }}
                                                    {{ $item->user->last_name }} </a></td>
                                            <td>{{ $item->amount }}</td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, h:i A') }}
                                            </td>
                                            <td>{{ $item->status }}
                                                @if ($item->status == 'completed')
                                                    (Completed At :
                                                    {{ \Carbon\Carbon::parse($item->completed_at)->format('d F Y, h:i A') }})
                                                @endif
                                            </td>
                                            <td>{{ $item->method }}</td>
                                            <td>{{ $item->account_info }}</td>
                                            <td>{{ $item->rejected_reason }}</td>
                                            <td>
                                                @if ($item->status == 'requested')
                                                    <button type="button" data-id="{{ $item->id }}"
                                                        data-status="completed"
                                                        class="payout-action waves-effect waves-light btn btn-sm btn-success mb-5">Complete</button>
                                                    <button type="button" data-id="{{ $item->id }}"
                                                        data-status="rejected"
                                                        class="payout-action waves-effect waves-light btn btn-sm btn-danger mb-5">Reject</button>
                                                @endif
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
    <div class="modal fade" id="payout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Reason For Rejection</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.payouts.action') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Reason</label>
                            <input type="text" name="rejected_reason" class="form-control" id="rejected_reason"
                                placeholder="Enter Reason">
                            <input type="hidden" name="id" id="payout_id">
                            <input type="hidden" name="status" id="payout_status">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
        <form style="display: none" id="accept_form" action="{{ route('payments.payouts.action') }}" method="POST">
            @csrf
            <input type="hidden" name="id" id="acc_payout_id">
            <input type="hidden" name="status" id="acc_payout_status">
        </form>
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
                            extend: 'csv',
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            }
                        },
                        {
                            extend: 'excel',
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            }
                        },
                        {
                            extend: 'pdf',
                            exportOptions: {
                                columns: ':not(:last-child)' // Exclude the last column
                            }
                        }
                    ]
                })

            });

            $('.payout-action').on('click', function() {
                var id = $(this).data('id');
                var status = $(this).data('status');
                console.log(id ,status);
                $('#payout_id').val(id);
                $('#payout_status').val(status);
                $('#acc_payout_id').val(id);
                $('#acc_payout_status').val(status);
                if (status == 'rejected') {
                    $('#payout').modal('show');
                } else if (status == 'completed') {
                    $('#accept_form').submit();
                }
            });
        </script>
    @endsection

@extends('dashboard.layouts.app')

@section('title')
    Appointments
@endsection
@section('appointments')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Appointments List</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Appointments</li>
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
                                        <th>ID</th>
                                        <th>Patient</th>
                                        <th>Health Professional</th>
                                        <th>Type</th>
                                        <th>Booking Date & Time</th>
                                        <th>Appointment Date & Time</th>
                                        <th>Amount</th>
                                        <th>Payment Method</th>
                                        <th>Pay For Me</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->med->fullName() ." - ". $item->med_id }}</td>
                                            <td>{{ $item->user->fullName() ." - ". $item->user_id }}</td>
                                            <td>{{ $item->appointment_type }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->appointment_date)->format('d F Y') }}
                                                @
                                                {{ \Carbon\Carbon::parse($item->appointment_time)->format('h:i A') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                                @
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('h:i A') }}</td>
                                            <td>{{ $item->consultation_fees }}</td>
                                            <td>{{ $item->gateway }}</td>
                                            <td>{{ $item->pay_for_me ? 'Yes' : 'No' }}</td>
                                            <td>{{ $item->status }}</td>
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
    </script>
@endsection

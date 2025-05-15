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
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->med->fullName() . ' - ' . $item->med_id }}</td>
                                            <td>{{ $item->user->fullName() . ' - ' . $item->user_id }}</td>
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
                                            <td>
                                                @php
                                                    $currentDateTime = \Carbon\Carbon::now();
                                                    $appointmentDateTime = \Carbon\Carbon::parse($item->appointment_date . ' ' . $item->appointment_time);
                                                    $isEscrowAppointment = $appointmentDateTime->diffInDays($currentDateTime) < 7;
                                                @endphp
                                                @if ($item->status == 'completed' && $isEscrowAppointment)
                                                    <button onclick="ConfirmDelete({{ $item->id }})" type="button" class="btn btn-danger btn-sm">Cancel</a>
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
                'scrollX': true,
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
            });

            window.ConfirmDelete = function(id) {
                Swal.fire({
                    title: 'Are you sure you want to cancel this appointment?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    theme: 'dark',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ url('portal/appointments/admin_cancel') }}" + "/" + id,
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                Swal.fire({
                                    title: "Cancelled!",
                                    text: "Your appointment has been cancelled.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    icon: "success",
                                    showConfirmButton: false,
                                    showCloseButton: false,
                                    theme: 'dark'
                                });
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            },
                            error: function(xhr, status, error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "There was an error cancelling the appointment.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                    icon: "error",
                                    showConfirmButton: false,
                                    showCloseButton: false,
                                    theme: 'dark'
                                });
                            }
                        });
                    }
                })
            }
        });
    </script>
@endsection

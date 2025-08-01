@extends('dashboard.layouts.app')

@section('title')
    Midnight Emergency Help
@endsection
@section('emergencyhelp')
    active
@endsection
@section('emergencyhelp.midnight')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Midnight Emergency Help List</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Dashboard</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">Midnight Emergency Help</li>
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
                                        <th>Date & Time of Request</th>
                                        <th>Time of Response</th>
                                        <th>Health Professional Name & ID</th>
                                        <th>Patient Name & ID</th>
                                        <th>Duration Of Consultation</th>
                                        <th>Status</th>
                                        <th>Patient Phone Number</th>
                                        <th>Patient email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emer as $item)
                                        <tr class="hover-primary">
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, h:i A') }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y, h:i A') }}
                                            </td>
                                            <td>{{ \App\Models\User::getNameWithTrashed($item->med_id) ." - " . $item->med_id}}</td>
                                            <td>{{ \App\Models\User::getNameWithTrashed($item->user_id) ." - " . $item->user_id}}</td>
                                            <td>{{ $item->duration }}</td>
                                            <td>{{ $item->status }}</td>
                                            <td>{{ \App\Models\User::getAttributeWithTrashed($item->user_id, 'contact') }}</td>
                                            <td>{{ \App\Models\User::getAttributeWithTrashed($item->user_id, 'email') }}</td>
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

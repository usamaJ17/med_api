@extends('dashboard.layouts.app')

@section('title')
    Professionals Titles
@endsection
@section('payments')
    active
@endsection
@section('payments.trans')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Transactions</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i>Payments</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Transactions</li>
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
                                        <th>For</th>
                                        <th>Amount</th>
                                        <th>Time</th>
                                        <th>User</th>
                                        <th>Gateway</th>
                                        <th>Appointment ID</th>
                                        {{-- <th></th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transactions as $item)
                                        <tr class="hover-primary">
                                            <td>{{ $item->transaction_id }}</td>
                                            <td>{{ $item->transaction_type }}</td>
                                            <td>{{ $item->transaction_amount }}</td>
                                            <td>{{ $item->transaction_date }} {{ $item->transaction_time }}</td>
                                            <td>{{ \App\Models\User::getNameWithTrashed($item->user_id) }}</td>
                                            <td>{{ $item->transaction_gateway }}</td>
                                            <td>{{ $item->appointment_id }}</td>
                                            {{-- <td>{{ $item->asd }}</td>
                                            <td>{{ $item->asd }}</td> --}}
                                            {{-- <td>
                                                <div class="btn-group">
                                                    <a class="hover-primary dropdown-toggle no-caret"
                                                        data-bs-toggle="dropdown"><i class="fa fa-ellipsis-h"></i></a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                            onclick="DeleteRecord(`{{ $item }}`)">Delete</a>
                                                    </div>
                                                </div>
                                            </td> --}}
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
                'buttons': [
                    {
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

        // function DeleteRecord(name) {
        //     $.ajax({
        //         url: "{{ url('portal/dynamic/title/delete') }}" + "/" + name,
        //         type: 'DELETE',
        //         data: {
        //             _token: "{{ csrf_token() }}"
        //         },
        //         success: function(response) {
        //             // reload page
        //             location.reload();
        //         }
        //     });
        // }
    </script>
@endsection

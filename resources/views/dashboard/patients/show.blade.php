@php use Carbon\Carbon; @endphp
@extends('dashboard.layouts.app')

@section('title')
    Patient Details
@endsection
@section('patient')
    active
@endsection
@section('patient.all')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Patient Details</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Patients</li>
                            <li class="breadcrumb-item active" aria-current="page">Patients Details</li>
                        </ol>
                    </nav>
                </div>
            </div>

        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xl-8 col-12">
                <div class="box bt-3 border-primary">
                    <div class="box-body text-end min-h-150"
                         style="background-image:url({{ asset('dashboard/images/auth-bg/bg-8.jpg') }}); background-repeat: no-repeat; background-position: center;background-size: cover;">
                    </div>
                    <div class="box-body wed-up position-relative">
                        <div class="d-md-flex align-items-end">
                            <img src="{{ $patient->getFirstMediaUrl() }}" style="max-height: 150px; width: auto"
                                 class="bg-success-light rounded10 me-20" alt=""/>
                            <div>
                                <h3>{{ $patient->first_name . ' ' . $patient->last_name }}</h3>
                                <p><i class="fa fa-clock-o"></i> Join on
                                    {{ Carbon::parse($patient->created_at)->format('d/m/Y H:m') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Information</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                <tr>
                                    <th scope="col">First Name</th>
                                    <td scope="col">{{ $patient->first_name }}</td>
                                    <th scope="col">Last Name</th>
                                    <td scope="col">{{ $patient->last_name }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Contact</th>
                                    <td scope="col">{{ $patient->contact }}</td>
                                    <th scope="col">Email</th>
                                    <td scope="col">{{ $patient->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">Date of Birth</th>
                                    <td scope="col">{{ $patient->dob }}</td>
                                    <th scope="col">Gender</th>
                                    <td scope="col">{{ $patient->gender }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {{-- <div class="box bt-3 border-primary">
                    <div class="box-header">
                        <h4 class="box-title">Latest Appointments</h4>
                    </div>
                    <div class="box-body">
                        <div class="inner-user-div4">
                            <table class="table mb-0" id="example2app">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointment as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center mb-10">
                                                    <div class="me-15">
                                                        <img src="{{ $item->user->profile_image }}"
                                                            class="avatar avatar-lg rounded10 bg-primary-light"
                                                            alt="" />
                                                    </div>
                                                    <div class="d-flex flex-column flex-grow-1 fw-500">
                                                        <p class="hover-primary text-fade mb-1 fs-14">
                                                            {{ $item->user->fullName() }}</p>
                                                        <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i>
                                                            {{ \Carbon\Carbon::parse($item->appointment_date)->format('d F Y') }}
                                                            @
                                                            {{ \Carbon\Carbon::parse($item->appointment_time)->format('h:i A') }}
                                                            <span class="mx-20">{{ $item->consultation_fees }}</span>
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <button
                                                            class="waves-effect btn btn-primary btn-sm">{{ ucfirst($item->status) }}</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-xl-4 col-12">
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Location</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                <tr>
                                    <th scope="col">Country</th>
                                    <td scope="col">{{ $patient->country }}</td>
                                    <th scope="col">State</th>
                                    <td scope="col">{{ $patient->state }}</td>
                                </tr>
                                <tr>
                                    <th scope="col">City</th>
                                    <td scope="col">{{ $patient->city }}</td>
                                    <th scope="col">Language</th>
                                    <td scope="col">{{ $patient->language }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Wallet</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                <tr>
                                    <th scope="col">Balance</th>
                                    <td scope="col">
                                        @if($patient->wallet)
                                            ${{ number_format($patient->wallet->balance, 2) }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Appointment</h4>
                    </div>
                    <div class="box-body">
                        <div id="appointment_overview"></div>
                    </div>
                    <div class="box-body">
                        <table class="table mb-0" id="exampleapppat">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Type</th>
                                <th>Health Professional</th>
                                <th>Amount</th>
                                <th>Transaction ID</th>
                                <th>Payment Method</th>
                                <th>Pay For Me</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($appointment as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ Carbon::parse($item->appointment_date)->format('d F Y') }}
                                        @
                                        {{ Carbon::parse($item->appointment_time)->format('h:i A') }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ $item->appointment_type }}</td>
                                    <td>{{ $item->med->fullName() }}</td>
                                    <td>{{ $item->consultation_fees }}</td>
                                    <td>{{ $item->transaction_id }}</td>
                                    <td>{{ $item->gateway }}</td>
                                    <td>{{ $item->pay_for_me ? "Yes" : "No" }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Refunds</h4>
                    </div>
                    <div class="box-body">
                        <table class="table mb-0" id="example1">
                            <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Transaction ID</th>
                                <th>Scheduled Date & Time</th>
                                <th>Date & Time of cancellation</th>
                                <th>Original Amount Paid</th>
                                <th>Method</th>
                                <th>Refund Method Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            {{-- @foreach ($appointment as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->appointment_date)->format('d F Y') }}
                                    @
                                    {{ \Carbon\Carbon::parse($item->appointment_time)->format('h:i A') }}</td>
                                <td>{{ $item->status }}</td>
                                <td>{{ $item->appointment_type }}</td>
                                <td>{{ $item->med->fullName() }}</td>
                                <td>{{ $item->consultation_fees }}</td>
                                <td>{{ $item->transaction_id }}</td>
                                <td>{{ $item->gateway }}</td>
                                <td>{{ $item->pay_for_me ? "Yes" : "No" }}</td>
                            </tr>
                            @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection
@section('script')
    <script>
        $(function () {
            'use strict';
            $('#example1').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': true,
                'autoWidth': false
            });
            $('#exampleapppat').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': false,
                'pageLength': 10,
                'autoWidth': false
            })
            $('#examplereview').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': false,
                'info': false,
                'autoWidth': false,
                'pageLength': 5,
            })
        });

        function DeleteRecord(id) {
            console.log(id);
            $.ajax({
                url: "{{ url('portal/patient') }}" + "/" + id,
                type: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    // reload page
                    location.reload();
                }
            });
        }

        $('#verify_btn').on('click', function () {
            $.ajax({
                url: "{{ route('complete_verification') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $patient->id }}",
                    status: 1
                },
                success: function (response) {
                    location.reload();
                }
            });
        });
        $('#un_verify_btn').on('click', function () {
            $.ajax({
                url: "{{ route('complete_verification') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $patient->id }}",
                    status: 0
                },
                success: function (response) {
                    location.reload();
                }
            });
        });
        $('#md_checkbox_23').change(function () {
            var isChecked = $(this).is(':checked');
            var val = 0;
            if (isChecked) {
                val = 1;
            }

            $.ajax({
                url: '{{ route('emergency_status') }}', // Replace with your endpoint URL
                type: 'POST',
                data: {
                    can_emergency: val,
                    id: "{{ $patient->id }}",
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                },
                success: function (response) {
                    console.log('Checkbox state updated successfully');
                },
                error: function (xhr, status, error) {
                    console.error('Error updating checkbox state:', error);
                }
            });
        });
        $('#md_checkbox_24').change(function () {
            var isChecked = $(this).is(':checked');
            var val = 0;
            if (isChecked) {
                val = 1;
            }

            $.ajax({
                url: '{{ route('night_emergency_status') }}', // Replace with your endpoint URL
                type: 'POST',
                data: {
                    can_night_emergency: val,
                    id: "{{ $patient->id }}",
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                },
                success: function (response) {
                    console.log('Checkbox state updated successfully');
                },
                error: function (xhr, status, error) {
                    console.error('Error updating checkbox state:', error);
                }
            });
        });
        var appointmentData = @json($appointmentData);
        var cancelAppointmentData = @json($cancelAppointmentData);

        var options = {
            series: [{
                name: 'Appointment',
                data: appointmentData.data
            }, {
                name: 'Cancelled',
                data: cancelAppointmentData.data
            }],
            chart: {
                type: 'area',
                height: 270,
                toolbar: {
                    show: false
                }
            },
            colors: ['#2444e8', '#ee3158'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '30%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                show: false,
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['#2444e8', '#ee3158'],
            },
            xaxis: {
                categories: appointmentData.date,

            },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return value.toFixed(0); // Format to show integers
                    }
                },
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },

            },
            fill: {
                opacity: 1
            },
            tooltip: {
                theme: 'dark',
                y: {
                    formatter: function (val) {
                        return val + " Appointment"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#appointment_overview"), options);
        chart.render();
    </script>
@endsection

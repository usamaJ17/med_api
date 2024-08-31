@extends('dashboard.layouts.app')

@section('title')
    Medical Professional Details
@endsection
@section('medical')
    active
@endsection
@section('medical.all')
    active
@endsection
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="me-auto">
                <h4 class="page-title">Medical Professional Details</h4>
                <div class="d-inline-block align-items-center">
                    <nav>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="mdi mdi-home-outline"></i></a></li>
                            <li class="breadcrumb-item" aria-current="page">Medical Professionals</li>
                            <li class="breadcrumb-item active" aria-current="page">Medical Professionals Details</li>
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
                <div class="box bt-3 border-success">
                    <div class="box-body ribbon-box text-end min-h-150"
                        style="background-image:url({{ asset('dashboard/images/auth-bg/bg-8.jpg') }}); background-repeat: no-repeat; background-position: center;background-size: cover;">
                        <div
                            class="ribbon-two @if ($medical->is_verified) ribbon-two-primary  @else ribbon-two-danger @endif ">
                            <span>
                                @if ($medical->is_verified)
                                    Verified
                                @else
                                    Un Verified
                                @endif
                            </span>
                        </div>
                        <div class="bg-success rounded10 p-15 fs-18 d-inline"><i class="fa fa-stethoscope"></i>
                            {{ $medical->professionalDetails->professions->name }}</div>
                    </div>
                    <div class="box-body wed-up position-relative">
                        <div class="d-md-flex align-items-end">
                            <img src="{{ $medical->getFirstMediaUrl() }}" style="max-height: 150px; width: auto"
                                class="bg-success-light rounded10 me-20" alt="" />
                            <div>
                                <h3>{{ $medical->first_name . ' ' . $medical->last_name }}</h3>
                                <h5>{{ $medical->professionalDetails->ranks->name }}</h5>
                                <p><i class="fa fa-clock-o"></i> Join on
                                    {{ \Carbon\Carbon::parse($medical->created_at)->format('d/m/Y H:m') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="mb-0 pull-right">
                            <input type="checkbox" id="md_checkbox_23" class="filled-in chk-col-success"
                                @if ($medical->can_emergency) checked @endif>
                            <label for="md_checkbox_23">Receive Emergency Calls</label>
                        </div>
                        <div class="mb-0 pull-right" style="margin-right: 10px !important;">
                            <input type="checkbox" id="md_checkbox_24" class="filled-in chk-col-success"
                                @if ($medical->can_night_emergency) checked @endif>
                            <label for="md_checkbox_24">Receive Midnight Emergency Calls</label>
                        </div>
                        <h4>Biography</h4>
                        <p>{{ $medical->professionalDetails->bio }}</p>
                    </div>
                </div>
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Information</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">First Name</th>
                                        <td scope="col">{{ $medical->first_name }}</td>
                                        <th scope="col">Last Name</th>
                                        <td scope="col">{{ $medical->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Contact</th>
                                        <td scope="col">{{ $medical->contact }}</td>
                                        <th scope="col">Email</th>
                                        <td scope="col">{{ $medical->email }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Date of Birth</th>
                                        <td scope="col">{{ $medical->dob }}</td>
                                        <th scope="col">Gender</th>
                                        <td scope="col">{{ $medical->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Profession</th>
                                        <td scope="col">{{ $medical->professionalDetails->professions->name }}</td>
                                        <th scope="col">Rank</th>
                                        <td scope="col">{{ $medical->professionalDetails->ranks->name }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">License Authority</th>
                                        <td scope="col">{{ $medical->professionalDetails->license_authority }}</td>
                                        <th scope="col">Regestraion Number</th>
                                        <td scope="col">{{ $medical->professionalDetails->regestraion_number }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Work At</th>
                                        <td scope="col">{{ $medical->professionalDetails->work_at }}</td>
                                        <th scope="col">Experence</th>
                                        <td scope="col">{{ $medical->professionalDetails->experence }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Degree</th>
                                        <td scope="col">{{ $medical->professionalDetails->degree }}</td>
                                        <th scope="col">Institution</th>
                                        <td scope="col">{{ $medical->professionalDetails->institution }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Statistics</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">Total Revenue Earned</th>
                                        <td scope="col">{{ $total_revenue }} GHS</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Number Of Articles</th>
                                        <td scope="col">{{ $atricals_count }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Number Of Followers</th>
                                        <td scope="col">{{ $medical->followers_count }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Total Unique Patients</th>
                                        <td scope="col">{{ $uniq_cus }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">Total Appointments</th>
                                        <td scope="col">{{ $tot_app }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-success">
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
                </div>
            </div>
            <div class="col-xl-4 col-12">
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">User Location</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="col">Country</th>
                                        <td scope="col">{{ $medical->country }}</td>
                                        <th scope="col">State</th>
                                        <td scope="col">{{ $medical->state }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="col">City</th>
                                        <td scope="col">{{ $medical->city }}</td>
                                        <th scope="col">Language</th>
                                        <td scope="col">{{ $medical->language }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">Documents <small class="subtitle">Fetched {{ count($docs) }}
                                Documents</small></h4>
                    </div>
                    <div class="box-body">
                        @foreach ($docs as $key => $item)
                            <div class="d-flex align-items-center mb-30">
                                <div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
                                    <span><img src="{{ $item }}" alt=""></span>
                                </div>
                                <div class="d-flex flex-column fw-500">
                                    <a href="{{ $item }}" target="_blank"
                                        class="text-dark hover-primary mb-1 fs-16"> {{ $key }}</a>
                                </div>
                            </div>
                        @endforeach
                        @if (!$medical->is_verified)
                            <button type="button" id="verify_btn"
                                class="waves-effect waves-light btn btn-success mb-5">Verify Professional</button>
                        @else
                            <button type="button" id="un_verify_btn"
                                class="waves-effect waves-light btn btn-danger mb-5">Un Verify Professional</button>
                        @endif
                    </div>
                </div>
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">Recent Review</h4>
                    </div>
                    <div class="box-body p-0">
                        <div class="inner-user-div">
                            <table class="table mb-0" id="examplereview">
                                <thead>
                                    <tr>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $item)
                                        <tr>
                                            <td class="media-list bb-1 bb-dashed border-light">
                                                <div class="media align-items-center">
                                                    <a class="avatar avatar-lg status-success" href="#">
                                                        <img src="../images/avatar/1.jpg" class="bg-success-light"
                                                            alt="...">
                                                    </a>
                                                    <div class="media-body">
                                                        <p class="fs-16">
                                                            <a class="hover-primary"
                                                                href="#">{{ $item->user->fullName() }}</a>
                                                        </p>
                                                        <span
                                                            class="text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                    </div>
                                                    <div class="media-right">
                                                        <div class="d-flex" title="{{ $item->rating }} out of 5">
                                                            @php
                                                                $fullStars = floor($item->rating); // Number of full stars
                                                                $halfStar = $item->rating - $fullStars >= 0.5 ? 1 : 0; // Half star if remainder >= 0.5
                                                            @endphp

                                                            @for ($i = 0; $i < $fullStars; $i++)
                                                                <i class="text-warning fa fa-star"></i> <!-- Full Star -->
                                                            @endfor

                                                            @if ($halfStar)
                                                                <i class="text-warning fa fa-star-half-o"></i>
                                                                <!-- Half Star -->
                                                            @endif

                                                            @if (!$halfStar && $fullStars < 5)
                                                                <i class="text-warning fa fa-star-o"></i>
                                                                <!-- Outline Star -->
                                                            @endif
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="media pt-0">
                                                    <p class="text-fade">{{ $item->body }} </p>
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
        <div class="row">
            <div class="col-12">
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">payouts</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive rounded card-table">
                            <table class="table border-no" id="example1">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Reject Reason</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payouts as $item)
                                        <tr class="hover-primary">
                                            <td> <a href="{{ route('medical.show', $item->user->id) }}">{{ $item->user->first_name }}
                                                    {{ $item->user->last_name }} </a></td>
                                            <td>{{ $item->amount }}</td>
                                            <td>{{ $item->status }} @if ($item->status == 'completed')
                                                    (Completed At :
                                                    {{ \Carbon\Carbon::parse($item->completed_at)->format('h:i A, d F Y') }})
                                                @endif
                                            </td>
                                            <td>{{ $item->rejected_reason }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-12">
                <div class="box bt-3 border-success">
                    <div class="box-header with-border">
                        <h4 class="box-title">Appointment</h4>
                    </div>
                    <div class="box-body">
                        <div id="appointment_overview"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
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
                'autoWidth': false
            });
            $('#example2app').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': false,
                'info': false,
                'pageLength': 5,
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
                success: function(response) {
                    // reload page
                    location.reload();
                }
            });
        }
        $('#verify_btn').on('click', function() {
            $.ajax({
                url: "{{ route('complete_verification') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $medical->id }}",
                    status: 1
                },
                success: function(response) {
                    location.reload();
                }
            });
        });
        $('#un_verify_btn').on('click', function() {
            $.ajax({
                url: "{{ route('complete_verification') }}",
                type: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: "{{ $medical->id }}",
                    status: 0
                },
                success: function(response) {
                    location.reload();
                }
            });
        });
        $('#md_checkbox_23').change(function() {
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
                    id: "{{ $medical->id }}",
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                },
                success: function(response) {
                    console.log('Checkbox state updated successfully');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating checkbox state:', error);
                }
            });
        });
        $('#md_checkbox_24').change(function() {
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
                    id: "{{ $medical->id }}",
                    _token: '{{ csrf_token() }}' // Include CSRF token if using Laravel
                },
                success: function(response) {
                    console.log('Checkbox state updated successfully');
                },
                error: function(xhr, status, error) {
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
                    formatter: function(value) {
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
                    formatter: function(val) {
                        return val + " Appointment"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#appointment_overview"), options);
        chart.render();
    </script>
@endsection

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
                <div class="box bt-3 border-primary">
                    <div class="box-body text-end min-h-150"
                        style="background-image:url({{ asset('dashboard/images/auth-bg/bg-8.jpg') }}); background-repeat: no-repeat; background-position: center;background-size: cover;">
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
                        <h4>Biography</h4>
                        <p>{{ $medical->professionalDetails->bio }}</p>
                    </div>
                </div>
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Resent Review</h4>
                    </div>
                    <div class="box-body p-0">
                        <div class="inner-user-div">
                            <div class="media-list bb-1 bb-dashed border-light">
                                <div class="media align-items-center">
                                    <a class="avatar avatar-lg status-success" href="#">
                                        <img src="../images/avatar/1.jpg" class="bg-success-light" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <p class="fs-16">
                                            <a class="hover-primary" href="#">Theron Trump</a>
                                        </p>
                                        <span class="text-muted">2 day ago</span>
                                    </div>
                                    <div class="media-right">
                                        <div class="d-flex">
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="media pt-0">
                                    <p class="text-fade">Vestibulum tincidunt sit amet sapien et eleifend. Fusce pretium
                                        libero enim, nec lacinia est ultrices id. Duis nibh sapien, ultrices in hendrerit
                                        ac, pulvinar ut mauris. Quisque eu condimentum justo. </p>
                                </div>
                            </div>
                            <div class="media-list bb-1 bb-dashed border-light">
                                <div class="media align-items-center">
                                    <a class="avatar avatar-lg status-success" href="#">
                                        <img src="../images/avatar/3.jpg" class="bg-success-light" alt="...">
                                    </a>
                                    <div class="media-body">
                                        <p class="fs-16">
                                            <a class="hover-primary" href="#">Johen Doe</a>
                                        </p>
                                        <span class="text-muted">5 day ago</span>
                                    </div>
                                    <div class="media-right">
                                        <div class="d-flex">
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star"></i>
                                            <i class="text-warning fa fa-star-half-o"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="media pt-0">
                                    <p class="text-fade">Praesent venenatis viverra turpis quis varius. Nullam ullamcorper
                                        congue urna, in sodales eros placerat non.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="#" class="waves-effect waves-light d-block w-p100 btn btn-primary">Load More
                            Reviews</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12">
                <div class="box bt-3 border-primary">
                    <div class="box-header">
                        <h4 class="box-title">Latest Appointments</h4>
                    </div>
                    <div class="box-body">
                        <div id="paginator1"></div>
                    </div>
                    <div class="box-body">
                        <div class="inner-user-div4">
                            <div>
                                <div class="d-flex align-items-center mb-10">
                                    <div class="me-15">
                                        <img src="../images/avatar/avatar-5.png"
                                            class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 fw-500">
                                        <p class="hover-primary text-fade mb-1 fs-14">Mark Wood</p>
                                        <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 13:00 <span
                                                class="mx-20">$ 90</span></p>
                                    </div>
                                    <div>
                                        <button class="waves-effect btn btn-primary btn-sm">Upcomming</button>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-10">
                                    <div class="me-15">
                                        <img src="../images/avatar/avatar-5.png"
                                            class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 fw-500">
                                        <p class="hover-primary text-fade mb-1 fs-14">Mark Wood</p>
                                        <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 13:00 <span
                                                class="mx-20">$ 90</span></p>
                                    </div>
                                    <div>
                                        <button class="waves-effect btn btn-primary btn-sm">Upcomming</button>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-10">
                                    <div class="me-15">
                                        <img src="../images/avatar/avatar-5.png"
                                            class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 fw-500">
                                        <p class="hover-primary text-fade mb-1 fs-14">Mark Wood</p>
                                        <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 13:00 <span
                                                class="mx-20">$ 90</span></p>
                                    </div>
                                    <div>
                                        <button class="waves-effect btn btn-primary btn-sm">Upcomming</button>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                </div>
                            </div>
                            <div>
                                <div class="d-flex align-items-center mb-10">
                                    <div class="me-15">
                                        <img src="../images/avatar/avatar-5.png"
                                            class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                    </div>
                                    <div class="d-flex flex-column flex-grow-1 fw-500">
                                        <p class="hover-primary text-fade mb-1 fs-14">Mark Wood</p>
                                        <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 13:00 <span
                                                class="mx-20">$ 90</span></p>
                                    </div>
                                    <div>
                                        <button class="waves-effect btn btn-success btn-sm">Completed</button>
                                    </div>
                                </div>
                                <div
                                    class="d-flex justify-content-between align-items-end mb-15 py-10 bb-dashed border-bottom">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box bt-3 border-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">Documents <small class="subtitle">Fetched  {{ count($docs) }} Documents</small></h4>
                    </div>
                    <div class="box-body">
                        @foreach ($docs as $key => $item)
                            <div class="d-flex align-items-center mb-30">
                                <div class="me-15 bg-primary-light h-50 w-50 l-h-60 rounded text-center">
                                    <span><img src="{{ $item }}" alt=""></span>
                                </div>
                                <div class="d-flex flex-column fw-500">
                                    <a href="{{ $item }}" target="_blank" class="text-dark hover-primary mb-1 fs-16"> {{$key}}</a>
                                </div>
                            </div>
                        @endforeach
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
    </script>
@endsection

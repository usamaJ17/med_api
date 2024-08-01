@extends('dashboard.layouts.app')

@section('title')
    Dashboard
@endsection
@section('content')
<div class="section">
    <div class="row">
        <div class="col-xl-8 col-12">
            <div class="box">
                <div class="box-body">
                    <div class="row">
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="d-flex align-items-center mb-15 mb-lg-0">
                                <div class="me-15 bg-danger w-60 h-60 rounded-circle text-center l-h-70">
                                    <i class="fs-24 fa fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-fade fs-16 mb-0">Patients</p>
                                    <h3 class="fw-500 my-0">{{ count($patients) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="d-flex align-items-center mb-15 mb-lg-0">
                                <div class="me-15 bg-warning w-60 h-60 rounded-circle text-center l-h-70">
                                    <i class="fs-24 fa fa-user-md"></i>
                                </div>
                                <div>
                                    <p class="text-fade fs-16 mb-0">Medical Professionals</p>
                                    <h3 class="fw-500 my-0">{{ count($medicals) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="d-flex align-items-center mb-15 mb-md-0">
                                <div class="me-15 bg-success w-60 h-60 rounded-circle text-center l-h-70">
                                    <i class="fs-24 fa fa-calendar-o"></i>
                                </div>
                                <div>
                                    <p class="text-fade fs-16 mb-0">Appointments</p>
                                    <h3 class="fw-500 my-0">{{ count($appointments) }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 col-12">
                            <div class="d-flex align-items-center mb-15 mb-md-0">
                                <div class="me-15 bg-info w-60 h-60 rounded-circle text-center l-h-70">
                                    <i class="fs-24 fa fa-money"></i>
                                </div>
                                <div>
                                    <p class="text-fade fs-16 mb-0">Earning</p>
                                    <h3 class="fw-500 my-0">4566 GHS</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                {{-- <div class="col-xl-6 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Patients</h4>
                        </div>
                        <div class="box-body">		
                            <p class="mb-0 text-muted">Total Patients</p>
                            <h3 class="text-success mt-0">412,154 People</h3>
                            <div class="d-md-flex align-items-center">
                                <div id="patient_overview" class="min-h-250"></div>
                                <div class="d-md-block d-flex">
                                    <div class="d-flex align-items-center me-md-0 me-15">
                                        <div class="me-10 bg-success w-30 h-30 rounded"></div>
                                        <div>
                                            <p class="text-fade mb-0">New</p>
                                            <h4 class="fw-500 my-0">64</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center my-20 me-md-0 me-15">
                                        <div class="me-10 bg-warning w-30 h-30 rounded"></div>
                                        <div>
                                            <p class="text-fade mb-0">Recovered</p>
                                            <h4 class="fw-500 my-0">73</h4>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center me-md-0 me-15">
                                        <div class="me-10 bg-danger w-30 h-30 rounded"></div>
                                        <div>
                                            <p class="text-fade mb-0">In Treatment</p>
                                            <h4 class="fw-500 my-0">48</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>							
                        </div>
                    </div>
                </div> --}}
                <div class="col-xl-12 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">User Signups</h4>
                        </div>
                        <div class="box-body">							
                            <div id="recent_trend"></div>							
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Next Patient</h4>
                        </div>
                        <div class="box-body">	
                            <div class="news-slider owl-carousel owl-sl">	
                                <div>
                                    <div class="d-flex align-items-center mb-10">
                                        <div class="me-15">
                                        <img src="{{ asset('dashboard/images/avatar/1.jpg') }}" class="w-auto avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 fw-500">
                                            <p class="hover-primary text-fade mb-1 fs-14">Shawn Hampton</p>
                                            <span class="text-dark fs-16">Emergency appointment</span>
                                        </div>
                                        <div>
                                            <a href="#" class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm mx-15"><i class="fa fa-phone"></i></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-40 py-10 bt-dashed border-top">
                                        <div>
                                            <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 10:00 <span class="mx-20">$ 30</span></p>
                                        </div>
                                        <div>
                                            <div class="dropdown">
                                                <a data-bs-toggle="dropdown" href="#" class="base-font mx-30"><i class="ti-more-alt text-muted"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                                                <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                                                <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-10">
                                        <div class="me-15">
                                            <img src="{{ asset('dashboard/images/avatar/2.jpg') }}" class="w-auto avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 fw-500">
                                            <p class="hover-primary text-fade mb-1 fs-14">Polly Paul</p>
                                            <span class="text-dark fs-16">USG + Consultation</span>
                                        </div>
                                        <div>
                                            <a href="#" class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm mx-15"><i class="fa fa-phone"></i></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-40 py-10 bt-dashed border-top">
                                        <div>
                                            <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 10:30 <span class="mx-20">$ 50</span></p>
                                        </div>
                                        <div>
                                            <div class="dropdown">
                                                <a data-bs-toggle="dropdown" href="#" class="base-font mx-30"><i class="ti-more-alt text-muted"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                                                <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                                                <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="d-flex align-items-center mb-10">
                                        <div class="me-15">
                                            <img src="{{ asset('dashboard/images/avatar/3.jpg') }}" class="w-auto avatar avatar-lg rounded10 bg-primary-light" alt="" />
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 fw-500">
                                            <p class="hover-primary text-fade mb-1 fs-14">Johen Doe</p>
                                            <span class="text-dark fs-16">Laboratory screening</span>
                                        </div>
                                        <div>
                                            <a href="#" class="waves-effect waves-circle btn btn-circle btn-primary-light btn-sm mx-15"><i class="fa fa-phone"></i></a>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-end mt-40 py-10 bt-dashed border-top">
                                        <div>
                                            <p class="mb-0 text-muted"><i class="fa fa-clock-o me-5"></i> 11:00 <span class="mx-20">$ 70</span></p>
                                        </div>
                                        <div>
                                            <div class="dropdown">
                                                <a data-bs-toggle="dropdown" href="#" class="base-font mx-30"><i class="ti-more-alt text-muted"></i></a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#"><i class="ti-import"></i> Import</a>
                                                <a class="dropdown-item" href="#"><i class="ti-export"></i> Export</a>
                                                <a class="dropdown-item" href="#"><i class="ti-printer"></i> Print</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#"><i class="ti-settings"></i> Settings</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Overal appointment</h4>
                        </div>
                        <div class="box-body">										
                            <div id="appointment_overview"></div>							
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Users Signups</h4>
                        </div>
                        <div class="box-body">										
                            <div id="patients_pace"></div>							
                        </div>
                    </div>
                </div>
            </div>					
        </div>
        <div class="col-xl-4 col-12">
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Available Doctors</h4>
                    <p class="mb-0 pull-right">Today</p>
                </div>
                <div class="box-body">
                    <div class="inner-user-div3">
                        <div class="d-flex align-items-center mb-30">
                            <div class="me-15">
                                <img src="{{ asset('dashboard/images/avatar/avatar-1.png') }}" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                            </div>
                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                <a href="#" class="text-dark hover-primary mb-1 fs-16">Dr. Jaylon Stanton</a>
                                <span class="text-fade">Dentist</span>
                            </div>
                            <div class="dropdown">
                                <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-info">5</span>
                                </a>
                                <a class="dropdown-item" href="#">Sent</a>
                                <a class="dropdown-item" href="#">Spam</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Draft</span>
                                    <span class="badge badge-pill badge-default">1</span>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-30">
                            <div class="me-15">
                                <img src="{{ asset('dashboard/images/avatar/avatar-10.png') }}" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                            </div>
                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                <a href="#" class="text-dark hover-danger mb-1 fs-16">Dr. Carla Schleifer</a>
                                <span class="text-fade">Oculist</span>
                            </div>
                            <div class="dropdown">
                                <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-info">5</span>
                                </a>
                                <a class="dropdown-item" href="#">Sent</a>
                                <a class="dropdown-item" href="#">Spam</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Draft</span>
                                    <span class="badge badge-pill badge-default">1</span>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-30">
                            <div class="me-15">
                                <img src="{{ asset('dashboard/images/avatar/avatar-11.png') }}" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                            </div>
                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                <a href="#" class="text-dark hover-success mb-1 fs-16">Dr. Hanna Geidt</a>
                                <span class="text-fade">Surgeon</span>
                            </div>
                            <div class="dropdown">
                                <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-info">5</span>
                                </a>
                                <a class="dropdown-item" href="#">Sent</a>
                                <a class="dropdown-item" href="#">Spam</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Draft</span>
                                    <span class="badge badge-pill badge-default">1</span>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-30">
                            <div class="me-15">
                                <img src="{{ asset('dashboard/images/avatar/avatar-12.png') }}" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                            </div>
                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                <a href="#" class="text-dark hover-info mb-1 fs-16">Dr. Roger George</a>
                                <span class="text-fade">General Practitioners</span>
                            </div>
                            <div class="dropdown">
                                <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-info">5</span>
                                </a>
                                <a class="dropdown-item" href="#">Sent</a>
                                <a class="dropdown-item" href="#">Spam</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Draft</span>
                                    <span class="badge badge-pill badge-default">1</span>
                                </a>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="me-15">
                                <img src="{{ asset('dashboard/images/avatar/avatar-15.png') }}" class="avatar avatar-lg rounded10 bg-primary-light" alt="" />
                            </div>
                            <div class="d-flex flex-column flex-grow-1 fw-500">
                                <a href="#" class="text-dark hover-warning mb-1 fs-16">Dr. Natalie doe</a>
                                <span class="text-fade">Physician</span>
                            </div>
                            <div class="dropdown">
                                <a class="px-10 pt-5" href="#" data-bs-toggle="dropdown"><i class="ti-more-alt"></i></a>
                                <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Inbox</span>
                                    <span class="badge badge-pill badge-info">5</span>
                                </a>
                                <a class="dropdown-item" href="#">Sent</a>
                                <a class="dropdown-item" href="#">Spam</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item flexbox" href="#">
                                    <span>Draft</span>
                                    <span class="badge badge-pill badge-default">1</span>
                                </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box bg-success box-inverse">
                <div class="box-header">
                    <h4 class="box-title">Doctor of the Month</h4>
                </div>
                <div class="box-body text-center">
                    <div class="mb-0">
                        <img src="{{ asset('dashboard/images/avatar/avatar-12.png') }}" width="100" class="rounded-circle bg-info-light" alt="user">
                        <h3 class="mt-20 mb-0">Dr. Johen Doe</h3>
                        <p class="mb-0">Cardiologists</p>
                    </div>
                </div>
                <div class="p-20">
                    <div class="row">
                        <div class="col-6 be-1">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('dashboard/images/health-1.png') }}" class="img-fluid me-10 w-50" alt="" />
                                <div>
                                    <h2 class="mb-0 text-white">10</h2>
                                    <p class="mb-0 text-white-50">Operations</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('dashboard/images/health-2.png') }}" class="img-fluid me-10 w-50" alt="" />
                                <div>
                                    <h2 class="mb-0 text-white">47</h2>
                                    <p class="mb-0 text-white-50">Patients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="box">		
                <div class="box-header no-border">
                    <h4 class="box-title">Admission by Division</h4>
                </div>
                <div class="box-body pt-0">	
                    <div id="chart124"></div>
                    <div class="row mt-25">
                        <div class="col-6">
                            <p class="mb-5"><span class="badge badge-dot badge-success"></span> Cardiology</p>
                            <p class="mb-5"><span class="badge badge-dot badge-info"></span> Endocrinology</p>
                            <p class="mb-0"><span class="badge badge-dot badge-danger"></span> Physicians</p>
                        </div>
                        <div class="col-6">
                            <p class="mb-5"><span class="badge badge-dot badge-warning"></span> Dermatology</p>
                            <p class="mb-5"><span class="badge badge-dot badge-primary"></span> Orthopedics</p>
                            <p class="mb-0"><span class="badge badge-dot badge-secondary"></span> Immunology</p>
                        </div>
                    </div>
                </div>																		
            </div>					
            
        </div>
    </div>	
</div>
@endsection	
@section('script')
    <script>
        var options = {
          series: [
          {
            name: "New Patient",
			data: [28, 15, 30, 18, 35 , 13, 43]
          },
          {
            name: "Return Patient",            
            data: [10, 39, 20, 36, 15, 32, 17]
          }
        ],
          chart: {
          height: 200,
          type: 'line',
          toolbar: {
            show: false
          }
        },
        colors: ['#ee3158', '#1dbfc1'],
        dataLabels: {
          enabled: false,
        },
        stroke: {
          curve: 'smooth'
        },
		grid: {
			show: false,  
		},
        xaxis: {
          categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Set', 'Sun'],
        },
        legend: {
          show: true,
        },
		xaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
          }        
        },
        yaxis: {
          axisBorder: {
            show: false
          },
          axisTicks: {
            show: false,
          },
          labels: {
            show: false,
          }        
        },
        };

        var chart = new ApexCharts(document.querySelector("#patients_pace"), options);
        chart.render();

        var patientSignups = @json($patientSignups);
        var medicalSignups = @json($medicalSignups);
        var formattedDates = @json($formattedDates);

        var options = {
          series: [{
          name: 'Patients',
          data: patientSignups
        }, {
          name: 'Medical Professionals',
          data: medicalSignups
        }],
          chart: {
          type: 'bar',
		  foreColor:"#bac0c7",
          height: 330,
			  toolbar: {
        		show: false,
			  }
        },
        plotOptions: {
          bar: {
			// endingShape: 'rounded',
            horizontal: false,
            columnWidth: '50%',
          },
        },
        dataLabels: {
          enabled: false,
        },
		grid: {
			show: false,			
		},
        stroke: {
          show: true,
          width: 2,
          colors: ['transparent']
        },
		colors: ['#ee3158', '#FFA800'],
        xaxis: {
          categories: formattedDates,
			
        },
        yaxis: {
            labels: {
                formatter: function (value) {
                    return value.toFixed(0); // Format to show integers
                }
            }
        },
		 legend: {
      		show: true,
		 },
        fill: {
          opacity: 1
        },
        tooltip: {
        theme: 'dark',
          y: {
            formatter: function (val) {
              return val
            }
          },
			marker: {
			  show: false,
		  },
        }
        };

        var chart = new ApexCharts(document.querySelector("#recent_trend"), options);
        chart.render();

    </script>
@endsection	
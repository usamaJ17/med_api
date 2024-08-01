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
                <div class="col-xl-12 col-12">						
                    <div class="box">
                        <div class="box-header">
                            <h4 class="box-title">Appointment</h4>
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
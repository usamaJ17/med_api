@extends('dashboard.layouts.app')

@section('title')
    Dashboard
@endsection
@section('dashboard')
    active
@endsection
@section('dashboard.home')
    active
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
                                        <h3 class="fw-500 my-0">{{ isset($patients) ? count($patients) : 0 }}</h3>
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
                                        <h3 class="fw-500 my-0">{{ isset($medicals) ? count($medicals) : 0 }}</h3>
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
                                        <h3 class="fw-500 my-0">{{ isset($appointments) ? count($appointments) : 0 }}</h3>
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
                                        <h3 class="fw-500 my-0">{{ isset($total_revenue) ? $total_revenue : 0 }} GHS</h3>
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
                                <div>
                                    <button onclick="updateChartWithTimeFrame('daily')">Daily</button>
                                    <button onclick="updateChartWithTimeFrame('weekly')">Weekly</button>
                                    <button onclick="updateChartWithTimeFrame('monthly')">Monthly</button>
                                    <button onclick="updateChartWithTimeFrame('all_time')">All Time</button>
                                </div>
                                <div id="recent_trend"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Patient Signups States</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateStatePChartWithTimeFrame('daily')">Daily</button>
                                    <button onclick="updateStatePChartWithTimeFrame('weekly')">Weekly</button>
                                    <button onclick="updateStatePChartWithTimeFrame('monthly')">Monthly</button>
                                    <button onclick="updateStatePChartWithTimeFrame('all_time')">All Time</button>
                                </div>
                                <div id="patient_trend_chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Medical Signups States</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateStateMChartWithTimeFrame('daily')">Daily</button>
                                    <button onclick="updateStateMChartWithTimeFrame('weekly')">Weekly</button>
                                    <button onclick="updateStateMChartWithTimeFrame('monthly')">Monthly</button>
                                    <button onclick="updateStateMChartWithTimeFrame('all_time')">All Time</button>
                                </div>
                                <div id="medical_trend_chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Revenue</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateChartWithTimeFrame1('daily')">Daily</button>
                                    <button onclick="updateChartWithTimeFrame1('weekly')">Weekly</button>
                                    <button onclick="updateChartWithTimeFrame1('monthly')">Monthly</button>
                                    <button onclick="updateChartWithTimeFrame1('all_time')">All Time</button>
                                </div>
                                <div id="revenue_trend"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Number of patients Booking appointments per Region</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateStateApChartWithTimeFrame('daily')">Daily</button>
                                    <button onclick="updateStateApChartWithTimeFrame('weekly')">Weekly</button>
                                    <button onclick="updateStateApChartWithTimeFrame('monthly')">Monthly</button>
                                    <button onclick="updateStateApChartWithTimeFrame('all_time')">All Time</button>
                                </div>
                                <div id="appointment_state_overview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Appointment</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateChartWithTimeFrame2('daily')">Daily</button>
                                    <button onclick="updateChartWithTimeFrame2('weekly')">Weekly</button>
                                    <button onclick="updateChartWithTimeFrame2('monthly')">Monthly</button>
                                    <button onclick="updateChartWithTimeFrame2('all_time')">All Time</button>
                                </div>
                                <div id="appointment_overview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Patient by Age Group</h4>
                            </div>
                            <div class="box-body">
                                <div id="age_group_overview"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">Daily Consultations per professional category</h4>
                            </div>
                            <div class="box-body">
                                <div>
                                    <button onclick="updateCChartWithTimeFrame('daily')">Daily</button>
                                    <button onclick="updateCChartWithTimeFrame('weekly')">Weekly</button>
                                    <button onclick="updateCChartWithTimeFrame('monthly')">Monthly</button>
                                    <button onclick="updateCChartWithTimeFrame('all_time')">All Time</button>
                                </div>
                                <div id="patients_pace"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-12">
                <div class="box">
                    <div class="box-header no-border">
                        <h4 class="box-title">Professional Categories Sign-Ups</h4> <small>(Last 15 days)</small>
                    </div>
                    <div class="box-body pt-0">
                        <div id="chart124"></div>
                        <div class="row mt-25">
                            @php
                                $patCatCount = count($dailyPatientCountCat);
                                $i = 0;
                                $type = ['success', 'info', 'danger', 'warning', 'primary', 'secondary', 'dark'];
                                $badgeIndex = 0;
                            @endphp

                            <div class="row">
                                @foreach ($dailyPatientCountCat as $typeName => $count)
                                    @if ($i % 3 == 0)
                                        @if ($i != 0)
                            </div>
                            @endif
                            <div class="col-6"> {{-- Start a new column --}}
                                @endif

                                <p class="mb-5">
                                    <span class="badge badge-dot badge-{{ $type[$badgeIndex % count($type)] }}"></span>
                                    {{ $typeName }}: {{ $count }}
                                </p>

                                @php
                                    $i++;
                                    $badgeIndex++;
                                @endphp
                                @endforeach
                            </div> {{-- Close the last column --}}
                        </div>

                    </div>
                </div>
                <div class="box bg-success box-inverse">
                    <div class="box-header">
                        <h4 class="box-title">Doctor of the Month</h4>
                    </div>
                    <div class="box-body text-center">
                        <div class="mb-0">
                            <img src="{{ $maxDoc->getFirstMediaUrl() }}" width="100"
                                class="rounded-circle bg-info-light" alt="user">
                            <h3 class="mt-20 mb-0">{{ $maxDoc->fullName() }}</h3>
                            <p class="mb-0">{{ $maxDoc->professional_type_name }}</p>
                        </div>
                    </div>
                    <div class="p-20">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('dashboard/images/health-2.png') }}" class="img-fluid me-10 w-50"
                                        alt="" />
                                    <div>
                                        <h2 class="mb-0 text-white">{{ $maxAppointmentCount }}</h2>
                                        <p class="mb-0 text-white-50">Appointments In Last 30 Days</p>
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
        var patientSignups = @json($patientSignups);
        var dailyPatientCountCat = @json($dailyPatientCountCat);
        var patientSignupsStates = @json($patientSignupsStates);
        var total_monthly_revenue = @json($total_monthly_revenue);
        var medicalSignups = @json($medicalSignups);
        var medicalSignupsStates = @json($medicalSignupsStates);
        var appointmentData = @json($appointmentData);
        var cancelAppointmentData = @json($cancelAppointmentData);
        var pro_cat_appointment = @json($pro_cat_appointment);
        var appointment_state_overview = @json($appointment_state_overview);

        
        var age = @json($age);
        var baseColors = ['#ee3158', '#1dbfc1', '#ff9900', '#ff5733', '#33ff57', '#3357ff'];
        var colors = [];

        // Generate colors based on the number of categories
        for (var i = 0; i < Object.keys(pro_cat_appointment).length; i++) {
            colors.push(baseColors[i % baseColors.length]);
        }
        function groupDataByTimeFrame(data, timeFrame) {
            const currentMonth = new Date().toLocaleString('default', { month: 'short' }); // Current month (e.g., "Jan", "Feb")
            const currentYear = new Date().getFullYear(); // Current year

            const filteredData = {
                date: data.date.filter(date => {
                    const [day, month] = date.split(" "); // Extract day and month (e.g., "21 Aug")
                    return month === currentMonth; // Match the month
                }),
                data: []
            };

            // Match the data points with the filtered dates
            filteredData.data = filteredData.date.map(date => {
                const index = data.date.indexOf(date);
                return index !== -1 ? data.data[index] : 0;
            });

            let groupedData = {
                date: [],
                data: []
            };

            if (timeFrame === "daily") {
                // Return the filtered data for daily view
                return filteredData;
            } else if (timeFrame === "weekly") {
                let weekCount = 0;
                let weekLabel = [];

                filteredData.date.forEach((date, index) => {
                    weekCount += filteredData.data[index];
                    weekLabel.push(date);

                    // Group by 7 days (weekly)
                    if ((index + 1) % 7 === 0 || index === filteredData.date.length - 1) {
                        groupedData.date.push(weekLabel[0] + " - " + weekLabel[weekLabel.length - 1]);
                        groupedData.data.push(weekCount);
                        weekCount = 0; // Reset for the next week
                        weekLabel = [];
                    }
                });
            } else if (timeFrame === "monthly") {
                // For the current month, simply sum all values
                groupedData.date = [currentMonth + " " + currentYear]; // Label for the current month
                groupedData.data = [filteredData.data.reduce((sum, count) => sum + count, 0)];
            } else if (timeFrame === "all_time") {
                // Group all data by months, no date filtering
                const allData = {};

                data.date.forEach((date, index) => {
                    const [day, month, year] = date.split(" "); // Extract day, month, and year (e.g., "21 Aug 2023")
                    const monthYear = `${month}`; // Create a unique label for each month-year combination

                    if (!allData[monthYear]) {
                        allData[monthYear] = 0;
                    }

                    allData[monthYear] += data.data[index]; // Sum data for the month-year
                });

                groupedData.date = Object.keys(allData); // Get all month-year labels
                groupedData.data = Object.values(allData); // Get all summed data values
            }

            return groupedData;
        }

        function groupDataByTimeFrame1(data, statesData, dates, timeFrame) {
            const currentMonth = new Date().toLocaleString('default', { month: 'short' }); // Current month (e.g., "Jan", "Feb")

            // Filter dates for the current month only
            const filteredDates = dates.filter(date => {
                const [day, month] = date.split(" "); // Extract day and month (ignoring year)
                return month === currentMonth; // Match the month
            });

            let groupedData = {
                date: [],
                data: {}
            };

            if (timeFrame === "daily") {
                // Keep the original structure for the current month only
                groupedData.date = filteredDates;
                statesData.forEach(state => {
                    groupedData.data[state] = filteredDates.map(date => {
                        const record = data.data.find(
                            item => item.date === date && item.state === state
                        );
                        return record ? record.value : 0; // Default to 0 if no record is found
                    });
                });
            } else if (timeFrame === "weekly") {
                let weekCount = {};
                let startOfWeek = null; // To track the first date of the week

                filteredDates.forEach((date, index) => {
                    if (index % 7 === 0) {
                        // Start of a new week
                        startOfWeek = date;
                    }

                    statesData.forEach(state => {
                        if (!weekCount[state]) weekCount[state] = 0;

                        const record = data.data.find(
                            item => item.date === date && item.state === state
                        );
                        weekCount[state] += record ? record.value : 0;
                    });

                    // Aggregate every 7 days or at the end of the dataset
                    if ((index + 1) % 7 === 0 || index === filteredDates.length - 1) {
                        // Construct weekly label
                        const endOfWeek = date; // Current date is the end of the week
                        groupedData.date.push(`${startOfWeek} - ${endOfWeek}`);

                        // Push aggregated data for each state
                        statesData.forEach(state => {
                            if (!groupedData.data[state]) groupedData.data[state] = [];
                            groupedData.data[state].push(weekCount[state]);
                            weekCount[state] = 0; // Reset for the next week
                        });

                        startOfWeek = null; // Reset the week start for the next week
                    }
                });
            } else if (timeFrame === "monthly") {
                // For the current month, aggregate data by state
                groupedData.date = [currentMonth]; // Label for the current month
                statesData.forEach(state => {
                    const monthRecords = data.data.filter(
                        item => filteredDates.includes(item.date) && item.state === state
                    );
                    groupedData.data[state] = [
                        monthRecords.reduce((sum, record) => sum + record.value, 0) // Sum values for the month
                    ];
                });
            } else if (timeFrame === "all_time") {
                // Group all data by months without filtering
                const allData = {};

                dates.forEach(date => {
                    const [day, month, year] = date.split(" "); // Extract day, month, and year
                    const monthYear = `${month}`; // Create unique month-year label

                    statesData.forEach(state => {
                        if (!allData[monthYear]) allData[monthYear] = {};
                        if (!allData[monthYear][state]) allData[monthYear][state] = 0;

                        const record = data.data.find(
                            item => item.date === date && item.state === state
                        );

                        allData[monthYear][state] += record ? record.value : 0;
                    });
                });

                groupedData.date = Object.keys(allData); // Month-year labels
                statesData.forEach(state => {
                    groupedData.data[state] = groupedData.date.map(monthYear => allData[monthYear][state]);
                });
            }

            return groupedData;
        }

        updateChartWithTimeFrame('daily');
        var chart1;
        function updateChartWithTimeFrame(timeFrame) {
            const filteredData = groupDataByTimeFrame(patientSignups, timeFrame);
            const filteredDataM = groupDataByTimeFrame(medicalSignups, timeFrame);
            
            if (chart1) {
                chart1.destroy();
            }
            var options = {
                series: [{
                    name: 'Patients',
                    data: filteredData.data
                }, {
                    name: 'Medical Professionals',
                    data: filteredDataM.data
                }],
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    colors: ['#ee3158', '#FFA800'],
                },
                colors: ['#ee3158', '#FFA800'],
                xaxis: {
                    categories: filteredData.date,

                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };

            chart1 = new ApexCharts(document.querySelector("#recent_trend"), options);
            chart1.render();
        }

        updateStateApChartWithTimeFrame('daily');
        var appointmentChart;
        function updateStateApChartWithTimeFrame(timeFrame){
            if (appointmentChart) {
                appointmentChart.destroy();
            }
            const uniqueStates = [...new Set(appointment_state_overview.data.map(item => item.state))];
            const groupedData = groupDataByTimeFrame1(appointment_state_overview, uniqueStates, appointment_state_overview.date,timeFrame);
            const seriesData = uniqueStates.map(state => ({
                name: state,
                data: groupedData.data[state]
            }));
            
            var patientOptions = {
                series: seriesData,
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    // colors: colours,
                },
                // colors: colours,
                xaxis: {
                    categories: groupedData.date,
                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };
            appointmentChart = new ApexCharts(document.querySelector("#appointment_state_overview"), patientOptions);
            appointmentChart.render();
        }
        updateStatePChartWithTimeFrame('daily');
        var patientChart;
        function updateStatePChartWithTimeFrame(timeFrame){
            if (patientChart) {
                patientChart.destroy();
            }
            const uniqueStates = [...new Set(patientSignupsStates.data.map(item => item.state))];
            const groupedData = groupDataByTimeFrame1(patientSignupsStates, uniqueStates, patientSignupsStates.date,timeFrame);
            const seriesData = uniqueStates.map(state => ({
                name: state,
                data: groupedData.data[state]
            }));
            var patientOptions = {
                series: seriesData,
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    // colors: colours,
                },
                // colors: colours,
                xaxis: {
                    categories: groupedData.date,
                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };
            patientChart = new ApexCharts(document.querySelector("#patient_trend_chart"), patientOptions);
            patientChart.render();
        }
        updateStateMChartWithTimeFrame('daily');
        var medicalChart;
        function updateStateMChartWithTimeFrame(timeFrame){
            if (medicalChart) {
                medicalChart.destroy();
            }
            const uniqueStates1 = [...new Set(medicalSignupsStates.data.map(item => item.state))];
            
            const groupedData = groupDataByTimeFrame1(medicalSignupsStates, uniqueStates1, medicalSignupsStates.date,timeFrame);
            const seriesData = uniqueStates1.map(state => ({
                name: state,
                data: groupedData.data[state]
            }));
            
            var medicalOptions = {
                series: seriesData,
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    // colors: colours,
                },
                // colors: colours,
                xaxis: {
                    categories: groupedData.date,
                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };

            medicalChart = new ApexCharts(document.querySelector("#medical_trend_chart"), medicalOptions);
            medicalChart.render();
        }


        updateChartWithTimeFrame1('daily');
        var chart2;
        function updateChartWithTimeFrame1(timeFrame) {
            const filteredData = groupDataByTimeFrame(total_monthly_revenue, timeFrame);
            if (chart2) {
                chart2.destroy();
            }
            var options = {
                series: [{
                    name: 'Revenue',
                    data: filteredData.data
                }],
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    colors: ['#00D0FF'],
                },
                colors: ['#00D0FF'],
                xaxis: {
                    categories: filteredData.date,

                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };

            chart2 = new ApexCharts(document.querySelector("#revenue_trend"), options);
            chart2.render();
        }

        updateChartWithTimeFrame2('daily');
        var chart3;
        function updateChartWithTimeFrame2(timeFrame) {
            const filteredData = groupDataByTimeFrame(appointmentData, timeFrame);
            const filteredData1 = groupDataByTimeFrame(cancelAppointmentData, timeFrame);
            if (chart3) {
                chart3.destroy();
            }
            var options = {
                series: [{
                    name: 'Total',
                    data: filteredData.data
                }, {
                    name: 'Cancelled',
                    data: filteredData1.data
                }],
                chart: {
                    type: 'bar',
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
                    show: false,
                    width: 0,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: filteredData.date,

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

            chart3 = new ApexCharts(document.querySelector("#appointment_overview"), options);
            chart3.render();
        }
        var options = {
            series: [{
                name: 'Total',
                data: Object.values(age)
            }],
            chart: {
                type: 'bar',
                height: 270,
                toolbar: {
                    show: false
                }
            },
            colors: ['#ee3158'],
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
                show: false,
                width: 0,
                colors: ['transparent']
            },
            xaxis: {
                categories: Object.keys(age),

            },
            yaxis: {
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
                        return val
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#age_group_overview"), options);
        chart.render();

        function groupDataByTimeFrame12(series, dates, timeFrame) {
            const currentMonth = new Date().toLocaleString('default', { month: 'short' }); // Current month (e.g., "Jan", "Feb")

            // Filter dates for the current month only
            const filteredDates = dates.filter(date => {
                const [day, month] = date.split(" "); // Extract day and month (ignoring year)
                return month === currentMonth; // Match the month
            });

            let groupedData = {
                date: [],
                series: []
            };

            if (timeFrame === "daily") {
                // Keep the original structure for the current month only
                groupedData.date = filteredDates;
                groupedData.series = series.map(s => ({
                    name: s.name,
                    data: filteredDates.map(date => {
                        const index = dates.indexOf(date);
                        return index !== -1 ? s.data[index] : 0; // Default to 0 if no data for the date
                    })
                }));
            } else if (timeFrame === "weekly") {
                // Weekly aggregation for the current month
                let weekLabels = [];
                let weekCounts = series.map(s => ({
                    name: s.name,
                    data: []
                }));

                filteredDates.forEach((date, index) => {
                    weekLabels.push(date);

                    series.forEach((s, i) => {
                        if (!weekCounts[i].data[weekCounts[i].data.length - 1]) {
                            weekCounts[i].data[weekCounts[i].data.length - 1] = 0;
                        }
                        const dataIndex = dates.indexOf(date);
                        weekCounts[i].data[weekCounts[i].data.length - 1] += dataIndex !== -1 ? s.data[dataIndex] : 0;
                    });

                    if ((index + 1) % 7 === 0 || index === filteredDates.length - 1) {
                        groupedData.date.push(`${weekLabels[0]} - ${weekLabels[weekLabels.length - 1]}`);
                        weekCounts.forEach((s, i) => {
                            weekCounts[i].data.push(0); // Start a new week's aggregation
                        });
                        weekLabels = [];
                    }
                });

                groupedData.series = weekCounts.map(s => ({
                    name: s.name,
                    data: s.data.slice(0, -1) // Remove the last empty week's data
                }));
            } else if (timeFrame === "monthly") {
                // Monthly aggregation for the current month
                let monthMap = {};
                filteredDates.forEach((date, index) => {
                    const month = date.split(" ")[1]; // Assuming "dd MMM" format

                    if (!monthMap[month]) {
                        monthMap[month] = {};
                        series.forEach(s => {
                            monthMap[month][s.name] = 0;
                        });
                    }

                    series.forEach(s => {
                        const dataIndex = dates.indexOf(date);
                        monthMap[month][s.name] += dataIndex !== -1 ? s.data[dataIndex] : 0;
                    });
                });

                groupedData.date = Object.keys(monthMap); // Months as labels
                groupedData.series = series.map(s => ({
                    name: s.name,
                    data: groupedData.date.map(month => monthMap[month][s.name])
                }));
            } else if (timeFrame === "all_time") {
                // Group all data by months without filtering
                let monthMap = {};
                dates.forEach((date, index) => {
                    const month = date.split(" ")[1]; // Assuming "dd MMM" format

                    if (!monthMap[month]) {
                        monthMap[month] = {};
                        series.forEach(s => {
                            monthMap[month][s.name] = 0;
                        });
                    }

                    series.forEach(s => {
                        monthMap[month][s.name] += s.data[index];
                    });
                });

                groupedData.date = Object.keys(monthMap); // Months as labels
                groupedData.series = series.map(s => ({
                    name: s.name,
                    data: groupedData.date.map(month => monthMap[month][s.name])
                }));
            }

            return groupedData;
        }

        updateCChartWithTimeFrame("daily");
        var cchart;
        function updateCChartWithTimeFrame(timeFrame) {
            var date_series_app_cat;
            var appointment_cat_series = [];
            Object.keys(pro_cat_appointment).forEach(function(key) {
                if (key === 'date') {
                    date_series_app_cat = {
                        name: key,
                        data: pro_cat_appointment[key]
                    };
                } else if (key === 'data') {
                    Object.keys(pro_cat_appointment[key]).forEach(function(subKey) {
                        appointment_cat_series.push({
                            name: subKey,
                            data: pro_cat_appointment[key][subKey]
                        });
                    });
                }
            });
            const groupedData = groupDataByTimeFrame12(appointment_cat_series, date_series_app_cat.data, timeFrame);
            if (cchart) {
                cchart.destroy();
            }
            var options = {
                series:  groupedData.series,
                chart: {
                    type: 'area',
                    stacked: false,
                    foreColor: "#bac0c7",
                    zoom: {
                        type: 'x',
                        enabled: true,
                        autoScaleYaxis: true
                    },
                    height: 330,
                    toolbar: {
                        show: false,
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: false,
                        opacityFrom: 0.5,
                        opacityTo: 0,
                        stops: [0, 95, 100]
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
                    colors: ['#389F99', '#E8F9F9', '#689F38', '#EE1044', '#3D6EAE', '#FFA800', '#FF9D00'],
                },
                colors: ['#389F99', '#E8F9F9', '#689F38', '#EE1044', '#3D6EAE', '#FFA800', '#FF9D00'],
                xaxis: {
                    categories: groupedData.date,

                },
                legend: {
                    show: true,
                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return val
                        }
                    },
                    marker: {
                        show: false,
                    },
                }
            };

            cchart = new ApexCharts(document.querySelector("#patients_pace"), options);
            cchart.render();
        }

        const labels = Object.keys(dailyPatientCountCat);
        const series = Object.values(dailyPatientCountCat);
        var options = {
            series: series,
            chart: {
                type: 'donut',
                width: 250,
            },
            dataLabels: {
                enabled: false,
            },
            colors: ['#3246D3', '#00D0FF', '#ee3158', '#ffa800', '#1dbfc1', '#e4e6ef'],
            legend: {
                show: false,
            },

            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                    }
                }
            },
            labels: labels,
            responsive: [{
                breakpoint: 1600,
                options: {
                    chart: {
                        width: 250,
                    }
                }
            }, {
                breakpoint: 500,
                options: {
                    chart: {
                        width: 200,
                    }
                }
            }]
        };

        var chart = new ApexCharts(document.querySelector("#chart124"), options);
        chart.render();
    </script>
@endsection

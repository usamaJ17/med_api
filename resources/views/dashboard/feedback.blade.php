@extends('dashboard.layouts.app')

@section('title')
    Dashboard
@endsection
@section('dashboard')
    active
@endsection
@section('dashboard.feedback')
    active
@endsection
@section('content')
    <div class="section">
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-xl-12 col-12">
                        <div class="box">
                            <div class="box-header">
                                <h4 class="box-title">User Feedback</h4>
                            </div>
                            <div class="box-body">
                                <div id="user_feedback"></div>
                            </div>
                            <div class="box-body">
                                <table class="table mb-0" id="exampleapppat">
                                    <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Rating</th>
                                        <th>FeedBack</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($userFeedbackData as $item)
                                        <tr>
                                            <td>{{ $item->user->fullName() }}</td>
                                            <td>{{ $item->rating }}</td>
                                            <td>{{ $item->message }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
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
        $(function() {
            'use strict';
            var user_feedback = @json($userFeedback);

            var options = {
                series: [{
                    name: 'feedback',
                    data: user_feedback.data
                }, {
                    name: 'Medical Professionals',
                    data: user_feedback.data
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
                    categories: user_feedback.date,

                },
                legend: {
                    show: true,
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

            var chart = new ApexCharts(document.querySelector("#user_feedback"), options);
            chart.render();

            $('#exampleapppat').DataTable({
                'paging': true,
                'lengthChange': false,
                'searching': true,
                'ordering': true,
                'info': false,
                'pageLength': 10,
                'autoWidth': false
            });
        });
    </script>
@endsection

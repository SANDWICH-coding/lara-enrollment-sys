@extends('adminlte::page')

@section('title', 'Blessed Trinity Academy')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-info">
                <div class="inner">
                    @if(isset($activeSchoolYear))
                    <h3>{{ $activeSchoolYear->schoolYearName }}</h3> <!-- Display active school year name -->
                    <p class="bg-white pl-2 rounded border" style="width: 90px;"><i class="fas fa-circle text-success" style="font-size: 10px;"></i> Active</p>
                    @else
                    <h3>N/A</h3> <!-- Display N/A if no active school year -->
                    <p class="text-danger">No active school year</p>
                    @endif
                </div>
                <div class="icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <a href="{{ route('manage.school.year') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{ $bounceRate < 0 ? 'bg-gradient-danger' : ($bounceRate == 0 ? 'bg-gradient-secondary' : 'bg-gradient-success') }}">
                <div class="inner">
                    <h3>
                        {{ round($bounceRate) }}<sup style="font-size: 20px">%</sup>
                    </h3>

                    <p>Bounce Rate</p>
                </div>
                <div class="icon">
                    <i class="fas {{ $bounceRate < 0 ? 'fa-arrow-down' : ($bounceRate == 0 ? 'fa-minus' : 'fa-arrow-up') }}"></i>
                </div>
                <a href="#" class="small-box-footer" id="toggleChart">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-warning">
                <div class="inner">
                    <h3>44</h3>

                    <p>Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-gradient-danger">
                <div class="inner">
                    <h3><span>₱</span>6,000.00</h3>

                    <p>Collectable</p>
                </div>
                <div class="icon">
                    <i class="fas fa-cash-register"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- Add new card for the line chart below the row -->
    <div class="row">
        <div class="col-6">
            <!-- Chart container hidden by default -->
            <div class="card" id="bounceRateChartContainer" style="display: none;">
                <div class="card-header bg-gradient-default">
                    <h5 class="card-title">Bounce Rate Line Graph</h5>

                    <div class="card-tools">
                        <div class="btn-group">

                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a href="#" class="dropdown-item" id="lineGraph">Line Graph</a>
                                <a href="#" class="dropdown-item" id="barGraph">Bar Graph</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bounceRateChartLine" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-6">
            <!-- Chart container hidden by default -->
            <div class="card" id="bounceRateChartContainer" style="display: none;">
                <div class="card-header bg-gradient-default">
                    <h5 class="card-title">Bounce Rate Bar Graph</h5>

                    <div class="card-tools">
                        <div class="btn-group">

                            <div class="dropdown-menu dropdown-menu-right" role="menu">
                                <a href="#" class="dropdown-item" id="lineGraph">Line Graph</a>
                                <a href="#" class="dropdown-item" id="barGraph">Bar Graph</a>
                            </div>
                        </div>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="bounceRateChartBar" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>

    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle visibility of the chart when "More info" is clicked
    document.getElementById('toggleChart').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        var chartContainers = document.querySelectorAll('#bounceRateChartContainer');

        // Toggle the display property of each chart container
        chartContainers.forEach(function(container) {
            if (container.style.display === 'none') {
                container.style.display = 'block'; // Show the chart
            } else {
                container.style.display = 'none'; // Hide the chart
            }
        });
    });

    fetch("/api/admin-dashboard")
        .then((response) => {
            if (!response.ok) {
                throw new Error("Something went wrong!");
            }
            return response.json();
        })
        .then((data) => {
            // Extract data for chart
            const enrollmentData = data.enrollmentData;

            const labels = enrollmentData.map((entry) => entry.schoolYear);
            const totalData = enrollmentData.map((entry) => entry.totalEnrollments);
            const maleData = enrollmentData.map((entry) => entry.maleEnrollments);
            const femaleData = enrollmentData.map((entry) => entry.femaleEnrollments);

            // Line Chart
            const lineCtx = document.getElementById("bounceRateChartLine").getContext("2d");
            new Chart(lineCtx, {
                type: "line",
                data: {
                    labels: labels,
                    datasets: [{
                            label: "Total",
                            data: totalData,
                            backgroundColor: "#17a2b8",
                            borderColor: "#17a2b8",
                            tension: 0.3,
                        },
                        {
                            label: "Male",
                            data: maleData,
                            backgroundColor: "#007bff",
                            borderColor: "#007bff",
                            tension: 0.3,
                        },
                        {
                            label: "Female",
                            data: femaleData,
                            backgroundColor: "#e83e8c",
                            borderColor: "#e83e8c",
                            tension: 0.3,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });

            // Bar Chart
            const barCtx = document.getElementById("bounceRateChartBar").getContext("2d");
            new Chart(barCtx, {
                type: "bar",
                data: {
                    labels: labels,
                    datasets: [{
                            label: "Total",
                            data: totalData,
                            backgroundColor: "#17a2b8",
                        },
                        {
                            label: "Male",
                            data: maleData,
                            backgroundColor: "#007bff",
                        },
                        {
                            label: "Female",
                            data: femaleData,
                            backgroundColor: "#e83e8c",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                        },
                    },
                },
            });

        })
        .catch((error) => {
            console.error("Error:", error);
        });
</script>


<script>

</script>


@endpush
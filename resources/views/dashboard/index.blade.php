@extends('layout.main')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__wobble img-circle elevation-3 brand-img" src="/assets/dist/img/mawaridLogo.jpg" alt="MawaridLogo" height="160" width="160">
    </div>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content connectedSortable">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$students_count}}</h3>
                            <p>Student</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="/students" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$teachers_count}}</h3>

                            <p>Teacher</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="/teachers" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{$parents_count}}</h3>

                            <p>Parent</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="/parents" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$classes_count}}</h3>

                            <p>Available Class</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="/class" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{$absent_atd}}</h3>

                            <p>Today Absent</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{$today_atd}}</h3>

                            <p>Today Present</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            </div>

            <!-- Chart -->
            <div class="row">
                <div class="card" style="width: 50%">
                    <div class="card-header ui-sortable-handle" style="cursor: move;">
                        <h3 class="card-title">
                            <i class="fas fa-chart-line mr-1"></i>
                            Profit & Expenses
                        </h3>
                        <div class="card-tools">
                            <ul class="nav nav-pills ml-auto">
                                <li class="nav-item">
                                    <a class="nav-link active" href="/profit"><i class="fas fa-eye"></i> View</a>
                                </li>
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="#expenses-chart" data-toggle="tab">Donut</a>--}}
{{--                                </li>--}}
                            </ul>
                        </div>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <select id="year-filter" class="form-control mb-3 w-48">
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                            <!-- Area Chart -->
                            <div class="chart tab-pane active" id="profit-chart" style="position: relative; height: 300px;">
                                <canvas id="profit-chart-canvas" height="300"></canvas>
                            </div>
{{--                            <!-- Donut Chart -->--}}
{{--                            <div class="chart tab-pane" id="expenses-chart" style="position: relative; height: 300px;">--}}
{{--                                All Expense--}}
{{--                                <canvas id="expenses-chart-canvas" height="300"></canvas>--}}
{{--                            </div>--}}
                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


    <script>
        let chart;

        function loadChart(year) {
            fetch(`/dashboard/chart-data?year=${year}`)
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('profit-chart-canvas').getContext('2d');

                    const chartData = {
                        labels: data.labels,
                        datasets: [
                            {
                                label: 'Profit',
                                data: data.profits,
                                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                                borderColor: 'rgba(40, 167, 69, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            },
                            {
                                label: 'Expense',
                                data: data.expenses,
                                backgroundColor: 'rgba(220, 53, 69, 0.2)',
                                borderColor: 'rgba(220, 53, 69, 1)',
                                borderWidth: 2,
                                tension: 0.3,
                                fill: true
                            }
                        ]
                    };

                    const chartOptions = {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: true
                            }
                        },
                        scales: {
                            x: { grid: { display: false } },
                            y: { beginAtZero: true }
                        }
                    };

                    if (chart) {
                        chart.destroy();
                    }

                    chart = new Chart(ctx, {
                        type: 'line',
                        data: chartData,
                        options: chartOptions
                    });
                });
        }

        // Load current year by default
        document.addEventListener('DOMContentLoaded', function () {
            const initialYear = document.getElementById('year-filter').value;
            loadChart(initialYear);
        });

        // Update chart on year change
        document.getElementById('year-filter').addEventListener('change', function () {
            const selectedYear = this.value;
            loadChart(selectedYear);
        });
    </script>

@endsection

@extends('layouts.admin')

@section('title')
{{ __('Dashboard') }}
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <!-- Estatísticas Rápidas -->
        <div class="row">
            <div class="col-12">
                <div class="card mt-3">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Dashboard') }}</h3>
                    </div>
                    <div class="card-body">
                        {{ __('Welcome to the admin dashboard') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Pequenos boxes -->
        <div class="row">
            <!-- Total de Usuários -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalUsers }}</h3>
                        <p>{{ __('User Registrations') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <a href="{{ route('admin.users') }}" class="small-box-footer">
                        {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total de Condomínios -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalCondominiums }}</h3>
                        <p>{{ __('Condominiums') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="{{ route('admin.condominiums') }}" class="small-box-footer">
                        {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total de Reclamações -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalComplaints }}</h3>
                        <p>{{ __('Complaints') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <a href="{{ route('admin.complaints') }}" class="small-box-footer">
                        {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- Total de Pagamentos -->
            <div class="col-lg-3 col-md-6 col-12">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalPayments }}</h3>
                        <p>{{ __('Total Payments (€)') }}</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-money-bill"></i>
                    </div>
                    <a href="{{ route('admin.payments') }}" class="small-box-footer">
                        {{ __('More info') }} <i class="fas fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
        </div>

        <hr class="my-4">

        <!-- Gráficos -->
        <h1 class="mt-4">{{ __('Statistics') }}</h1>

        <div class="card mt-3">
            <div class="card-header">
                <h3 class="card-title">{{ __('Graphs') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div id="units-status-chart" style="height: 400px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="payments-status-chart" style="height: 400px;"></div>
                    </div>
                    <div class="col-md-4">
                        <div id="monthly-revenue-chart" style="height: 400px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script>
    google.charts.load('current', {
        'packages': ['corechart']
    });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        // Units Status Chart
        drawPieChart(
            'units-status-chart',
            '{{ __("Units Status") }}',
            @json($unitsStatus)
        );

        // Payments Status Chart
        drawPieChart(
            'payments-status-chart',
            '{{ __("Payments Status") }}',
            @json($paymentsStatus)
        );

        // Monthly Revenue Chart
        drawLineChart(
            'monthly-revenue-chart',
            '{{ __("Monthly Revenue") }}',
            @json($monthlyRevenue)
        );
    }

    function drawPieChart(elementId, title, dataArray) {
        var data = google.visualization.arrayToDataTable(dataArray);
        var options = {
            title: title,
            width: '100%',
            height: 400,
            pieHole: 0.4
        };
        var chart = new google.visualization.PieChart(document.getElementById(elementId));
        chart.draw(data, options);
    }

    function drawLineChart(elementId, title, dataArray) {
        dataArray = dataArray.map((row, index) => {
            if (index > 0) {
                row[0] = new Date(row[0]);
            }
            return row;
        });

        var data = google.visualization.arrayToDataTable(dataArray);
        var options = {
            title: title,
            curveType: 'function',
            width: '100%',
            height: 400,
            legend: {
                position: 'bottom'
            },
            hAxis: {
                title: '{{ __("Month") }}',
                format: 'MMM',
                slantedText: true,
                slantedTextAngle: 45,
                viewWindow: {
                    min: new Date(2024, 0, 1), // Start from January 2024
                    max: new Date(2025, 0, 1) // End at Jan 2025
                },
                ticks: [
                    new Date(2024, 0, 1), // Jan
                    new Date(2024, 1, 1), // Feb
                    new Date(2024, 2, 1), // Mar
                    new Date(2024, 3, 1), // Apr
                    new Date(2024, 4, 1), // May
                    new Date(2024, 5, 1), // Jun
                    new Date(2024, 6, 1), // Jul
                    new Date(2024, 7, 1), // Aug
                    new Date(2024, 8, 1), // Sep
                    new Date(2024, 9, 1), // Oct
                    new Date(2024, 10, 1), // Nov
                    new Date(2024, 11, 1), // Dec
                    new Date(2025, 0, 1) // Jan 25
                ]
            },
            vAxis: {
                title: '{{ __("Revenue") }}',
                minValue: 0
            }
        };
        var chart = new google.visualization.LineChart(document.getElementById(elementId));
        chart.draw(data, options);
    }
</script>


@endsection
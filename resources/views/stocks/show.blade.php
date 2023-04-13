<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historical Stock Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }

        .data-table-container {
            border-radius: 5px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            padding: 1rem;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 24px;
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body>
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif
    <div class="container">
        <h2 class="my-4">Stock Data : {{ $companyName }} ({{ $symbol }})</h2>
        <div class="data-table-container">
            <table id="historical-data" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Open</th>
                        <th>High</th>
                        <th>Low</th>
                        <th>Close</th>
                        <th>Volume</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($historicalData as $data)
                        @php
                            $dataDate = date('Y-m-d', $data['date']);
                        @endphp
                        @if ($dataDate >= $startDate && $dataDate <= $endDate)
                            <tr>
                                <td>{{ $dataDate }}</td>
                                <td>{{ $data['open'] ?? '-' }}</td>
                                <td>{{ $data['high'] ?? '-' }}</td>
                                <td>{{ $data['low'] ?? '-' }}</td>
                                <td>{{ $data['close'] ?? '-' }}</td>
                                <td>{{ $data['volume'] ?? '-' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="container">
        <div class="my-4">
            <canvas id="historical-data-chart"></canvas>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@2.3.0/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.1.0/dist/chartjs-adapter-luxon.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#historical-data').DataTable();
        });
        const chartData = {
            labels: [],
            datasets: [{
                    label: 'Open',
                    data: [],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                },
                {
                    label: 'Close',
                    data: [],
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                },
            ],
        };

        @foreach ($historicalData as $data)
            @php
                $dataDate = date('Y-m-d', $data['date']);
            @endphp
            @if ($dataDate >= $startDate && $dataDate <= $endDate)
                chartData.labels.push("{{ $dataDate }}");
                chartData.datasets[0].data.push({{ $data['open'] ?? 'null' }});
                chartData.datasets[1].data.push({{ $data['close'] ?? 'null' }});
            @endif
        @endforeach

        // Create chart
        const ctx = document.getElementById('historical-data-chart').getContext('2d');
        const historicalDataChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            parser: 'yyyy-MM-dd',
                            unit: 'day',
                        },
                        ticks: {
                            displayFormats: {
                                day: 'yyyy-MM-dd',
                            },
                        },
                    },
                    y: {
                        beginAtZero: false,
                    },
                },
            },
        });
    </script>
</body>

</html>

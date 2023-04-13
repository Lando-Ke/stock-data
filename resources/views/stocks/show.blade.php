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
    </style>
</head>

<body>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#historical-data').DataTable();
        });
    </script>
</body>

</html>

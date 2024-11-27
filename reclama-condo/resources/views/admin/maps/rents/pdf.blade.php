<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        td {
            font-size: 11px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    <h1>Rent Map Report</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Unit</th>
                <th>Tenant</th>
                <th>Due Date</th>
                <th>Amount (€)</th>
                <th>Status</th>
                <th>Paid At</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monPayments as $monPayment)
                <tr>
                    <td>{{ $monPayment->id }}</td>
                    <td>{{ $monPayment->unit->unit_number }} - {{ $monPayment->unit->block->block }} - {{ $monPayment->unit->block->condominium->name }}</td>
                    <td>{{ $monPayment->tenant->user_id }} - {{ $monPayment->tenant->user->name }}</td>
                    <td>{{ $monPayment->due_date ? \Carbon\Carbon::parse($monPayment->due_date)->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ number_format($monPayment->amount, 2, ',', '.') }}</td>
                    <td>{{ strtoupper($monPayment->status) }}</td>
                    <td>{{ $monPayment->paid_at ? $monPayment->paid_at->format('d/m/Y') : 'N/A' }}</td>
                    <td>{{ $monPayment->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d/m/Y H:i') }} | Page [page_num] of [topage]
    </div>

</body>
</html>

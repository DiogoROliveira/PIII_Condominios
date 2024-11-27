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

    <h1>Unit Report</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Condominium</th>
                <th>Block</th>
                <th>Unit Number</th>
                <th>Status</th>
                <th>Base Rent</th>
                <th>Tenant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($units as $unit)
                <tr>
                    <td>{{ $unit->id }}</td>
                    <td>{{ $unit->block->condominium->name ?? 'N/A' }}</td>
                    <td>{{ $unit->block->block ?? 'N/A' }}</td>
                    <td>{{ $unit->unit_number }}</td>
                    <td>{{ $unit->status }}</td>
                    <td>{{ $unit->base_rent ?? 'N/A' }}</td>
                    <td>{{ $unit->tenant->name ?? 'Vacant' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d/m/Y H:i') }} | Page [page_num] of [topage]
    </div>

</body>
</html>

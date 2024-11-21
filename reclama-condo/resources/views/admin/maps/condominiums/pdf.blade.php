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

    <h1>Condominium Report</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>City</th>
                <th>State</th>
                <th>Postal Code</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Number of Blocks</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($condominiums as $condominium)
                <tr>
                    <td>{{ $condominium->id }}</td>
                    <td>{{ $condominium->name }}</td>
                    <td>{{ $condominium->address ?? 'N/A' }}</td>
                    <td>{{ $condominium->city ?? 'N/A' }}</td>
                    <td>{{ $condominium->state ?? 'N/A' }}</td>
                    <td>{{ $condominium->postal_code ?? 'N/A' }}</td>
                    <td>{{ $condominium->phone ?? 'N/A' }}</td>
                    <td>{{ $condominium->email ?? 'N/A' }}</td>
                    <td>{{ $condominium->number_of_blocks ?? 'N/A' }}</td>
                    <td>{{ $condominium->admin->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d/m/Y H:i') }} | Page [page_num] of [topage]
    </div>

</body>
</html>

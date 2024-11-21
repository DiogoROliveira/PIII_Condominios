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

    <h1>Complaint Report</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Complaint Type</th>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Attachments</th>
                <th>Response</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $complaint)
                <tr>
                    <td>{{ $complaint->id }}</td>
                    <td>{{ $complaint->user->name }}</td>
                    <td>{{ $complaint->complaintType->name }}</td>
                    <td>{{ $complaint->title }}</td>
                    <td>{{ $complaint->description }}</td>
                    <td>{{ $complaint->status }}</td>
                    <td>{{ $complaint->attachments->count() > 0 ? 'Yes' : 'No' }}</td>
                    <td>{{ $complaint->response ?? 'No Response' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Generated on {{ now()->format('d/m/Y H:i') }} | Page [page_num] of [topage]
    </div>

</body>
</html>

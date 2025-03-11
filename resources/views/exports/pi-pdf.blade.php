<!-- resources/views/exports/pi-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Principal Investigators</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .status-active {
            color: green;
        }
        .status-inactive {
            color: red;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Principal Investigators List</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Designation</th>
        <th>Department</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($piList as $pi)
        <tr>
            <td>{{ $pi->id }}</td>
            <td>{{ $pi->getFullNameAttribute() }}</td>
            <td>{{ $pi->email }}</td>
            <td>{{ $pi->phone }}</td>
            <td>{{ $pi->designation }}</td>
            <td>{{ $pi->department }}</td>
            <td class="{{ $pi->status == 1 ? 'status-active' : 'status-inactive' }}">
                {{ $pi->status == 1 ? 'Active' : 'Inactive' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <title>Complaints List</title>
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
        .status-pending {
            color: orange;
        }
        .status-approved {
            color: green;
        }
        .status-rejected {
            color: red;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Instrument Complaints List</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Sr. No.</th>
        <th>Student Name</th>
        <th>Instrument</th>
        <th>Subject</th>
        <th>Description</th>
        <th>Status</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($complaints as $complaint)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $complaint->student->first_name }} {{ $complaint->student->last_name }}</td>
            <td>{{ $complaint->instrument->name }}</td>
            <td>{{ $complaint->subject }}</td>
            <td>{{ $complaint->description }}</td>
            <td class="status-{{ $complaint->status }}">{{ ucfirst($complaint->status) }}</td>
            <td>{{ $complaint->created_at->format('Y-m-d H:i:s') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
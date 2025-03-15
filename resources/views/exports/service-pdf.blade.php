<!DOCTYPE html>
<html>
<head>
    <title>Service Records List</title>
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
        .status-completed {
            color: green;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Instrument Service Records</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Sr. No.</th>
        <th>Instrument</th>
        <th>Service Type</th>
        <th>Description</th>
        <th>Cost</th>
        <th>Next Service Date</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($services as $service)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $service->instrument->name }}</td>
            <td>{{ ucfirst($service->service_type) }}</td>
            <td>{{ $service->description??'' }}</td>
            <td>₹{{ $service->cost ?? '-' }}</td>
            <td>{{ $service->next_service_date ?? '-' }}</td>
            <td class="status-{{ $service->status }}">{{ ucfirst($service->status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
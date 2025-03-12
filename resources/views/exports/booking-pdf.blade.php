<!DOCTYPE html>
<html>
<head>
    <title>Bookings List</title>
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
        .status-confirmed {
            color: green;
        }
        .status-cancelled {
            color: red;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>Bookings List</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Student Name</th>
        <th>Instrument</th>
        <th>Date</th>
        <th>Slot</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $booking->student->first_name }} {{ $booking->student->last_name }}</td>
            <td>{{ $booking->instrument->name }}</td>
            <td>{{ $booking->date }}</td>
            <td>{{ $booking->slot->start_time }} - {{ $booking->slot->end_time }}</td>
            <td class="status-{{ $booking->status }}">{{ ucfirst($booking->status) }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
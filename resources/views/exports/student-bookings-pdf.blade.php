<!DOCTYPE html>
<html>
<head>
    <title>Student Bookings</title>
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
    <h2> {{$bookings->first()->student->first_name}} {{$bookings->first()->student->last_name}}'s Bookings</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Sr. No.</th>
        <th>Date</th>
        <th>Instrument</th>
        <th>Slot</th>
        <th>Status</th>
        <th>Cost</th>
    </tr>
    </thead>
    <tbody>
    @foreach($bookings as $booking)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ \Carbon\Carbon::parse($booking->date)->format('d M, Y') }}</td>
            <td>{{ $booking->instrument->name }}</td>
            <td>{{ $booking->slot->start_time }} - {{ $booking->slot->end_time }}</td>
            <td class="status-{{ $booking->status }}">
                {{ ucfirst($booking->status) }}
                @if($booking->description)
                    <br>
                    <small>{{ $booking->description }}</small>
                @endif
            </td>
            <td>{{ $booking->instrument->per_hour_cost * (abs(\Carbon\Carbon::parse($booking->slot->end_time)->diffInMinutes(\Carbon\Carbon::parse($booking->slot->start_time))) / 60) }} ₹</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

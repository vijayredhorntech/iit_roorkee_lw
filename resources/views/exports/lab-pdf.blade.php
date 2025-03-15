<!-- resources/views/exports/pi-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Lab Deatils</title>
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
    <h2>Labs List</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>Sr. No.</th>
        <th>Name</th>
        <th>Department</th>
        <th>Building</th>
        <th>Floor</th>
        <th>Room Number</th>
        <th>Type</th>
        <th>Contact</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($labList as $lab)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $lab->lab_name}}</td>
            <td>{{ $lab->department }}</td>
            <td>{{ $lab->building }}</td>
            <td>{{ $lab->floor }}</td>
            <td>{{ $lab->room_number }}</td>
            <td>{{ $lab->type }}</td>
            <td>{{ $lab->contact_number }}</td>
            <td class="{{ $lab->status == 1 ? 'status-active' : 'status-inactive' }}">
                {{ $lab->status == 1 ? 'Active' : 'Inactive' }}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

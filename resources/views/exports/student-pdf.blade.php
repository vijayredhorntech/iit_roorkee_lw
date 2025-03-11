
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
    <h2>Students List</h2>
    <p>Generated on: {{ date('Y-m-d H:i:s') }}</p>
</div>

<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Academic ID</th>
        <th>Department</th>
        <th>Research Area</th>
        <th>Email</th>
        <th>Mobile</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($studentList as $student)
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->first_name }} {{ $student->last_name }}</td>
            <td>{{ $student->academic_id }}</td>
            <td>{{ $student->department }}</td>
            <td>{{ $student->research_area }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->mobile_number }}</td>
            <td>{{ $student->status == 1 ? 'Active' : 'Inactive' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>


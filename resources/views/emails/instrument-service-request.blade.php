<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>IIT ROORKEE</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #001A6E;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .alert-box {
            background-color: #f8f9fa;
            border-left: 4px solid #001A6E;
            padding: 15px;
            margin-bottom: 20px;
        }
        .instrument-details {
            background-color: #f8f9fa;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }
        .instrument-details h2 {
            color: #001A6E;
            font-size: 18px;
            margin-bottom: 15px;
            border-bottom: 1px solid #e1e1e1;
            padding-bottom: 10px;
        }
        .detail-row {
            display: flex;
            margin-bottom: 10px;
            align-items: flex-start;
        }
        .detail-label {
            font-weight: bold;
            width: 150px;
            color: #555;
        }
        .detail-value {
            flex: 1;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e1e1e1;
        }
        .btn {
            display: inline-block;
            background-color: #001A6E;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            font-weight: bold;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e1e1;
        }
    </style>
</head>
<body>
<div class="email-container" style="padding: 20px">
    <div class="header" style="color: white">
        <h1>IIT ROORKEE</h1>
    </div>
    <div class="content">
        <div class="alert-box">
            <strong style="color: red">ATTENTION:</strong> A service request has been initiated for an instrument that requires immediate attention.
        </div>

        <p>Dear Concerned Department,</p>
        <p>A service request has been initiated for the following instrument. Please take necessary action to address this service request at your earliest convenience.</p>

        <div class="instrument-details">
            <h2>Instrument Details</h2>
            <div class="detail-row">
                <div class="detail-label">Name:</div>
                <div class="detail-value">{{ $instrument->name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Model Number:</div>
                <div class="detail-value">{{ $instrument->model_number }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Serial Number:</div>
                <div class="detail-value">{{ $instrument->serial_number }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Lab:</div>
                <div class="detail-value">{{ $instrument->lab->lab_name }}</div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Current Status:</div>
                <div class="detail-value">{{ $instrument->operating_status }}</div>
            </div>
        </div>
        <div class="signature">
            <p>Thank you,<br>
                {{ config('app.name') }}</p>
        </div>
    </div>
    <div class="footer">
        <p>This is an automated email from IIT Roorkee Instrument Management System. Please do not reply to this email.</p>
    </div>
</div>
</body>
</html>

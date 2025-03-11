<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Our Platform</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .header {
            background-color: #001A6E;
            color: #ffffff;
            padding: 15px;
            font-size: 24px;
            font-weight: bold;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            font-size: 16px;
            color: #333333;
        }
        .button {
            display: inline-block;
            background-color: #001A6E;
            color: #ffffff;
            padding: 12px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">Welcome to IIT Roorkee</div>
    <div class="content">
        <p>Dear <strong>{{$user->name}}</strong>,</p>
        <p>We are excited to welcome you as a Principal Investigator on our platform.</p>
        <p>Your account has been successfully created. Below are your login details:</p>
        <p><strong>Username:</strong> {{$user->email}}</p>
        <p><strong>Password:</strong>
            <span style="color: #ff0000; font-weight: bold;">{{$password}}</span>
        </p>
        <p>For security reasons, we recommend changing your password after logging in.</p>
        <a href="{{route('login')}}" class="button">Login Now</a>
    </div>
    <div class="footer">
        <p>If you have any questions, feel free to contact our support team.</p>
        <p>&copy; 2025 Your Company Name. All rights reserved.</p>
    </div>
</div>
</body>
</html>

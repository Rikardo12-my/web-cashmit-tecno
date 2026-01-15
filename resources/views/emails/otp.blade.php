<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <h2>Your One-Time Password (OTP)</h2>
    <p>Your OTP is: <strong>{{ $otp_id }}</strong></p>
    <p>Please use this OTP to complete your verification process. This OTP is valid for a limited time only.</p>
    <p>If you did not request this OTP, please ignore this email.</p>
    <br>
    <p>Thank you,</p>
    <p>{{ config('app.name') }} Team</p>
</body>
</html>
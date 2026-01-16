<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <div style="max-width: 600px; margin: auto; padding: 20px; font-family: Arial, sans-serif; border: 1px solid #ddd; border-radius: 5px;">
        <h2 style="text-align: center; color: #333;">{{ config('app.name') }}</h2>
        <p style="font-size: 16px; color: #555;">Hello,</p>
        <p style="font-size: 16px; color: #555;">Your One-Time Password (OTP) is:</p>
        <h1 style="text-align: center; color: #000; font-size: 32px; margin: 20px 0;">{{ $otp_id }}</h1>
        <p style="font-size: 16px; color: #555;">This OTP is valid for the next 10 minutes. Please do not share it with anyone.</p>
        <p style="font-size: 16px; color: #555;">If you did not request this OTP, please ignore this email.</p>
        <br>
        <p style="font-size: 16px; color: #555;">Best regards,<br>{{ config('app.name') }} Team</p>
    </div>
</body>
</html>
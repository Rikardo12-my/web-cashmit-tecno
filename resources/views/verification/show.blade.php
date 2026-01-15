<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
</head>
<body>
    <form action="/verify/{{ $unique_id }}" method="post">
        @method('PUT')
        @csrf
        <input type="number" name="otp" placeholder="Enter OTP">
        <button type="submit">Verify</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="/verify" method="post">
        @csrf
        <input type="hidden" value="register" name="type">
        <button type="submit">Send OTP</button>
    </form>
    
</body>
</html>
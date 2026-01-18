<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code | {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .email-container {
            max-width: 500px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-out;
        }
        
        .email-header {
            background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
            padding: 30px 20px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .email-header::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }
        
        .email-header::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -60px;
            left: -60px;
        }
        
        .app-logo {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            display: inline-block;
            position: relative;
            z-index: 2;
        }
        
        .app-logo i {
            margin-right: 10px;
        }
        
        .email-title {
            font-size: 20px;
            font-weight: 500;
            margin-top: 5px;
            position: relative;
            z-index: 2;
        }
        
        .email-body {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.5;
        }
        
        .otp-container {
            text-align: center;
            margin: 30px 0;
        }
        
        .otp-label {
            font-size: 16px;
            color: #666;
            margin-bottom: 15px;
            display: block;
        }
        
        .otp-code {
            display: inline-flex;
            gap: 12px;
            justify-content: center;
            margin-top: 10px;
        }
        
        .otp-digit {
            width: 60px;
            height: 70px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 700;
            color: #4A90E2;
            box-shadow: 0 5px 15px rgba(74, 144, 226, 0.2);
            border: 2px solid rgba(74, 144, 226, 0.1);
            transition: all 0.3s ease;
        }
        
        .otp-digit:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(74, 144, 226, 0.3);
        }
        
        .validity-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 15px;
            margin: 25px 0;
            border-left: 4px solid #4A90E2;
        }
        
        .validity-info i {
            color: #4A90E2;
            margin-right: 10px;
        }
        
        .warning-box {
            background: #fff9e6;
            border-radius: 12px;
            padding: 15px;
            margin: 25px 0;
            border-left: 4px solid #ffc107;
        }
        
        .warning-box i {
            color: #ffc107;
            margin-right: 10px;
        }
        
        .info-text {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .security-note {
            font-size: 14px;
            color: #888;
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .email-footer {
            background: #f8f9fa;
            padding: 25px 30px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .footer-logo {
            color: #4A90E2;
            font-weight: 700;
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .footer-text {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .social-icons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: #4A90E2;
            color: white;
            transform: translateY(-3px);
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @media (max-width: 480px) {
            .email-body {
                padding: 30px 20px;
            }
            
            .otp-digit {
                width: 50px;
                height: 60px;
                font-size: 26px;
            }
            
            .otp-code {
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <div class="app-logo">
                <i class="fas fa-shield-alt"></i>{{ config('app.name') }}
            </div>
            <div class="email-title">Secure One-Time Password</div>
        </div>
        
        <div class="email-body">
            <p class="greeting">Hello,</p>
            <p class="info-text">You've requested a One-Time Password (OTP) for authentication. Please use the following code to complete your verification:</p>
            
            <div class="otp-container">
                <span class="otp-label">Your Verification Code</span>
                <div class="otp-code">
                    @php
                        // Pisahkan OTP menjadi digit individual
                        $otp_digits = str_split((string)$otp_id);
                    @endphp
                    
                    @foreach($otp_digits as $digit)
                        <div class="otp-digit">{{ $digit }}</div>
                    @endforeach
                </div>
            </div>
            
            <div class="validity-info">
                <i class="fas fa-clock"></i>
                <span>This OTP is valid for the next <strong>10 minutes</strong>. Please use it before it expires.</span>
            </div>
            
            <div class="warning-box">
                <i class="fas fa-exclamation-triangle"></i>
                <span><strong>Security Notice:</strong> Never share this code with anyone, including {{ config('app.name') }} representatives.</span>
            </div>
            
            <p class="info-text">If you didn't request this OTP, please ignore this email or contact our support team immediately if you suspect any unauthorized activity on your account.</p>
            
            <p class="security-note">
                <i class="fas fa-lock"></i> For your security, this email was sent automatically. Please do not reply.
            </p>
        </div>
        
        <div class="email-footer">
            <div class="footer-logo">{{ config('app.name') }}</div>
            <p class="footer-text">Thank you for choosing us. We're committed to keeping your account secure.</p>
            
            <div class="social-icons">
                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    
    <script>
        // Tambahkan efek ketikan untuk OTP (optional)
        document.addEventListener('DOMContentLoaded', function() {
            const otpDigits = document.querySelectorAll('.otp-digit');
            
            otpDigits.forEach((digit, index) => {
                // Delay animasi untuk setiap digit
                digit.style.animationDelay = `${index * 0.1}s`;
                digit.style.animation = 'fadeIn 0.5s ease-out';
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification | {{ config('app.name', 'App') }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-blue: #4A90E2;
            --light-blue: #87CEEB;
            --gradient-blue: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --indigo-color: #6610f2;
            --shadow: 0 4px 20px rgba(0,0,0,0.08);
            --shadow-hover: 0 6px 25px rgba(0,0,0,0.12);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .otp-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .otp-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .otp-header {
            background: var(--gradient-blue);
            padding: 35px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .otp-header::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }
        
        .otp-header::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -40px;
            left: -40px;
        }
        
        .header-icon {
            font-size: 50px;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
            display: inline-block;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .header-title {
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 8px;
            position: relative;
            z-index: 2;
        }
        
        .header-subtitle {
            font-size: 16px;
            opacity: 0.9;
            font-weight: 300;
            position: relative;
            z-index: 2;
        }
        
        .otp-body {
            padding: 40px 35px;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-label {
            display: block;
            margin-bottom: 10px;
            color: #495057;
            font-weight: 500;
            font-size: 15px;
        }
        
        .required::after {
            content: " *";
            color: var(--danger-color);
        }
        
        .hidden-input {
            display: none;
        }
        
        .verification-info {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--info-color);
        }
        
        .verification-info i {
            color: var(--info-color);
            margin-right: 10px;
            font-size: 18px;
        }
        
        .info-text {
            color: #666;
            line-height: 1.6;
            display: inline-block;
            vertical-align: middle;
        }
        
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--gradient-blue);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
        }
        
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        
        .btn-submit:active {
            transform: translateY(-1px);
        }
        
        .btn-submit i {
            font-size: 18px;
        }
        
        .security-notice {
            background: #fff9e6;
            border-radius: 12px;
            padding: 18px;
            margin-top: 25px;
            border-left: 4px solid var(--warning-color);
        }
        
        .security-notice i {
            color: var(--warning-color);
            margin-right: 10px;
            font-size: 18px;
        }
        
        .notice-text {
            color: #856404;
            font-size: 14px;
            line-height: 1.5;
            display: inline-block;
            vertical-align: middle;
        }
        
        .otp-footer {
            background: #f8f9fa;
            padding: 25px 35px;
            text-align: center;
            border-top: 1px solid #eee;
        }
        
        .footer-text {
            color: #777;
            font-size: 14px;
            line-height: 1.5;
        }
        
        .help-link {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .help-link:hover {
            color: var(--indigo-color);
            text-decoration: underline;
        }
        
        .countdown-timer {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(74, 144, 226, 0.1);
            padding: 8px 16px;
            border-radius: 50px;
            margin-top: 15px;
            color: var(--primary-blue);
            font-weight: 500;
        }
        
        .countdown-timer i {
            font-size: 16px;
        }
        
        @media (max-width: 480px) {
            .otp-container {
                max-width: 100%;
            }
            
            .otp-header {
                padding: 30px 20px;
            }
            
            .otp-body {
                padding: 30px 25px;
            }
            
            .header-title {
                font-size: 22px;
            }
            
            .btn-submit {
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-header">
            <div class="header-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="header-title">Secure Verification</h1>
            <p class="header-subtitle">Protect your account with OTP</p>
        </div>
        
        <form action="/verify" method="post" class="otp-body">
            @csrf
            <input type="hidden" value="register" name="type" class="hidden-input">
            
            <div class="verification-info">
                <i class="fas fa-info-circle"></i>
                <span class="info-text">
                    To complete your registration, we need to verify your identity. Click the button below to receive a One-Time Password (OTP).
                </span>
            </div>
            
            <div class="form-group">
                <label class="form-label required">Verification Type</label>
                <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border: 1px solid #e9ecef;">
                    <strong style="color: var(--primary-blue);">Registration</strong>
                    <p style="color: #666; margin-top: 5px; font-size: 14px;">New account verification</p>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                Send OTP to My Email
            </button>
            
            <div class="countdown-timer">
                <i class="fas fa-clock"></i>
                <span>OTP valid for 10 minutes</span>
            </div>
            
            <div class="security-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="notice-text">
                    <strong>Security Tip:</strong> Never share your OTP with anyone. We will never ask for your OTP via phone or email.
                </span>
            </div>
        </form>
        
        <div class="otp-footer">
            <p class="footer-text">
                Need help with verification?
                <a href="#" class="help-link">Contact Support</a>
            </p>
            <p class="footer-text" style="margin-top: 10px; font-size: 13px;">
                <i class="fas fa-lock" style="color: var(--primary-blue);"></i>
                Secured by {{ config('app.name', 'App') }}
            </p>
        </div>
    </div>
    
    <script>
        // Tambahkan efek loading saat tombol diklik
        document.querySelector('form').addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            
            // Tampilkan loading state
            submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Sending OTP...
            `;
            submitBtn.disabled = true;
            
            // Simulasi pengiriman (dalam implementasi nyata, ini tidak diperlukan)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });
        
        // Tambahkan efek visual untuk form
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.otp-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
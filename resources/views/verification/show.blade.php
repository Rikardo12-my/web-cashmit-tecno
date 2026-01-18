<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP | {{ config('app.name', 'App') }}</title>
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
        
        .verify-container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .verify-container:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }
        
        .verify-header {
            background: var(--gradient-blue);
            padding: 35px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .verify-header::before {
            content: '';
            position: absolute;
            width: 180px;
            height: 180px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }
        
        .verify-header::after {
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
        
        .verify-body {
            padding: 40px 35px;
        }
        
        .otp-input-container {
            margin-bottom: 30px;
        }
        
        .otp-label {
            display: block;
            margin-bottom: 15px;
            color: #495057;
            font-weight: 500;
            font-size: 15px;
            text-align: center;
        }
        
        .required::after {
            content: " *";
            color: var(--danger-color);
        }
        
        .otp-input-group {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 20px;
        }
        
        .otp-input {
            width: 60px;
            height: 70px;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            background: #f8f9fa;
            color: var(--primary-blue);
            transition: all 0.3s ease;
            outline: none;
        }
        
        .otp-input:focus {
            border-color: var(--primary-blue);
            background: white;
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            transform: translateY(-2px);
        }
        
        .otp-input.filled {
            border-color: var(--success-color);
            background: rgba(40, 167, 69, 0.05);
        }
        
        .timer-container {
            text-align: center;
            margin-bottom: 25px;
        }
        
        .timer {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(74, 144, 226, 0.1);
            padding: 10px 20px;
            border-radius: 50px;
            color: var(--primary-blue);
            font-weight: 600;
            font-size: 16px;
        }
        
        .timer.expiring {
            background: rgba(255, 193, 7, 0.1);
            color: var(--warning-color);
        }
        
        .timer.expired {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .timer i {
            font-size: 16px;
        }
        
        .btn-verify {
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
            margin-bottom: 20px;
        }
        
        .btn-verify:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        
        .btn-verify:active:not(:disabled) {
            transform: translateY(-1px);
        }
        
        .btn-verify:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-verify i {
            font-size: 18px;
        }
        
        .resend-option {
            text-align: center;
            margin-top: 20px;
        }
        
        .resend-text {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .btn-resend {
            background: transparent;
            border: 2px solid var(--primary-blue);
            color: var(--primary-blue);
            padding: 10px 25px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-resend:hover:not(:disabled) {
            background: var(--primary-blue);
            color: white;
            transform: translateY(-2px);
        }
        
        .btn-resend:disabled {
            opacity: 0.5;
            cursor: not-allowed;
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
        
        .verify-footer {
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
        
        .error-message {
            background: rgba(220, 53, 69, 0.1);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: var(--danger-color);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            display: none;
        }
        
        .error-message.show {
            display: flex;
        }
        
        .success-message {
            background: rgba(40, 167, 69, 0.1);
            border-radius: 10px;
            padding: 12px 15px;
            margin-bottom: 20px;
            color: var(--success-color);
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            display: none;
        }
        
        .success-message.show {
            display: flex;
        }
        
        @media (max-width: 480px) {
            .verify-container {
                max-width: 100%;
            }
            
            .verify-header {
                padding: 30px 20px;
            }
            
            .verify-body {
                padding: 30px 25px;
            }
            
            .header-title {
                font-size: 22px;
            }
            
            .otp-input {
                width: 50px;
                height: 60px;
                font-size: 24px;
            }
            
            .otp-input-group {
                gap: 8px;
            }
            
            .btn-verify {
                padding: 14px;
                font-size: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-header">
            <div class="header-icon">
                <i class="fas fa-key"></i>
            </div>
            <h1 class="header-title">Enter Verification Code</h1>
            <p class="header-subtitle">Check your email for the OTP</p>
        </div>
        
        <form action="/verify/{{ $unique_id }}" method="post" class="verify-body" id="verifyForm">
            @method('PUT')
            @csrf
            
            <div class="error-message" id="errorMessage">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorText">Invalid OTP. Please try again.</span>
            </div>
            
            <div class="success-message" id="successMessage">
                <i class="fas fa-check-circle"></i>
                <span id="successText">OTP verified successfully!</span>
            </div>
            
            <div class="otp-input-container">
                <label class="otp-label required">Enter the 6-digit code sent to your email</label>
                
                <div class="otp-input-group" id="otpInputGroup">
                    @for($i = 1; $i <= 6; $i++)
                    <input 
                        type="number" 
                        class="otp-input" 
                        maxlength="1" 
                        data-index="{{ $i-1 }}"
                        oninput="moveToNext(this)"
                        onkeydown="handleOtpKeyDown(event, {{ $i-1 }})"
                        placeholder="0"
                    >
                    @endfor
                </div>
                
                <input type="hidden" name="otp" id="otpField">
            </div>
            
            <div class="timer-container">
                <div class="timer" id="timer">
                    <i class="fas fa-clock"></i>
                    <span id="timeLeft">10:00</span>
                </div>
            </div>
            
            <button type="submit" class="btn-verify" id="verifyBtn" disabled>
                <i class="fas fa-check-circle"></i>
                Verify Account
            </button>
            
            <div class="resend-option">
                <p class="resend-text">Didn't receive the code?</p>
                <button type="button" class="btn-resend" id="resendBtn" disabled>
                    <i class="fas fa-redo"></i>
                    Resend OTP (<span id="resendCountdown">60</span>s)
                </button>
            </div>
            
            <div class="security-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="notice-text">
                    <strong>Note:</strong> The OTP is case-sensitive and valid for 10 minutes only.
                </span>
            </div>
        </form>
        
        <div class="verify-footer">
            <p class="footer-text">
                Having trouble verifying?
                <a href="#" class="help-link">Get Help</a>
            </p>
            <p class="footer-text" style="margin-top: 10px; font-size: 13px;">
                <i class="fas fa-lock" style="color: var(--primary-blue);"></i>
                Secured by {{ config('app.name', 'App') }}
            </p>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timeLeft = 600; // 10 minutes in seconds
            let resendTime = 60; // 60 seconds for resend
            let timerInterval;
            let resendInterval;
            
            // Initialize OTP input handling
            const otpInputs = document.querySelectorAll('.otp-input');
            const otpField = document.getElementById('otpField');
            const verifyBtn = document.getElementById('verifyBtn');
            const timer = document.getElementById('timer');
            const timeLeftEl = document.getElementById('timeLeft');
            const resendBtn = document.getElementById('resendBtn');
            const resendCountdownEl = document.getElementById('resendCountdown');
            const errorMessage = document.getElementById('errorMessage');
            const successMessage = document.getElementById('successMessage');
            
            // Start the OTP expiration timer
            startTimer();
            
            // Start resend countdown
            startResendCountdown();
            
            function startTimer() {
                clearInterval(timerInterval);
                timerInterval = setInterval(updateTimer, 1000);
            }
            
            function updateTimer() {
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timer.classList.add('expired');
                    timeLeftEl.textContent = 'Expired';
                    verifyBtn.disabled = true;
                    otpInputs.forEach(input => input.disabled = true);
                    return;
                }
                
                timeLeft--;
                
                // Update timer display
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timeLeftEl.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // Change color when less than 2 minutes
                if (timeLeft < 120 && !timer.classList.contains('expiring')) {
                    timer.classList.add('expiring');
                }
            }
            
            function startResendCountdown() {
                clearInterval(resendInterval);
                resendTime = 60;
                resendBtn.disabled = true;
                resendCountdownEl.textContent = resendTime;
                
                resendInterval = setInterval(() => {
                    resendTime--;
                    resendCountdownEl.textContent = resendTime;
                    
                    if (resendTime <= 0) {
                        clearInterval(resendInterval);
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = '<i class="fas fa-redo"></i> Resend OTP';
                    }
                }, 1000);
            }
            
            // OTP input functionality
            window.moveToNext = function(input) {
                const index = parseInt(input.getAttribute('data-index'));
                
                // Handle paste
                if (input.value.length > 1) {
                    const pasteValue = input.value;
                    const otpDigits = pasteValue.split('').slice(0, 6);
                    
                    otpDigits.forEach((digit, idx) => {
                        if (idx < otpInputs.length) {
                            otpInputs[idx].value = digit;
                            otpInputs[idx].classList.add('filled');
                        }
                    });
                    
                    // Focus the last input
                    if (otpDigits.length < otpInputs.length) {
                        otpInputs[otpDigits.length].focus();
                    } else {
                        otpInputs[otpInputs.length - 1].focus();
                    }
                    
                    updateOTPField();
                    return;
                }
                
                // Single digit input
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                
                input.classList.toggle('filled', input.value.length === 1);
                updateOTPField();
            };
            
            window.handleOtpKeyDown = function(e, index) {
                // Handle backspace
                if (e.key === 'Backspace' || e.key === 'Delete') {
                    if (otpInputs[index].value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                        otpInputs[index - 1].value = '';
                        otpInputs[index - 1].classList.remove('filled');
                    } else {
                        otpInputs[index].classList.remove('filled');
                    }
                    
                    setTimeout(updateOTPField, 10);
                }
                
                // Handle arrow keys
                if (e.key === 'ArrowLeft' && index > 0) {
                    otpInputs[index - 1].focus();
                }
                if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            };
            
            function updateOTPField() {
                let otp = '';
                otpInputs.forEach(input => {
                    otp += input.value;
                });
                
                otpField.value = otp;
                
                // Enable verify button if OTP is complete
                verifyBtn.disabled = otp.length !== otpInputs.length || timeLeft <= 0;
            }
            
            // Resend OTP functionality
            resendBtn.addEventListener('click', function() {
                if (!resendBtn.disabled) {
                    // Show loading
                    resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                    resendBtn.disabled = true;
                    
                    // Simulate API call
                    setTimeout(() => {
                        // Reset OTP fields
                        otpInputs.forEach(input => {
                            input.value = '';
                            input.classList.remove('filled');
                        });
                        otpField.value = '';
                        verifyBtn.disabled = true;
                        
                        // Reset timer
                        timeLeft = 600;
                        timer.classList.remove('expired', 'expiring');
                        startTimer();
                        
                        // Start resend countdown again
                        startResendCountdown();
                        
                        // Show success message
                        showMessage('New OTP sent to your email!', 'success');
                    }, 1500);
                }
            });
            
            // Form submission
            document.getElementById('verifyForm').addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Show loading
                verifyBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
                verifyBtn.disabled = true;
                
                // Simulate API verification
                setTimeout(() => {
                    // In real implementation, this would be an AJAX call
                    // For demo, we'll simulate successful verification
                    const otp = otpField.value;
                    
                    if (otp === '123456') { // Demo successful OTP
                        showMessage('Verification successful! Redirecting...', 'success');
                        
                        // Simulate redirect after 2 seconds
                        setTimeout(() => {
                            window.location.href = '/dashboard'; // Change to your success URL
                        }, 2000);
                    } else {
                        showMessage('Invalid OTP. Please try again.', 'error');
                        
                        // Reset form state
                        verifyBtn.innerHTML = '<i class="fas fa-check-circle"></i> Verify Account';
                        verifyBtn.disabled = otp.length !== otpInputs.length;
                        
                        // Shake animation for error
                        otpInputs.forEach(input => {
                            input.style.animation = 'shake 0.5s ease';
                            setTimeout(() => {
                                input.style.animation = '';
                            }, 500);
                        });
                    }
                }, 2000);
            });
            
            function showMessage(text, type) {
                if (type === 'error') {
                    document.getElementById('errorText').textContent = text;
                    errorMessage.classList.add('show');
                    successMessage.classList.remove('show');
                } else {
                    document.getElementById('successText').textContent = text;
                    successMessage.classList.add('show');
                    errorMessage.classList.remove('show');
                }
                
                // Auto-hide error after 5 seconds
                if (type === 'error') {
                    setTimeout(() => {
                        errorMessage.classList.remove('show');
                    }, 5000);
                }
            }
            
            // Add shake animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
                    20%, 40%, 60%, 80% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>
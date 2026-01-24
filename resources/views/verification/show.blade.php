<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP | {{ config('app.name', 'App') }}</title>
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
        
        .otp-input-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0 30px;
        }
        
        .otp-input {
            width: 60px;
            height: 70px;
            border: 2px solid #e1e5eb;
            border-radius: 12px;
            text-align: center;
            font-size: 28px;
            font-weight: 600;
            color: var(--primary-blue);
            background: #f8f9fa;
            transition: all 0.3s ease;
            font-family: 'Poppins', monospace;
        }
        
        .otp-input:focus {
            border-color: var(--primary-blue);
            background: white;
            box-shadow: 0 0 0 4px rgba(74, 144, 226, 0.15);
            outline: none;
            transform: translateY(-2px);
        }
        
        .otp-input.filled {
            border-color: var(--success-color);
            background-color: rgba(40, 167, 69, 0.05);
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
        
        .email-display {
            background: #f0f7ff;
            border-radius: 10px;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            border: 1px dashed var(--primary-blue);
        }
        
        .email-display i {
            color: var(--primary-blue);
            margin-right: 10px;
        }
        
        .email-text {
            color: var(--primary-blue);
            font-weight: 500;
            word-break: break-all;
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
        
        .btn-submit:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
        }
        
        .btn-submit:active:not(:disabled) {
            transform: translateY(-1px);
        }
        
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .btn-submit i {
            font-size: 18px;
        }
        
        .resend-otp {
            text-align: center;
            margin-top: 25px;
        }
        
        .resend-text {
            color: #666;
            font-size: 14px;
        }
        
        .resend-link {
            color: var(--primary-blue);
            background: none;
            border: none;
            font-weight: 600;
            cursor: pointer;
            padding: 5px;
            font-size: 15px;
            transition: all 0.3s ease;
        }
        
        .resend-link:hover:not(:disabled) {
            color: var(--indigo-color);
            text-decoration: underline;
        }
        
        .resend-link:disabled {
            color: #aaa;
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
        
        .timer-expired {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
        }
        
        .error-message {
            background: rgba(220, 53, 69, 0.1);
            color: var(--danger-color);
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            display: none;
        }
        
        .error-message.show {
            display: flex;
        }
        
        .error-message i {
            font-size: 18px;
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
            
            .otp-input {
                width: 50px;
                height: 60px;
                font-size: 24px;
            }
        }
        
        @media (max-width: 380px) {
            .otp-input {
                width: 45px;
                height: 55px;
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="otp-container">
        <div class="otp-header">
            <div class="header-icon">
                <i class="fas fa-key"></i>
            </div>
            <h1 class="header-title">Enter OTP Code</h1>
            <p class="header-subtitle">Verify your identity to continue</p>
        </div>
        
        <form action="/verify/{{$unique_id}}" method="post" class="otp-body" id="otpForm">
            @method('PUT')
            @csrf
            
            <div class="error-message" id="errorMessage">
                <i class="fas fa-exclamation-circle"></i>
                <span id="errorText">Invalid OTP. Please try again.</span>
            </div>
            
            <div class="verification-info">
                <i class="fas fa-info-circle"></i>
                <span class="info-text">
                    Please enter the 6-digit verification code sent to your email address.
                </span>
            </div>
            
            <div class="form-group">
                <label class="form-label required">6-Digit OTP Code</label>
                <div class="otp-input-container">
                    <input type="text" maxlength="1" class="otp-input" data-index="1" autofocus>
                    <input type="text" maxlength="1" class="otp-input" data-index="2">
                    <input type="text" maxlength="1" class="otp-input" data-index="3">
                    <input type="text" maxlength="1" class="otp-input" data-index="4">
                    <input type="text" maxlength="1" class="otp-input" data-index="5">
                    <input type="text" maxlength="1" class="otp-input" data-index="6">
                </div>
                <input type="hidden" name="otp" id="fullOtp">
            </div>
            
            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                <i class="fas fa-check-circle"></i>
                Verify & Continue
            </button>
            
            <div class="countdown-timer" id="countdownTimer">
                <i class="fas fa-clock"></i>
                <span>Code expires in: <span id="timer">10:00</span></span>
            </div>
            
            <div class="resend-otp">
                <p class="resend-text">Didn't receive the code?</p>
                <button type="button" class="resend-link" id="resendLink" disabled>
                    Resend OTP (60s)
                </button>
            </div>
            
            <div class="security-notice">
                <i class="fas fa-exclamation-triangle"></i>
                <span class="notice-text">
                    <strong>Security Tip:</strong> This code is valid for 10 minutes only. Do not share it with anyone.
                </span>
            </div>
        </form>
        
        <div class="otp-footer">
            <p class="footer-text">
                Having trouble with verification?
                <a href="#" class="help-link">Contact Support</a>
            </p>
            <p class="footer-text" style="margin-top: 10px; font-size: 13px;">
                <i class="fas fa-lock" style="color: var(--primary-blue);"></i>
                Secured by {{ config('app.name', 'App') }}
            </p>
        </div>
    </div>
    
    <script>
        // DOM Elements
        const otpInputs = document.querySelectorAll('.otp-input');
        const fullOtpInput = document.getElementById('fullOtp');
        const submitBtn = document.getElementById('submitBtn');
        const errorMessage = document.getElementById('errorMessage');
        const errorText = document.getElementById('errorText');
        const timerElement = document.getElementById('timer');
        const countdownTimer = document.getElementById('countdownTimer');
        const resendLink = document.getElementById('resendLink');
        const otpForm = document.getElementById('otpForm');
        
        // Timer variables
        let timeLeft = 600; // 10 minutes in seconds
        let timerInterval;
        let canResend = false;
        let resendTime = 60; // 60 seconds wait for resend
        
        // Initialize OTP inputs
        otpInputs.forEach((input, index) => {
            // Handle input
            input.addEventListener('input', (e) => {
                const value = e.target.value;
                
                // Only allow digits
                if (!/^\d*$/.test(value)) {
                    e.target.value = '';
                    return;
                }
                
                // If a digit is entered, move to next input
                if (value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
                
                // Update filled state
                if (value.length === 1) {
                    input.classList.add('filled');
                } else {
                    input.classList.remove('filled');
                }
                
                // Update the full OTP value
                updateFullOtp();
                
                // Check if all inputs are filled
                checkOtpComplete();
            });
            
            // Handle backspace
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value.length === 0 && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
            
            // Handle paste
            input.addEventListener('paste', (e) => {
                e.preventDefault();
                const pasteData = e.clipboardData.getData('text').trim();
                
                if (/^\d{6}$/.test(pasteData)) {
                    // Fill all inputs with pasted OTP
                    for (let i = 0; i < otpInputs.length; i++) {
                        otpInputs[i].value = pasteData[i] || '';
                        if (pasteData[i]) {
                            otpInputs[i].classList.add('filled');
                        } else {
                            otpInputs[i].classList.remove('filled');
                        }
                    }
                    
                    // Move focus to last input
                    otpInputs[otpInputs.length - 1].focus();
                    
                    // Update full OTP
                    updateFullOtp();
                    checkOtpComplete();
                }
            });
        });
        
        // Function to update the full OTP value
        function updateFullOtp() {
            let otp = '';
            otpInputs.forEach(input => {
                otp += input.value;
            });
            fullOtpInput.value = otp;
        }
        
        // Function to check if OTP is complete
        function checkOtpComplete() {
            let isComplete = true;
            otpInputs.forEach(input => {
                if (input.value.length === 0) {
                    isComplete = false;
                }
            });
            
            submitBtn.disabled = !isComplete;
            return isComplete;
        }
        
        // Function to start the countdown timer
        function startTimer() {
            clearInterval(timerInterval);
            
            timerInterval = setInterval(() => {
                timeLeft--;
                
                // Update timer display
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                // If time expires
                if (timeLeft <= 0) {
                    clearInterval(timerInterval);
                    timerElement.textContent = "00:00";
                    countdownTimer.classList.add('timer-expired');
                    
                    // Disable submit button
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = `
                        <i class="fas fa-exclamation-circle"></i>
                        OTP Expired
                    `;
                    
                    // Enable resend
                    enableResend();
                }
            }, 1000);
        }
        
        // Function to start resend countdown
        function startResendTimer() {
            canResend = false;
            resendLink.disabled = true;
            resendLink.textContent = `Resend OTP (${resendTime}s)`;
            
            let resendCounter = resendTime;
            const resendInterval = setInterval(() => {
                resendCounter--;
                resendLink.textContent = `Resend OTP (${resendCounter}s)`;
                
                if (resendCounter <= 0) {
                    clearInterval(resendInterval);
                    enableResend();
                }
            }, 1000);
        }
        
        // Function to enable resend button
        function enableResend() {
            canResend = true;
            resendLink.disabled = false;
            resendLink.textContent = "Resend OTP";
        }
        
        // Function to resend OTP
        function resendOtp() {
            if (!canResend) return;
            
            // Show loading state
            resendLink.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
            resendLink.disabled = true;
            
            // In a real app, you would make an API call here
            // For demo, we'll simulate with setTimeout
            setTimeout(() => {
                // Reset OTP inputs
                otpInputs.forEach(input => {
                    input.value = '';
                    input.classList.remove('filled');
                });
                
                // Reset timer
                timeLeft = 600;
                countdownTimer.classList.remove('timer-expired');
                
                // Update UI
                startTimer();
                startResendTimer();
                
                // Enable submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <i class="fas fa-check-circle"></i>
                    Verify & Continue
                `;
                
                // Hide error message
                errorMessage.classList.remove('show');
                
                // Focus first input
                otpInputs[0].focus();
                
                // Show success message
                alert('A new OTP has been sent to your email address.');
            }, 1500);
        }
        
        // Form submission
        otpForm.addEventListener('submit', (e) => {
            e.preventDefault();
            
            // Get the OTP value
            const otpValue = fullOtpInput.value;
            
            // Validate OTP
            if (otpValue.length !== 6 || !/^\d{6}$/.test(otpValue)) {
                showError('Please enter a valid 6-digit OTP code.');
                return;
            }
            
            // Show loading state
            submitBtn.innerHTML = `
                <i class="fas fa-spinner fa-spin"></i>
                Verifying...
            `;
            submitBtn.disabled = true;
            
            // In a real app, you would submit the form via AJAX or let it submit normally
            // For demo, we'll simulate verification
            setTimeout(() => {
                // Simulate verification failure for demo (change to success in real app)
                const isSuccess = Math.random() > 0.2; // 80% success rate for demo
                
                if (isSuccess) {
                    // Success - submit the form
                    otpForm.submit();
                } else {
                    // Failure - show error
                    showError('Invalid OTP code. Please try again.');
                    
                    // Reset submit button
                    submitBtn.innerHTML = `
                        <i class="fas fa-check-circle"></i>
                        Verify & Continue
                    `;
                    submitBtn.disabled = false;
                    
                    // Clear inputs and refocus first
                    otpInputs.forEach(input => {
                        input.value = '';
                        input.classList.remove('filled');
                    });
                    otpInputs[0].focus();
                    updateFullOtp();
                }
            }, 2000);
        });
        
        // Function to show error message
        function showError(message) {
            errorText.textContent = message;
            errorMessage.classList.add('show');
            
            // Auto hide error after 5 seconds
            setTimeout(() => {
                errorMessage.classList.remove('show');
            }, 5000);
        }
        
        // Resend OTP button click
        resendLink.addEventListener('click', resendOtp);
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', () => {
            // Start timers
            startTimer();
            startResendTimer();
            
            // Add animation to container
            const container = document.querySelector('.otp-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
            
            // Focus first OTP input
            otpInputs[0].focus();
        });
    </script>
</body>
</html>
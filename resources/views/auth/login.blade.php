<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | {{ config('app.name') }}</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
  
  <style>
    :root {
      --primary-blue: #4A90E2;
      --light-blue: #87CEEB;
      --gradient-blue: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
      --gradient-blue-reverse: linear-gradient(135deg, #87CEEB 0%, #4A90E2 100%);
      --white: #FFFFFF;
      --gray-50: #FAFAFA;
      --gray-100: #F5F5F5;
      --gray-200: #E5E5E5;
      --gray-300: #D4D4D4;
      --gray-400: #A3A3A3;
      --gray-600: #525252;
      --gray-800: #262626;
      --shadow-sm: 0 1px 3px rgba(0,0,0,0.1);
      --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
      --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05);
      --shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
      --radius-sm: 8px;
      --radius-md: 12px;
      --radius-lg: 16px;
      --radius-xl: 24px;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      color: var(--gray-800);
    }
    .social-login {
    margin: 20px 0;
  }

  .google-login-link {
    text-decoration: none;
    display: block;
    width: 100%;
  }

  .google-button {
    width: 100%;
    max-width: 300px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    padding: 12px 24px;
    background-color: #ffffff;
    border: 1px solid #dadce0;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    color: #3c4043;
    transition: background-color 0.2s, box-shadow 0.2s;
    outline: none;
  }

  .google-button:hover {
    background-color: #f8f9fa;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  }

  .google-button:focus {
    box-shadow: 0 0 0 3px rgba(66, 133, 244, 0.3);
  }

  .google-button:active {
    background-color: #f1f3f4;
  }

  .google-icon {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
  }

  .google-button-text {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    letter-spacing: 0.25px;
  }

  /* Responsive */
  @media (max-width: 480px) {
    .google-button {
      padding: 10px 16px;
      font-size: 13px;
    }
  }
    .login-container {
      width: 100%;
      max-width: 420px;
      margin: 0 auto;
    }

    /* Login Box */
    .login-box {
      background: var(--white);
      border-radius: var(--radius-xl);
      padding: 40px;
      box-shadow: var(--shadow-xl);
      position: relative;
      overflow: hidden;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Decorative Elements */
    .login-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-blue);
    }

    .login-box::after {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 300px;
      height: 300px;
      background: radial-gradient(circle, rgba(74, 144, 226, 0.1) 0%, rgba(135, 206, 235, 0) 70%);
      z-index: 0;
    }

    /* Logo Section */
    .logo-section {
      text-align: center;
      margin-bottom: 32px;
      position: relative;
      z-index: 1;
    }

    .logo-container {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 64px;
      height: 64px;
      background: var(--gradient-blue);
      border-radius: var(--radius-lg);
      margin-bottom: 16px;
      box-shadow: var(--shadow-lg);
    }

    .logo-icon {
      font-size: 28px;
      color: var(--white);
    }
    .brand-image {
      width: 100px;
      height: 100px;
    }
    .logo-text {
      font-size: 28px;
      font-weight: 700;
      background: linear-gradient(45deg, #4A90E2, #87CEEB);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      letter-spacing: -0.5px;
    }

    .logo-subtitle {
      color: var(--gray-400);
      font-size: 14px;
      margin-top: 4px;
      font-weight: 400;
    }

    /* Form Styling */
    .login-form {
      position: relative;
      z-index: 1;
    }

    .form-title {
      text-align: center;
      font-size: 18px;
      font-weight: 500;
      color: var(--gray-600);
      margin-bottom: 24px;
    }

    /* Input Groups */
    .input-group {
      margin-bottom: 20px;
      position: relative;
    }

    .input-label {
      display: block;
      margin-bottom: 8px;
      font-size: 14px;
      font-weight: 500;
      color: var(--gray-600);
    }

    .input-wrapper {
      position: relative;
    }

    .form-input {
      width: 100%;
      padding: 14px 16px;
      padding-left: 48px;
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-md);
      font-size: 15px;
      font-family: 'Inter', sans-serif;
      background: var(--white);
      transition: all 0.3s ease;
      color: var(--gray-800);
    }

    .form-input:focus {
      outline: none;
      border-color: var(--primary-blue);
      box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
      transform: translateY(-1px);
    }

    .form-input:hover {
      border-color: var(--gray-300);
    }

    .input-icon {
      position: absolute;
      left: 16px;
      top: 50%;
      transform: translateY(-50%);
      color: var(--gray-400);
      font-size: 16px;
      transition: color 0.3s ease;
    }

    .form-input:focus + .input-icon {
      color: var(--primary-blue);
    }

    .password-toggle-btn {
      position: absolute;
      right: 16px;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: var(--gray-400);
      cursor: pointer;
      font-size: 16px;
      transition: all 0.3s ease;
      padding: 8px;
      border-radius: 6px;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 36px;
      height: 36px;
    }

    .password-toggle-btn:hover {
      color: var(--primary-blue);
      background: var(--gray-100);
    }

    .password-toggle-btn.active {
      color: var(--primary-blue);
      background: var(--gray-100);
    }

    /* Error States */
    .error-message {
      color: #ef4444;
      font-size: 13px;
      margin-top: 4px;
      display: flex;
      align-items: center;
      gap: 6px;
      animation: slideIn 0.3s ease;
    }

    .error-icon {
      font-size: 12px;
    }

    /* Alert */
    .alert {
      padding: 12px 16px;
      border-radius: var(--radius-md);
      margin-bottom: 20px;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 10px;
      animation: slideIn 0.3s ease;
    }

    .alert-danger {
      background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
      color: #dc2626;
      border: 1px solid rgba(220, 38, 38, 0.2);
    }

    .alert-icon {
      font-size: 16px;
    }

    /* Checkbox */
    .checkbox-group {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 24px;
      cursor: pointer;
    }

    .checkbox-input {
      width: 18px;
      height: 18px;
      border: 2px solid var(--gray-300);
      border-radius: 4px;
      appearance: none;
      cursor: pointer;
      position: relative;
      transition: all 0.3s ease;
    }

    .checkbox-input:checked {
      background: var(--primary-blue);
      border-color: var(--primary-blue);
    }

    .checkbox-input:checked::after {
      content: '✓';
      position: absolute;
      color: white;
      font-size: 12px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }

    .checkbox-label {
      font-size: 14px;
      color: var(--gray-600);
      cursor: pointer;
      user-select: none;
    }

    /* Submit Button */
    .submit-button {
      width: 100%;
      padding: 16px;
      background: var(--gradient-blue);
      color: white;
      border: none;
      border-radius: var(--radius-md);
      font-size: 16px;
      font-weight: 600;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      margin-bottom: 24px;
      box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
    }

    .submit-button:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(74, 144, 226, 0.4);
    }

    .submit-button:active {
      transform: translateY(0);
    }

    .submit-button::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 100%);
      opacity: 0;
      transition: opacity 0.3s ease;
    }

    .submit-button:hover::after {
      opacity: 1;
    }

    /* Divider */
    .divider {
      display: flex;
      align-items: center;
      margin: 24px 0;
      color: var(--gray-400);
      font-size: 14px;
    }

    .divider::before,
    .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--gray-200);
    }

    .divider span {
      padding: 0 16px;
    }

    /* Social Login */
    .social-login {
      margin-bottom: 24px;
    }

    .google-button {
      width: 100%;
      padding: 14px;
      background: var(--white);
      color: var(--gray-800);
      border: 2px solid var(--gray-200);
      border-radius: var(--radius-md);
      font-size: 15px;
      font-weight: 500;
      font-family: 'Inter', sans-serif;
      cursor: pointer;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
    }

    .google-button:hover {
      border-color: var(--gray-300);
      background: var(--gray-50);
      transform: translateY(-1px);
    }

    .google-icon {
      color: #DB4437;
      font-size: 18px;
    }

    /* Links */
    .login-links {
      text-align: center;
      margin-top: 20px;
    }

    .link {
      color: var(--primary-blue);
      text-decoration: none;
      font-size: 14px;
      font-weight: 500;
      transition: all 0.3s ease;
      position: relative;
      display: inline-block;
      padding: 4px 0;
    }

    .link::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary-blue);
      transition: width 0.3s ease;
    }

    .link:hover::after {
      width: 100%;
    }

    .link:hover {
      color: var(--light-blue);
    }

    .link + .link {
      margin-left: 16px;
    }

    /* Footer */
    .login-footer {
      text-align: center;
      margin-top: 32px;
      padding-top: 20px;
      border-top: 1px solid var(--gray-200);
      color: var(--gray-400);
      font-size: 12px;
    }

    /* Animations */
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes float {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }

    /* Floating Animation for Logo */
    .logo-container {
      animation: float 3s ease-in-out infinite;
    }

    /* Responsive */
    @media (max-width: 480px) {
      .login-box {
        padding: 32px 24px;
      }
      
      .logo-text {
        font-size: 24px;
      }
      
      .form-input {
        padding: 12px 16px;
        padding-left: 48px;
      }
    }

    /* Loading State */
    .submit-button.loading {
      opacity: 0.8;
      cursor: not-allowed;
    }

    .submit-button.loading::before {
      content: '';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 20px;
      height: 20px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top-color: white;
      border-radius: 50%;
      animation: spin 0.8s linear infinite;
    }

    .submit-button.loading span {
      visibility: hidden;
    }

    @keyframes spin {
      to {
        transform: translate(-50%, -50%) rotate(360deg);
      }
    }

    /* Success Animation */
    @keyframes successPulse {
      0% {
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
      }
      50% {
        box-shadow: 0 4px 20px rgba(74, 144, 226, 0.6);
      }
      100% {
        box-shadow: 0 4px 15px rgba(74, 144, 226, 0.3);
      }
    }
  </style>
</head>
<body>
<div class="login-container">
  <div class="login-box">
    <!-- Logo Section -->
    <div class="logo-section">
      <div class="logo-container">
        <img src="{{asset('adminlte/dist/img/LogoCashMit.png')}}" alt="LogoCashmit" class="brand-image">
      </div>
      <h1 class="logo-text">{{ config('app.name', 'AdminLTE') }}</h1>
      <p class="logo-subtitle">Cepat Kali, Aman Kali, Kampus Punya!</p>
    </div>

    <!-- Alert Messages -->
    @if (session('failed'))
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle alert-icon"></i>
      <span>{{ session('failed') }}</span>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success" style="background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%); color: #16a34a; border: 1px solid rgba(22, 163, 74, 0.2);">
      <i class="fas fa-check-circle alert-icon"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Login Form -->
    <form action="/login" method="post" class="login-form" id="loginForm">
      @csrf
      
      <h2 class="form-title">Sign in to your account</h2>

      <!-- Email Input -->
      <div class="input-group">
        <label class="input-label">Email Address</label>
        <div class="input-wrapper">
          <input type="email" 
                 class="form-input" 
                 placeholder="you@example.com" 
                 name="email"
                 value="{{ old('email') }}"
                 required
                 autocomplete="email"
                 autofocus>
          <i class="fas fa-envelope input-icon"></i>
        </div>
        @error('email')
        <div class="error-message">
          <i class="fas fa-exclamation-circle error-icon"></i>
          <span>{{ $message }}</span>
        </div>
        @enderror
      </div>

      <!-- Password Input -->
      <div class="input-group">
        <label class="input-label">Password</label>
        <div class="input-wrapper">
          <input type="password" 
                 class="form-input" 
                 placeholder="Enter your password" 
                 id="password"
                 name="password"
                 required
                 autocomplete="current-password">
          <i class="fas fa-lock input-icon"></i>
          <button type="button" class="password-toggle-btn" id="togglePassword" aria-label="Show password">
            <i class="fas fa-eye"></i>
          </button>
        </div>
        @error('password')
        <div class="error-message">
          <i class="fas fa-exclamation-circle error-icon"></i>
          <span>{{ $message }}</span>
        </div>
        @enderror
      </div>

      <!-- Remember Me -->
      <div class="checkbox-group">
        <input type="checkbox" id="remember" name="remember" class="checkbox-input" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember" class="checkbox-label">Remember this device</label>
      </div>

      <!-- Submit Button -->
      <button type="submit" class="submit-button" id="loginButton">
        <span>Sign In</span>
      </button>

      <!-- Divider -->
      <div class="divider">
        <span>Or continue with</span>
      </div>

      <div class="social-login">
  <a href="/auth-google-redirect" class="google-login-link">
    <button type="button" class="google-button" id="googleLogin">
      <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="24" height="24">
        <path fill="#FFC107" d="M43.611,20.083H42V20H24v8h11.303c-1.649,4.657-6.08,8-11.303,8c-6.627,0-12-5.373-12-12c0-6.627,5.373-12,12-12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C12.955,4,4,12.955,4,24c0,11.045,8.955,20,20,20c11.045,0,20-8.955,20-20C44,22.659,43.862,21.35,43.611,20.083z"/>
        <path fill="#FF3D00" d="M6.306,14.691l6.571,4.819C14.655,15.108,18.961,12,24,12c3.059,0,5.842,1.154,7.961,3.039l5.657-5.657C34.046,6.053,29.268,4,24,4C16.318,4,9.656,8.337,6.306,14.691z"/>
        <path fill="#4CAF50" d="M24,44c5.166,0,9.86-1.977,13.409-5.192l-6.19-5.238C29.211,35.091,26.715,36,24,36c-5.202,0-9.619-3.317-11.283-7.946l-6.522,5.025C9.505,39.556,16.227,44,24,44z"/>
        <path fill="#1976D2" d="M43.611,20.083H42V20H24v8h11.303c-0.792,2.237-2.231,4.166-4.087,5.571c0.001-0.001,0.002-0.001,0.003-0.002l6.19,5.238C36.971,39.205,44,34,44,24C44,22.659,43.862,21.35,43.611,20.083z"/>
      </svg>
      <span class="google-button-text">Sign in with Google</span>
    </button>
  </a>
</div>

      <!-- Links -->
      <div class="login-links">
        <a href="/forgot-password" class="link">Forgot password?</a>
        <a href="/register" class="link">Create new account</a>
      </div>
    </form>

    <!-- Footer -->
    <div class="login-footer">
      © 2024 {{ config('app.name', 'AdminLTE') }}. All rights reserved.
    </div>
  </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Elements
  const togglePassword = document.getElementById('togglePassword');
  const passwordInput = document.getElementById('password');
  const passwordIcon = togglePassword.querySelector('i');
  const loginForm = document.getElementById('loginForm');
  const loginButton = document.getElementById('loginButton');
  const loginText = loginButton.querySelector('span');
  
  // Improved Password Toggle Functionality
  togglePassword.addEventListener('click', function() {
    const isPassword = passwordInput.type === 'password';
    
    // Toggle input type
    passwordInput.type = isPassword ? 'text' : 'password';
    
    // Toggle icon with animation
    this.classList.toggle('active');
    
    // Smooth icon change
    passwordIcon.style.transform = 'scale(0.8)';
    setTimeout(() => {
      passwordIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
      passwordIcon.style.transform = 'scale(1)';
    }, 150);
    
    // Add focus to password field for better UX
    passwordInput.focus();
  });

  // Keyboard shortcut for password toggle (Alt+P)
  document.addEventListener('keydown', function(e) {
    if (e.altKey && e.key === 'p') {
      e.preventDefault();
      togglePassword.click();
    }
  });

  // Form submission with improved UX
  loginForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Show loading state
    loginButton.classList.add('loading');
    loginButton.disabled = true;
    
    // Simulate API call delay (remove this in production)
    await new Promise(resolve => setTimeout(resolve, 1500));
    
    // Submit the form
    this.submit();
  });

  // Handle input validation with visual feedback
  const emailInput = document.querySelector('input[name="email"]');
  const passwordInputField = document.getElementById('password');
  
  emailInput.addEventListener('input', function() {
    this.style.borderColor = this.checkValidity() ? '#10b981' : '#ef4444';
  });
  
  passwordInputField.addEventListener('input', function() {
    if (this.value.length > 0) {
      this.style.borderColor = '#10b981';
    } else {
      this.style.borderColor = '#e5e5e5';
    }
  });

  // Auto-focus email field on page load
  if (emailInput.value === '') {
    emailInput.focus();
  }

  // Google login button
  const googleButton = document.getElementById('googleLogin');
  googleButton.addEventListener('click', function() {
    // Add your Google OAuth logic here
  });

  // Handle Enter key to submit form
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Enter' && !loginButton.disabled) {
      loginForm.requestSubmit();
    }
  });

  // Password strength indicator (optional feature)
  passwordInputField.addEventListener('input', function() {
    const strength = calculatePasswordStrength(this.value);
    // You can add visual strength indicator here if needed
  });

  function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    return strength;
  }

  if (localStorage.getItem('rememberPasswordVisibility') === 'true') {
    togglePassword.click();
  }
  
  togglePassword.addEventListener('click', function() {
    const isVisible = passwordInput.type === 'text';
    localStorage.setItem('rememberPasswordVisibility', isVisible);
  });
});
</script>
</body>
</html>
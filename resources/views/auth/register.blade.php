<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register | {{ config('app.name') }}</title>

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
      --success-green: #10b981;
      --error-red: #ef4444;
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

    .register-container {
      width: 100%;
      max-width: 480px;
      margin: 0 auto;
    }

    /* Register Box */
    .register-box {
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
    .register-box::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-blue);
    }

    .register-box::after {
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
      margin-bottom: 24px;
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

    .brand-image {
      width: 50px;
      height: 50px;
      object-fit: contain;
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
    .register-form {
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

    /* Grid Layout */
    .form-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
      margin-bottom: 16px;
    }

    /* Input Groups */
    .input-group {
      margin-bottom: 16px;
      position: relative;
    }

    .input-group.full-width {
      grid-column: 1 / -1;
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
      color: var(--error-red);
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

    .alert-success {
      background: linear-gradient(135deg, rgba(34, 197, 94, 0.1) 0%, rgba(34, 197, 94, 0.05) 100%);
      color: #16a34a;
      border: 1px solid rgba(22, 163, 74, 0.2);
    }

    .alert-icon {
      font-size: 16px;
    }

    /* Role Info Box */
    .role-info-box {
      background: linear-gradient(135deg, rgba(74, 144, 226, 0.05) 0%, rgba(135, 206, 235, 0.02) 100%);
      border: 1px solid rgba(74, 144, 226, 0.1);
      border-radius: var(--radius-md);
      padding: 16px;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
      gap: 12px;
      animation: slideIn 0.3s ease;
    }

    .role-icon {
      color: var(--primary-blue);
      font-size: 20px;
      flex-shrink: 0;
    }

    .role-info-content {
      flex: 1;
    }

    .role-title {
      font-weight: 600;
      color: var(--primary-blue);
      font-size: 14px;
      margin-bottom: 4px;
    }

    .role-description {
      color: var(--gray-600);
      font-size: 13px;
      line-height: 1.4;
    }

    /* Password Strength */
    .password-strength {
      margin-top: 8px;
    }

    .strength-bar {
      height: 4px;
      background: var(--gray-200);
      border-radius: 2px;
      overflow: hidden;
      margin-bottom: 4px;
    }

    .strength-fill {
      height: 100%;
      width: 0%;
      background: var(--error-red);
      border-radius: 2px;
      transition: all 0.3s ease;
    }

    .strength-text {
      font-size: 12px;
      color: var(--gray-400);
    }

    .strength-fill.weak { width: 33%; background: var(--error-red); }
    .strength-fill.fair { width: 66%; background: #f59e0b; }
    .strength-fill.good { width: 100%; background: var(--success-green); }

    /* Terms Checkbox */
    .terms-group {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-bottom: 24px;
      cursor: pointer;
    }

    .checkbox-input {
      width: 20px;
      height: 20px;
      border: 2px solid var(--gray-300);
      border-radius: 4px;
      appearance: none;
      cursor: pointer;
      position: relative;
      transition: all 0.3s ease;
      flex-shrink: 0;
      margin-top: 2px;
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

    .terms-label {
      font-size: 14px;
      color: var(--gray-600);
      cursor: pointer;
      user-select: none;
      line-height: 1.5;
    }

    .terms-link {
      color: var(--primary-blue);
      text-decoration: none;
      font-weight: 500;
    }

    .terms-link:hover {
      text-decoration: underline;
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

    .submit-button:disabled {
      opacity: 0.6;
      cursor: not-allowed;
      transform: none;
    }

    /* Login Link */
    .login-link {
      text-align: center;
      margin-top: 20px;
      color: var(--gray-600);
      font-size: 14px;
    }

    .login-link a {
      color: var(--primary-blue);
      text-decoration: none;
      font-weight: 500;
      margin-left: 4px;
      position: relative;
    }

    .login-link a::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--primary-blue);
      transition: width 0.3s ease;
    }

    .login-link a:hover::after {
      width: 100%;
    }

    /* Footer */
    .register-footer {
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
    @media (max-width: 520px) {
      .register-box {
        padding: 32px 24px;
      }
      
      .form-grid {
        grid-template-columns: 1fr;
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
/* Photo Upload Styles */
.input-group.file-upload {
    position: relative;
}

.file-upload-container {
    position: relative;
    width: 100%;
}

.form-input[type="file"] {
    padding: 12px 16px;
    padding-left: 48px;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-md);
    background: var(--white);
    color: var(--gray-600);
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    z-index: 1;
}

.form-input[type="file"]:hover {
    border-color: var(--gray-300);
    background: var(--gray-50);
}

.form-input[type="file"]:focus {
    outline: none;
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
}

.form-input[type="file"]::file-selector-button {
    display: none;
}

.file-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 12px 16px;
    padding-left: 48px;
    display: flex;
    align-items: center;
    color: var(--gray-400);
    pointer-events: none;
    z-index: 0;
    font-size: 14px;
}

.file-info {
    display: none;
    align-items: center;
    gap: 8px;
    margin-top: 8px;
    padding: 8px 12px;
    background: var(--gray-50);
    border-radius: var(--radius-sm);
    font-size: 13px;
}

.file-info.show {
    display: flex;
    animation: slideIn 0.3s ease;
}

.file-preview {
    width: 40px;
    height: 40px;
    border-radius: 6px;
    overflow: hidden;
    border: 1px solid var(--gray-200);
}

.file-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.file-details {
    flex: 1;
    min-width: 0;
}

.file-name {
    font-weight: 500;
    color: var(--gray-700);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
}

.file-size {
    color: var(--gray-500);
    font-size: 12px;
}

.remove-file {
    background: none;
    border: none;
    color: var(--error-red);
    cursor: pointer;
    padding: 4px;
    border-radius: 4px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.remove-file:hover {
    background: rgba(239, 68, 68, 0.1);
}

/* Custom file input button */
.custom-file-button {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: var(--gray-100);
    border: none;
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: 500;
    color: var(--gray-600);
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 2;
}

.custom-file-button:hover {
    background: var(--gray-200);
    color: var(--gray-800);
}

/* When file is selected */
.form-input[type="file"]:valid ~ .file-placeholder {
    color: var(--gray-600);
    font-weight: 500;
}

/* Error state */
.form-input[type="file"].error {
    border-color: var(--error-red);
}

.form-input[type="file"].error ~ .file-placeholder {
    color: var(--error-red);
}

/* Success state */
.form-input[type="file"].success {
    border-color: var(--success-green);
}

.form-input[type="file"].success ~ .file-placeholder {
    color: var(--success-green);
}

/* Disabled state */
.form-input[type="file"]:disabled {
    background: var(--gray-100);
    cursor: not-allowed;
    opacity: 0.6;
}

.form-input[type="file"]:disabled ~ .custom-file-button {
    background: var(--gray-300);
    cursor: not-allowed;
    opacity: 0.6;
}

/* File upload hint */
.file-upload-hint {
    display: block;
    margin-top: 4px;
    font-size: 12px;
    color: var(--gray-400);
}

.file-upload-hint i {
    margin-right: 4px;
    font-size: 11px;
}

/* Responsive */
@media (max-width: 480px) {
    .form-input[type="file"] {
        padding: 10px 14px;
        padding-left: 44px;
        font-size: 13px;
    }
    
    .file-placeholder {
        padding: 10px 14px;
        padding-left: 44px;
        font-size: 13px;
    }
    
    .custom-file-button {
        padding: 5px 10px;
        font-size: 11px;
    }
}
    .submit-button.loading span {
      visibility: hidden;
    }

    @keyframes spin {
      to {
        transform: translate(-50%, -50%) rotate(360deg);
      }
    }
  </style>
</head>
<body>
<div class="register-container">
  <div class="register-box">
    <!-- Logo Section -->
    <div class="logo-section">
      <div class="logo-container">
        <img src="{{asset('adminlte/dist/img/LogoCashMit.png')}}" alt="LogoCashmit" class="brand-image">
      </div>
      <h1 class="logo-text">{{ config('app.name', 'AdminLTE') }}</h1>
      <p class="logo-subtitle">Cepat Kali, Aman Kali, Kampus Punya!</p>
    </div>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="alert alert-danger">
      <i class="fas fa-exclamation-circle alert-icon"></i>
      <span>Please fix the errors below to continue.</span>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
      <i class="fas fa-check-circle alert-icon"></i>
      <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Register Form -->
    <form action="/register" method="post" class="register-form" id="registerForm" enctype="multipart/form-data">
      @csrf
      
      <h2 class="form-title">Create your account</h2>

      <!-- Role Information -->
      <div class="role-info-box">
        <i class="fas fa-user-check role-icon"></i>
        <div class="role-info-content">
          <div class="role-title">Registering as Customer</div>
          <div class="role-description">
            All new registrations are automatically set as Customers. 
            For Admin or Petugas access, please contact the system administrator.
          </div>
        </div>
      </div>

      <!-- Hidden role field (automatically customer) -->
      <input type="hidden" name="role" value="customer">

      <!-- Name and NIM/NIP -->
      <div class="form-grid">
        <div class="input-group">
          <label class="input-label">Full Name</label>
          <div class="input-wrapper">
            <input type="text" 
                   class="form-input" 
                   placeholder="John Doe" 
                   name="nama"
                   value="{{ old('nama') }}"
                   required>
            <i class="fas fa-user input-icon"></i>
          </div>
          @error('nama')
          <div class="error-message">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>{{ $message }}</span>
          </div>
          @enderror
        </div>

        <div class="input-group">
          <label class="input-label">NIM/NIP</label>
          <div class="input-wrapper">
            <input type="text" 
                   class="form-input" 
                   placeholder="1234567890" 
                   name="nim_nip"
                   value="{{ old('nim_nip') }}"
                   required>
            <i class="fas fa-id-card input-icon"></i>
          </div>
          @error('nim_nip')
          <div class="error-message">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>{{ $message }}</span>
          </div>
          @enderror
        </div>
      </div>

      <!-- Email -->
      <div class="input-group">
        <label class="input-label">Email Address</label>
        <div class="input-wrapper">
          <input type="email" 
                 class="form-input" 
                 placeholder="you@example.com" 
                 name="email"
                 value="{{ old('email') }}"
                 required>
          <i class="fas fa-envelope input-icon"></i>
        </div>
        @error('email')
        <div class="error-message">
          <i class="fas fa-exclamation-circle error-icon"></i>
          <span>{{ $message }}</span>
        </div>
        @enderror
      </div>

      <!-- Phone and Birth Date -->
      <div class="form-grid">
        <div class="input-group">
          <label class="input-label">Phone Number</label>
          <div class="input-wrapper">
            <input type="tel" 
                   class="form-input" 
                   placeholder="081234567890" 
                   name="telepon"
                   value="{{ old('telepon') }}"
                   required>
            <i class="fas fa-phone input-icon"></i>
          </div>
          @error('telepon')
          <div class="error-message">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>{{ $message }}</span>
          </div>
          @enderror
        </div>

        <div class="input-group">
          <label class="input-label">Birth Date</label>
          <div class="input-wrapper">
            <input type="date" 
                   class="form-input" 
                   name="tanggal_lahir"
                   value="{{ old('tanggal_lahir') }}"
                   required>
            <i class="fas fa-calendar input-icon"></i>
          </div>
          @error('tanggal_lahir')
          <div class="error-message">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>{{ $message }}</span>
          </div>
          @enderror
        </div>
      </div>

      <!-- Address -->
      <div class="input-group">
        <label class="input-label">Address</label>
        <div class="input-wrapper">
          <input type="text" 
                 class="form-input" 
                 placeholder="Your complete address" 
                 name="alamat"
                 value="{{ old('alamat') }}"
                 required>
          <i class="fas fa-map-marker-alt input-icon"></i>
        </div>
        @error('alamat')
        <div class="error-message">
          <i class="fas fa-exclamation-circle error-icon"></i>
          <span>{{ $message }}</span>
        </div>
        @enderror
      </div>

      <!-- Photo Upload -->
      <div class="input-group">
        <label class="input-label">Profile Photo (Optional)</label>
        <div class="input-wrapper">
          <input type="file" 
                 class="form-input" 
                 name="foto"
                 accept="image/*"
                 style="padding-left: 16px;">
          <i class="fas fa-camera input-icon"></i>
        </div>
        @error('foto')
        <div class="error-message">
          <i class="fas fa-exclamation-circle error-icon"></i>
          <span>{{ $message }}</span>
        </div>
        @enderror
      </div>

      <!-- Password and Confirm Password -->
      <div class="form-grid">
        <div class="input-group">
          <label class="input-label">Password</label>
          <div class="input-wrapper">
            <input type="password" 
                   class="form-input" 
                   placeholder="Password" 
                   id="password"
                   name="password"
                   required>
            <i class="fas fa-lock input-icon"></i>
            <button type="button" class="password-toggle-btn" id="togglePassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          @error('password')
          <div class="error-message">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>{{ $message }}</span>
          </div>
          @enderror
          <div class="password-strength">
            <div class="strength-bar">
              <div class="strength-fill" id="strengthFill"></div>
            </div>
            <div class="strength-text" id="strengthText">Password strength</div>
          </div>
        </div>

        <div class="input-group">
          <label class="input-label">Confirm Password</label>
          <div class="input-wrapper">
            <input type="password" 
                   class="form-input" 
                   placeholder="Retype" 
                   id="confirmPassword"
                   name="password_confirmation"
                   required>
            <i class="fas fa-lock input-icon"></i>
            <button type="button" class="password-toggle-btn" id="toggleConfirmPassword">
              <i class="fas fa-eye"></i>
            </button>
          </div>
          <div class="error-message" id="passwordMatchError" style="display: none;">
            <i class="fas fa-exclamation-circle error-icon"></i>
            <span>Passwords do not match</span>
          </div>
        </div>
      </div>

      <!-- Terms and Conditions -->
      <div class="terms-group">
        <input type="checkbox" id="terms" name="terms" class="checkbox-input" required>
        <label for="terms" class="terms-label">
          I agree to the <a href="/terms" class="terms-link">Terms of Service</a> and 
          <a href="/privacy" class="terms-link">Privacy Policy</a>. I understand that my account 
          needs to be verified before I can access all features.
        </label>
      </div>
      @error('terms')
      <div class="error-message" style="margin-top: -16px; margin-bottom: 16px;">
        <i class="fas fa-exclamation-circle error-icon"></i>
        <span>You must agree to the terms and conditions</span>
      </div>
      @enderror

      <!-- Submit Button -->
      <button type="submit" class="submit-button" id="registerButton" disabled>
        <span>Create Account</span>
      </button>

      <!-- Login Link -->
      <div class="login-link">
        Already have an account? <a href="/login">Sign in</a>
      </div>
    </form>

    <!-- Footer -->
    <div class="register-footer">
      © 2024 {{ config('app.name', 'AdminLTE') }}. All rights reserved.
    </div>
  </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function() {
  // Elements
  const passwordInput = document.getElementById('password');
  const confirmPasswordInput = document.getElementById('confirmPassword');
  const togglePasswordBtn = document.getElementById('togglePassword');
  const toggleConfirmPasswordBtn = document.getElementById('toggleConfirmPassword');
  const registerForm = document.getElementById('registerForm');
  const registerButton = document.getElementById('registerButton');
  const termsCheckbox = document.getElementById('terms');
  const strengthFill = document.getElementById('strengthFill');
  const strengthText = document.getElementById('strengthText');
  const passwordMatchError = document.getElementById('passwordMatchError');

  // Password toggle functionality
  function setupPasswordToggle(toggleBtn, inputField) {
    toggleBtn.addEventListener('click', function() {
      const isPassword = inputField.type === 'password';
      inputField.type = isPassword ? 'text' : 'password';
      
      // Update icon with animation
      const icon = this.querySelector('i');
      this.classList.toggle('active');
      icon.style.transform = 'scale(0.8)';
      setTimeout(() => {
        icon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        icon.style.transform = 'scale(1)';
      }, 150);
      
      inputField.focus();
    });
  }

  setupPasswordToggle(togglePasswordBtn, passwordInput);
  setupPasswordToggle(toggleConfirmPasswordBtn, confirmPasswordInput);

  // Password strength checker
  function checkPasswordStrength(password) {
    let strength = 0;
    let feedback = '';
    
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    switch(strength) {
      case 0:
      case 1:
        strengthFill.className = 'strength-fill weak';
        feedback = 'Weak password';
        break;
      case 2:
      case 3:
        strengthFill.className = 'strength-fill fair';
        feedback = 'Fair password';
        break;
      case 4:
        strengthFill.className = 'strength-fill good';
        feedback = 'Strong password';
        break;
    }
    
    strengthText.textContent = feedback;
  }

  // Password match checker
  function checkPasswordMatch() {
    const password = passwordInput.value;
    const confirmPassword = confirmPasswordInput.value;
    
    if (confirmPassword === '') {
      passwordMatchError.style.display = 'none';
      confirmPasswordInput.style.borderColor = '';
      return true;
    }
    
    if (password === confirmPassword) {
      passwordMatchError.style.display = 'none';
      confirmPasswordInput.style.borderColor = 'var(--success-green)';
      return true;
    } else {
      passwordMatchError.style.display = 'flex';
      confirmPasswordInput.style.borderColor = 'var(--error-red)';
      return false;
    }
  }

  // Form validation
  function validateForm() {
    const isFormValid = registerForm.checkValidity() && 
                       termsCheckbox.checked && 
                       checkPasswordMatch();
    registerButton.disabled = !isFormValid;
  }

  // Event listeners for real-time validation
  passwordInput.addEventListener('input', function() {
    checkPasswordStrength(this.value);
    checkPasswordMatch();
    validateForm();
  });

  confirmPasswordInput.addEventListener('input', function() {
    checkPasswordMatch();
    validateForm();
  });

  termsCheckbox.addEventListener('change', validateForm);
  
  // Validate all form inputs on input
  const formInputs = registerForm.querySelectorAll('input:not([type="hidden"])');
  formInputs.forEach(input => {
    input.addEventListener('input', validateForm);
    input.addEventListener('change', validateForm);
  });

  // Initialize form validation
  validateForm();

  // Form submission with loading state
  registerForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!registerButton.disabled) {
      // Show loading state
      registerButton.classList.add('loading');
      registerButton.disabled = true;
      
      // Validate passwords match one more time
      if (!checkPasswordMatch()) {
        registerButton.classList.remove('loading');
        registerButton.disabled = false;
        return;
      }
      
      // Submit the form
      try {
        // Simulate API call delay
        await new Promise(resolve => setTimeout(resolve, 1500));
        this.submit();
      } catch (error) {
        console.error('Form submission error:', error);
        registerButton.classList.remove('loading');
        registerButton.disabled = false;
      }
    }
  });

  // Set maximum birth date to today
  const birthDateInput = document.querySelector('input[name="tanggal_lahir"]');
  const today = new Date().toISOString().split('T')[0];
  birthDateInput.max = today;

  // Preview photo if selected
  const photoInput = document.querySelector('input[name="foto"]');
  photoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      // Validate file size (max 2MB)
      if (file.size > 2 * 1024 * 1024) {
        alert('File size must be less than 2MB');
        this.value = '';
        return;
      }
      
      // Validate file type
      if (!file.type.match('image.*')) {
        alert('Please select an image file');
        this.value = '';
        return;
      }
    }
  });

  // Auto-focus first input
  const firstInput = document.querySelector('input[name="nama"]');
  if (firstInput.value === '') {
    firstInput.focus();
  }

  // Keyboard shortcuts
  document.addEventListener('keydown', function(e) {
    // Alt+P to toggle password visibility
    if (e.altKey && e.key === 'p') {
      e.preventDefault();
      togglePasswordBtn.click();
    }
    
    // Alt+C to toggle confirm password visibility
    if (e.altKey && e.key === 'c') {
      e.preventDefault();
      toggleConfirmPasswordBtn.click();
    }
  });
});
</script>
</body>
</html>
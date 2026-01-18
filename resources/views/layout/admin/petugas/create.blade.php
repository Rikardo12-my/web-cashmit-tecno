@extends('layout.admin.master')

@section('title', 'Tambah Petugas Baru')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-8">
                    <div class="d-flex align-items-center">
                        <div class="bg-gradient-primary p-3 rounded-circle mr-3">
                            <i class="fas fa-user-plus text-white fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="m-0 text-dark">Tambah Petugas Baru</h1>
                            <nav aria-label="breadcrumb" class="mt-2">
                                <ol class="breadcrumb p-0 bg-transparent">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}">Petugas</a></li>
                                    <li class="breadcrumb-item active text-primary">Tambah Baru</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="float-sm-right">
                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <!-- Alert Info -->
                    <div class="alert alert-light-primary border-left-4 border-primary mb-4">
                        <div class="d-flex">
                            <div class="mr-3 text-primary">
                                <i class="fas fa-info-circle fa-lg"></i>
                            </div>
                            <div>
                                <p class="mb-0">Petugas yang dibuat akan langsung aktif dan email terverifikasi.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-bottom-0 py-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-user-tie text-primary mr-2"></i>
                                    Form Tambah Petugas
                                </h5>
                            </div>
                        </div>
                        
                        <div class="card-body pt-0">
                            <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data" id="createPetugasForm">
                                @csrf
                                
                                <!-- Foto Profil Section -->
                                <div class="text-center mb-5">
                                    <div class="avatar-upload mx-auto">
                                        <div class="avatar-preview mb-3" id="avatarPreview">
                                        </div>
                                        <div class="avatar-upload-btn">
                                            <input type="file" id="foto" name="foto" accept="image/*" class="d-none">
                                            <label for="foto" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-camera mr-2"></i>Upload Foto
                                            </label>
                                            <div class="text-muted small mt-2">Opsional • Max 2MB • JPG, PNG, GIF</div>
                                            @error('foto')
                                            <div class="text-danger small mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 1: Nama & Email -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">
                                                <span class="text-muted small">Nama Lengkap</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" name="nama" value="{{ old('nama') }}"
                                                    placeholder="Masukkan nama lengkap" required>
                                            </div>
                                            @error('nama')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                <span class="text-muted small">Email</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-envelope text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ old('email') }}"
                                                    placeholder="contoh@email.com" required>
                                            </div>
                                            @error('email')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 2: Password & Konfirmasi -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">
                                                <span class="text-muted small">Password</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-lock text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password"
                                                    placeholder="Minimal 8 karakter" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary border-left-0" type="button" id="togglePassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            @error('password')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">
                                                <span class="text-muted small">Konfirmasi Password</span>
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-lock text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Ulangi password" required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary border-left-0" type="button" id="toggleConfirmPassword">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 3: Telepon & NIM/NIP -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telepon" class="form-label">
                                                <span class="text-muted small">Nomor Telepon</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-phone text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                                    id="telepon" name="telepon" value="{{ old('telepon') }}"
                                                    placeholder="Contoh: 081234567890">
                                            </div>
                                            @error('telepon')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nim_nip" class="form-label">
                                                <span class="text-muted small">NIM/NIP</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-id-card text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control @error('nim_nip') is-invalid @enderror"
                                                    id="nim_nip" name="nim_nip" value="{{ old('nim_nip') }}"
                                                    placeholder="Nomor identitas">
                                            </div>
                                            @error('nim_nip')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Row 4: Tanggal Lahir & Alamat -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir" class="form-label">
                                                <span class="text-muted small">Tanggal Lahir</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0">
                                                        <i class="fas fa-calendar-alt text-muted"></i>
                                                    </span>
                                                </div>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            </div>
                                            @error('tanggal_lahir')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">
                                                <span class="text-muted small">Alamat</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-light border-right-0 align-items-start pt-3">
                                                        <i class="fas fa-map-marker-alt text-muted"></i>
                                                    </span>
                                                </div>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                    id="alamat" name="alamat" rows="3"
                                                    placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                            </div>
                                            @error('alamat')
                                            <div class="invalid-feedback d-block mt-2">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="row mt-5">
                                    <div class="col-md-6 mb-2">
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <i class="fas fa-save mr-2"></i> Simpan Petugas
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="{{ route('admin.petugas.index') }}" class="btn btn-light btn-block border">
                                            <i class="fas fa-times mr-2"></i> Batal
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    /* Card Styling */
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0,0,0,.05);
    }
    
    /* Avatar Upload */
    .avatar-upload {
        max-width: 200px;
    }
    
    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #667eea;
        border: 2px solid #e2e8f0;
        margin: 0 auto;
        position: relative;
        overflow: hidden;
    }
    
    .avatar-preview.has-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
    }
    
    /* Form Controls */
    .form-label {
        margin-bottom: 8px;
        display: block;
    }
    
    .form-control {
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.2s ease;
        height: calc(2.25rem + 2px);
    }
    
    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
    }
    
    textarea.form-control {
        height: auto;
        min-height: 100px;
        resize: vertical;
    }
    
    /* Input Groups */
    .input-group-text {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-right: 0;
        color: #64748b;
    }
    
    .input-group .form-control {
        border-left: 0;
    }
    
    .input-group .form-control:focus {
        border-color: #667eea;
    }
    
    .input-group .form-control:focus + .input-group-append .btn {
        border-color: #667eea;
    }
    
    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        padding: 10px 20px;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
    }
    
    .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }
    
    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
    }
    
    .btn-outline-primary:hover {
        background-color: rgba(102, 126, 234, 0.1);
    }
    
    .btn-light {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #64748b;
    }
    
    .btn-light:hover {
        background-color: #f1f5f9;
        border-color: #cbd5e1;
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 13px;
    }
    
    /* Alert */
    .alert-light-primary {
        background-color: rgba(102, 126, 234, 0.05);
        border-left: 4px solid #667eea;
        border-color: rgba(102, 126, 234, 0.2);
    }
    
    /* Invalid Feedback */
    .invalid-feedback {
        font-size: 13px;
        color: #e53e3e;
    }
    
    /* Spacing */
    .mb-4 {
        margin-bottom: 1.5rem !important;
    }
    
    .mt-5 {
        margin-top: 3rem !important;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.25rem;
        }
        
        .btn-block {
            margin-bottom: 10px;
        }
        
        .avatar-preview {
            width: 100px;
            height: 100px;
        }
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Preview Avatar
        $('#foto').on('change', function(e) {
            const file = e.target.files[0];
            const avatarPreview = $('#avatarPreview');
            
            if (file) {
                // Check file size
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB',
                        icon: 'error',
                        confirmButtonColor: '#667eea'
                    });
                    $(this).val('');
                    return;
                }
                
                // Check file type
                const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        title: 'Format File Tidak Didukung',
                        text: 'Hanya file JPG, PNG, atau GIF yang diperbolehkan',
                        icon: 'error',
                        confirmButtonColor: '#667eea'
                    });
                    $(this).val('');
                    return;
                }
                
                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview
                        .addClass('has-image')
                        .css('background-image', `url(${e.target.result})`);
                }
                reader.readAsDataURL(file);
            } else {
                avatarPreview
                    .removeClass('has-image')
                    .css('background-image', '');
            }
        });

        // Toggle Password Visibility
        $('#togglePassword').on('click', function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        $('#toggleConfirmPassword').on('click', function() {
            const confirmInput = $('#password_confirmation');
            const type = confirmInput.attr('type') === 'password' ? 'text' : 'password';
            confirmInput.attr('type', type);
            $(this).find('i').toggleClass('fa-eye fa-eye-slash');
        });

        // Form Validation
        $('#createPetugasForm').on('submit', function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#password_confirmation').val();
            
            // Password validation
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    title: 'Password Terlalu Pendek',
                    text: 'Password harus minimal 8 karakter',
                    icon: 'warning',
                    confirmButtonColor: '#667eea'
                });
                return false;
            }
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    title: 'Password Tidak Cocok',
                    text: 'Password dan konfirmasi password harus sama',
                    icon: 'error',
                    confirmButtonColor: '#667eea'
                });
                return false;
            }
            
            return true;
        });

        // Phone number formatting
        $('input[name="telepon"]').on('input', function() {
            $(this).val($(this).val().replace(/\D/g, ''));
        });

        // Auto-focus first field
        $('input[name="nama"]').focus();
        
        // Reset preview when form resets
        $('form').on('reset', function() {
            $('#avatarPreview')
                .removeClass('has-image')
                .css('background-image', '');
        });
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
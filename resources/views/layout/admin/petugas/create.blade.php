@extends('layout.admin.master')

@section('title', 'Tambah Petugas Baru')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-user-plus mr-2"></i>➕ Tambah Petugas Baru
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.petugas.index') }}"><i class="fas fa-user-tie"></i> Petugas</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-plus-circle"></i> Tambah Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-user-tie mr-2"></i>
                                Form Tambah Petugas
                            </h3>
                            <div class="card-tools">
                                <a href="{{ route('admin.petugas.index') }}" class="btn btn-sm btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.petugas.store') }}" method="POST" enctype="multipart/form-data" id="createPetugasForm">
                                @csrf
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Petugas yang dibuat akan langsung aktif dan email terverifikasi.
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama" class="form-label">
                                                <i class="fas fa-user mr-1"></i> Nama Lengkap
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                                    id="nama" name="nama" value="{{ old('nama') }}"
                                                    placeholder="Masukkan nama lengkap" required>
                                            </div>
                                            @error('nama')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope mr-1"></i> Email
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-at"></i></span>
                                                </div>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                    id="email" name="email" value="{{ old('email') }}"
                                                    placeholder="contoh@email.com" required>
                                            </div>
                                            @error('email')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="form-label">
                                                <i class="fas fa-lock mr-1"></i> Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password"
                                                    placeholder="Minimal 8 karakter" required>
                                            </div>
                                            @error('password')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password_confirmation" class="form-label">
                                                <i class="fas fa-lock mr-1"></i> Konfirmasi Password
                                                <span class="text-danger">*</span>
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                                                </div>
                                                <input type="password" class="form-control"
                                                    id="password_confirmation" name="password_confirmation"
                                                    placeholder="Ulangi password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="telepon" class="form-label">
                                                <i class="fas fa-phone mr-1"></i> Nomor Telepon
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                                    id="telepon" name="telepon" value="{{ old('telepon') }}"
                                                    placeholder="Contoh: 081234567890">
                                            </div>
                                            @error('telepon')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nim_nip" class="form-label">
                                                <i class="fas fa-id-card mr-1"></i> NIM/NIP
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-address-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control @error('nim_nip') is-invalid @enderror"
                                                    id="nim_nip" name="nim_nip" value="{{ old('nim_nip') }}"
                                                    placeholder="Nomor identitas">
                                            </div>
                                            @error('nim_nip')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir" class="form-label">
                                                <i class="fas fa-birthday-cake mr-1"></i> Tanggal Lahir
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                                                    id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                                            </div>
                                            @error('tanggal_lahir')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="alamat" class="form-label">
                                                <i class="fas fa-map-marker-alt mr-1"></i> Alamat
                                            </label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                </div>
                                                <textarea class="form-control @error('alamat') is-invalid @enderror"
                                                    id="alamat" name="alamat" rows="1"
                                                    placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                                            </div>
                                            @error('alamat')
                                            <div class="invalid-feedback d-block">
                                                <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Input Foto -->
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="foto" class="form-label">
                                                <i class="fas fa-image mr-1"></i> Foto Profil (Opsional)
                                            </label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input @error('foto') is-invalid @enderror"
                                                    id="foto" name="foto" accept="image/*">
                                                <label class="custom-file-label" for="foto" id="fotoLabel">
                                                    <i class="fas fa-upload mr-1"></i> Pilih foto (max: 2MB)
                                                </label>
                                                @error('foto')
                                                <div class="invalid-feedback d-block">
                                                    <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                            <small class="form-text text-muted">
                                                <i class="fas fa-info-circle mr-1"></i>Format: JPG, PNG, GIF. Ukuran maksimal 2MB.
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Preview Foto -->
                                <div class="row" id="fotoPreviewContainer" style="display: none;">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label><i class="fas fa-eye mr-1"></i> Preview Foto:</label>
                                            <div class="image-preview-wrapper text-center">
                                                <img id="fotoPreview" src="" alt="Preview Foto"
                                                    class="img-fluid rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                                        <i class="fas fa-save mr-1"></i> Simpan Petugas
                                    </button>
                                    <a href="{{ route('admin.petugas.index') }}" class="btn btn-secondary btn-block mt-2">
                                        <i class="fas fa-times mr-1"></i> Batal
                                    </a>
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
    .card-outline {
        border-top: 4px solid #667eea;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
    }
    
    .form-control, .custom-file-input {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
        padding: 12px 15px;
    }
    
    .form-control:focus, .custom-file-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.3rem rgba(102, 126, 234, 0.25);
        transform: translateY(-2px);
    }
    
    .input-group-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px 0 0 8px;
    }
    
    .custom-file-label {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        padding: 12px 15px;
    }
    
    .custom-file-label::after {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 0 6px 6px 0;
        height: calc(100% + 4px);
        top: -2px;
        right: -2px;
    }
    
    .image-preview-wrapper {
        border: 3px dashed #667eea;
        border-radius: 50%;
        padding: 20px;
        background: linear-gradient(45deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        display: inline-block;
    }
    
    .btn {
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Preview Foto saat Upload
        $('#foto').on('change', function(e) {
            const file = e.target.files[0];
            const label = $('#fotoLabel');

            if (file) {
                label.html(`<i class="fas fa-check-circle mr-1"></i>${file.name}`);

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#fotoPreview').attr('src', e.target.result);
                    $('#fotoPreviewContainer').slideDown();
                }
                reader.readAsDataURL(file);
            } else {
                label.html('<i class="fas fa-upload mr-1"></i> Pilih foto (max: 2MB)');
                $('#fotoPreviewContainer').slideUp();
            }
        });

        // Form validation
        $('#createPetugasForm').on('submit', function(e) {
            const password = $('#password').val();
            const confirmPassword = $('#password_confirmation').val();
            
            if (password !== confirmPassword) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Password dan konfirmasi password tidak sama!',
                    icon: 'error',
                    confirmButtonColor: '#667eea'
                });
            }
        });

        // Initialize custom file input
        bsCustomFileInput.init();
    });
</script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
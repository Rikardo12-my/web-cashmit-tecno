@extends('layout.customer.customer')

@section('title', 'Profil Saya')

@section('content')
<div class="container-fluid">
    <!-- Header Info -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="info-box bg-gradient-info">
                <span class="info-box-icon"><i class="fas fa-user-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Profil Customer</span>
                    <span class="info-box-number">{{ Auth::user()->nama }}</span>
                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description">
                        <i class="fas fa-envelope mr-1"></i> {{ Auth::user()->email }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <div class="col-md-4">
            <!-- Profil Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Foto Profil</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body text-center">
                    @if($user->foto)
                        <img src="{{ Storage::url('public/foto-profil/' . $user->foto) }}" 
                             class="img-fluid rounded-circle mb-3"
                             style="width: 200px; height: 200px; object-fit: cover; border: 3px solid #007bff;"
                             alt="Foto Profil"
                             onerror="this.onerror=null; this.src='{{ asset('images/default-avatar.png') }}'">
                    @else
                        <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 200px; height: 200px;">
                            <i class="fas fa-user fa-5x text-white"></i>
                        </div>
                    @endif
                    
                    <div class="mt-3">
                        <form id="uploadFotoForm" action="{{ route('profile.upload-foto') }}" method="POST" enctype="multipart/form-data" class="d-inline-block">
                            @csrf
                            <input type="file" name="foto" id="fotoInput" class="d-none" accept="image/*">
                            <button type="button" class="btn btn-primary btn-sm" onclick="document.getElementById('fotoInput').click()">
                                <i class="fas fa-upload mr-1"></i> Upload Foto
                            </button>
                        </form>
                        
                        @if($user->foto)
                            <form id="deleteFotoForm" action="{{ route('profile.hapus-foto') }}" method="POST" class="d-inline-block">
                                @csrf
                                <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteFoto()">
                                    <i class="fas fa-trash mr-1"></i> Hapus Foto
                                </button>
                            </form>
                        @endif
                    </div>
                    
                    <div class="mt-3">
                        <small class="text-muted">Format: JPG, PNG, GIF • Maks: 2MB</small>
                    </div>
                </div>
            </div>
            
            <!-- Informasi Akun -->
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Akun</h3>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <strong><i class="fas fa-user mr-1"></i> Role:</strong>
                        </div>
                        <div class="col-6 text-right">
                            <span class="badge badge-success">{{ ucfirst($user->role) }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6">
                            <strong><i class="fas fa-envelope mr-1"></i> Email:</strong>
                        </div>
                        <div class="col-6 text-right">
                            <span>{{ $user->email }}</span>
                        </div>
                    </div>
                    
                    <div class="row mb-2">
                        <div class="col-6">
                            <strong><i class="fas fa-calendar-alt mr-1"></i> Bergabung:</strong>
                        </div>
                        <div class="col-6 text-right">
                            <span>{{ $user->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-6">
                            <strong><i class="fas fa-circle mr-1"></i> Status:</strong>
                        </div>
                        <div class="col-6 text-right">
                            @if($user->status == 'active')
                                <span class="badge badge-success">Aktif</span>
                            @elseif($user->status == 'verify')
                                <span class="badge badge-warning">Verifikasi</span>
                            @else
                                <span class="badge badge-danger">Banned</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <!-- Tab Navigation -->
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="profile-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ session('tab') == 'nama' || !session('tab') ? 'active' : '' }}" 
                               id="nama-tab" data-toggle="pill" href="#nama" role="tab">
                               <i class="fas fa-user-edit mr-1"></i> Ubah Nama
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ session('tab') == 'password' ? 'active' : '' }}" 
                               id="password-tab" data-toggle="pill" href="#password" role="tab">
                               <i class="fas fa-key mr-1"></i> Ubah Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ session('tab') == 'foto' ? 'active' : '' }}" 
                               id="foto-tab" data-toggle="pill" href="#foto" role="tab">
                               <i class="fas fa-camera mr-1"></i> Pengaturan Foto
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body">
                    <div class="tab-content" id="profile-tabContent">
                        
                        <!-- Alert Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        
                        <!-- Tab 1: Ubah Nama -->
                        <div class="tab-pane fade {{ session('tab') == 'nama' || !session('tab') ? 'show active' : '' }}" 
                             id="nama" role="tabpanel">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-user-edit mr-2"></i>Perbarui Nama Anda
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update-nama') }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label for="nama_current">Nama Saat Ini</label>
                                            <input type="text" class="form-control" 
                                                   value="{{ $user->nama }}" disabled>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="nama">Nama Baru</label>
                                            <input type="text" name="nama" id="nama"
                                                   class="form-control @error('nama') is-invalid @enderror"
                                                   value="{{ old('nama', $user->nama) }}"
                                                   placeholder="Masukkan nama baru"
                                                   required>
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                                            </button>
                                            <button type="reset" class="btn btn-secondary">
                                                <i class="fas fa-undo mr-1"></i> Reset
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab 2: Ubah Password -->
                        <div class="tab-pane fade {{ session('tab') == 'password' ? 'show active' : '' }}" 
                             id="password" role="tabpanel">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-key mr-2"></i>Keamanan Akun
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('profile.update-password') }}" method="POST">
                                        @csrf
                                        
                                        <div class="form-group">
                                            <label for="current_password">Password Saat Ini</label>
                                            <div class="input-group">
                                                <input type="password" name="current_password" id="current_password"
                                                       class="form-control @error('current_password') is-invalid @enderror"
                                                       placeholder="Masukkan password saat ini"
                                                       required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" 
                                                            type="button" data-target="current_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('current_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="new_password">Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="new_password"
                                                       class="form-control @error('new_password') is-invalid @enderror"
                                                       placeholder="Minimal 8 karakter"
                                                       required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" 
                                                            type="button" data-target="new_password">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                                @error('new_password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="new_password_confirmation">Konfirmasi Password Baru</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password_confirmation" 
                                                       id="new_password_confirmation"
                                                       class="form-control"
                                                       placeholder="Ulangi password baru"
                                                       required>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary toggle-password" 
                                                            type="button" data-target="new_password_confirmation">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Password Strength Indicator -->
                                        <div class="form-group">
                                            <div class="progress mb-1" style="height: 5px;">
                                                <div class="progress-bar bg-danger" id="password-strength" 
                                                     role="progressbar" style="width: 0%"></div>
                                            </div>
                                            <small class="text-muted" id="password-strength-text">
                                                Kekuatan password: Lemah
                                            </small>
                                        </div>
                                        
                                        <div class="alert alert-info">
                                            <h6><i class="fas fa-lightbulb mr-2"></i>Tips Password Aman:</h6>
                                            <ul class="mb-0 pl-3">
                                                <li>Gunakan minimal 8 karakter</li>
                                                <li>Kombinasikan huruf besar & kecil</li>
                                                <li>Tambahkan angka dan simbol</li>
                                                <li>Jangan gunakan informasi pribadi</li>
                                            </ul>
                                        </div>
                                        
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-key mr-1"></i> Ubah Password
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tab 3: Pengaturan Foto -->
                        <div class="tab-pane fade {{ session('tab') == 'foto' ? 'show active' : '' }}" 
                             id="foto" role="tabpanel">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title">
                                        <i class="fas fa-camera mr-2"></i>Kelola Foto Profil
                                    </h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-gradient-info">
                                                    <h5 class="card-title mb-0 text-white">
                                                        <i class="fas fa-upload mr-1"></i>Upload Foto Baru
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <form action="{{ route('profile.upload-foto') }}" method="POST" enctype="multipart/form-data" id="uploadFotoTabForm">
                                                        @csrf
                                                        
                                                        <div class="form-group">
                                                            <label for="foto_tab">Pilih Foto</label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" 
                                                                       name="foto" id="foto_tab" 
                                                                       accept="image/*" required>
                                                                <label class="custom-file-label" for="foto_tab">
                                                                    Pilih file...
                                                                </label>
                                                            </div>
                                                            @error('foto')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <div class="image-preview mb-3" id="imagePreview">
                                                                <img src="" alt="Preview" class="image-preview__image" style="display: none;">
                                                                <span class="image-preview__default-text">Preview akan muncul di sini</span>
                                                            </div>
                                                        </div>
                                                        
                                                        <button type="submit" class="btn btn-primary btn-block">
                                                            <i class="fas fa-upload mr-1"></i> Upload Foto
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header bg-gradient-danger">
                                                    <h5 class="card-title mb-0 text-white">
                                                        <i class="fas fa-trash mr-1"></i>Hapus Foto
                                                    </h5>
                                                </div>
                                                <div class="card-body text-center">
                                                    @if($user->foto)
                                                        <p class="text-muted">Hapus foto profil saat ini?</p>
                                                        <form action="{{ route('profile.hapus-foto') }}" method="POST">
                                                            @csrf
                                                            <button type="button" class="btn btn-danger" onclick="confirmDeleteFoto()">
                                                                <i class="fas fa-trash mr-1"></i> Hapus Foto Profil
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div class="text-center py-4">
                                                            <i class="fas fa-user-slash fa-3x text-muted mb-3"></i>
                                                            <p class="text-muted">Tidak ada foto profil</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="card mt-3">
                                                <div class="card-header">
                                                    <h5 class="card-title mb-0">
                                                        <i class="fas fa-info-circle mr-1"></i>Ketentuan Foto
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <ul class="mb-0">
                                                        <li>Format: JPG, PNG, GIF</li>
                                                        <li>Ukuran maksimal: 2MB</li>
                                                        <li>Rasio disarankan: 1:1 (persegi)</li>
                                                        <li>Gunakan foto wajah yang jelas</li>
                                                        <li>Hindari konten tidak pantas</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
$(document).ready(function() {
    // Auto submit foto upload form
    $('#fotoInput').change(function() {
        if (this.files.length > 0) {
            $('#uploadFotoForm').submit();
        }
    });
    
    // File input preview
    $('#foto_tab').change(function() {
        const file = this.files[0];
        const preview = $('#imagePreview');
        const previewImage = preview.find('.image-preview__image');
        const defaultText = preview.find('.image-preview__default-text');
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImage.attr('src', e.target.result);
                previewImage.show();
                defaultText.hide();
            }
            
            reader.readAsDataURL(file);
            
            // Update file label
            $(this).next('.custom-file-label').html(file.name);
        }
    });
    
    // Toggle password visibility
    $('.toggle-password').click(function() {
        const targetId = $(this).data('target');
        const input = $('#' + targetId);
        const icon = $(this).find('i');
        
        if (input.attr('type') === 'password') {
            input.attr('type', 'text');
            icon.removeClass('fa-eye').addClass('fa-eye-slash');
        } else {
            input.attr('type', 'password');
            icon.removeClass('fa-eye-slash').addClass('fa-eye');
        }
    });
    
    // Password strength checker
    $('#new_password').on('keyup', function() {
        const password = $(this).val();
        const strengthBar = $('#password-strength');
        const strengthText = $('#password-strength-text');
        
        let strength = 0;
        let text = '';
        let color = '';
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]+/)) strength++;
        if (password.match(/[A-Z]+/)) strength++;
        if (password.match(/[0-9]+/)) strength++;
        if (password.match(/[!@#$%^&*(),.?":{}|<>]+/)) strength++;
        
        switch(strength) {
            case 0:
            case 1:
                text = 'Sangat Lemah';
                color = 'bg-danger';
                break;
            case 2:
                text = 'Lemah';
                color = 'bg-warning';
                break;
            case 3:
                text = 'Sedang';
                color = 'bg-info';
                break;
            case 4:
                text = 'Kuat';
                color = 'bg-success';
                break;
            case 5:
                text = 'Sangat Kuat';
                color = 'bg-primary';
                break;
        }
        
        const percentage = (strength / 5) * 100;
        strengthBar.css('width', percentage + '%');
        strengthBar.removeClass('bg-danger bg-warning bg-info bg-success bg-primary').addClass(color);
        strengthText.text('Kekuatan password: ' + text);
    });
    
    // Auto activate tab from session
    const activeTab = '{{ session("tab", "nama") }}';
    if (activeTab) {
        $('#' + activeTab + '-tab').tab('show');
    }
});

// Confirm delete foto
function confirmDeleteFoto() {
    Swal.fire({
        title: 'Hapus Foto Profil?',
        text: "Foto profil akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $('#deleteFotoForm').submit();
        }
    });
}

// SweetAlert for messages
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        showConfirmButton: false,
        timer: 3000
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        showConfirmButton: false,
        timer: 3000
    });
@endif
</script>

<style>
.info-box {
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    border-radius: .25rem;
    background: #fff;
    display: flex;
    margin-bottom: 1rem;
    min-height: 80px;
    padding: .5rem;
    position: relative;
}

.info-box .info-box-icon {
    border-radius: .25rem;
    align-items: center;
    display: flex;
    font-size: 1.875rem;
    justify-content: center;
    text-align: center;
    width: 70px;
}

.info-box .info-box-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    line-height: 1.8;
    flex: 1;
    padding: 0 10px;
}

.info-box .info-box-number {
    font-size: 1.5rem;
    font-weight: 700;
}

.card-tabs .nav-tabs {
    border-bottom: 1px solid #dee2e6;
}

.card-tabs .nav-tabs .nav-link {
    border: 1px solid transparent;
    border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
}

.card-tabs .nav-tabs .nav-link.active {
    background-color: #fff;
    border-color: #dee2e6 #dee2e6 #fff;
    color: #495057;
}

.image-preview {
    width: 100%;
    height: 200px;
    border: 2px dashed #ddd;
    border-radius: 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.image-preview__image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.image-preview__default-text {
    color: #6c757d;
}

.progress {
    border-radius: 10px;
    overflow: hidden;
}

.custom-file-label::after {
    content: "Browse";
}

.toggle-password {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
}
</style>
@endsection
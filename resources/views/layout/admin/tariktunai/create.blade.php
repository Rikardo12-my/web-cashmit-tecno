@extends('layout.admin.master')

@section('title', 'Buat Transaksi Tarik Tunai Baru')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .payment-method-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .payment-method-card:hover {
        border-color: #4a90e2;
        background-color: #f8fbff;
    }
    
    .payment-method-card.active {
        border-color: #4a90e2;
        background-color: #e8f4ff;
    }
    
    .payment-icon {
        font-size: 24px;
        color: #4a90e2;
        margin-right: 10px;
    }
    
    .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        position: relative;
    }
    
    .step {
        text-align: center;
        position: relative;
        z-index: 2;
    }
    
    .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-weight: bold;
        transition: all 0.3s ease;
    }
    
    .step.active .step-number {
        background: #4a90e2;
        color: white;
    }
    
    .step-line {
        position: absolute;
        top: 20px;
        left: 10%;
        right: 10%;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }
    
    .info-box {
        background: #f8fbff;
        border-left: 4px solid #4a90e2;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .info-box i {
        color: #4a90e2;
    }
</style>
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-plus-circle mr-2 text-primary"></i>
                        Buat Transaksi Tarik Tunai Baru
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.index') }}">Tarik Tunai</a></li>
                        <li class="breadcrumb-item active">Tambah Baru</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step-line"></div>
                <div class="step active" data-step="1">
                    <div class="step-number">1</div>
                    <div class="step-label">Informasi Dasar</div>
                </div>
                <div class="step" data-step="2">
                    <div class="step-number">2</div>
                    <div class="step-label">Metode Pembayaran</div>
                </div>
                <div class="step" data-step="3">
                    <div class="step-number">3</div>
                    <div class="step-label">Konfirmasi</div>
                </div>
            </div>

            <form id="createTransactionForm" method="POST" action="{{ route('admin.tariktunai.store') }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Step 1: Basic Information -->
                        <div class="card card-primary step-content" id="step1">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    Informasi Transaksi
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Informasi:</strong> Pastikan semua data yang diisi sudah benar sebelum melanjutkan.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="user_id">Customer <span class="text-danger">*</span></label>
                                            <select name="user_id" id="user_id" class="form-control select2" required>
                                                <option value="">-- Pilih Customer --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah (Rp) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" 
                                                       name="jumlah" 
                                                       id="jumlah" 
                                                       class="form-control" 
                                                       value="{{ old('jumlah') }}"
                                                       min="10000" 
                                                       max="10000000"
                                                       required
                                                       placeholder="Contoh: 500000">
                                            </div>
                                            <small class="text-muted">Minimal Rp 10.000, Maksimal Rp 10.000.000</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="catatan_admin">Catatan Admin</label>
                                            <textarea name="catatan_admin" 
                                                      id="catatan_admin" 
                                                      class="form-control" 
                                                      rows="3"
                                                      placeholder="Tambahkan catatan untuk transaksi ini...">{{ old('catatan_admin') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="petugas_id">Assign Petugas (Opsional)</label>
                                            <select name="petugas_id" id="petugas_id" class="form-control select2">
                                                <option value="">-- Pilih Petugas --</option>
                                                @foreach($petugasList as $petugas)
                                                    <option value="{{ $petugas->id }}" {{ old('petugas_id') == $petugas->id ? 'selected' : '' }}>
                                                        {{ $petugas->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary float-right next-step" data-next="2">
                                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Payment Method -->
                        <div class="card card-primary step-content" id="step2" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-credit-card mr-2"></i>
                                    Metode Pembayaran
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Penting:</strong> Pilih metode pembayaran sesuai kebutuhan customer. Untuk COD, pilih lokasi penyerahan.
                                </div>
                                
                                <!-- Payment Method Selection -->
                                <div class="row mb-4">
                                    @foreach($paymentMethods as $method)
                                    <div class="col-md-6">
                                        <div class="payment-method-card" data-method-id="{{ $method->id }}" data-category="{{ $method->kategori }}">
                                            <div class="d-flex align-items-center">
                                                <div class="payment-icon">
                                                    @switch($method->kategori)
                                                        @case('bank_qris')<i class="fas fa-university"></i>@break
                                                        @case('qris_cod')<i class="fas fa-truck"></i>@break
                                                        @case('e_wallet')<i class="fas fa-wallet"></i>@break
                                                        @default<i class="fas fa-credit-card"></i>
                                                    @endswitch
                                                </div>
                                                <div>
                                                    <h6 class="mb-1">{{ $method->nama }}</h6>
                                                    <small class="text-muted">
                                                        @switch($method->kategori)
                                                            @case('bank_qris')Transfer Bank / QRIS@break
                                                            @case('qris_cod')COD (Cash on Delivery)@break
                                                            @case('e_wallet')E-Wallet@break
                                                        @endswitch
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <input type="hidden" name="payment_method_id" id="selected_payment_method">
                                
                                <!-- COD Location (Hidden by default) -->
                                <div id="cod-location-section" style="display: none;">
                                    <div class="form-group">
                                        <label for="lokasi_cod_id">Lokasi COD <span class="text-danger">*</span></label>
                                        <select name="lokasi_cod_id" id="lokasi_cod_id" class="form-control select2">
                                            <option value="">-- Pilih Lokasi COD --</option>
                                            @foreach($lokasiCodList as $lokasi)
                                                <option value="{{ $lokasi->id }}" {{ old('lokasi_cod_id') == $lokasi->id ? 'selected' : '' }}>
                                                    {{ $lokasi->nama }} - {{ $lokasi->alamat }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-muted">Pilih lokasi untuk penyerahan uang tunai</small>
                                    </div>
                                </div>
                                
                                <!-- Payment Evidence -->
                                <div class="form-group">
                                    <label for="bukti_bayar_customer">Bukti Bayar Customer (Opsional)</label>
                                    <div class="custom-file">
                                        <input type="file" 
                                               class="custom-file-input" 
                                               id="bukti_bayar_customer" 
                                               name="bukti_bayar_customer"
                                               accept="image/*">
                                        <label class="custom-file-label" for="bukti_bayar_customer">Pilih file...</label>
                                    </div>
                                    <small class="text-muted">Format: JPG, JPEG, PNG | Maks: 2MB</small>
                                    
                                    <div id="imagePreview" class="mt-3" style="display: none;">
                                        <img id="previewImage" src="#" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-secondary prev-step" data-prev="1">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </button>
                                <button type="button" class="btn btn-primary float-right next-step" data-next="3">
                                    Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Step 3: Confirmation -->
                        <div class="card card-primary step-content" id="step3" style="display: none;">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Konfirmasi Transaksi
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="info-box bg-success text-white">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <strong>Konfirmasi:</strong> Periksa kembali semua informasi sebelum membuat transaksi.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tr>
                                                    <th width="30%">Customer</th>
                                                    <td id="confirmCustomer">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Jumlah</th>
                                                    <td id="confirmJumlah">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Metode Pembayaran</th>
                                                    <td id="confirmPaymentMethod">-</td>
                                                </tr>
                                                <tr id="confirmCodLocationRow" style="display: none;">
                                                    <th>Lokasi COD</th>
                                                    <td id="confirmCodLocation">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Petugas</th>
                                                    <td id="confirmPetugas">-</td>
                                                </tr>
                                                <tr>
                                                    <th>Catatan</th>
                                                    <td id="confirmCatatan">-</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-secondary prev-step" data-prev="2">
                                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                                </button>
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fas fa-check mr-2"></i> Buat Transaksi
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Information -->
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    Panduan Transaksi
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="callout callout-info">
                                    <h5><i class="fas fa-info-circle mr-2"></i> Proses Transaksi</h5>
                                    <p>Transaksi tarik tunai akan melalui beberapa status:</p>
                                    <ol class="mb-0">
                                        <li><strong>Pending:</strong> Menunggu verifikasi</li>
                                        <li><strong>Diproses:</strong> Sedang diproses admin</li>
                                        <li><strong>Menunggu Petugas:</strong> Siap untuk diambil petugas</li>
                                        <li><strong>Dalam Perjalanan:</strong> Petugas dalam perjalanan</li>
                                        <li><strong>Selesai:</strong> Transaksi berhasil</li>
                                        <li><strong>Dibatalkan:</strong> Transaksi dibatalkan</li>
                                    </ol>
                                </div>
                                
                                <div class="callout callout-warning mt-3">
                                    <h5><i class="fas fa-exclamation-triangle mr-2"></i> Perhatian!</h5>
                                    <ul class="mb-0">
                                        <li>Pastikan customer sudah membayar sebelum membuat transaksi</li>
                                        <li>Untuk metode COD, tentukan lokasi penyerahan</li>
                                        <li>Assign petugas jika diperlukan</li>
                                        <li>Simpan bukti pembayaran jika ada</li>
                                    </ul>
                                </div>
                                
                                <div class="mt-3">
                                    <h6><i class="fas fa-history mr-2"></i> Riwayat Terbaru</h6>
                                    <div class="list-group">
                                        @php
                                            $recentTransactions = \App\Models\TarikTunai::with('user')
                                                ->orderBy('created_at', 'desc')
                                                ->limit(3)
                                                ->get();
                                        @endphp
                                        
                                        @forelse($recentTransactions as $recent)
                                        <a href="{{ route('admin.tariktunai.show', $recent->id) }}" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h6 class="mb-1">{{ $recent->user->name ?? 'Customer' }}</h6>
                                                <small>{{ $recent->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">Rp {{ number_format($recent->jumlah, 0, ',', '.') }}</p>
                                            <small class="text-muted">{{ $recent->paymentMethod->nama ?? '' }}</small>
                                        </a>
                                        @empty
                                        <div class="list-group-item">
                                            <p class="mb-0 text-muted text-center">Belum ada transaksi</p>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@section('js')
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        theme: 'bootstrap4'
    });
    
    // Initialize custom file input
    bsCustomFileInput.init();
    
    // Step Navigation
    $('.next-step').click(function() {
        const currentStep = $(this).closest('.step-content').attr('id').replace('step', '');
        const nextStep = $(this).data('next');
        
        // Validate current step
        if (currentStep == 1) {
            if (!validateStep1()) return;
        } else if (currentStep == 2) {
            if (!validateStep2()) return;
        }
        
        // Move to next step
        $(`#step${currentStep}`).hide();
        $(`#step${nextStep}`).show();
        
        // Update step indicator
        $('.step').removeClass('active');
        $(`.step[data-step="${nextStep}"]`).addClass('active');
        
        // Update confirmation data if going to step 3
        if (nextStep == 3) {
            updateConfirmationData();
        }
    });
    
    $('.prev-step').click(function() {
        const currentStep = $(this).closest('.step-content').attr('id').replace('step', '');
        const prevStep = $(this).data('prev');
        
        $(`#step${currentStep}`).hide();
        $(`#step${nextStep}`).show();
        
        // Update step indicator
        $('.step').removeClass('active');
        $(`.step[data-step="${prevStep}"]`).addClass('active');
    });
    
    // Payment method selection
    $('.payment-method-card').click(function() {
        $('.payment-method-card').removeClass('active');
        $(this).addClass('active');
        
        const methodId = $(this).data('method-id');
        const category = $(this).data('category');
        
        $('#selected_payment_method').val(methodId);
        
        // Show/hide COD location
        if (category === 'qris_cod') {
            $('#cod-location-section').show();
            $('#lokasi_cod_id').prop('required', true);
        } else {
            $('#cod-location-section').hide();
            $('#lokasi_cod_id').prop('required', false);
        }
    });
    
    // Image preview
    $('#bukti_bayar_customer').change(function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            
            reader.readAsDataURL(this.files[0]);
        } else {
            $('#imagePreview').hide();
        }
    });
    
    // Auto-format amount
    $('#jumlah').on('input', function() {
        const value = $(this).val();
        if (value >= 10000 && value <= 10000000) {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        } else {
            $(this).removeClass('is-valid');
            $(this).addClass('is-invalid');
        }
    });
});

function validateStep1() {
    const userId = $('#user_id').val();
    const jumlah = $('#jumlah').val();
    
    if (!userId) {
        alert('Silakan pilih customer');
        $('#user_id').focus();
        return false;
    }
    
    if (!jumlah || jumlah < 10000 || jumlah > 10000000) {
        alert('Jumlah harus antara Rp 10.000 - Rp 10.000.000');
        $('#jumlah').focus();
        return false;
    }
    
    return true;
}

function validateStep2() {
    const paymentMethod = $('#selected_payment_method').val();
    
    if (!paymentMethod) {
        alert('Silakan pilih metode pembayaran');
        return false;
    }
    
    // Validate COD location if COD is selected
    const category = $('.payment-method-card.active').data('category');
    if (category === 'qris_cod') {
        const codLocation = $('#lokasi_cod_id').val();
        if (!codLocation) {
            alert('Silakan pilih lokasi COD');
            $('#lokasi_cod_id').focus();
            return false;
        }
    }
    
    return true;
}

function updateConfirmationData() {
    // Customer
    const customerName = $('#user_id option:selected').text();
    $('#confirmCustomer').text(customerName);
    
    // Amount
    const amount = $('#jumlah').val();
    $('#confirmJumlah').text('Rp ' + formatNumber(amount));
    
    // Payment Method
    const paymentMethodName = $('.payment-method-card.active').find('h6').text();
    $('#confirmPaymentMethod').text(paymentMethodName);
    
    // COD Location
    const category = $('.payment-method-card.active').data('category');
    if (category === 'qris_cod') {
        $('#confirmCodLocationRow').show();
        const codLocation = $('#lokasi_cod_id option:selected').text();
        $('#confirmCodLocation').text(codLocation);
    } else {
        $('#confirmCodLocationRow').hide();
    }
    
    // Petugas
    const petugasName = $('#petugas_id option:selected').text() || 'Belum ditugaskan';
    $('#confirmPetugas').text(petugasName);
    
    // Catatan
    const catatan = $('#catatan_admin').val() || '-';
    $('#confirmCatatan').text(catatan);
}

function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
@endsection
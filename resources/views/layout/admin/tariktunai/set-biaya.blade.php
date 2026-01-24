@extends('layout.admin.master')

@section('title', 'Set Biaya Admin - ' . $tarikTunai->kode_transaksi)

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-calculator mr-2"></i>💰 Set Biaya Admin
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.index') }}"><i class="fas fa-money-bill-wave"></i> Tarik Tunai</a></li>
                        <li class="breadcrumb-item active">Set Biaya Admin</li>
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
                    <div class="card card-outline card-info">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice-dollar mr-2"></i>
                                Detail Transaksi
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Info Transaksi -->
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <div class="info-box bg-gradient-light">
                                        <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Kode Transaksi</span>
                                            <span class="info-box-number">{{ $tarikTunai->kode_transaksi }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-gradient-light">
                                        <span class="info-box-icon"><i class="fas fa-user"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Customer</span>
                                            <span class="info-box-number">{{ $tarikTunai->user->nama ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="info-box bg-gradient-light">
                                        <span class="info-box-icon"><i class="fas fa-map-marker-alt"></i></span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Lokasi</span>
                                            <span class="info-box-number">{{ $tarikTunai->lokasiCod->nama_lokasi ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Current Status -->
                            <div class="alert alert-info">
                                <h5><i class="fas fa-info-circle mr-2"></i>Informasi Transaksi</h5>
                                <div class="row mt-3">
                                    <div class="col-md-4">
                                        <strong>Jumlah Tarik Tunai:</strong><br>
                                        <span class="h4 text-primary">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Biaya Admin Saat Ini:</strong><br>
                                        <span class="h4 text-warning">Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        <strong>Total Saat Ini:</strong><br>
                                        <span class="h4 text-success">Rp {{ number_format($tarikTunai->total_dibayar, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Set Biaya Admin -->
                            <form action="{{ route('admin.tariktunai.set-biaya', $tarikTunai) }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <label for="biaya_admin">
                                        <i class="fas fa-money-bill-wave mr-1"></i> Biaya Admin Baru
                                    </label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" 
                                               class="form-control @error('biaya_admin') is-invalid @enderror" 
                                               id="biaya_admin" 
                                               name="biaya_admin" 
                                               value="{{ old('biaya_admin', $tarikTunai->biaya_admin) }}"
                                               min="0" 
                                               step="1000"
                                               required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-outline-secondary" id="calculateTotal">
                                                Hitung
                                            </button>
                                        </div>
                                    </div>
                                    @error('biaya_admin')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                    <small class="text-muted">Masukkan nominal biaya admin (minimum 0)</small>
                                </div>

                                <!-- Preview Perhitungan -->
                                <div class="card bg-gradient-light mb-4" id="previewCalculation" style="display: none;">
                                    <div class="card-body">
                                        <h5 class="card-title"><i class="fas fa-calculator mr-2"></i>Preview Perhitungan</h5>
                                        <table class="table table-sm">
                                            <tr>
                                                <td>Jumlah Tarik Tunai:</td>
                                                <td class="text-right">
                                                    <span id="previewJumlah">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Biaya Admin:</td>
                                                <td class="text-right">
                                                    <span id="previewBiayaAdmin" class="text-warning">Rp 0</span>
                                                </td>
                                            </tr>
                                            <tr class="table-success">
                                                <td><strong>Total Dibayar:</strong></td>
                                                <td class="text-right">
                                                    <strong><span id="previewTotal" class="text-success">Rp 0</span></strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                <!-- Catatan Admin -->
                                <div class="form-group">
                                    <label for="catatan_admin">
                                        <i class="fas fa-sticky-note mr-1"></i> Catatan Admin (Opsional)
                                    </label>
                                    <textarea class="form-control @error('catatan_admin') is-invalid @enderror" 
                                              id="catatan_admin" 
                                              name="catatan_admin" 
                                              rows="3" 
                                              placeholder="Tambahkan catatan jika diperlukan...">{{ old('catatan_admin') }}</textarea>
                                    @error('catatan_admin')
                                        <span class="invalid-feedback d-block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Action Buttons -->
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('admin.tariktunai.index') }}" class="btn btn-secondary">
                                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-save mr-1"></i> Simpan Biaya Admin
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <!-- Informasi Penting -->
                            <div class="alert alert-warning mt-4">
                                <h5><i class="fas fa-exclamation-triangle mr-2"></i>Perhatian!</h5>
                                <ul class="mb-0">
                                    <li>Setelah biaya admin di-set, transaksi akan berstatus <strong>"Menunggu Admin"</strong></li>
                                    <li>Admin dapat meng-assign petugas setelah biaya admin ditetapkan</li>
                                    <li>Pastikan nominal biaya admin sesuai dengan ketentuan perusahaan</li>
                                    <li>Customer akan mendapatkan notifikasi tentang biaya admin yang ditetapkan</li>
                                </ul>
                            </div>
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
    .info-box {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
    }
    
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }
    
    .info-box-icon {
        border-radius: 12px 0 0 12px;
        background: rgba(255,255,255,0.1);
    }
    
    #previewCalculation {
        border-left: 4px solid #4facfe;
        animation: slideIn 0.5s ease;
    }
    
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
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        const jumlahTarik = {{ $tarikTunai->jumlah }};
        
        // Format currency
        function formatCurrency(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }
        
        // Calculate total
        function calculateTotal() {
            const biayaAdmin = parseFloat($('#biaya_admin').val()) || 0;
            const total = jumlahTarik + biayaAdmin;
            
            // Update preview
            $('#previewBiayaAdmin').text(formatCurrency(biayaAdmin));
            $('#previewTotal').text(formatCurrency(total));
            
            // Show preview
            $('#previewCalculation').slideDown();
        }
        
        // Calculate on input change
        $('#biaya_admin').on('input', calculateTotal);
        
        // Calculate button click
        $('#calculateTotal').click(calculateTotal);
        
        // Calculate on page load if there's existing value
        if ($('#biaya_admin').val()) {
            calculateTotal();
        }
        
        // Form validation
        $('form').submit(function(e) {
            const biayaAdmin = parseFloat($('#biaya_admin').val()) || 0;
            
            if (biayaAdmin < 0) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Biaya admin tidak boleh kurang dari 0!'
                });
            }
        });
    });
</script>
@endsection
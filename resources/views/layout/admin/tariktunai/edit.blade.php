@extends('layout.admin.master')

@section('title', 'Edit Transaksi Tarik Tunai')

@section('css')
<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<style>
    .tab-content > .tab-pane {
        padding: 20px;
        background: white;
        border: 1px solid #dee2e6;
        border-top: none;
        border-radius: 0 0 10px 10px;
    }
    
    .nav-tabs .nav-link {
        border: 1px solid transparent;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        padding: 12px 20px;
        font-weight: 600;
    }
    
    .nav-tabs .nav-link.active {
        background-color: white;
        border-color: #dee2e6 #dee2e6 #fff;
    }
    
    .info-box {
        background: linear-gradient(135deg, #f8fbff 0%, #e8f4ff 100%);
        border-left: 4px solid #4a90e2;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    
    .evidence-preview {
        max-width: 200px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-bottom: 10px;
    }
    
    .transaction-summary {
        background: white;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
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
                        <i class="fas fa-edit mr-2 text-primary"></i>
                        Edit Transaksi #{{ $transaction->id }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.index') }}">Tarik Tunai</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.show', $transaction->id) }}">Detail</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Transaction Summary -->
            <div class="transaction-summary">
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="display-6 font-weight-bold text-primary">
                                Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                            </div>
                            <small class="text-muted">Jumlah Transaksi</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h4 font-weight-bold">
                                {{ $transaction->user->name }}
                            </div>
                            <small class="text-muted">Customer</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h4">
                                @php
                                    $statusClass = 'badge-' . $transaction->status;
                                @endphp
                                <span class="badge {{ $statusClass }} p-2">
                                    {{ $transaction->getStatusLabelAttribute()['label'] }}
                                </span>
                            </div>
                            <small class="text-muted">Status</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <div class="h4 font-weight-bold">
                                {{ $transaction->created_at->format('d M Y') }}
                            </div>
                            <small class="text-muted">Tanggal Dibuat</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="card">
                <div class="card-header bg-white p-0">
                    <ul class="nav nav-tabs" id="editTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="basic-tab" data-toggle="tab" href="#basic" role="tab">
                                <i class="fas fa-info-circle mr-2"></i> Informasi Dasar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab">
                                <i class="fas fa-credit-card mr-2"></i> Pembayaran
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="petugas-tab" data-toggle="tab" href="#petugas" role="tab">
                                <i class="fas fa-user-tag mr-2"></i> Petugas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="evidence-tab" data-toggle="tab" href="#evidence" role="tab">
                                <i class="fas fa-file-image mr-2"></i> Bukti
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-0">
                    <form action="{{ route('admin.tariktunai.update', $transaction->id) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="editForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="tab-content" id="editTabsContent">
                            <!-- Basic Information Tab -->
                            <div class="tab-pane fade show active" id="basic" role="tabpanel">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Informasi:</strong> Ubah informasi dasar transaksi. 
                                    Jumlah transaksi tidak dapat diubah jika status sudah selesai atau dalam proses.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="jumlah">Jumlah (Rp)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">Rp</span>
                                                </div>
                                                <input type="number" 
                                                       name="jumlah" 
                                                       id="jumlah" 
                                                       class="form-control" 
                                                       value="{{ old('jumlah', $transaction->jumlah) }}"
                                                       min="10000" 
                                                       max="10000000"
                                                       @if(in_array($transaction->status, ['selesai', 'dalam_perjalanan'])) disabled @endif>
                                            </div>
                                            <small class="text-muted">Minimal Rp 10.000, Maksimal Rp 10.000.000</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" id="status" class="form-control">
                                                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="diproses" {{ $transaction->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                <option value="menunggu_petugas" {{ $transaction->status == 'menunggu_petugas' ? 'selected' : '' }}>Menunggu Petugas</option>
                                                <option value="dalam_perjalanan" {{ $transaction->status == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                                <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                                <option value="dibatalkan" {{ $transaction->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                            </select>
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
                                                      rows="4"
                                                      placeholder="Tambahkan catatan untuk transaksi ini...">{{ old('catatan_admin', $transaction->catatan_admin) }}</textarea>
                                            <small class="text-muted">Catatan ini hanya visible untuk admin</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Payment Tab -->
                            <div class="tab-pane fade" id="payment" role="tabpanel">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Informasi:</strong> Ubah metode pembayaran dan lokasi COD jika diperlukan.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="payment_method_id">Metode Pembayaran</label>
                                            <select name="payment_method_id" id="payment_method_id" class="form-control select2">
                                                <option value="">-- Pilih Metode --</option>
                                                @foreach($paymentMethods as $method)
                                                    <option value="{{ $method->id }}" 
                                                            {{ $transaction->payment_method_id == $method->id ? 'selected' : '' }}
                                                            data-category="{{ $method->kategori }}">
                                                        {{ $method->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="lokasi_cod_id">Lokasi COD</label>
                                            <select name="lokasi_cod_id" id="lokasi_cod_id" class="form-control select2">
                                                <option value="">-- Pilih Lokasi --</option>
                                                @foreach($lokasiCodList as $lokasi)
                                                    <option value="{{ $lokasi->id }}" 
                                                            {{ $transaction->lokasi_cod_id == $lokasi->id ? 'selected' : '' }}>
                                                        {{ $lokasi->nama }} - {{ $lokasi->alamat }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="waktu_diserahkan">Waktu Diserahkan</label>
                                            <input type="datetime-local" 
                                                   name="waktu_diserahkan" 
                                                   id="waktu_diserahkan"
                                                   class="form-control"
                                                   value="{{ old('waktu_diserahkan', $transaction->waktu_diserahkan ? $transaction->waktu_diserahkan->format('Y-m-d\TH:i') : '') }}">
                                            <small class="text-muted">Isi jika transaksi sudah selesai</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Petugas Tab -->
                            <div class="tab-pane fade" id="petugas" role="tabpanel">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Informasi:</strong> Assign atau ubah petugas untuk transaksi ini.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="petugas_id">Petugas</label>
                                            <select name="petugas_id" id="petugas_id" class="form-control select2">
                                                <option value="">-- Pilih Petugas --</option>
                                                @foreach($petugasList as $petugas)
                                                    <option value="{{ $petugas->id }}" 
                                                            {{ $transaction->petugas_id == $petugas->id ? 'selected' : '' }}>
                                                        {{ $petugas->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Petugas</label>
                                            <div class="alert 
                                                @if($transaction->petugas) alert-success @else alert-warning @endif 
                                                mb-0">
                                                <i class="fas 
                                                    @if($transaction->petugas) fa-check-circle @else fa-clock @endif 
                                                    mr-2"></i>
                                                @if($transaction->petugas)
                                                    Petugas: <strong>{{ $transaction->petugas->name }}</strong> sudah ditugaskan
                                                @else
                                                    Belum ada petugas yang ditugaskan
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                @if($transaction->petugas)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header bg-light">
                                                <h5 class="card-title mb-0">
                                                    <i class="fas fa-user-circle mr-2"></i>
                                                    Informasi Petugas
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->petugas->name) }}&background=4a90e2&color=fff&size=100" 
                                                             class="img-fluid rounded-circle">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <table class="table table-borderless">
                                                            <tr>
                                                                <th width="30%">Nama</th>
                                                                <td>{{ $transaction->petugas->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Email</th>
                                                                <td>{{ $transaction->petugas->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>Telepon</th>
                                                                <td>{{ $transaction->petugas->phone ?? '-' }}</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Evidence Tab -->
                            <div class="tab-pane fade" id="evidence" role="tabpanel">
                                <div class="info-box">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Informasi:</strong> Upload atau ganti bukti pembayaran dan serah terima.
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bukti Bayar Customer</label>
                                            @if($transaction->bukti_bayar_customer)
                                            <div class="mb-3">
                                                <img src="{{ $transaction->getBuktiBayarUrlAttribute() }}" 
                                                     class="evidence-preview">
                                                <p class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Diupload saat pembuatan transaksi
                                                    </small>
                                                </p>
                                            </div>
                                            @endif
                                            
                                            <div class="custom-file">
                                                <input type="file" 
                                                       class="custom-file-input" 
                                                       id="bukti_bayar_customer" 
                                                       name="bukti_bayar_customer"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="bukti_bayar_customer">
                                                    {{ $transaction->bukti_bayar_customer ? 'Ganti file...' : 'Pilih file...' }}
                                                </label>
                                            </div>
                                            <small class="text-muted">Format: JPG, JPEG, PNG | Maks: 2MB</small>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Bukti Serah Terima Petugas</label>
                                            @if($transaction->bukti_serah_terima_petugas)
                                            <div class="mb-3">
                                                <img src="{{ $transaction->getBuktiSerahTerimaUrlAttribute() }}" 
                                                     class="evidence-preview">
                                                <p class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Diupload: {{ $transaction->waktu_diserahkan ? $transaction->waktu_diserahkan->format('d F Y H:i') : '-' }}
                                                    </small>
                                                </p>
                                            </div>
                                            @endif
                                            
                                            <div class="custom-file">
                                                <input type="file" 
                                                       class="custom-file-input" 
                                                       id="bukti_serah_terima_petugas" 
                                                       name="bukti_serah_terima_petugas"
                                                       accept="image/*">
                                                <label class="custom-file-label" for="bukti_serah_terima_petugas">
                                                    {{ $transaction->bukti_serah_terima_petugas ? 'Ganti file...' : 'Pilih file...' }}
                                                </label>
                                            </div>
                                            <small class="text-muted">Format: JPG, JPEG, PNG | Maks: 2MB</small>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <div class="alert alert-info">
                                            <i class="fas fa-exclamation-circle mr-2"></i>
                                            <strong>Perhatian:</strong> Upload bukti serah terima hanya jika transaksi sudah selesai.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer text-right">
                    <a href="{{ route('admin.tariktunai.show', $transaction->id) }}" class="btn btn-secondary mr-2">
                        <i class="fas fa-times mr-2"></i> Batal
                    </a>
                    <button type="submit" form="editForm" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
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
    
    // Show/hide COD location based on payment method category
    function toggleCodLocation() {
        const selectedOption = $('#payment_method_id option:selected');
        const category = selectedOption.data('category');
        
        if (category === 'qris_cod') {
            $('#lokasi_cod_id').closest('.form-group').show();
        } else {
            $('#lokasi_cod_id').closest('.form-group').hide();
        }
    }
    
    // Initial check
    toggleCodLocation();
    
    // On payment method change
    $('#payment_method_id').change(toggleCodLocation);
    
    // Status change confirmation
    $('#status').change(function() {
        const newStatus = $(this).val();
        const currentStatus = '{{ $transaction->status }}';
        
        if (newStatus === 'dibatalkan') {
            if (!confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
                $(this).val(currentStatus);
                return false;
            }
        }
    });
    
    // Tab switching with form validation
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        // You can add validation here if needed
    });
});
</script>
@endsection
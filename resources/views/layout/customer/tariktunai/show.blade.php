@extends('layout.customer.customer')

@section('title', 'Detail Tarik Tunai - ' . $tarikTunai->kode_transaksi)

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title d-flex align-items-center">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Detail Transaksi
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('customer.tariktunai.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Detail Transaksi -->
        <div class="col-lg-8">
            <!-- Card Detail Transaksi -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Transaksi
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Informasi Dasar -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Transaksi</th>
                                    <td width="60%">
                                        <span class="badge badge-primary">{{ $tarikTunai->kode_transaksi }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Pengajuan</th>
                                    <td>{{ $tarikTunai->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $statusColors = [
                                                'menunggu_admin' => 'warning',
                                                'menunggu_pembayaran' => 'info',
                                                'diproses' => 'primary',
                                                'selesai' => 'success',
                                                'dibatalkan_customer' => 'danger',
                                                'dibatalkan_admin' => 'danger'
                                            ];
                                            
                                            $statusTexts = [
                                                'menunggu_admin' => 'Menunggu Admin',
                                                'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                                'diproses' => 'Sedang Diproses',
                                                'selesai' => 'Selesai',
                                                'dibatalkan_customer' => 'Dibatalkan (Customer)',
                                                'dibatalkan_admin' => 'Dibatalkan (Admin)'
                                            ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$tarikTunai->status] ?? 'secondary' }}">
                                            {{ $statusTexts[$tarikTunai->status] ?? $tarikTunai->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah Tarik</th>
                                    <td>
                                        <h5 class="text-primary mb-0">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                                @if($tarikTunai->biaya_admin > 0)
                                <tr>
                                    <th>Biaya Admin</th>
                                    <td>
                                        <h5 class="text-warning mb-0">Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                                @endif
                                @if($tarikTunai->total_dibayar > 0)
                                <tr>
                                    <th>Total Dibayar</th>
                                    <td>
                                        <h5 class="text-success mb-0">Rp {{ number_format($tarikTunai->total_dibayar, 0, ',', '.') }}</h5>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                        
                        <!-- Informasi Metode Pembayaran -->
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Metode Pembayaran</th>
                                    <td width="60%">
                                        @if($tarikTunai->paymentMethod)
                                            <strong>{{ $tarikTunai->paymentMethod->nama }}</strong>
                                            @if($tarikTunai->paymentMethod->account_number)
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <i class="fas fa-credit-card"></i>
                                                        {{ $tarikTunai->paymentMethod->account_number }}
                                                    </small>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Lokasi Penyerahan</th>
                                    <td>
                                        @if($tarikTunai->lokasiCod)
                                            <strong>{{ $tarikTunai->lokasiCod->nama_lokasi }}</strong>
                                            @if($tarikTunai->lokasiCod->area_detail)
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{ $tarikTunai->lokasiCod->area_detail }}
                                                    </small>
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($tarikTunai->petugas)
                                <tr>
                                    <th>Petugas</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($tarikTunai->petugas->foto)
                                                <img src="{{ asset('storage/' . $tarikTunai->petugas->foto) }}" 
                                                     alt="{{ $tarikTunai->petugas->nama }}" 
                                                     class="img-circle img-sm mr-2"
                                                     style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                                <div class="img-circle img-sm mr-2 bg-secondary d-flex align-items-center justify-content-center"
                                                     style="width: 30px; height: 30px;">
                                                    <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                                </div>
                                            @endif
                                            <span>{{ $tarikTunai->petugas->nama }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                @if($tarikTunai->waktu_dibatalkan)
                                <tr>
                                    <th>Dibatalkan Pada</th>
                                    <td class="text-danger">
                                        {{ $tarikTunai->waktu_dibatalkan->format('d/m/Y H:i') }}
                                        @if($tarikTunai->catatan_cancel)
                                            <br><small>{{ $tarikTunai->catatan_cancel }}</small>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <!-- QRIS Button -->
                                @if($tarikTunai->paymentMethod && $tarikTunai->paymentMethod->qris_image)
                                    <button type="button" 
                                            class="btn btn-outline-primary btn-qris-show"
                                            data-id="{{ $tarikTunai->paymentMethod->id }}">
                                        <i class="fas fa-qrcode mr-1"></i> Lihat QRIS
                                    </button>
                                @endif
                                
                                <!-- Location Button -->
                                @if($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->gambar)
                                    <button type="button" 
                                            class="btn btn-outline-success btn-location-show ml-2"
                                            data-id="{{ $tarikTunai->lokasiCod->id }}">
                                        <i class="fas fa-map-marker-alt mr-1"></i> Lihat Lokasi
                                    </button>
                                @endif
                                
                                <!-- Tombol Upload Bukti -->
@if($tarikTunai->biaya_admin > 0 && $tarikTunai->status == 'menunggu_pembayaran')
    <button type="button" 
            class="btn btn-success ml-2"
            data-bs-toggle="modal" 
            data-bs-target="#uploadModal">
        <i class="fas fa-upload mr-1"></i> Upload Bukti
    </button>
@endif

<!-- Tombol Cancel -->
@if(in_array($tarikTunai->status, ['menunggu_admin', 'menunggu_pembayaran']))
    <button type="button" 
            class="btn btn-danger ml-2"
            data-bs-toggle="modal" 
            data-bs-target="#cancelModal"
            data-id="{{ $tarikTunai->id }}"
            data-code="{{ $tarikTunai->kode_transaksi }}">
        <i class="fas fa-times mr-1"></i> Batalkan
    </button>
@endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Timeline -->
            <div class="card card-outline card-info mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-history mr-2"></i>
                        Timeline Transaksi
                    </h4>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Step 1: Pengajuan -->
                        <div class="timeline-item {{ $tarikTunai->created_at ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pengajuan Berhasil</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->created_at)
                                        {{ $tarikTunai->created_at->format('d/m/Y H:i') }}
                                    @else
                                        Menunggu...
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 2: Biaya Admin -->
                        <div class="timeline-item {{ $tarikTunai->biaya_admin > 0 ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Penentuan Biaya Admin</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->biaya_admin > 0)
                                        Biaya admin: Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}
                                    @else
                                        Menunggu konfirmasi admin...
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 3: Pembayaran -->
                        <div class="timeline-item {{ $tarikTunai->bukti_bayar_customer ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-credit-card"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Pembayaran</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->bukti_bayar_customer)
                                        <span class="text-success">Bukti pembayaran telah diupload</span>
                                    @else
                                        Menunggu pembayaran...
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 4: Penugasan -->
                        <div class="timeline-item {{ $tarikTunai->petugas_id ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Penugasan Petugas</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->petugas)
                                        Petugas: {{ $tarikTunai->petugas->nama }}
                                    @else
                                        Menunggu penugasan...
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Step 5: Selesai -->
                        <div class="timeline-item {{ $tarikTunai->status == 'selesai' ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Penyerahan Selesai</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->status == 'selesai')
                                        <span class="text-success">Transaksi selesai</span>
                                    @else
                                        Menunggu penyerahan...
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: QRIS dan Lokasi -->
        <div class="col-lg-4">
            <!-- QRIS Card -->
            @if($tarikTunai->paymentMethod && $tarikTunai->paymentMethod->qris_image)
            <div class="card card-outline card-primary mb-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-qrcode mr-2"></i>
                        QRIS Pembayaran
                    </h4>
                </div>
                <div class="card-body text-center">
                    <div class="spinner-border text-primary my-5 qris-spinner" id="qrisSpinnerShow" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <img id="qrisImageShow" class="img-fluid d-none" alt="QRIS" style="max-height: 200px;">
                    <div id="qrisErrorShow" class="alert alert-danger d-none"></div>
                    
                    <div id="qrisInfoShow" class="mt-3 d-none">
                        <h6 class="font-weight-bold text-primary">{{ $tarikTunai->paymentMethod->nama }}</h6>
                        @if($tarikTunai->paymentMethod->account_number)
                        <div class="alert alert-light border small mt-2">
                            <p class="mb-1">
                                <strong><i class="fas fa-credit-card mr-2"></i>Nomor:</strong> 
                                {{ $tarikTunai->paymentMethod->account_number }}
                            </p>
                            @if($tarikTunai->paymentMethod->account_name)
                            <p class="mb-0">
                                <strong><i class="fas fa-user mr-2"></i>Nama:</strong> 
                                {{ $tarikTunai->paymentMethod->account_name }}
                            </p>
                            @endif
                        </div>
                        @endif
                    </div>
                    
                    <button type="button" 
                            class="btn btn-outline-primary btn-sm mt-3"
                            onclick="downloadQrisShow()"
                            id="btnDownloadQrisShow"
                            disabled>
                        <i class="fas fa-download mr-1"></i> Download QRIS
                    </button>
                </div>
            </div>
            @endif

            <!-- Lokasi Card -->
            @if($tarikTunai->lokasiCod)
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Lokasi Penyerahan
                    </h4>
                </div>
                <div class="card-body">
                    <h5 class="text-success">{{ $tarikTunai->lokasiCod->nama_lokasi }}</h5>
                    
                    @if($tarikTunai->lokasiCod->alamat)
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                        {{ $tarikTunai->lokasiCod->alamat }}
                    </p>
                    @endif
                    
                    @if($tarikTunai->lokasiCod->area_detail)
                    <p class="mb-2">
                        <i class="fas fa-info-circle text-info mr-2"></i>
                        {{ $tarikTunai->lokasiCod->area_detail }}
                    </p>
                    @endif
                    
                    @if($tarikTunai->lokasiCod->jam_operasional)
                    <p class="mb-2">
                        <i class="fas fa-clock text-warning mr-2"></i>
                        {{ $tarikTunai->lokasiCod->jam_operasional }}
                    </p>
                    @endif
                    
                    @if($tarikTunai->lokasiCod->telepon)
                    <p class="mb-3">
                        <i class="fas fa-phone text-primary mr-2"></i>
                        {{ $tarikTunai->lokasiCod->telepon }}
                    </p>
                    @endif
                    
                    <!-- Gambar Lokasi -->
                    @if($tarikTunai->lokasiCod->gambar)
                    <div class="text-center">
                        <div class="spinner-border text-primary my-5 location-spinner" id="locationSpinnerShow" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                        <img id="locationImageShow" class="img-fluid rounded d-none" alt="Lokasi" style="max-height: 150px;">
                        <div id="locationErrorShow" class="alert alert-danger d-none"></div>
                    </div>
                    
                    @if($tarikTunai->lokasiCod->latitude && $tarikTunai->lokasiCod->longitude)
                    <button type="button" 
                            class="btn btn-outline-success btn-sm mt-2 w-100"
                            onclick="openMapsShow()"
                            id="btnOpenMapsShow">
                        <i class="fas fa-map mr-1"></i> Buka di Google Maps
                    </button>
                    @endif
                    @endif
                </div>
            </div>
            @endif

            <!-- Bukti Pembayaran Card -->
            @if($tarikTunai->bukti_bayar_customer)
            <div class="card card-outline card-warning mt-4">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-receipt mr-2"></i>
                        Bukti Pembayaran
                    </h4>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $tarikTunai->bukti_bayar_customer) }}" 
                         class="img-fluid rounded" 
                         alt="Bukti Pembayaran"
                         style="max-height: 150px;">
                    <p class="text-muted mt-2 mb-0">
                        Diupload pada: {{ $tarikTunai->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal QRIS (full size) -->
<div class="modal fade" id="qrisModalShow" tabindex="-1" role="dialog" aria-labelledby="qrisModalShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="qrisModalShowLabel">
                    <i class="fas fa-qrcode mr-2"></i>QRIS Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary my-5" id="qrisSpinnerModal" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <img id="qrisImageModal" class="img-fluid d-none" alt="QRIS" style="max-width: 100%;">
                <div id="qrisErrorModal" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="downloadQrisModal()" id="btnDownloadQrisModal" disabled>
                    <i class="fas fa-download mr-1"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lokasi (full size) -->
<div class="modal fade" id="locationModalShow" tabindex="-1" role="dialog" aria-labelledby="locationModalShowLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="locationModalShowLabel">
                    <i class="fas fa-map-marker-alt mr-2"></i>Detail Lokasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="spinner-border text-primary my-5" id="locationSpinnerModal" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <img id="locationImageModal" class="img-fluid rounded d-none w-100" alt="Lokasi">
                <div id="locationErrorModal" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                @if($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->latitude && $tarikTunai->lokasiCod->longitude)
                <button type="button" class="btn btn-success" onclick="openMapsModal()">
                    <i class="fas fa-map mr-1"></i> Buka di Maps
                </button>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Bukti -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('customer.tariktunai.upload-bukti', $tarikTunai) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="uploadModalLabel">
                        <i class="fas fa-upload mr-2"></i>Upload Bukti Pembayaran
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <h6><i class="fas fa-file-invoice-dollar mr-2"></i>Ringkasan Pembayaran</h6>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Jumlah Tarik:</td>
                                <td class="text-right">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Biaya Admin:</td>
                                <td class="text-right text-warning">Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="table-success">
                                <td><strong>Total Dibayar:</strong></td>
                                <td class="text-right"><strong>Rp {{ number_format($tarikTunai->total_dibayar, 0, ',', '.') }}</strong></td>
                            </tr>
                        </table>
                    </div>
                    
                    <div class="form-group">
                        <label for="bukti_bayar_customer">Bukti Pembayaran *</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="bukti_bayar_customer" 
                                   name="bukti_bayar_customer" accept="image/*" required>
                            <label class="custom-file-label" for="bukti_bayar_customer">Pilih file gambar</label>
                        </div>
                        <small class="form-text text-muted">Format: JPG, PNG (Maks. 2MB)</small>
                    </div>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Pastikan Anda membayar sesuai dengan total yang tertera di atas.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-upload mr-1"></i> Upload Bukti
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Cancel -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="cancelForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">
                        <i class="fas fa-exclamation-triangle text-danger mr-2"></i>Konfirmasi Pembatalan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin membatalkan transaksi <strong id="cancelCodeModal"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle"></i>
                        <strong>Perhatian:</strong> Tindakan ini tidak dapat dibatalkan!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times mr-1"></i> Ya, Batalkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .timeline {
        position: relative;
        padding-left: 40px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }
    
    .timeline-item.active .timeline-icon {
        background-color: #007bff;
        color: white;
    }
    
    .timeline-icon {
        position: absolute;
        left: -40px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #e9ecef;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .timeline-content {
        padding-left: 20px;
    }
    
    .timeline-content h6 {
        margin-bottom: 5px;
        font-weight: 600;
    }
    
    .card-outline {
        border-top: 4px solid;
        border-radius: 10px;
    }
    
    .card-outline.card-primary {
        border-top-color: #007bff;
    }
    
    .card-outline.card-info {
        border-top-color: #17a2b8;
    }
    
    .card-outline.card-success {
        border-top-color: #28a745;
    }
    
    .card-outline.card-warning {
        border-top-color: #ffc107;
    }
    
    .table-borderless th {
        font-weight: 600;
        color: #495057;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    .img-circle {
        border-radius: 50%;
    }
    
    .img-sm {
        width: 30px;
        height: 30px;
    }
    /* Timeline Styles */
.timeline {
    position: relative;
    padding-left: 40px;
}

.timeline:before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e9ecef;
}

.timeline-item {
    position: relative;
    margin-bottom: 30px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-item.active .timeline-icon {
    background-color: #007bff;
    color: white;
}

.timeline-icon {
    position: absolute;
    left: -40px;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background-color: #e9ecef;
    color: #6c757d;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1;
}

.timeline-content {
    padding-left: 20px;
}

.timeline-content h6 {
    margin-bottom: 5px;
    font-weight: 600;
    color: #343a40;
}

/* Card Outline Styles */
.card-outline {
    border-top: 4px solid;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.05);
}

.card-outline.card-primary {
    border-top-color: #007bff;
}

.card-outline.card-success {
    border-top-color: #28a745;
}

.card-outline.card-info {
    border-top-color: #17a2b8;
}

.card-outline.card-warning {
    border-top-color: #ffc107;
}

/* Table Styles */
.table-borderless th {
    font-weight: 600;
    color: #495057;
    padding: 8px 0;
    vertical-align: top;
}

.table-borderless td {
    padding: 8px 0;
    vertical-align: top;
}
</style>

<script>
    let currentQrisUrlShow = null;
    let currentLocationDataShow = @json($tarikTunai->lokasiCod ? $tarikTunai->lokasiCod->only(['latitude', 'longitude']) : null);

    document.addEventListener('DOMContentLoaded', function() {
        // Load QRIS image on page load
        @if($tarikTunai->paymentMethod && $tarikTunai->paymentMethod->qris_image)
            loadQrisImageShow({{ $tarikTunai->paymentMethod->id }});
        @endif
        
        // Load Location image on page load
        @if($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->gambar)
            loadLocationImageShow({{ $tarikTunai->lokasiCod->id }});
        @endif
        
        // Tombol QRIS modal
        $('.btn-qris-show').click(function() {
            const paymentMethodId = $(this).data('id');
            loadQrisImageModal(paymentMethodId);
            $('#qrisModalShow').modal('show');
        });
        
        // Tombol Lokasi modal
        $('.btn-location-show').click(function() {
            const locationId = $(this).data('id');
            loadLocationImageModal(locationId);
            $('#locationModalShow').modal('show');
        });
        
        // Modal Cancel
        $('#cancelModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var code = button.data('code');
            var modal = $(this);
            modal.find('#cancelCodeModal').text(code);
            modal.find('#cancelForm').attr('action', '/customer/tarik-tunai/' + id + '/cancel');
        });
        
        // File input label
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });
    });
    
    function loadQrisImageShow(paymentMethodId) {
        console.log('Loading QRIS for show page:', paymentMethodId);
        
        $.ajax({
            url: '{{ route("customer.tariktunai.get-qris", ":id") }}'.replace(':id', paymentMethodId),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('QRIS Response:', response);
                $('#qrisSpinnerShow').addClass('d-none');
                
                if (response.error) {
                    $('#qrisErrorShow').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.error}
                    `).removeClass('d-none');
                    return;
                }
                
                if (response.success && response.qris_image) {
                    currentQrisUrlShow = response.qris_image;
                    
                    const img = new Image();
                    img.onload = function() {
                        $('#qrisImageShow')
                            .attr('src', response.qris_image)
                            .attr('alt', 'QRIS ' + (response.nama || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');
                        
                        $('#qrisInfoShow').removeClass('d-none');
                        $('#btnDownloadQrisShow').prop('disabled', false);
                    };
                    
                    img.onerror = function() {
                        $('#qrisErrorShow').html(`
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gambar QRIS gagal dimuat
                        `).removeClass('d-none');
                    };
                    
                    img.src = response.qris_image;
                } else {
                    $('#qrisErrorShow').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Tidak ada QRIS yang tersedia
                    `).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#qrisSpinnerShow').addClass('d-none');
                $('#qrisErrorShow').html(`
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat QRIS
                `).removeClass('d-none');
            }
        });
    }
    
    function loadLocationImageShow(locationId) {
        console.log('Loading Location for show page:', locationId);
        
        $.ajax({
            url: '{{ route("customer.tariktunai.get-location", ":id") }}'.replace(':id', locationId),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Location Response:', response);
                $('#locationSpinnerShow').addClass('d-none');
                
                if (response.error) {
                    $('#locationErrorShow').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.error}
                    `).removeClass('d-none');
                    return;
                }
                
                if (response.success && response.gambar) {
                    const img = new Image();
                    img.onload = function() {
                        $('#locationImageShow')
                            .attr('src', response.gambar)
                            .attr('alt', 'Lokasi ' + (response.nama_lokasi || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');
                    };
                    
                    img.onerror = function() {
                        $('#locationErrorShow').html(`
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gambar lokasi gagal dimuat
                        `).removeClass('d-none');
                    };
                    
                    img.src = response.gambar;
                } else {
                    $('#locationErrorShow').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Tidak ada gambar lokasi yang tersedia
                    `).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#locationSpinnerShow').addClass('d-none');
                $('#locationErrorShow').html(`
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat gambar lokasi
                `).removeClass('d-none');
            }
        });
    }
    
    function loadQrisImageModal(paymentMethodId) {
        console.log('Loading QRIS for modal:', paymentMethodId);
        
        // Reset modal
        $('#qrisSpinnerModal').removeClass('d-none');
        $('#qrisImageModal').addClass('d-none');
        $('#qrisErrorModal').addClass('d-none');
        $('#btnDownloadQrisModal').prop('disabled', true);
        
        $.ajax({
            url: '{{ route("customer.tariktunai.get-qris", ":id") }}'.replace(':id', paymentMethodId),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('QRIS Response:', response);
                $('#qrisSpinnerModal').addClass('d-none');
                
                if (response.error) {
                    $('#qrisErrorModal').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.error}
                    `).removeClass('d-none');
                    return;
                }
                
                if (response.success && response.qris_image) {
                    const img = new Image();
                    img.onload = function() {
                        $('#qrisImageModal')
                            .attr('src', response.qris_image)
                            .attr('alt', 'QRIS ' + (response.nama || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');
                        
                        $('#qrisModalShowLabel').html(`<i class="fas fa-qrcode mr-2"></i>QRIS - ${response.nama || 'Pembayaran'}`);
                        $('#btnDownloadQrisModal').prop('disabled', false);
                    };
                    
                    img.onerror = function() {
                        $('#qrisErrorModal').html(`
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gambar QRIS gagal dimuat
                        `).removeClass('d-none');
                    };
                    
                    img.src = response.qris_image;
                } else {
                    $('#qrisErrorModal').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Tidak ada QRIS yang tersedia
                    `).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#qrisSpinnerModal').addClass('d-none');
                $('#qrisErrorModal').html(`
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat QRIS
                `).removeClass('d-none');
            }
        });
    }
    
    function loadLocationImageModal(locationId) {
        console.log('Loading Location for modal:', locationId);
        
        // Reset modal
        $('#locationSpinnerModal').removeClass('d-none');
        $('#locationImageModal').addClass('d-none');
        $('#locationErrorModal').addClass('d-none');
        
        $.ajax({
            url: '{{ route("customer.tariktunai.get-location", ":id") }}'.replace(':id', locationId),
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                console.log('Location Response:', response);
                $('#locationSpinnerModal').addClass('d-none');
                
                if (response.error) {
                    $('#locationErrorModal').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        ${response.error}
                    `).removeClass('d-none');
                    return;
                }
                
                if (response.success && response.gambar) {
                    const img = new Image();
                    img.onload = function() {
                        $('#locationImageModal')
                            .attr('src', response.gambar)
                            .attr('alt', 'Lokasi ' + (response.nama_lokasi || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');
                        
                        $('#locationModalShowLabel').html(`<i class="fas fa-map-marker-alt mr-2"></i>${response.nama_lokasi || 'Lokasi Penyerahan'}`);
                    };
                    
                    img.onerror = function() {
                        $('#locationErrorModal').html(`
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            Gambar lokasi gagal dimuat
                        `).removeClass('d-none');
                    };
                    
                    img.src = response.gambar;
                } else {
                    $('#locationErrorModal').html(`
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Tidak ada gambar lokasi yang tersedia
                    `).removeClass('d-none');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#locationSpinnerModal').addClass('d-none');
                $('#locationErrorModal').html(`
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Gagal memuat gambar lokasi
                `).removeClass('d-none');
            }
        });
    }
    
    function downloadQrisShow() {
        if (currentQrisUrlShow) {
            const link = document.createElement('a');
            link.href = currentQrisUrlShow;
            link.download = 'qris-pembayaran-{{ $tarikTunai->kode_transaksi }}.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            Swal.fire({
                icon: 'success',
                title: 'QRIS Berhasil Didownload',
                text: 'File QRIS telah berhasil didownload.',
                confirmButtonColor: '#007bff',
                timer: 2000
            });
        }
    }
    
    function downloadQrisModal() {
        const qrisImage = $('#qrisImageModal').attr('src');
        if (qrisImage) {
            const link = document.createElement('a');
            link.href = qrisImage;
            link.download = 'qris-pembayaran-{{ $tarikTunai->kode_transaksi }}-modal.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            
            Swal.fire({
                icon: 'success',
                title: 'QRIS Berhasil Didownload',
                text: 'File QRIS telah berhasil didownload.',
                confirmButtonColor: '#007bff',
                timer: 2000
            });
        }
    }
    
    function openMapsShow() {
        if (currentLocationDataShow && currentLocationDataShow.latitude && currentLocationDataShow.longitude) {
            const lat = currentLocationDataShow.latitude;
            const lng = currentLocationDataShow.longitude;
            const url = `https://www.google.com/maps?q=${lat},${lng}`;
            window.open(url, '_blank');
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Koordinat Tidak Tersedia',
                text: 'Koordinat lokasi tidak tersedia untuk membuka di Google Maps.',
                confirmButtonColor: '#007bff'
            });
        }
    }
    
    function openMapsModal() {
        @if($tarikTunai->lokasiCod && $tarikTunai->lokasiCod->latitude && $tarikTunai->lokasiCod->longitude)
            const lat = {{ $tarikTunai->lokasiCod->latitude }};
            const lng = {{ $tarikTunai->lokasiCod->longitude }};
            const url = `https://www.google.com/maps?q=${lat},${lng}`;
            window.open(url, '_blank');
        @endif
    }
</script>

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#007bff',
            timer: 3000
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#007bff'
        });
    });
</script>
@endif
@endsection
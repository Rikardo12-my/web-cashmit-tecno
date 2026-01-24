@extends('layout.admin.master')

@section('title', 'Detail Tarik Tunai')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">
                        <i class="fas fa-receipt mr-2"></i>📄 Detail Tarik Tunai
                    </h1>
                    @if($tarikTunai->isQRISCOD())
                        <span class="badge badge-orange mt-2">
                            <i class="fas fa-qrcode mr-1"></i> QRIS COD
                        </span>
                    @endif
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="fas fa-home"></i> Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.index') }}"><i class="fas fa-money-bill-wave"></i> Tarik Tunai</a></li>
                        <li class="breadcrumb-item active"><i class="fas fa-eye"></i> Detail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <!-- Transaction Info Card -->
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2"></i>
                                Informasi Transaksi
                            </h3>
                            <div class="card-tools">
                                <span class="badge badge-primary">
                                    {{ $tarikTunai->kode_transaksi }}
                                </span>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-4">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-user mr-2"></i>Customer
                                        </label>
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="avatar-placeholder rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px; background: linear-gradient(45deg, #667eea, #764ba2);">
                                                <i class="fas fa-user text-white fa-lg"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">{{ $tarikTunai->user->nama ?? 'N/A' }}</h5>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope mr-1"></i>{{ $tarikTunai->user->email ?? '-' }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-phone mr-1"></i>{{ $tarikTunai->user->telepon ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-4">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-user-tie mr-2"></i>Petugas
                                        </label>
                                        @if($tarikTunai->petugas)
                                        <div class="d-flex align-items-center mt-2">
                                            <div class="avatar-placeholder rounded-circle mr-3 d-flex align-items-center justify-content-center"
                                                 style="width: 50px; height: 50px; background: linear-gradient(45deg, #43e97b, #38f9d7);">
                                                <i class="fas fa-user-tie text-white fa-lg"></i>
                                            </div>
                                            <div>
                                                <h5 class="mb-0">{{ $tarikTunai->petugas->nama }}</h5>
                                                <small class="text-muted">
                                                    <i class="fas fa-check-circle mr-1 text-success"></i>Ditugaskan
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar-alt mr-1"></i>
                                                    {{ $tarikTunai->waktu_diproses->timezone('Asia/Jakarta')->format('d/m/Y H:i') ?? '-' }}
                                                </small>
                                            </div>
                                        </div>
                                        @else
                                        <div class="alert alert-warning mt-2">
                                            <i class="fas fa-user-clock mr-2"></i>Belum ada petugas yang ditugaskan
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="info-item mb-4">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-money-bill-wave mr-2"></i>Detail Pembayaran
                                        </label>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Jumlah Tarik Tunai:</span>
                                                <strong class="text-primary">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mb-2">
                                                <span>Biaya Admin:</span>
                                                <strong class="text-warning">Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}</strong>
                                            </div>
                                            <hr>
                                            <div class="d-flex justify-content-between">
                                                <span><strong>Total Dibayar:</strong></span>
                                                <strong class="text-success" style="font-size: 1.2rem;">
                                                    Rp {{ number_format($tarikTunai->total_dibayar, 0, ',', '.') }}
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="info-item mb-4">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-map-marker-alt mr-2"></i>Lokasi & Metode
                                        </label>
                                        <div class="mt-2">
                                            @if($tarikTunai->lokasiCod)
                                            <div class="mb-2">
                                                <small class="text-muted d-block">Lokasi COD:</small>
                                                <strong>{{ $tarikTunai->lokasiCod->nama_lokasi }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $tarikTunai->lokasiCod->alamat }}</small>
                                            </div>
                                            @endif
                                            @if($tarikTunai->paymentMethod)
                                            <div>
                                                <small class="text-muted d-block">Metode Pembayaran:</small>
                                                <strong>
                                                    {{ $tarikTunai->paymentMethod->nama }}
                                                    @if($tarikTunai->isQRISCOD())
                                                        <span class="badge badge-orange ml-2">QRIS COD</span>
                                                    @endif
                                                </strong>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Timeline Horizontal -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-history mr-2"></i>Proses Transaksi
        </h3>
    </div>
    <div class="card-body">
        @php
            $timelineSteps = $tarikTunai->timelineSteps;
            $currentStep = $tarikTunai->currentStep;
            $totalSteps = count($timelineSteps);
        @endphp
        
        @if($totalSteps > 0)
        <!-- Progress Bar -->
        <div class="progress mb-4" style="height: 8px;">
            <div class="progress-bar bg-success" 
                 role="progressbar" 
                 style="width: {{ ($currentStep / $totalSteps) * 100 }}%"
                 aria-valuenow="{{ $currentStep }}" 
                 aria-valuemin="0" 
                 aria-valuemax="{{ $totalSteps }}">
            </div>
        </div>

        <!-- Timeline Steps -->
        <div class="row text-center">
            @foreach($timelineSteps as $label => $time)
            <div class="col position-relative">
                <!-- Connector Line -->
                @if(!$loop->first)
                <div class="timeline-connector" style="left: -50%;"></div>
                @endif
                
                <!-- Step Circle -->
                <div class="step-circle mx-auto mb-2 
                    {{ $loop->index < $currentStep ? 'bg-success text-white' : 
                       ($loop->index == $currentStep ? 'bg-primary text-white border-primary' : 
                       'bg-light text-muted border-secondary') }}">
                    @if($loop->index < $currentStep)
                    <i class="fas fa-check"></i>
                    @else
                    {{ $loop->iteration }}
                    @endif
                </div>
                
                <!-- Step Info -->
                <div class="step-info">
                    <small class="d-block fw-bold">{{ $label }}</small>
                    @if($time)
                    <small class="text-muted d-block">
                        {{ $time->timezone('Asia/Jakarta')->format('d/m H:i') }}
                    </small>
                    @else
                    <small class="text-muted d-block">-</small>
                    @endif
                    
                    @if($tarikTunai->is_qris_cod && $label == 'Verifikasi QRIS')
                    <span class="badge bg-orange mt-1">
                        <i class="fas fa-qrcode"></i>
                    </span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Current Status -->
        <div class="alert alert-info mt-4">
            <div class="d-flex align-items-center">
                <i class="fas fa-info-circle fa-lg me-3"></i>
                <div>
                    <strong>Status Saat Ini:</strong>
                    <span class="badge bg-{{ $statusColors[$tarikTunai->status] ?? 'secondary' }} ms-2">
                        {{ $tarikTunai->status_label ?? ucfirst(str_replace('_', ' ', $tarikTunai->status)) }}
                    </span>
                    <div class="mt-1">
                        <small>Step {{ $currentStep }} dari {{ $totalSteps }}</small>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center py-4">
            <i class="fas fa-history fa-3x text-muted mb-3"></i>
            <p class="text-muted">Belum ada timeline tersedia</p>
        </div>
        @endif
    </div>
</div>



                            <!-- Catatan -->
                            <div class="row">
                                @if($tarikTunai->catatan_admin)
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-user-shield mr-2"></i>Catatan Admin
                                        </label>
                                        <div class="alert alert-info mt-2">
                                            {{ $tarikTunai->catatan_admin }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if($tarikTunai->catatan_petugas)
                                <div class="col-md-6">
                                    <div class="info-item">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-user-tie mr-2"></i>Catatan Petugas
                                        </label>
                                        <div class="alert alert-warning mt-2">
                                            {{ $tarikTunai->catatan_petugas }}
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            
                            <!-- Bukti Serah Terima Petugas -->
                            @if($tarikTunai->bukti_serah_terima_petugas)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="info-item">
                                        <label class="text-muted d-block">
                                            <i class="fas fa-file-contract mr-2"></i>Bukti Serah Terima Petugas
                                        </label>
                                        <div class="text-center mt-2">
                                            <img src="{{ Storage::url($tarikTunai->bukti_serah_terima_petugas) }}" 
                                                 alt="Bukti Serah Terima" 
                                                 class="img-fluid rounded shadow-sm mb-2"
                                                 style="max-height: 200px;">
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt mr-1"></i>
                                                {{ $tarikTunai->waktu_upload_bukti_petugas->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                            </small>
                                            <br>
                                            <a href="{{ Storage::url($tarikTunai->bukti_serah_terima_petugas) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-expand mr-1"></i> Lihat Full Size
                                            </a>
                                        </div>
                                        @if($tarikTunai->catatan_serah_terima)
                                        <div class="alert alert-light mt-2">
                                            <i class="fas fa-sticky-note mr-2"></i>
                                            {{ $tarikTunai->catatan_serah_terima }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Status & Actions Card -->
                    <div class="card card-outline card-info mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tasks mr-2"></i>
                                Status & Aksi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <span class="badge badge-{{ $tarikTunai->statusColor }} badge-pill px-4 py-3" 
                                      style="font-size: 1.1rem;">
                                    <i class="fas fa-circle mr-2"></i>
                                    {{ $tarikTunai->statusLabel }}
                                </span>
                            </div>

                            @if($tarikTunai->status == 'menunggu_admin')
                            <form action="{{ route('admin.tariktunai.assign', $tarikTunai->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label>Assign Petugas:</label>
                                    <select name="petugas_id" class="form-control" required>
                                        <option value="">-- Pilih Petugas --</option>
                                        @foreach($petugasList as $petugas)
                                        <option value="{{ $petugas->id }}">{{ $petugas->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-user-tie mr-1"></i> Assign Petugas
                                </button>
                            </form>
                            @endif

                            <hr>

                            <!-- Form Update Status -->
                            <form action="{{ route('admin.tariktunai.update-status', $tarikTunai->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label>Update Status:</label>
                                    <select name="status" class="form-control">
                                        <option value="">-- Pilih Status --</option>
                                        
                                        @if($tarikTunai->isQRISCOD())
                                            <!-- Opsi khusus untuk QRIS COD -->
                                            <option value="pending" {{ $tarikTunai->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="menunggu_admin" {{ $tarikTunai->status == 'menunggu_admin' ? 'selected' : '' }}>Menunggu Admin</option>
                                            <option value="diproses" {{ $tarikTunai->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="dalam_perjalanan" {{ $tarikTunai->status == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                            <option value="menunggu_serah_terima" {{ $tarikTunai->status == 'menunggu_serah_terima' ? 'selected' : '' }}>Menunggu Serah Terima</option>
                                            <option value="menunggu_verifikasi_qris" {{ $tarikTunai->status == 'menunggu_verifikasi_qris' ? 'selected' : '' }}>Menunggu Verifikasi QRIS</option>
                                            <option value="selesai" {{ $tarikTunai->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        @else
                                            <!-- Opsi untuk metode pembayaran lain -->
                                            <option value="pending" {{ $tarikTunai->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="menunggu_admin" {{ $tarikTunai->status == 'menunggu_admin' ? 'selected' : '' }}>Menunggu Admin</option>
                                            <option value="menunggu_pembayaran" {{ $tarikTunai->status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                            <option value="menunggu_verifikasi_admin" {{ $tarikTunai->status == 'menunggu_verifikasi_admin' ? 'selected' : '' }}>Menunggu Verifikasi Admin</option>
                                            <option value="diproses" {{ $tarikTunai->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="dalam_perjalanan" {{ $tarikTunai->status == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                            <option value="menunggu_serah_terima" {{ $tarikTunai->status == 'menunggu_serah_terima' ? 'selected' : '' }}>Menunggu Serah Terima</option>
                                            <option value="selesai" {{ $tarikTunai->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        @endif
                                        
                                        <option value="dibatalkan_customer" {{ $tarikTunai->status == 'dibatalkan_customer' ? 'selected' : '' }}>Dibatalkan Customer</option>
                                        <option value="dibatalkan_admin" {{ $tarikTunai->status == 'dibatalkan_admin' ? 'selected' : '' }}>Dibatalkan Admin</option>
                                    </select>
                                </div>
                                
                                <!-- Field khusus untuk QRIS -->
                                @if($tarikTunai->isQRISCOD() && $tarikTunai->status == 'menunggu_verifikasi_qris')
                                <div class="form-group">
                                    <label>Bukti Pembayaran QRIS:</label>
                                    <input type="file" name="bukti_qris" class="form-control-file">
                                    <small class="text-muted">Upload bukti pembayaran QRIS dari customer</small>
                                </div>
                                @endif
                                
                                <div class="form-group">
                                    <label>Catatan Admin:</label>
                                    <textarea name="catatan_admin" class="form-control" rows="2" 
                                              placeholder="Tambahkan catatan...">{{ $tarikTunai->catatan_admin }}</textarea>
                                </div>
                                
                                <!-- Tombol khusus untuk verifikasi QRIS -->
                                @if($tarikTunai->isQRISCOD() && $tarikTunai->status == 'menunggu_verifikasi_qris')
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" name="action" value="verifikasi_qris" class="btn btn-success btn-block">
                                            <i class="fas fa-check-circle mr-1"></i> Verifikasi QRIS
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="submit" name="action" value="tolak_qris" class="btn btn-danger btn-block">
                                            <i class="fas fa-times-circle mr-1"></i> Tolak QRIS
                                        </button>
                                    </div>
                                </div>
                                @else
                                <button type="submit" class="btn btn-info btn-block">
                                    <i class="fas fa-sync-alt mr-1"></i> Update Status
                                </button>
                                @endif
                            </form>

                            <!-- Form untuk set biaya admin -->
                            @if(in_array($tarikTunai->status, ['pending', 'menunggu_admin']))
                            <form action="{{ route('admin.tariktunai.set-biaya', $tarikTunai->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="form-group">
                                    <label>Set Biaya Admin:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Rp</span>
                                        </div>
                                        <input type="number" name="biaya_admin" class="form-control" 
                                               value="{{ $tarikTunai->biaya_admin }}" 
                                               min="0" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Catatan:</label>
                                    <textarea name="catatan_admin" class="form-control" rows="2" 
                                              placeholder="Catatan untuk customer...">{{ $tarikTunai->catatan_admin }}</textarea>
                                </div>
                                <button type="submit" class="btn btn-warning btn-block">
                                    <i class="fas fa-money-bill-wave mr-1"></i> Set Biaya Admin
                                </button>
                            </form>
                            @endif

                            <hr>

                            <div class="d-grid gap-2">
                                
                                <form action="{{ route('admin.tariktunai.destroy', $tarikTunai->id) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Hapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fas fa-trash mr-1"></i> Hapus Transaksi
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Transfer Customer -->
                    @if($tarikTunai->bukti_bayar_customer && !$tarikTunai->isQRISCOD())
                    <div class="card card-outline card-success mb-4">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-invoice-dollar mr-2"></i>
                                Bukti Bayar Customer
                            </h3>
                        </div>
                        <div class="card-body text-center">
                            <img src="{{ Storage::url($tarikTunai->bukti_bayar_customer) }}" 
                                 alt="Bukti Bayar" 
                                 class="img-fluid rounded shadow-sm mb-2"
                                 style="max-height: 200px;">
                            <br>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt mr-1"></i>
                                {{ $tarikTunai->waktu_upload_bukti_customer->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            </small>
                            <br>
                            <a href="{{ Storage::url($tarikTunai->bukti_bayar_customer) }}" 
                               target="_blank" 
                               class="btn btn-sm btn-outline-primary mt-2">
                                <i class="fas fa-expand mr-1"></i> Lihat Full Size
                            </a>
                            
                            <!-- Form verifikasi untuk non-QRIS -->
                            @if($tarikTunai->status == 'menunggu_verifikasi_admin')
                            <div class="mt-3">
                                <form action="{{ route('admin.tariktunai.verifikasi-bukti', $tarikTunai->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Verifikasi Bukti:</label>
                                        <select name="status_verifikasi" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="diterima">Terima</option>
                                            <option value="ditolak">Tolak</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Catatan Verifikasi:</label>
                                        <textarea name="catatan_verifikasi" class="form-control" rows="2" 
                                                  placeholder="Berikan alasan..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-info btn-block">
                                        <i class="fas fa-check mr-1"></i> Verifikasi
                                    </button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Info QRIS COD -->
                    @if($tarikTunai->isQRISCOD())
                    <div class="card card-outline card-orange">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-qrcode mr-2"></i>
                                Informasi QRIS COD
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-orange">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Perhatian!</strong> Transaksi ini menggunakan QRIS COD. 
                                Proses pembayaran dilakukan saat serah terima.
                            </div>
                            
                            @if($tarikTunai->status == 'menunggu_verifikasi_qris')
                            <div class="alert alert-warning">
                                <i class="fas fa-clock mr-2"></i>
                                <strong>Menunggu Verifikasi QRIS</strong><br>
                                Customer telah membayar via QRIS. Tunggu bukti pembayaran dari petugas.
                            </div>
                            @endif
                            
                            @if($tarikTunai->waktu_verifikasi_qris)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>QRIS Telah Diverifikasi</strong><br>
                                Tanggal: {{ $tarikTunai->waktu_verifikasi_qris->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .card-outline {
        border-top: 4px solid;
        border-radius: 12px;
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    }

    .card-outline.card-primary { border-top-color: #667eea; }
    .card-outline.card-info { border-top-color: #4facfe; }
    .card-outline.card-success { border-top-color: #43e97b; }
    .card-outline.card-orange { border-top-color: #ff9500; }

    .info-item label {
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .avatar-placeholder {
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Timeline Styles */
    .timeline {
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #667eea, #764ba2);
        z-index: 1;
    }

    .timeline-step {
        position: relative;
        z-index: 2;
    }

    .step-circle {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #fff;
        border: 3px solid #dee2e6;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #6c757d;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    .step-circle.completed {
        background: linear-gradient(135deg, #43e97b, #38f9d7);
        border-color: #43e97b;
        color: white;
        transform: scale(1.1);
    }

    .step-circle.active {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-color: #667eea;
        color: white;
        transform: scale(1.1);
        animation: pulse 2s infinite;
    }

    .step-circle.pending {
        background: #fff;
        border-color: #dee2e6;
        color: #6c757d;
    }

    .step-label {
        font-size: 12px;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1.1); }
        50% { transform: scale(1.2); }
    }

    /* Badge Styles */
    .badge-purple {
        background: linear-gradient(135deg, #8a2be2, #da70d6);
        color: white;
    }
    
    .badge-orange {
        background: linear-gradient(135deg, #ff9500, #ff5e3a);
        color: white;
    }
    
    .badge-secondary { background-color: #6c757d; }
    .badge-warning { background-color: #ffc107; color: #212529; }
    .badge-info { background-color: #17a2b8; }
    .badge-primary { background-color: #007bff; }
    .badge-blue { background-color: #007bff; }
    .badge-teal { background-color: #20c997; }
    .badge-success { background-color: #28a745; }
    .badge-danger { background-color: #dc3545; }
    .badge-dark { background-color: #343a40; }

    .btn {
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    
    .alert-orange {
        background-color: rgba(255, 149, 0, 0.1);
        border-color: #ff9500;
        color: #cc7700;
    }

    @media (max-width: 768px) {
        .timeline::before {
            display: none;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            font-size: 14px;
        }
    }
    .step-circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    border: 3px solid;
    position: relative;
    z-index: 2;
}

.timeline-connector {
    position: absolute;
    top: 20px;
    width: 100%;
    height: 3px;
    background-color: #dee2e6;
    z-index: 1;
}

.step-info {
    min-height: 70px;
}

/* Responsive */
@media (max-width: 768px) {
    .step-circle {
        width: 30px;
        height: 30px;
        font-size: 12px;
    }
    
    .step-info small {
        font-size: 11px;
    }
    
    .timeline-connector {
        top: 15px;
    }
}
</style>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // Status update confirmation
        $('form').on('submit', function(e) {
            const form = $(this);
            if (form.find('select[name="status"]').length > 0) {
                const newStatus = form.find('select[name="status"]').val();
                const currentStatus = "{{ $tarikTunai->status }}";
                
                if (newStatus !== currentStatus && newStatus === 'dibatalkan') {
                    if (!confirm('Anda yakin ingin membatalkan transaksi ini?')) {
                        e.preventDefault();
                        return false;
                    }
                }
                
                // Validasi khusus untuk QRIS COD
                @if($tarikTunai->isQRISCOD())
                if (newStatus === 'selesai' && currentStatus !== 'menunggu_verifikasi_qris') {
                    alert('Transaksi QRIS COD harus melalui verifikasi QRIS terlebih dahulu!');
                    e.preventDefault();
                    return false;
                }
                @endif
            }
            return true;
        });
        
        // Show/hide bukti QRIS field
        $('select[name="status"]').change(function() {
            const selectedStatus = $(this).val();
            @if($tarikTunai->isQRISCOD())
            if (selectedStatus === 'menunggu_verifikasi_qris') {
                $('input[name="bukti_qris"]').closest('.form-group').show();
            } else {
                $('input[name="bukti_qris"]').closest('.form-group').hide();
            }
            @endif
        }).trigger('change');
    });
</script>
@endsection
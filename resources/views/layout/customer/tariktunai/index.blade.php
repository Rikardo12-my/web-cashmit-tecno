@extends('layout.customer.customer')

@section('title', 'Tarik Tunai')

@section('content')
<div class="container-fluid">
    <!-- Header Clean & Modern -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-3">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <!-- Left: Title with Icon -->
                        <div class="d-flex align-items-center mb-3 mb-md-0">
                            <div class="bg-primary bg-opacity-10 rounded-2 p-3 me-3 shadow-sm">
                                <i class="fas fa-money-bill-wave text-primary fa-lg"></i>
                            </div>
                            <div>
                                <h1 class="h3 fw-bold mb-1 text-dark">Tarik Tunai Saya</h1>
                                <p class="text-muted mb-0">Kelola semua transaksi tarik tunai dalam satu tempat</p>
                            </div>
                        </div>

                        <!-- Right: Action Button -->
                        <div class="d-flex align-items-center">
                            <a href="{{ route('customer.tariktunai.create') }}"
                                class="btn btn-primary btn-lg px-4 py-2 fw-medium shadow-sm d-flex align-items-center">
                                <i class="fas fa-plus-circle me-2"></i>
                                Ajukan Tarik Tunai Baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <div class="mb-2 mb-md-0">
                            <h3 class="h5 fw-bold mb-1 text-dark">Daftar Transaksi</h3>
                            <p class="text-muted small mb-0">Temukan transaksi dengan cepat</p>
                        </div>
                        <div class="w-100 w-md-auto">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" id="searchInput" class="form-control border-start-0 ps-0"
                                    placeholder="Cari transaksi...">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if($tarikTunais->isEmpty())
                    <div class="empty-state text-center py-5">
                        <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada riwayat tarik tunai</h4>
                        <p class="text-muted">Mulai dengan mengajukan permintaan tarik tunai baru</p>
                        <a href="{{ route('customer.tariktunai.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus-circle mr-1"></i> Ajukan Sekarang
                        </a>
                    </div>
                    @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 8%">ID</th>
                                    <th style="width: 10%">Tanggal</th>
                                    <th style="width: 10%">Jumlah</th>
                                    <th style="width: 10%">Bukti Bayar</th>
                                    <th style="width: 10%">QRIS</th>
                                    <th style="width: 12%">Lokasi</th>
                                    <th style="width: 8%">Status</th>
                                    <th style="width: 10%">Total</th>
                                    <th style="width: 12%">Petugas</th>
                                    <th style="width: 8%">Aksi</th>
                                </tr>
                            </thead>

                            <!-- Di dalam tbody, tambahkan kolom bukti bayar -->
                            <tbody>
                                @foreach($tarikTunais as $transaksi)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary">{{ $transaksi->kode_transaksi ?? '#' . str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        {{ $transaksi->created_at->format('d/m/Y') }}<br>
                                        <small class="text-muted">{{ $transaksi->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-primary">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</strong>
                                    </td>

                                    <!-- KOLOM BUKTI BAYAR CUSTOMER -->
                                    <td>
                                        @if($transaksi->bukti_bayar_customer)
                                        <div class="text-center">
                                            <!-- Thumbnail gambar bukti -->
                                            <button type="button"
                                                class="btn btn-sm btn-outline-info view-bukti-customer-btn p-0"
                                                data-url="{{ Storage::url($transaksi->bukti_bayar_customer) }}"
                                                data-waktu="{{ $transaksi->waktu_upload_bukti_customer ? ($transaksi->waktu_upload_bukti_customer instanceof \Carbon\Carbon ? $transaksi->waktu_upload_bukti_customer->timezone('Asia/Jakarta')->format('d/m/Y H:i') : \Carbon\Carbon::parse($transaksi->waktu_upload_bukti_customer)->timezone('Asia/Jakarta')->format('d/m/Y H:i')) : '' }}"
                                                data-judul="Bukti Pembayaran {{ $transaksi->kode_transaksi }}"
                                                title="Lihat Bukti Pembayaran">
                                                <div style="width: 50px; height: 50px; overflow: hidden; border-radius: 5px; border: 2px solid #17a2b8; margin: 0 auto;">
                                                    <img src="{{ Storage::url($transaksi->bukti_bayar_customer) }}"
                                                        alt="Bukti Pembayaran"
                                                        style="width: 100%; height: 100%; object-fit: cover;"
                                                        onerror="this.src='{{ asset('images/no-image.png') }}'">
                                                </div>
                                            </button>
                                            <br>
                                            @if($transaksi->waktu_upload_bukti_customer)
                                            <small class="text-muted">
                                                {{ $transaksi->waktu_upload_bukti_customer instanceof \Carbon\Carbon ? $transaksi->waktu_upload_bukti_customer->timezone('Asia/Jakarta')->format('d/m H:i') : \Carbon\Carbon::parse($transaksi->waktu_upload_bukti_customer)->timezone('Asia/Jakarta')->format('d/m H:i') }}
                                            </small>
                                            @endif
                                        </div>
                                        @elseif(in_array($transaksi->status, ['menunggu_pembayaran']))
                                        <!-- Tombol upload jika status menunggu pembayaran -->
                                        <button type="button"
                                            class="btn btn-sm btn-warning upload-bukti-btn"
                                            data-id="{{ $transaksi->id }}"
                                            title="Upload Bukti Pembayaran">
                                            <i class="fas fa-upload"></i> Upload
                                        </button>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <!-- END KOLOM BUKTI BAYAR -->

                                    <td>
                                        <!-- Kode QRIS tetap sama -->
                                        @if($transaksi->paymentMethod && $transaksi->paymentMethod->qris_image)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary view-qris-btn"
                                            data-id="{{ $transaksi->paymentMethod->id }}"
                                            title="Lihat QRIS">
                                            <i class="fas fa-qrcode"></i> QRIS
                                        </button>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <!-- Kolom lainnya tetap sama -->
                                    <td>
                                        @if($transaksi->lokasiCod)
                                        @if($transaksi->lokasiCod->gambar)
                                        <button type="button"
                                            class="btn btn-sm btn-outline-success view-location-btn"
                                            data-id="{{ $transaksi->lokasiCod->id }}"
                                            title="Lihat Lokasi">
                                            <i class="fas fa-map-marker-alt"></i> Lokasi
                                        </button>
                                        @else
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                                            <div>
                                                <strong class="d-block">{{ $transaksi->lokasiCod->nama_lokasi }}</strong>
                                            </div>
                                        </div>
                                        @endif
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <!-- Status tetap sama -->
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
                                        'menunggu_pembayaran' => 'Menunggu Bayar',
                                        'diproses' => 'Diproses',
                                        'selesai' => 'Selesai',
                                        'dibatalkan_customer' => 'Dibatalkan',
                                        'dibatalkan_admin' => 'Dibatalkan'
                                        ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$transaksi->status] ?? 'secondary' }}">
                                            {{ $statusTexts[$transaksi->status] ?? $transaksi->status }}
                                        </span>
                                        @if($transaksi->biaya_admin <= 0 && $transaksi->status == 'menunggu_admin')
                                            <small class="d-block text-muted mt-1">Menunggu biaya admin</small>
                                            @endif
                                    </td>
                                    <td>
                                        @if($transaksi->total_dibayar > 0)
                                        <strong class="text-success">Rp {{ number_format($transaksi->total_dibayar, 0, ',', '.') }}</strong>
                                        @if($transaksi->biaya_admin > 0)
                                        <small class="d-block text-warning">+Rp {{ number_format($transaksi->biaya_admin, 0, ',', '.') }} admin</small>
                                        @endif
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaksi->petugas)
                                        <div class="d-flex align-items-center">
                                            @if($transaksi->petugas->foto)
                                            <img src="{{ asset('storage/' . $transaksi->petugas->foto) }}"
                                                alt="{{ $transaksi->petugas->nama }}"
                                                class="img-circle img-sm mr-2"
                                                style="width: 30px; height: 30px; object-fit: cover;">
                                            @else
                                            <div class="img-circle img-sm mr-2 bg-secondary d-flex align-items-center justify-content-center"
                                                style="width: 30px; height: 30px;">
                                                <i class="fas fa-user text-white" style="font-size: 12px;"></i>
                                            </div>
                                            @endif
                                            <span>{{ $transaksi->petugas->nama }}</span>
                                        </div>
                                        @else
                                        <span class="text-muted">Belum ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('customer.tariktunai.show', $transaksi) }}"
                                                class="btn btn-sm btn-info"
                                                title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            @if(in_array($transaksi->status, ['menunggu_admin', 'menunggu_pembayaran']))
                                            @if($transaksi->biaya_admin > 0 && $transaksi->status == 'menunggu_pembayaran')
                                            <button type="button"
                                                class="btn btn-sm btn-success upload-bukti-btn"
                                                title="Upload Bukti"
                                                data-id="{{ $transaksi->id }}">
                                                <i class="fas fa-upload"></i>
                                            </button>
                                            @endif

                                            <button type="button"
                                                class="btn btn-sm btn-danger"
                                                title="Batalkan"
                                                data-toggle="modal"
                                                data-target="#cancelModal"
                                                data-id="{{ $transaksi->id }}"
                                                data-code="{{ $transaksi->kode_transaksi ?? '#' . str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                @if($tarikTunais->isNotEmpty())
                <div class="card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="legend">
                            <small class="text-muted">Total {{ $tarikTunais->count() }} transaksi</small>
                        </div>
                        <div>
                            <small class="text-success mr-3">
                                <i class="fas fa-money-bill-wave"></i>
                                Total Transaksi: Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}
                                @if($totalBiayaAdmin > 0)
                                <small class="text-warning">(Biaya admin: Rp {{ number_format($totalBiayaAdmin ?? 0, 0, ',', '.') }})</small>
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Modal QRIS untuk Index -->
<div class="modal fade" id="qrisModalIndex" tabindex="-1" role="dialog" aria-labelledby="qrisModalIndexLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="qrisModalIndexLabel">
                    <i class="fas fa-qrcode mr-2"></i>QRIS Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary my-5" id="qrisSpinnerIndex" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <img id="qrisImageIndex" class="img-fluid d-none" alt="QRIS" style="max-height: 300px;">
                <div id="qrisErrorIndex" class="alert alert-danger d-none"></div>

                <div id="qrisInfoIndex" class="mt-3 d-none">
                    <h6 id="qrisMethodNameIndex" class="font-weight-bold text-primary"></h6>
                    <p id="qrisDescriptionIndex" class="text-muted small mb-3"></p>
                    <div class="alert alert-light border">
                        <p class="mb-1">
                            <strong><i class="fas fa-credit-card mr-2"></i>Nomor:</strong>
                            <span id="qrisAccountNumberIndex"></span>
                        </p>
                        <p class="mb-0">
                            <strong><i class="fas fa-user mr-2"></i>Nama:</strong>
                            <span id="qrisAccountNameIndex"></span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="downloadQrisIndex()" id="btnDownloadQrisIndex" disabled>
                    <i class="fas fa-download mr-1"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Lokasi untuk Index -->
<div class="modal fade" id="locationModalIndex" tabindex="-1" role="dialog" aria-labelledby="locationModalIndexLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="locationModalIndexLabel">
                    <i class="fas fa-map-marker-alt mr-2"></i>Detail Lokasi Penyerahan
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="spinner-border text-primary my-5" id="locationSpinnerIndex" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <img id="locationImageIndex" class="img-fluid rounded d-none w-100" alt="Lokasi" style="max-height: 300px;">
                <div id="locationErrorIndex" class="alert alert-danger d-none"></div>

                <div id="locationInfoModalIndex" class="mt-3 d-none">
                    <h4 id="locationNameIndex" class="font-weight-bold text-success"></h4>
                    <p id="locationDetailIndex" class="text-muted"></p>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Alamat Lengkap
                                    </h6>
                                    <p class="mb-0" id="locationAlamatIndex"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-clock mr-2"></i> Jam Operasional
                                    </h6>
                                    <p class="mb-0" id="locationJamOperasionalIndex">Setiap hari 08:00 - 22:00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-phone mr-2"></i> Kontak
                                    </h6>
                                    <p class="mb-0" id="locationTeleponIndex">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title text-primary">
                                        <i class="fas fa-map-pin mr-2"></i> Koordinat
                                    </h6>
                                    <p class="mb-1"><strong>Latitude:</strong> <span id="locationLatIndex"></span></p>
                                    <p class="mb-0"><strong>Longitude:</strong> <span id="locationLngIndex"></span></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle mr-2"></i>
                        <strong>Petunjuk:</strong>
                        Datang ke lokasi ini untuk menerima uang tunai dari petugas kami.
                        Pastikan membawa identitas yang valid untuk verifikasi.
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-success" onclick="openInMapsIndex()" id="btnOpenMapsIndex" disabled>
                    <i class="fas fa-map mr-1"></i> Buka di Google Maps
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Upload Bukti -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="uploadForm" method="POST" enctype="multipart/form-data">
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
                    <div id="paymentSummary" class="alert alert-info mb-3">
                        <p>Loading informasi pembayaran...</p>
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
                    <p>Apakah Anda yakin ingin membatalkan transaksi <strong id="cancelCode"></strong>?</p>
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

<!-- Modal View Bukti Pembayaran -->
<div class="modal fade" id="viewBuktiModal" tabindex="-1" role="dialog" aria-labelledby="viewBuktiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewBuktiModalLabel">
                    <i class="fas fa-receipt mr-2"></i>Bukti Pembayaran
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="spinner-border text-primary my-5" id="buktiSpinner" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <img id="buktiImage" class="img-fluid rounded d-none" alt="Bukti Pembayaran" style="max-height: 500px;">
                <div id="buktiError" class="alert alert-danger d-none"></div>

                <div id="buktiInfo" class="mt-3 d-none text-left">
                    <h6 class="font-weight-bold text-primary" id="buktiTitle"></h6>
                    <p class="text-muted">
                        <i class="far fa-clock mr-2"></i>
                        Diupload pada: <span id="buktiTimestamp"></span>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i> Tutup
                </button>
                <button type="button" class="btn btn-outline-primary" onclick="downloadBukti()" id="btnDownloadBukti" disabled>
                    <i class="fas fa-download mr-1"></i> Download
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .empty-state {
        padding: 60px 20px;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 60px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .img-circle {
        border-radius: 50%;
    }

    .img-sm {
        width: 30px;
        height: 30px;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(74, 144, 226, 0.05);
    }

    .badge {
        border-radius: 50px;
        padding: 5px 12px;
        font-weight: 500;
    }

    .view-qris-btn,
    .view-location-btn {
        font-size: 12px;
        padding: 2px 8px;
    }

    /* Custom Styles */
    .card {
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .card:hover {
        border-color: #dee2e6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .bg-primary {
        background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%) !important;
        border: none;
    }

    .bg-primary:hover {
        background: linear-gradient(135deg, #3a80d2 0%, #77bee5 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(74, 144, 226, 0.3);
    }

    .bg-opacity-10 {
        background-color: rgba(74, 144, 226, 0.08) !important;
    }

    .rounded-3 {
        border-radius: 12px !important;
    }

    .rounded-2 {
        border-radius: 10px !important;
    }

    .shadow-sm {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }

    .text-dark {
        color: #2c3e50 !important;
    }

    .fw-medium {
        font-weight: 500;
    }

    .fa-lg {
        font-size: 1.25rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn-lg {
            padding: 0.75rem 1.25rem !important;
            font-size: 0.9rem;
        }

        .h3 {
            font-size: 1.4rem;
        }
    }

    .input-group {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .input-group-text {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        padding: 0.5rem 0.75rem;
    }

    .form-control {
        border-color: #dee2e6;
        border-left: none;
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }

    .form-control:focus {
        box-shadow: none;
        border-color: #dee2e6;
    }

    .form-control.border-start-0 {
        padding-left: 0;
    }

    .btn-primary {
        border-radius: 0 8px 8px 0;
        padding: 0.5rem 1rem;
        border: none;
    }

    @media (max-width: 768px) {
        .w-md-auto {
            width: 100% !important;
        }
    }
</style>

<script>
    let currentPaymentMethodIdIndex = null;
    let currentLocationIdIndex = null;
    let currentLocationDataIndex = null;
    let currentQrisUrlIndex = null;

    document.addEventListener('DOMContentLoaded', function() {
        // Modal Upload
        $('#uploadModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('#uploadForm').attr('action', '/customer/tarik-tunai/' + id + '/upload-bukti');

            // Ambil data transaksi via AJAX
            $.ajax({
                url: '/customer/tarik-tunai/' + id + '/detail',
                method: 'GET',
                success: function(response) {
                    var html = `
                        <h6><i class="fas fa-file-invoice-dollar mr-2"></i>Ringkasan Pembayaran</h6>
                        <table class="table table-sm mb-0">
                            <tr>
                                <td>Jumlah Tarik:</td>
                                <td class="text-right">Rp ${formatNumber(response.jumlah)}</td>
                            </tr>
                            <tr>
                                <td>Biaya Admin:</td>
                                <td class="text-right text-warning">Rp ${formatNumber(response.biaya_admin)}</td>
                            </tr>
                            <tr class="table-success">
                                <td><strong>Total Dibayar:</strong></td>
                                <td class="text-right"><strong>Rp ${formatNumber(response.total_dibayar)}</strong></td>
                            </tr>
                        </table>
                    `;
                    modal.find('#paymentSummary').html(html);
                },
                error: function() {
                    modal.find('#paymentSummary').html('<p class="text-danger">Gagal memuat data pembayaran</p>');
                }
            });
        });

        // Modal Cancel
        $('#cancelModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var code = button.data('code');
            var modal = $(this);
            modal.find('#cancelCode').text(code);
            modal.find('#cancelForm').attr('action', '/customer/tarik-tunai/' + id + '/cancel');
        });

        // File input label
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('table tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // QRIS Modal untuk Index
        $('#qrisModalIndex').on('show.bs.modal', function(event) {
            if (!currentPaymentMethodIdIndex) {
                showQrisErrorIndex('Tidak ada QRIS yang dipilih');
                return;
            }
            loadQrisImageIndex(currentPaymentMethodIdIndex);
        });

        // Location Modal untuk Index
        $('#locationModalIndex').on('show.bs.modal', function(event) {
            if (!currentLocationIdIndex) {
                showLocationErrorIndex('Tidak ada lokasi yang dipilih');
                return;
            }
            loadLocationImageIndex(currentLocationIdIndex);
        });

        // Tombol lihat QRIS di tabel
        $('.view-qris-btn').click(function() {
            currentPaymentMethodIdIndex = $(this).data('id');
            $('#qrisModalIndex').modal('show');
        });

        // Tombol lihat lokasi di tabel
        $('.view-location-btn').click(function() {
            currentLocationIdIndex = $(this).data('id');
            $('#locationModalIndex').modal('show');
        });

        // Reset modal saat ditutup
        $('#qrisModalIndex, #locationModalIndex').on('hidden.bs.modal', function() {
            resetModalIndex($(this).attr('id'));
        });
    });

    function formatNumber(num) {
        return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function loadQrisImageIndex(paymentMethodId) {
        console.log('Loading QRIS for Index:', paymentMethodId);

        // Reset modal
        $('#qrisSpinnerIndex').removeClass('d-none');
        $('#qrisImageIndex').addClass('d-none');
        $('#qrisErrorIndex').addClass('d-none');
        $('#qrisInfoIndex').addClass('d-none');
        $('#btnDownloadQrisIndex').prop('disabled', true);

        // AJAX request untuk QRIS
        $.ajax({
            url: '{{ route("customer.tariktunai.get-qris", ":id") }}'.replace(':id', paymentMethodId),
            method: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('QRIS Response:', response);
                $('#qrisSpinnerIndex').addClass('d-none');

                if (response.error) {
                    showQrisErrorIndex(response.error + (response.suggestion ? '<br><small>' + response.suggestion + '</small>' : ''));
                    return;
                }

                if (response.success && response.qris_image) {
                    currentQrisUrlIndex = response.qris_image;

                    const img = new Image();
                    img.onload = function() {
                        $('#qrisImageIndex')
                            .attr('src', response.qris_image)
                            .attr('alt', 'QRIS ' + (response.nama || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');

                        // Update info
                        if (response.nama) {
                            $('#qrisMethodNameIndex').text(response.nama);
                        }
                        if (response.deskripsi) {
                            $('#qrisDescriptionIndex').text(response.deskripsi);
                        }
                        if (response.account_number) {
                            $('#qrisAccountNumberIndex').text(response.account_number);
                        }
                        if (response.account_name) {
                            $('#qrisAccountNameIndex').text(response.account_name);
                        }

                        $('#qrisInfoIndex').removeClass('d-none');
                        $('#btnDownloadQrisIndex').prop('disabled', false);
                        $('#qrisModalIndexLabel').html(`<i class="fas fa-qrcode mr-2"></i>QRIS - ${response.nama || 'Pembayaran'}`);
                    };

                    img.onerror = function() {
                        console.error('Image failed to load:', response.qris_image);
                        showQrisErrorIndex('Gambar QRIS gagal dimuat<br>URL: ' + response.qris_image);
                    };

                    img.src = response.qris_image;
                } else {
                    showQrisErrorIndex('Tidak ada QRIS yang tersedia');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#qrisSpinnerIndex').addClass('d-none');

                let errorMessage = 'Gagal memuat QRIS';
                if (xhr.status === 404) {
                    errorMessage = 'Endpoint tidak ditemukan';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error';
                }

                showQrisErrorIndex(errorMessage);
            }
        });
    }

    function loadLocationImageIndex(locationId) {
        console.log('Loading Location for Index:', locationId);

        // Reset modal
        $('#locationSpinnerIndex').removeClass('d-none');
        $('#locationImageIndex').addClass('d-none');
        $('#locationErrorIndex').addClass('d-none');
        $('#locationInfoModalIndex').addClass('d-none');
        $('#btnOpenMapsIndex').prop('disabled', true);

        // AJAX request untuk lokasi
        $.ajax({
            url: '{{ route("customer.tariktunai.get-location", ":id") }}'.replace(':id', locationId),
            method: 'GET',
            dataType: 'json',
            timeout: 10000,
            success: function(response) {
                console.log('Location Response:', response);
                $('#locationSpinnerIndex').addClass('d-none');

                if (response.error) {
                    showLocationErrorIndex(response.error + (response.suggestion ? '<br><small>' + response.suggestion + '</small>' : ''));
                    return;
                }

                if (response.success && response.gambar) {
                    const img = new Image();
                    img.onload = function() {
                        $('#locationImageIndex')
                            .attr('src', response.gambar)
                            .attr('alt', 'Lokasi ' + (response.nama_lokasi || ''))
                            .removeClass('d-none')
                            .addClass('animate__animated animate__fadeIn');

                        // Update info
                        $('#locationNameIndex').text(response.nama_lokasi || 'Lokasi Penyerahan');
                        $('#locationAlamatIndex').text(response.alamat || 'Alamat tidak tersedia');
                        $('#locationDetailIndex').text(response.area_detail || '');
                        $('#locationLatIndex').text(response.latitude || '-');
                        $('#locationLngIndex').text(response.longitude || '-');
                        $('#locationJamOperasionalIndex').text(response.jam_operasional || 'Setiap hari 08:00 - 22:00');
                        $('#locationTeleponIndex').text(response.telepon || '-');
                        $('#locationInfoModalIndex').removeClass('d-none');

                        // Simpan data untuk Google Maps
                        currentLocationDataIndex = response;
                        if (response.latitude && response.longitude && response.latitude !== '-' && response.longitude !== '-') {
                            $('#btnOpenMapsIndex').prop('disabled', false);
                        }
                    };

                    img.onerror = function() {
                        console.error('Image failed to load:', response.gambar);
                        showLocationErrorIndex('Gambar lokasi gagal dimuat<br>URL: ' + response.gambar);
                    };

                    img.src = response.gambar;
                } else {
                    showLocationErrorIndex('Tidak ada gambar lokasi yang tersedia');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
                $('#locationSpinnerIndex').addClass('d-none');

                let errorMessage = 'Gagal memuat gambar lokasi';
                if (xhr.status === 404) {
                    errorMessage = 'Endpoint tidak ditemukan';
                } else if (xhr.status === 500) {
                    errorMessage = 'Server error';
                }

                showLocationErrorIndex(errorMessage);
            }
        });
    }

    function showQrisErrorIndex(message) {
        $('#qrisErrorIndex').html(`
            <i class="fas fa-exclamation-triangle mr-2"></i>
            ${message}
            <br><small class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut</small>
        `).removeClass('d-none');
    }

    function showLocationErrorIndex(message) {
        $('#locationErrorIndex').html(`
            <i class="fas fa-exclamation-triangle mr-2"></i>
            ${message}
            <br><small class="text-muted">Silakan hubungi admin untuk informasi lebih lanjut</small>
        `).removeClass('d-none');
    }

    function resetModalIndex(modalId) {
        if (modalId === 'qrisModalIndex') {
            $('#qrisImageIndex').attr('src', '').addClass('d-none');
            $('#qrisErrorIndex').addClass('d-none');
            $('#qrisInfoIndex').addClass('d-none');
            $('#qrisSpinnerIndex').removeClass('d-none');
            $('#btnDownloadQrisIndex').prop('disabled', true);
        } else if (modalId === 'locationModalIndex') {
            $('#locationImageIndex').attr('src', '').addClass('d-none');
            $('#locationErrorIndex').addClass('d-none');
            $('#locationInfoModalIndex').addClass('d-none');
            $('#locationSpinnerIndex').removeClass('d-none');
            $('#btnOpenMapsIndex').prop('disabled', true);
        }
    }

    function downloadQrisIndex() {
        if (currentQrisUrlIndex) {
            const link = document.createElement('a');
            link.href = currentQrisUrlIndex;
            link.download = 'qris-pembayaran-' + currentPaymentMethodIdIndex + '.png';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'QRIS Berhasil Didownload',
                text: 'File QRIS telah berhasil didownload.',
                confirmButtonColor: '#007bff',
                timer: 2000
            });
        }
    }

    function openInMapsIndex() {
        if (currentLocationDataIndex && currentLocationDataIndex.latitude && currentLocationDataIndex.longitude) {
            const lat = currentLocationDataIndex.latitude;
            const lng = currentLocationDataIndex.longitude;
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
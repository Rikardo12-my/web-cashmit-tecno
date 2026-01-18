@extends('layout.customer.customer')

@section('content')
<div class="container-fluid px-4 py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-xl-9">
            <!-- Header -->
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-5">
                <div class="mb-3 mb-md-0">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-3 p-3 me-3">
                            <i class="fas fa-money-bill-wave text-primary fa-lg"></i>
                        </div>
                        <div>
                            <h1 class="h3 fw-bold mb-1">Tarik Tunai Baru</h1>
                            <p class="text-muted mb-0">Isi form di bawah untuk mengajukan tarik tunai</p>
                        </div>
                    </div>
                </div>
                <a href="{{ route('customer.tariktunai.index') }}" 
                   class="btn btn-outline-secondary d-flex align-items-center">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Form Container -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-4 p-md-5">
                    <form id="tarikTunaiForm" action="{{ route('customer.tariktunai.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-6">
                                <!-- Jumlah Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-coins text-primary"></i>
                                        </div>
                                        <div>
                                            <label class="form-label fw-bold text-dark mb-1">Jumlah Tarik Tunai</label>
                                            <p class="text-muted small mb-0">Minimal Rp 10.000</p>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-lg border rounded-3 overflow-hidden">
                                        <span class="input-group-text bg-light border-0 fs-5">Rp</span>
                                        <input type="number"
                                               class="form-control border-0 @error('jumlah') is-invalid @enderror"
                                               id="jumlah"
                                               name="jumlah"
                                               value="{{ old('jumlah') }}"
                                               min="10000"
                                               step="1000"
                                               required>
                                    </div>
                                    @error('jumlah')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Payment Method Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-credit-card text-primary"></i>
                                        </div>
                                        <div>
                                            <label class="form-label fw-bold text-dark mb-1">Metode Pembayaran</label>
                                            <p class="text-muted small mb-0">Pilih cara pembayaran</p>
                                        </div>
                                    </div>
                                    <select class="form-select form-select-lg border rounded-3 @error('payment_method_id') is-invalid @enderror"
                                            id="payment_method_id"
                                            name="payment_method_id"
                                            required>
                                        <option value="">Pilih metode pembayaran</option>
                                        <!-- Bank QRIS -->
                                        @if($paymentMethodsByCategory['bank_qris']->count() > 0)
                                        <optgroup label="🏦 Bank QRIS">
                                            @foreach($paymentMethodsByCategory['bank_qris'] as $method)
                                            <option value="{{ $method->id }}"
                                                    data-has-qris="{{ $method->qris_image ? 'true' : 'false' }}">
                                                {{ $method->nama }}
                                                @if($method->qris_image)<span class="float-end text-success">QRIS ✓</span>@endif
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                        <!-- E-Wallet -->
                                        @if($paymentMethodsByCategory['e_wallet']->count() > 0)
                                        <optgroup label="💳 E-Wallet">
                                            @foreach($paymentMethodsByCategory['e_wallet'] as $method)
                                            <option value="{{ $method->id }}"
                                                    data-has-qris="{{ $method->qris_image ? 'true' : 'false' }}">
                                                {{ $method->nama }}
                                                @if($method->qris_image)<span class="float-end text-success">QRIS ✓</span>@endif
                                            </option>
                                            @endforeach
                                        </optgroup>
                                        @endif
                                    </select>
                                    @error('payment_method_id')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                    <button type="button"
                                            class="btn btn-outline-primary btn-sm mt-3 d-none"
                                            id="btnViewQris">
                                        <i class="fas fa-qrcode me-2"></i>Lihat QRIS
                                    </button>
                                </div>

                                <!-- Location Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="rounded-circle bg-primary bg-opacity-10 p-2 me-3">
                                            <i class="fas fa-map-marker-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <label class="form-label fw-bold text-dark mb-1">Lokasi Penyerahan</label>
                                            <p class="text-muted small mb-0">Tempat mengambil uang tunai</p>
                                        </div>
                                    </div>
                                    <div class="input-group input-group-lg border rounded-3 overflow-hidden">
                                        <select class="form-select border-0 @error('lokasi_cod_id') is-invalid @enderror"
                                                id="lokasi_cod_id"
                                                name="lokasi_cod_id"
                                                required>
                                            <option value="">Pilih lokasi</option>
                                            @foreach($lokasiCod as $lokasi)
                                            <option value="{{ $lokasi->id }}"
                                                    data-has-image="{{ $lokasi->gambar ? 'true' : 'false' }}">
                                                {{ $lokasi->nama_lokasi }}
                                                @if($lokasi->area_detail)<small class="text-muted">({{ $lokasi->area_detail }})</small>@endif
                                            </option>
                                            @endforeach
                                        </select>
                                        <button type="button"
                                                class="btn btn-outline-info border-start-0"
                                                id="btnViewLocation"
                                                disabled>
                                            <i class="fas fa-map-marked-alt"></i>
                                        </button>
                                    </div>
                                    @error('lokasi_cod_id')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-6">
                                <!-- Process Steps -->
                                <div class="card border-0 bg-light rounded-4 mb-4">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">📋 Alur Proses</h5>
                                        <div class="timeline">
                                            <div class="timeline-step">
                                                <div class="timeline-icon">1</div>
                                                <div class="timeline-content">
                                                    <h6 class="fw-bold mb-1">Ajukan Permintaan</h6>
                                                    <p class="text-muted small mb-0">Isi form dan submit</p>
                                                </div>
                                            </div>
                                            <div class="timeline-step">
                                                <div class="timeline-icon">2</div>
                                                <div class="timeline-content">
                                                    <h6 class="fw-bold mb-1">Admin Konfirmasi</h6>
                                                    <p class="text-muted small mb-0">Biaya admin ditentukan</p>
                                                </div>
                                            </div>
                                            <div class="timeline-step">
                                                <div class="timeline-icon">3</div>
                                                <div class="timeline-content">
                                                    <h6 class="fw-bold mb-1">Lakukan Pembayaran</h6>
                                                    <p class="text-muted small mb-0">Bayar sesuai total</p>
                                                </div>
                                            </div>
                                            <div class="timeline-step">
                                                <div class="timeline-icon">4</div>
                                                <div class="timeline-content">
                                                    <h6 class="fw-bold mb-1">Ambil Uang Tunai</h6>
                                                    <p class="text-muted small mb-0">Datang ke lokasi</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Important Notes -->
                                <div class="card border-0 border-start border-3 border-warning rounded-4 mb-4">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">⚠️ Catatan Penting</h5>
                                        <ul class="list-unstyled">
                                            <li class="mb-2">
                                                <i class="fas fa-info-circle text-warning me-2"></i>
                                                <span class="small">Biaya admin ditentukan oleh Admin setelah pengajuan</span>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-clock text-warning me-2"></i>
                                                <span class="small">Konfirmasi dalam 1-2 jam kerja</span>
                                            </li>
                                            <li class="mb-2">
                                                <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                                <span class="small">Wajib hadir di lokasi yang dipilih</span>
                                            </li>
                                            <li>
                                                <i class="fas fa-id-card text-warning me-2"></i>
                                                <span class="small">Bawa identitas saat mengambil uang</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- User Stats -->
                                <div class="card border-0 bg-primary bg-opacity-5 rounded-4">
                                    <div class="card-body p-4">
                                        <h5 class="fw-bold mb-3">📊 Statistik Anda</h5>
                                        <div class="row text-center">
                                            <div class="col-4">
                                                <div class="stat-box {{ $activeCount >= 3 ? 'bg-danger text-white' : 'bg-primary text-white' }} rounded-3 p-2">
                                                    <div class="h4 mb-0 fw-bold">{{ $activeCount ?? 0 }}</div>
                                                    <small>Aktif</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-box bg-secondary text-white rounded-3 p-2">
                                                    <div class="h4 mb-0 fw-bold">3</div>
                                                    <small>Maks</small>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="stat-box bg-success text-white rounded-3 p-2">
                                                    <div class="h4 mb-0 fw-bold">{{ $completedCount ?? 0 }}</div>
                                                    <small>Selesai</small>
                                                </div>
                                            </div>
                                        </div>
                                        @if($activeCount >= 3)
                                        <div class="alert alert-danger mt-3">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Anda telah mencapai batas maksimal transaksi aktif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-5 pt-4 border-top">
                            @if($activeCount >= 3)
                            <button type="button" class="btn btn-danger btn-lg w-100" disabled>
                                <i class="fas fa-ban me-2"></i>Transaksi Aktif Maksimal
                            </button>
                            <p class="text-center text-danger small mt-2">
                                Anda memiliki {{ $activeCount }} transaksi aktif. Maksimal 3 transaksi.
                            </p>
                            @else
                            <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i>Ajukan Tarik Tunai
                            </button>
                            <p class="text-center text-muted small mt-2">
                                Pastikan data yang Anda isi sudah benar
                            </p>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- QRIS Modal -->
<div class="modal fade" id="qrisModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header bg-primary text-white border-0 rounded-top-4">
                <h5 class="modal-title">
                    <i class="fas fa-qrcode me-2"></i>QRIS Pembayaran
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="spinner-border text-primary my-4" id="qrisSpinner" role="status"></div>
                <img id="qrisImage" class="img-fluid rounded-3 d-none" alt="QRIS">
                <div id="qrisError" class="alert alert-danger d-none mt-3"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-primary" onclick="downloadQris()" id="btnDownloadQris" disabled>
                    <i class="fas fa-download me-1"></i>Download
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Location Modal -->
<div class="modal fade" id="locationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4">
            <div class="modal-header bg-success text-white border-0 rounded-top-4">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt me-2"></i>Detail Lokasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="spinner-border text-primary my-5" id="locationSpinner" role="status"></div>
                <div id="locationContent" class="d-none">
                    <img id="locationImage" class="img-fluid rounded-3 mb-4" alt="Lokasi">
                    <h5 id="locationName" class="fw-bold mb-3"></h5>
                    <p id="locationAlamat" class="text-muted mb-4"></p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    <span class="fw-semibold">Jam Operasional</span>
                                </div>
                                <p id="locationJamOperasional" class="mb-0">08:00 - 22:00</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light rounded-3 p-3">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-phone text-primary me-2"></i>
                                    <span class="fw-semibold">Telepon</span>
                                </div>
                                <p id="locationTelepon" class="mb-0">-</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="locationError" class="alert alert-danger d-none"></div>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <button type="button" class="btn btn-success" onclick="openInMaps()" id="btnOpenMaps" disabled>
                    <i class="fas fa-map me-1"></i>Buka di Maps
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #4A90E2;
        --secondary: #6c757d;
        --success: #28a745;
        --danger: #dc3545;
        --warning: #ffc107;
        --light: #f8f9fa;
        --border-radius: 12px;
    }

    .card {
        border: 1px solid #e9ecef;
    }

    .rounded-4 {
        border-radius: 16px !important;
    }

    .form-select-lg, .input-group-lg .form-control {
        padding: 0.75rem 1rem;
        font-size: 1rem;
    }

    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline-step {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .timeline-icon {
        position: absolute;
        left: -30px;
        top: 0;
        width: 24px;
        height: 24px;
        background: var(--primary);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: bold;
    }

    .timeline-content h6 {
        font-size: 0.9rem;
    }

    .timeline-content p {
        font-size: 0.8rem;
    }

    .stat-box {
        transition: all 0.2s ease;
    }

    .stat-box:hover {
        transform: translateY(-2px);
    }

    .bg-opacity-10 {
        background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
    }

    .bg-primary {
        background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%) !important;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(74, 144, 226, 0.3);
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #4A90E2 0%, #87CEEB 100%);
        color: white;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.1);
    }

    .border-start-0 {
        border-left: 0 !important;
    }

    .border-end-0 {
        border-right: 0 !important;
    }

    .fw-semibold {
        font-weight: 600;
    }

    #qrisImage {
        max-height: 280px;
        border: 1px solid #dee2e6;
    }

    #locationImage {
        max-height: 300px;
        object-fit: cover;
        width: 100%;
    }

    @media (max-width: 768px) {
        .container-fluid {
            padding: 1rem !important;
        }
        
        .card-body {
            padding: 1.5rem !important;
        }
        
        .timeline {
            padding-left: 25px;
        }
        
        .timeline-icon {
            left: -25px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize modals
        const qrisModal = new bootstrap.Modal(document.getElementById('qrisModal'));
        const locationModal = new bootstrap.Modal(document.getElementById('locationModal'));

        let currentPaymentMethodId = null;
        let currentLocationId = null;
        let currentLocationData = null;
        let currentQrisUrl = null;

        // Payment method change
        document.getElementById('payment_method_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const hasQris = selectedOption.dataset.hasQris === 'true';
            const viewBtn = document.getElementById('btnViewQris');
            
            if (hasQris) {
                viewBtn.classList.remove('d-none');
                currentPaymentMethodId = this.value;
            } else {
                viewBtn.classList.add('d-none');
                currentPaymentMethodId = null;
            }
        });

        // Location change
        document.getElementById('lokasi_cod_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const hasImage = selectedOption.dataset.hasImage === 'true';
            const viewBtn = document.getElementById('btnViewLocation');
            
            currentLocationId = this.value;
            viewBtn.disabled = !hasImage;
            
            if (hasImage && currentLocationId) {
                loadLocationData(currentLocationId);
            }
        });

        // View QRIS button
        document.getElementById('btnViewQris').addEventListener('click', function() {
            if (currentPaymentMethodId) {
                qrisModal.show();
            }
        });

        // View Location button
        document.getElementById('btnViewLocation').addEventListener('click', function() {
            if (currentLocationId) {
                locationModal.show();
            }
        });

        // Form validation
        document.getElementById('tarikTunaiForm').addEventListener('submit', function(e) {
            @if($activeCount >= 3)
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Transaksi Aktif Maksimal',
                text: 'Anda sudah memiliki 3 transaksi aktif. Harap selesaikan terlebih dahulu.',
                confirmButtonColor: '#4A90E2'
            });
            return false;
            @endif

            const jumlah = document.getElementById('jumlah').value;
            const paymentMethod = document.getElementById('payment_method_id').value;
            const location = document.getElementById('lokasi_cod_id').value;

            if (!jumlah || !paymentMethod || !location) {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Data Belum Lengkap',
                    text: 'Harap lengkapi semua field yang wajib diisi.',
                    confirmButtonColor: '#4A90E2'
                });
                return false;
            }
        });

        // QRIS Modal events
        document.getElementById('qrisModal').addEventListener('show.bs.modal', function() {
            if (currentPaymentMethodId) {
                loadQrisImage(currentPaymentMethodId);
            }
        });

        // Location Modal events
        document.getElementById('locationModal').addEventListener('show.bs.modal', function() {
            if (currentLocationId) {
                loadLocationImage(currentLocationId);
            }
        });
    });

    function loadQrisImage(paymentMethodId) {
        const spinner = document.getElementById('qrisSpinner');
        const image = document.getElementById('qrisImage');
        const error = document.getElementById('qrisError');
        const downloadBtn = document.getElementById('btnDownloadQris');

        spinner.classList.remove('d-none');
        image.classList.add('d-none');
        error.classList.add('d-none');
        downloadBtn.disabled = true;

        fetch(`{{ route("customer.tariktunai.get-qris", ":id") }}`.replace(':id', paymentMethodId))
            .then(response => response.json())
            .then(data => {
                spinner.classList.add('d-none');
                
                if (data.error) {
                    error.textContent = data.error;
                    error.classList.remove('d-none');
                    return;
                }

                if (data.qris_image) {
                    currentQrisUrl = data.qris_image;
                    
                    image.onload = function() {
                        image.classList.remove('d-none');
                        downloadBtn.disabled = false;
                    };
                    
                    image.onerror = function() {
                        error.textContent = 'Gambar QRIS gagal dimuat';
                        error.classList.remove('d-none');
                    };
                    
                    image.src = data.qris_image;
                } else {
                    error.textContent = 'QRIS tidak tersedia';
                    error.classList.remove('d-none');
                }
            })
            .catch(err => {
                spinner.classList.add('d-none');
                error.textContent = 'Gagal memuat QRIS. Periksa koneksi internet.';
                error.classList.remove('d-none');
            });
    }

    function loadLocationImage(locationId) {
        const spinner = document.getElementById('locationSpinner');
        const content = document.getElementById('locationContent');
        const error = document.getElementById('locationError');
        const openMapsBtn = document.getElementById('btnOpenMaps');

        spinner.classList.remove('d-none');
        content.classList.add('d-none');
        error.classList.add('d-none');
        openMapsBtn.disabled = true;

        fetch(`{{ route("customer.tariktunai.get-location", ":id") }}`.replace(':id', locationId))
            .then(response => response.json())
            .then(data => {
                spinner.classList.add('d-none');
                
                if (data.error) {
                    error.textContent = data.error;
                    error.classList.remove('d-none');
                    return;
                }

                if (data.gambar) {
                    document.getElementById('locationImage').src = data.gambar;
                    document.getElementById('locationName').textContent = data.nama_lokasi || 'Lokasi Penyerahan';
                    document.getElementById('locationAlamat').textContent = data.alamat || 'Alamat tidak tersedia';
                    document.getElementById('locationJamOperasional').textContent = data.jam_operasional || '08:00 - 22:00';
                    document.getElementById('locationTelepon').textContent = data.telepon || '-';
                    
                    currentLocationData = data;
                    if (data.latitude && data.longitude) {
                        openMapsBtn.disabled = false;
                    }
                    
                    content.classList.remove('d-none');
                } else {
                    error.textContent = 'Gambar lokasi tidak tersedia';
                    error.classList.remove('d-none');
                }
            })
            .catch(err => {
                spinner.classList.add('d-none');
                error.textContent = 'Gagal memuat lokasi';
                error.classList.remove('d-none');
            });
    }

    function loadLocationData(locationId) {
        // Load location data for display
        fetch(`{{ route("customer.tariktunai.get-location", ":id") }}`.replace(':id', locationId))
            .then(response => response.json())
            .then(data => {
                currentLocationData = data;
            })
            .catch(err => {
                console.error('Failed to load location data:', err);
            });
    }

    function downloadQris() {
        if (currentQrisUrl) {
            const link = document.createElement('a');
            link.href = currentQrisUrl;
            link.download = `qris-${currentPaymentMethodId}.png`;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }

    function openInMaps() {
        if (currentLocationData && currentLocationData.latitude && currentLocationData.longitude) {
            const url = `https://www.google.com/maps?q=${currentLocationData.latitude},${currentLocationData.longitude}`;
            window.open(url, '_blank');
        }
    }
</script>
@endsection
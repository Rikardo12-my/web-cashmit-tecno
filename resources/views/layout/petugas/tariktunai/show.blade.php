@extends('layout.petugas.petugas')

@section('title', 'Detail Tugas - ' . $tarikTunai->kode_transaksi)

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <a href="{{ route('petugas.tariktunai.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Kolom Kiri: Detail Transaksi -->
        <div class="col-lg-8">
            <!-- Card Informasi Transaksi -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-file-invoice-dollar mr-2"></i>
                        Informasi Transaksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Kode Transaksi</th>
                                    <td>
                                        <span class="badge badge-primary">{{ $tarikTunai->kode_transaksi }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Customer</th>
                                    <td>
                                        @if($tarikTunai->user)
                                        <strong>{{ $tarikTunai->user->name }}</strong><br>
                                        <small class="text-muted">{{ $tarikTunai->user->email }}</small>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>
                                        <h4 class="text-primary mb-0">Rp {{ number_format($tarikTunai->jumlah, 0, ',', '.') }}</h4>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Status</th>
                                    <td>
                                        @php
                                        $statusColors = [
                                        'diproses' => 'warning',
                                        'dalam_perjalanan' => 'info',
                                        'menunggu_serah_terima' => 'primary',
                                        'selesai' => 'success',
                                        'menunggu_admin' => 'secondary',
                                        'menunggu_pembayaran' => 'info'
                                        ];

                                        $statusTexts = [
                                        'diproses' => 'Diproses',
                                        'dalam_perjalanan' => 'Dalam Perjalanan',
                                        'menunggu_serah_terima' => 'Menunggu Serah Terima',
                                        'selesai' => 'Selesai',
                                        'menunggu_admin' => 'Menunggu Admin',
                                        'menunggu_pembayaran' => 'Menunggu Pembayaran'
                                        ];
                                        @endphp
                                        <span class="badge badge-{{ $statusColors[$tarikTunai->status] ?? 'secondary' }} p-2">
                                            <i class="fas fa-circle mr-1"></i>
                                            {{ $statusTexts[$tarikTunai->status] ?? $tarikTunai->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Biaya Admin</th>
                                    <td>
                                        @if($tarikTunai->biaya_admin > 0)
                                        <span class="text-warning">Rp {{ number_format($tarikTunai->biaya_admin, 0, ',', '.') }}</span>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total Dibayar</th>
                                    <td>
                                        @if($tarikTunai->total_dibayar > 0)
                                        <h5 class="text-success mb-0">Rp {{ number_format($tarikTunai->total_dibayar, 0, ',', '.') }}</h5>
                                        @else
                                        <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Lokasi -->
            <div class="card card-outline card-success mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-map-marker-alt mr-2"></i>
                        Lokasi Penyerahan
                    </h3>
                </div>
                <div class="card-body">
                    @if($tarikTunai->lokasiCod)
                    <h4 class="text-success">{{ $tarikTunai->lokasiCod->nama_lokasi }}</h4>
                    <p class="mb-2">
                        <i class="fas fa-map-marker-alt text-danger mr-2"></i>
                        {{ $tarikTunai->lokasiCod->alamat }}
                    </p>

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

                    @if($lokasiImage)
                    <div class="text-center">
                        <img src="{{ $lokasiImage }}" class="img-fluid rounded" alt="Lokasi" style="max-height: 250px;">
                    </div>
                    @endif

                    @if($tarikTunai->lokasiCod->latitude && $tarikTunai->lokasiCod->longitude)
                    <div class="mt-3">
                        <a href="https://www.google.com/maps?q={{ $tarikTunai->lokasiCod->latitude }},{{ $tarikTunai->lokasiCod->longitude }}"
                            target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-map mr-1"></i> Buka di Google Maps
                        </a>
                    </div>
                    @endif
                    @else
                    <p class="text-muted">Lokasi tidak tersedia</p>
                    @endif
                </div>
            </div>

            <!-- Card Timeline -->
            <div class="card card-outline card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-2"></i>
                        Timeline Proses
                    </h3>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <!-- Diterima -->
                        <div class="timeline-item active">
                            <div class="timeline-icon">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Ditugaskan kepada Anda</h6>
                                <p class="text-muted mb-0">{{ $tarikTunai->updated_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <!-- Dalam Perjalanan -->
                        <div class="timeline-item {{ $tarikTunai->waktu_dalam_perjalanan ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-walking"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Dalam Perjalanan</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->waktu_dalam_perjalanan)
                                    {{ $tarikTunai->waktu_dalam_perjalanan->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                    @else
                                    Belum dimulai
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Menunggu Serah Terima -->
                        <div class="timeline-item {{ $tarikTunai->waktu_diserahkan ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Menunggu Serah Terima</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->waktu_diserahkan)
                                    {{ $tarikTunai->waktu_diserahkan->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                    @else
                                    Belum
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Selesai -->
                        <div class="timeline-item {{ $tarikTunai->waktu_selesai ? 'active' : '' }}">
                            <div class="timeline-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="timeline-content">
                                <h6>Selesai</h6>
                                <p class="text-muted mb-0">
                                    @if($tarikTunai->waktu_selesai)
                                    {{ $tarikTunai->waktu_selesai->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                                    @else
                                    Belum selesai
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi & Bukti -->
        <div class="col-lg-4">
            <!-- Card Aksi -->
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-2"></i>
                        Aksi Petugas
                    </h3>
                </div>
                <div class="card-body">
                    <!-- Update Status -->
                    @if($tarikTunai->status !== 'selesai')
                    <form action="{{ route('petugas.tariktunai.update-status', $tarikTunai) }}" method="POST" class="mb-3">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Update Status</label>
                            <select class="form-control" name="status" required>
                                @if($tarikTunai->status === 'diproses')
                                <option value="dalam_perjalanan">Dalam Perjalanan</option>
                                @elseif($tarikTunai->status === 'dalam_perjalanan')
                                <option value="menunggu_serah_terima">Menunggu Serah Terima</option>
                                @elseif($tarikTunai->status === 'menunggu_serah_terima')
                                <option value="selesai">Selesai</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan (Opsional)</label>
                            <textarea class="form-control" name="catatan_petugas" rows="2" 
                                placeholder="Tambahkan catatan...">{{ old('catatan_petugas', $tarikTunai->catatan_petugas) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-1"></i> Update Status
                        </button>
                    </form>
                    @endif

                  <!-- Ganti kode form upload bukti di bagian ini: -->
@if(in_array($tarikTunai->status, ['menunggu_serah_terima', 'selesai', 'dalam_perjalanan']))
<div class="card card-outline card-warning mb-4">
    <div class="card-header">
        <h5 class="card-title">
            <i class="fas fa-camera mr-2"></i>
            Upload Bukti Serah Terima
        </h5>
    </div>
    <div class="card-body">
        <!-- TAMBAHKAN action dan method di sini -->
        <form id="uploadBuktiForm" action="{{ route('petugas.tariktunai.upload-bukti', $tarikTunai) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Foto Bukti Serah Terima *</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="bukti_serah_terima" 
                           name="bukti_serah_terima_petugas" accept="image/*" required>
                    <label class="custom-file-label" for="bukti_serah_terima">Pilih file gambar</label>
                </div>
                <small class="form-text text-muted">
                    Format: JPG, PNG, GIF (Maks. 2MB). Pastikan foto jelas menunjukkan proses serah terima.
                </small>
                <!-- Error message container -->
                <div id="file-error" class="invalid-feedback"></div>
            </div>
            <div class="form-group">
                <label>Catatan Serah Terima</label>
                <textarea class="form-control" id="catatan_serah_terima" name="catatan_serah_terima" 
                          rows="3" placeholder="Contoh: Uang telah diserahkan kepada customer bernama {{ $tarikTunai->user->name ?? 'customer' }} di lokasi yang ditentukan...">
                    {{ old('catatan_serah_terima', $tarikTunai->catatan_serah_terima) }}
                </textarea>
            </div>
            <div class="alert alert-info">
                <i class="fas fa-info-circle mr-2"></i>
                Setelah upload bukti, status transaksi akan otomatis berubah menjadi "Selesai".
            </div>
            <button type="submit" class="btn btn-success btn-block" id="uploadBuktiBtn">
                <i class="fas fa-upload mr-1"></i> Upload Bukti
            </button>
        </form>
    </div>
</div>
@endif

                    <!-- Mark as Selesai -->
                    @if($tarikTunai->status === 'menunggu_serah_terima')
                    <form action="{{ route('petugas.tariktunai.mark-selesai', $tarikTunai) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="konfirmasi" name="konfirmasi" value="1" required>
                            <label class="form-check-label" for="konfirmasi">
                                Konfirmasi uang telah diserahkan
                            </label>
                        </div>
                        <button type="submit" class="btn btn-success btn-block mt-2">
                            <i class="fas fa-check-circle mr-1"></i> Tandai Selesai
                        </button>
                    </form>
                    @endif

                    <!-- Download QRIS -->
                    @if($tarikTunai->paymentMethod && $tarikTunai->paymentMethod->qris_image)
                    <div class="mt-3">
                        <a href="{{ route('petugas.tariktunai.download-qris', $tarikTunai) }}" class="btn btn-outline-primary btn-block">
                            <i class="fas fa-download mr-1"></i> Download QRIS
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card Bukti -->
            @if($tarikTunai->bukti_serah_terima_petugas)
            <div class="card card-outline card-success mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-check-circle mr-2"></i>
                        Bukti Serah Terima
                    </h3>
                </div>
                <div class="card-body text-center">
                    <img src="{{ asset('storage/' . $tarikTunai->bukti_serah_terima_petugas) }}"
                        class="img-fluid rounded"
                        alt="Bukti Serah Terima"
                        style="max-height: 200px;">
                    @if($tarikTunai->waktu_upload_bukti_petugas)
                    <p class="text-muted mt-2 mb-0">
                        Diupload: {{ $tarikTunai->waktu_upload_bukti_petugas->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                    </p>
                    @endif
                    @if($tarikTunai->catatan_serah_terima)
                    <div class="alert alert-light border mt-2">
                        <small>{{ $tarikTunai->catatan_serah_terima }}</small>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Card Catatan -->
            @if($tarikTunai->catatan_petugas || $tarikTunai->catatan_serah_terima)
            <div class="card card-outline card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-sticky-note mr-2"></i>
                        Catatan
                    </h3>
                </div>
                <div class="card-body">
                    @if($tarikTunai->catatan_petugas)
                    <h6>Catatan Proses:</h6>
                    <p class="mb-3">{{ $tarikTunai->catatan_petugas }}</p>
                    @endif

                    @if($tarikTunai->catatan_serah_terima)
                    <h6>Catatan Serah Terima:</h6>
                    <p class="mb-0">{{ $tarikTunai->catatan_serah_terima }}</p>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
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
        background-color: #17a2b8;
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

    .card-outline {
        border-top: 4px solid;
        border-radius: 10px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // File input label
        $('.custom-file-input').on('change', function() {
            var fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').html(fileName);
        });

        // AJAX Upload Bukti
        $('#uploadBuktiForm').submit(function(e) {
            e.preventDefault();
            
            var formData = new FormData(this);
            var btn = $('#uploadBuktiBtn');
            var originalText = btn.html();
            
            // Disable button dan tampilkan loading
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');
            
            $.ajax({
                url: "{{ route('petugas.tariktunai.upload-bukti', $tarikTunai) }}",
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        // Tampilkan pesan sukses
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                            confirmButtonColor: '#3085d6',
                            timer: 2000,
                            timerProgressBar: true
                        }).then((result) => {
                            // Redirect ke dashboard setelah 2 detik atau setelah klik OK
                            window.location.href = response.redirect_url;
                        });
                    } else {
                        // Tampilkan pesan error dari server
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: response.message,
                            confirmButtonColor: '#d33',
                        });
                        
                        // Enable button kembali
                        btn.prop('disabled', false);
                        btn.html(originalText);
                    }
                },
                error: function(xhr) {
                    // Tampilkan pesan error
                    var errorMessage = 'Gagal mengupload bukti.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 413) {
                        errorMessage = 'File terlalu besar. Maksimal 2MB.';
                    } else if (xhr.status === 422) {
                        errorMessage = 'Format file tidak valid. Gunakan JPG, JPEG, atau PNG.';
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage,
                        confirmButtonColor: '#d33',
                    });
                    
                    // Enable button kembali
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            });
        });
    });
</script>
<script>
$(document).ready(function() {
    // File input label
    $('.custom-file-input').on('change', function() {
        var fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').html(fileName);
    });

    // AJAX Upload Bukti - FIXED VERSION
    $('#uploadBuktiForm').submit(function(e) {
        e.preventDefault();
        
        var formData = new FormData(this);
        var btn = $('#uploadBuktiBtn');
        var originalText = btn.html();
        
        // Disable button dan tampilkan loading
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');
        
        // Debug: Cek form data
        console.log('Form Data:');
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }
        
        // Ambil route dari form action atau gunakan default
        var url = $(this).attr('action') || '{{ route("petugas.tariktunai.upload-bukti", $tarikTunai) }}';
        
        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Response:', response);
                
                if (response.success) {
                    // Tampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonColor: '#28a745',
                        timer: 3000,
                        timerProgressBar: true,
                        showConfirmButton: false
                    }).then(() => {
                        // Redirect ke dashboard
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            window.location.reload();
                        }
                    });
                } else {
                    // Tampilkan pesan error dari server
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message,
                        confirmButtonColor: '#dc3545',
                    });
                    
                    // Enable button kembali
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr.responseText);
                
                // Tampilkan pesan error
                var errorMessage = 'Gagal mengupload bukti.';
                var response = xhr.responseJSON;
                
                if (response && response.message) {
                    errorMessage = response.message;
                } else if (xhr.status === 413) {
                    errorMessage = 'File terlalu besar. Maksimal 2MB.';
                } else if (xhr.status === 422) {
                    if (response && response.errors) {
                        var errors = [];
                        for (var key in response.errors) {
                            errors.push(response.errors[key].join(', '));
                        }
                        errorMessage = 'Validasi gagal: ' + errors.join(', ');
                    } else {
                        errorMessage = 'Format file tidak valid. Gunakan JPG, PNG, atau GIF.';
                    }
                } else if (xhr.status === 403) {
                    errorMessage = 'Anda tidak berhak mengupload bukti untuk transaksi ini.';
                } else if (xhr.status === 404) {
                    errorMessage = 'Endpoint tidak ditemukan. Pastikan route sudah terdaftar.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#dc3545',
                });
                
                // Enable button kembali
                btn.prop('disabled', false);
                btn.html(originalText);
            },
            complete: function() {
                console.log('AJAX request complete');
            }
        });
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // File input label - FIX VERSION
    $(document).on('change', '.custom-file-input', function() {
        var fileName = $(this).val().split('\\').pop();
        if (fileName) {
            $(this).next('.custom-file-label').html(fileName);
        } else {
            $(this).next('.custom-file-label').html('Pilih file gambar');
        }
    });

    // AJAX Upload Bukti - IMPROVED VERSION
    $('#uploadBuktiForm').submit(function(e) {
        e.preventDefault();
        
        // Reset error state
        $('.custom-file-input').removeClass('is-invalid');
        $('#file-error').text('');
        
        var formData = new FormData(this);
        var btn = $('#uploadBuktiBtn');
        var originalText = btn.html();
        
        // Validate file size
        var fileInput = document.getElementById('bukti_serah_terima');
        if (fileInput.files.length > 0) {
            var fileSize = fileInput.files[0].size; // in bytes
            var maxSize = 2 * 1024 * 1024; // 2MB
            
            if (fileSize > maxSize) {
                $('.custom-file-input').addClass('is-invalid');
                $('#file-error').text('File terlalu besar. Maksimal 2MB.');
                return false;
            }
            
            // Validate file type
            var validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            var fileType = fileInput.files[0].type;
            
            if (!validTypes.includes(fileType)) {
                $('.custom-file-input').addClass('is-invalid');
                $('#file-error').text('Format file tidak valid. Gunakan JPG, PNG, atau GIF.');
                return false;
            }
        } else {
            $('.custom-file-input').addClass('is-invalid');
            $('#file-error').text('Silakan pilih file gambar terlebih dahulu.');
            return false;
        }
        
        // Disable button dan tampilkan loading
        btn.prop('disabled', true);
        btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Uploading...');
        
        // Get CSRF token
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        if (csrfToken) {
            formData.append('_token', csrfToken);
        }
        
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(response) {
                console.log('Success Response:', response);
                
                if (response.success) {
                    // Tampilkan pesan sukses
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        confirmButtonColor: '#28a745',
                        showConfirmButton: true,
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (response.redirect_url) {
                                window.location.href = response.redirect_url;
                            } else {
                                window.location.reload();
                            }
                        }
                    });
                } else {
                    // Tampilkan pesan error dari server
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response.message || 'Terjadi kesalahan',
                        confirmButtonColor: '#dc3545',
                    });
                    
                    // Enable button kembali
                    btn.prop('disabled', false);
                    btn.html(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', xhr);
                
                // Tampilkan pesan error
                var errorMessage = 'Gagal mengupload bukti.';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    if (xhr.responseJSON.errors) {
                        var errors = [];
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errors.push(value);
                        });
                        errorMessage = errors.join(', ');
                    }
                } else if (xhr.status === 413) {
                    errorMessage = 'File terlalu besar. Maksimal 2MB.';
                } else if (xhr.status === 422) {
                    errorMessage = 'Data tidak valid. Silakan periksa kembali.';
                } else if (xhr.status === 500) {
                    errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonColor: '#dc3545',
                });
                
                // Enable button kembali
                btn.prop('disabled', false);
                btn.html(originalText);
            }
        });
    });
    
    // Hapus form "Mark as Selesai" jika menggunakan upload bukti AJAX
    // Karena form ini bisa menyebabkan konflik
    @if(in_array($tarikTunai->status, ['menunggu_serah_terima', 'selesai', 'dalam_perjalanan']))
        $('form[action*="mark-selesai"]').remove();
    @endif
});
</script>
@endsection
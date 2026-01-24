@extends('layout.petugas.petugas')

@section('title', 'Dashboard Petugas - Tarik Tunai')

@section('content')
<div class="container-fluid">

    <!-- Main Content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Tugas Tarik Tunai</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari transaksi...">
                            <div class="input-group-append">
                                <button class="btn btn-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card-body p-0">
                    @if($tarikTunais->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">Belum ada tugas</h4>
                            <p class="text-muted">Tunggu sampai admin menugaskan transaksi kepada Anda</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Kode</th>
                                        <th style="width: 15%">Customer</th>
                                        <th style="width: 12%">Jumlah</th>
                                        <th style="width: 15%">Lokasi</th>
                                        <th style="width: 12%">Status</th>
                                        <th style="width: 12%">Bukti</th>
                                        <th style="width: 12%">Timeline</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tarikTunais as $transaksi)
                                    <tr>
                                        <td>
                                            <span class="badge badge-secondary">{{ $transaksi->kode_transaksi }}</span>
                                        </td>
                                        <td>
                                            @if($transaksi->user)
                                                <div class="d-flex align-items-center">
                                                    <i class="fas fa-user mr-2 text-primary"></i>
                                                    <div>
                                                        <strong>{{ $transaksi->user->name }}</strong><br>
                                                        <small class="text-muted">{{ $transaksi->user->email }}</small>
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-primary">Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</strong>
                                            @if($transaksi->biaya_admin > 0)
                                                <br><small class="text-warning">+Rp {{ number_format($transaksi->biaya_admin, 0, ',', '.') }} admin</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($transaksi->lokasiCod)
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-info view-location-btn"
                                                        data-id="{{ $transaksi->id }}"
                                                        title="Lihat Detail Lokasi">
                                                    <i class="fas fa-map-marker-alt"></i> {{ $transaksi->lokasiCod->nama_lokasi }}
                                                </button>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'secondary',
                                                    'menunggu_admin' => 'secondary',
                                                    'menunggu_pembayaran' => 'info',
                                                    'menunggu_verifikasi_admin' => 'info',
                                                    'diproses' => 'warning',
                                                    'dalam_perjalanan' => 'info',
                                                    'menunggu_serah_terima' => 'primary',
                                                    'selesai' => 'success',
                                                    'dibatalkan_customer' => 'danger',
                                                    'dibatalkan_admin' => 'danger'
                                                ];
                                                
                                                $statusTexts = [
                                                    'pending' => 'Pending',
                                                    'menunggu_admin' => 'Menunggu Admin',
                                                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                                    'menunggu_verifikasi_admin' => 'Menunggu Verifikasi',
                                                    'diproses' => 'Diproses',
                                                    'dalam_perjalanan' => 'Dalam Perjalanan',
                                                    'menunggu_serah_terima' => 'Menunggu Serah Terima',
                                                    'selesai' => 'Selesai',
                                                    'dibatalkan_customer' => 'Dibatalkan Customer',
                                                    'dibatalkan_admin' => 'Dibatalkan Admin'
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $statusColors[$transaksi->status] ?? 'secondary' }}">
                                                {{ $statusTexts[$transaksi->status] ?? $transaksi->status }}
                                            </span>
                                        </td>
                                        <!-- KOLOM BUKTI - PERBAIKAN -->
<!-- KOLOM BUKTI - PERBAIKAN -->
<td class="align-middle">
    @if($transaksi->bukti_serah_terima_petugas)
        <div class="text-center">
            <!-- Thumbnail gambar bukti serah terima -->
            <button type="button" 
                    class="btn btn-sm btn-outline-success view-bukti-btn p-0 border-0 bg-transparent d-block mx-auto"
                    data-url="{{ Storage::url($transaksi->bukti_serah_terima_petugas) }}"
                    data-waktu="{{ $transaksi->waktu_upload_bukti_petugas ? $transaksi->waktu_upload_bukti_petugas->timezone('Asia/Jakarta')->format('d/m/Y H:i') : '' }}"
                    data-catatan="{{ $transaksi->catatan_serah_terima }}"
                    title="Lihat Bukti Serah Terima"
                    style="cursor: pointer; border: none; background: transparent;">
                <div style="width: 40px; height: 40px; overflow: hidden; border-radius: 5px; border: 2px solid #28a745; margin: 0 auto;">
                    <img src="{{ Storage::url($transaksi->bukti_serah_terima_petugas) }}" 
                         alt="Bukti Serah Terima"
                         style="width: 100%; height: 100%; object-fit: cover;"
                         onerror="this.src='{{ asset('images/no-image.png') }}'">
                </div>
            </button>
            
            @if($transaksi->waktu_upload_bukti_petugas)
                <div class="mt-1">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        {{ $transaksi->waktu_upload_bukti_petugas->timezone('Asia/Jakarta')->format('d/m H:i') }}
                    </small>
                </div>
            @endif
        </div>
    @elseif(in_array($transaksi->status, ['menunggu_serah_terima', 'dalam_perjalanan', 'diproses', 'selesai']))
        <!-- BELUM UPLOAD BUKTI -->
        <div class="text-center">
            <div class="mb-1">
                <span class="badge badge-warning" style="font-size: 0.7rem;">
                    <i class="fas fa-clock"></i> Belum
                </span>
            </div>
            
            @if(in_array($transaksi->status, ['menunggu_serah_terima', 'dalam_perjalanan', 'diproses']))
                <div>
                    <a href="{{ route('petugas.tariktunai.show', $transaksi->id) }}" 
                       class="btn btn-sm btn-success" 
                       style="font-size: 0.7rem; padding: 2px 8px;"
                       title="Upload Bukti">
                        <i class="fas fa-upload mr-1"></i> Upload
                    </a>
                </div>
            @endif
            
            @if($transaksi->status === 'selesai')
                <div class="mt-1">
                    <small class="text-danger" style="font-size: 0.7rem;">
                        <i class="fas fa-exclamation-circle"></i> Perlu
                    </small>
                </div>
            @endif
        </div>
    @else
        <!-- TIDAK PERLU BUKTI -->
        <div class="text-center">
            <span class="text-muted">-</span>
        </div>
    @endif
</td>
                                        <td>
                                            @if($transaksi->waktu_dalam_perjalanan)
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i> 
                                                    {{ optional($transaksi->waktu_dalam_perjalanan)->timezone('Asia/Jakarta')->format('H:i') ?? '-' }}
                                                </small>
                                            @endif
                                            @if($transaksi->waktu_selesai)
                                                <br><small class="text-success">
                                                    <i class="fas fa-check"></i> 
                                                    Selesai: {{ optional($transaksi->waktu_selesai)->timezone('Asia/Jakarta')->format('H:i') ?? '-' }}
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('petugas.tariktunai.show', $transaksi->id) }}"  
                                                   class="btn btn-sm btn-info" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                
                                                @if(in_array($transaksi->status, ['diproses', 'dalam_perjalanan', 'menunggu_serah_terima']))
                                                    <button type="button" 
                                                            class="btn btn-sm btn-primary update-status-btn"
                                                            data-id="{{ $transaksi->id }}"
                                                            data-status="{{ $transaksi->status }}"
                                                            title="Update Status">
                                                        <i class="fas fa-sync-alt"></i>
                                                    </button>
                                                @endif
                                                
                                                @if(in_array($transaksi->status, ['menunggu_serah_terima', 'dalam_perjalanan', 'diproses', 'selesai']) && !$transaksi->bukti_serah_terima_petugas)
                                                    <a href="{{ route('petugas.tariktunai.show', $transaksi->id) }}"  
                                                       class="btn btn-sm btn-success" title="Upload Bukti">
                                                        <i class="fas fa-upload"></i>
                                                    </a>
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
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Lokasi -->
<div class="modal fade" id="locationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-map-marker-alt mr-2"></i>Detail Lokasi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="locationDetailContent">
                    <!-- Content akan diisi oleh JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Update Status -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="statusForm" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Update Status Transaksi</h5>
                    <button type="button" class="close text-white" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="statusSelect">Status Baru</label>
                        <select class="form-control" id="statusSelect" name="status" required>
                            <!-- Options akan diisi oleh JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="catatan_petugas">Catatan (Opsional)</label>
                        <textarea class="form-control" id="catatan_petugas" name="catatan_petugas" rows="3" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Lihat Bukti -->
<div class="modal fade" id="viewBuktiModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-file-image mr-2"></i>Bukti Serah Terima
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="buktiImage" src="" class="img-fluid rounded" alt="Bukti Serah Terima" style="max-height: 400px;">
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-calendar-alt mr-2"></i>Waktu Upload:</strong> 
                           <span id="buktiWaktu"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-user mr-2"></i>Diupload oleh:</strong> 
                           {{ Auth::user()->name }}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label><strong><i class="fas fa-sticky-note mr-2"></i>Catatan Serah Terima:</strong></label>
                    <div id="buktiCatatan" class="alert alert-light border p-3">
                        <!-- Catatan akan diisi oleh JavaScript -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="downloadBukti" href="#" class="btn btn-primary" download>
                    <i class="fas fa-download mr-2"></i>Download
                </a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<style>
.small-box {
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.small-box .inner {
    padding: 20px;
}

.small-box .icon {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 70px;
    opacity: 0.3;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,123,255,0.05);
}

.badge {
    font-size: 0.8em;
    padding: 5px 10px;
}

.view-bukti-btn:hover {
    text-decoration: none;
    opacity: 0.8;
}
</style>

<script>
$(document).ready(function() {
    // Search functionality
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $('table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });

    // View location detail
    $(document).on('click', '.view-location-btn', function() {
        var transaksiId = $(this).data('id');
        
        $.ajax({
            url: '/petugas/tarik-tunai/' + transaksiId + '/location-detail',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    var data = response.data;
                    var html = `
                        <h5 class="text-primary">${data.lokasi.nama_lokasi}</h5>
                        <p><strong><i class="fas fa-map-marker-alt mr-2"></i>Alamat:</strong> ${data.lokasi.alamat}</p>
                        ${data.lokasi.area_detail ? `<p><strong><i class="fas fa-info-circle mr-2"></i>Detail Area:</strong> ${data.lokasi.area_detail}</p>` : ''}
                        ${data.lokasi.jam_operasional ? `<p><strong><i class="fas fa-clock mr-2"></i>Jam Operasional:</strong> ${data.lokasi.jam_operacional}</p>` : ''}
                        ${data.lokasi.telepon ? `<p><strong><i class="fas fa-phone mr-2"></i>Telepon:</strong> ${data.lokasi.telepon}</p>` : ''}
                        
                        <hr>
                        <h6>Informasi Customer</h6>
                        <p><strong><i class="fas fa-user mr-2"></i>Nama:</strong> ${data.customer.name}</p>
                        <p><strong><i class="fas fa-envelope mr-2"></i>Email:</strong> ${data.customer.email}</p>
                        <p><strong><i class="fas fa-money-bill-wave mr-2"></i>Jumlah:</strong> Rp ${data.transaksi.jumlah}</p>
                        <p><strong><i class="fas fa-coins mr-2"></i>Biaya Admin:</strong> Rp ${data.transaksi.biaya_admin}</p>
                        
                        ${data.lokasi.gambar_url ? `
                            <hr>
                            <h6>Gambar Lokasi</h6>
                            <img src="${data.lokasi.gambar_url}" class="img-fluid rounded" alt="Lokasi">
                        ` : ''}
                    `;
                    
                    $('#locationDetailContent').html(html);
                    $('#locationModal').modal('show');
                } else {
                    $('#locationDetailContent').html('<div class="alert alert-danger">' + response.error + '</div>');
                    $('#locationModal').modal('show');
                }
            },
            error: function(xhr) {
                $('#locationDetailContent').html('<div class="alert alert-danger">Gagal memuat data lokasi</div>');
                $('#locationModal').modal('show');
            }
        });
    });

    // Update status
    $(document).on('click', '.update-status-btn', function() {
        var transaksiId = $(this).data('id');
        var currentStatus = $(this).data('status');
        
        console.log('Update Status:', transaksiId, currentStatus);
        
        // Set form action
        $('#statusForm').attr('action', '/petugas/tarik-tunai/' + transaksiId + '/status');
        
        // Set status options berdasarkan current status
        var statusOptions = {
            'diproses': ['Dalam Perjalanan'],
            'dalam_perjalanan': ['Menunggu Serah Terima'],
            'menunggu_serah_terima': ['Selesai']
        };
        
        var optionsHtml = '';
        if (statusOptions[currentStatus]) {
            statusOptions[currentStatus].forEach(function(statusText) {
                var statusValue = statusText.toLowerCase().replace(/ /g, '_');
                optionsHtml += `<option value="${statusValue}">${statusText}</option>`;
            });
        } else {
            optionsHtml = '<option value="">Tidak ada status yang tersedia</option>';
        }
        
        $('#statusSelect').html(optionsHtml);
        $('#catatan_petugas').val('');
        $('#statusModal').modal('show');
    });

    // Lihat bukti di modal
    $(document).on('click', '.view-bukti-btn', function() {
        var imageUrl = $(this).data('url');
        var waktuUpload = $(this).data('waktu');
        var catatan = $(this).data('catatan');
        
        // Set data ke modal
        $('#buktiImage').attr('src', imageUrl);
        $('#buktiWaktu').text(waktuUpload || 'Tidak ada data waktu');
        $('#buktiCatatan').text(catatan || 'Tidak ada catatan');
        $('#downloadBukti').attr('href', imageUrl);
        
        // Tampilkan modal
        $('#viewBuktiModal').modal('show');
    });
    
    // SweetAlert for messages
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: "{{ session('success') }}",
            confirmButtonColor: '#28a745'
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: "{{ session('error') }}",
            confirmButtonColor: '#dc3545'
        });
    @endif
});

</script>
@endsection
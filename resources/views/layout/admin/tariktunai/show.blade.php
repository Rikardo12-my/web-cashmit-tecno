@extends('layout.admin.master')

@section('title', 'Detail Transaksi Tarik Tunai')

@section('css')
<style>
    .transaction-header {
        background: linear-gradient(135deg, #4a90e2 0%, #2c6bb3 100%);
        color: white;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
    }
    
    .info-card {
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    
    .info-card .card-header {
        background-color: #f8fbff;
        border-bottom: 2px solid #e8f4ff;
    }
    
    .user-avatar-lg {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid white;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .action-timeline {
        position: relative;
        padding-left: 30px;
    }
    
    .action-timeline::before {
        content: '';
        position: absolute;
        left: 10px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -25px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #4a90e2;
        border: 2px solid white;
        box-shadow: 0 0 0 3px #e8f4ff;
    }
    
    .evidence-image {
        max-width: 300px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .evidence-image:hover {
        transform: scale(1.05);
    }
    
    .status-badge-lg {
        padding: 8px 20px;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
    }
    
    .badge-pending { background: #fff3cd; color: #856404; }
    .badge-diproses { background: #cce5ff; color: #004085; }
    .badge-menunggu_petugas { background: #d4edda; color: #155724; }
    .badge-dalam_perjalanan { background: #fff3cd; color: #856404; }
    .badge-selesai { background: #d1ecf1; color: #0c5460; }
    .badge-dibatalkan { background: #f8d7da; color: #721c24; }
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
                        <i class="fas fa-file-invoice-dollar mr-2 text-primary"></i>
                        Detail Transaksi
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.tariktunai.index') }}">Tarik Tunai</a></li>
                        <li class="breadcrumb-item active">Detail #{{ $transaction->id }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Transaction Header -->
            <div class="transaction-header">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($transaction->user->name) }}&background=fff&color=4a90e2&size=80" 
                                 class="user-avatar-lg mr-4">
                            <div>
                                <h2 class="mb-1">{{ $transaction->user->name }}</h2>
                                <p class="mb-1">
                                    <i class="fas fa-envelope mr-2"></i>{{ $transaction->user->email }}
                                </p>
                                <p class="mb-0">
                                    <i class="fas fa-calendar mr-2"></i>
                                    Dibuat: {{ $transaction->created_at->format('d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="display-4 font-weight-bold">
                            Rp {{ number_format($transaction->jumlah, 0, ',', '.') }}
                        </div>
                        <span class="status-badge-lg badge-{{ $transaction->status }}">
                            {{ $transaction->getStatusLabelAttribute()['label'] }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="btn-group" role="group">
                        <a href="{{ route('admin.tariktunai.edit', $transaction->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        
                        @if(in_array($transaction->status, ['pending', 'menunggu_petugas']))
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assignModal">
                            <i class="fas fa-user-tag mr-2"></i> Assign Petugas
                        </button>
                        @endif
                        
                        @if($transaction->status == 'dalam_perjalanan')
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#completeModal">
                            <i class="fas fa-check-circle mr-2"></i> Tandai Selesai
                        </button>
                        @endif
                        
                        @if(!in_array($transaction->status, ['selesai', 'dibatalkan']))
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#cancelModal">
                            <i class="fas fa-times-circle mr-2"></i> Batalkan
                        </button>
                        @endif
                        
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog mr-2"></i> Lainnya
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="#" onclick="window.print()">
                                    <i class="fas fa-print mr-2"></i> Cetak
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-share-alt mr-2"></i> Bagikan
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#deleteModal">
                                    <i class="fas fa-trash mr-2"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Left Column: Transaction Details -->
                <div class="col-md-8">
                    <!-- Basic Information Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-info-circle mr-2 text-primary"></i>
                                Informasi Transaksi
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">ID Transaksi</th>
                                            <td>#{{ $transaction->id }}</td>
                                        </tr>
                                        <tr>
                                            <th>Customer</th>
                                            <td>{{ $transaction->user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $transaction->user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Telepon</th>
                                            <td>{{ $transaction->user->phone ?? '-' }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-borderless">
                                        <tr>
                                            <th width="40%">Metode Pembayaran</th>
                                            <td>
                                                <span class="badge badge-info">
                                                    {{ $transaction->paymentMethod->nama ?? 'N/A' }}
                                                </span>
                                            </td>
                                        </tr>
                                        @if($transaction->lokasiCod)
                                        <tr>
                                            <th>Lokasi COD</th>
                                            <td>
                                                {{ $transaction->lokasiCod->nama }}<br>
                                                <small class="text-muted">{{ $transaction->lokasiCod->alamat }}</small>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th>Petugas</th>
                                            <td>
                                                @if($transaction->petugas)
                                                <span class="badge badge-success">
                                                    {{ $transaction->petugas->name }}
                                                </span>
                                                @else
                                                <span class="badge badge-secondary">
                                                    Belum ditugaskan
                                                </span>
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Evidence Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-file-image mr-2 text-primary"></i>
                                Bukti Pembayaran
                            </h3>
                        </div>
                        <div class="card-body">
                            @if($transaction->bukti_bayar_customer)
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Bukti Bayar Customer</h6>
                                    <img src="{{ $transaction->getBuktiBayarUrlAttribute() }}" 
                                         class="evidence-image" 
                                         data-toggle="modal" 
                                         data-target="#imageModal"
                                         data-image="{{ $transaction->getBuktiBayarUrlAttribute() }}"
                                         data-title="Bukti Bayar Customer">
                                    <p class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock mr-1"></i>
                                            Diupload saat pembuatan transaksi
                                        </small>
                                    </p>
                                </div>
                                @if($transaction->bukti_serah_terima_petugas)
                                <div class="col-md-6">
                                    <h6>Bukti Serah Terima</h6>
                                    <img src="{{ $transaction->getBuktiSerahTerimaUrlAttribute() }}" 
                                         class="evidence-image" 
                                         data-toggle="modal" 
                                         data-target="#imageModal"
                                         data-image="{{ $transaction->getBuktiSerahTerimaUrlAttribute() }}"
                                         data-title="Bukti Serah Terima">
                                    <p class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock mr-1"></i>
                                            Diupload: {{ $transaction->waktu_diserahkan ? $transaction->waktu_diserahkan->format('d F Y H:i') : '-' }}
                                        </small>
                                    </p>
                                </div>
                                @endif
                            </div>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <h5>Tidak ada bukti pembayaran</h5>
                                <p class="text-muted">Customer belum mengupload bukti pembayaran</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Right Column: Actions & History -->
                <div class="col-md-4">
                    <!-- Status Actions Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-sync-alt mr-2 text-primary"></i>
                                Ubah Status
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.tariktunai.update-status', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group">
                                    <label for="status">Status Saat Ini</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="diproses" {{ $transaction->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="menunggu_petugas" {{ $transaction->status == 'menunggu_petugas' ? 'selected' : '' }}>Menunggu Petugas</option>
                                        <option value="dalam_perjalanan" {{ $transaction->status == 'dalam_perjalanan' ? 'selected' : '' }}>Dalam Perjalanan</option>
                                        <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan" {{ $transaction->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="catatan_admin">Catatan</label>
                                    <textarea name="catatan_admin" 
                                              id="catatan_admin" 
                                              class="form-control" 
                                              rows="3"
                                              placeholder="Tambahkan catatan perubahan status...">{{ old('catatan_admin', $transaction->catatan_admin) }}</textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block">
                                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Activity Timeline Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-2 text-primary"></i>
                                Riwayat Aktivitas
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="action-timeline">
                                <div class="timeline-item">
                                    <h6 class="mb-1">Transaksi Dibuat</h6>
                                    <p class="text-muted mb-1">
                                        <i class="far fa-calendar mr-1"></i>
                                        {{ $transaction->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                                
                                @if($transaction->petugas)
                                <div class="timeline-item">
                                    <h6 class="mb-1">Petugas Ditugaskan</h6>
                                    <p class="text-muted mb-1">
                                        <i class="fas fa-user-tag mr-1"></i>
                                        {{ $transaction->petugas->name }}
                                    </p>
                                </div>
                                @endif
                                
                                @if($transaction->waktu_diserahkan)
                                <div class="timeline-item">
                                    <h6 class="mb-1">Transaksi Selesai</h6>
                                    <p class="text-muted mb-1">
                                        <i class="far fa-check-circle mr-1"></i>
                                        {{ $transaction->waktu_diserahkan->format('d M Y H:i') }}
                                    </p>
                                </div>
                                @endif
                                
                                @if($transaction->catatan_admin)
                                <div class="timeline-item">
                                    <h6 class="mb-1">Catatan Admin</h6>
                                    <p class="text-muted mb-1">
                                        <i class="far fa-sticky-note mr-1"></i>
                                        {{ Str::limit($transaction->catatan_admin, 50) }}
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Information Card -->
                    <div class="card info-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-exclamation-circle mr-2 text-primary"></i>
                                Informasi Penting
                            </h3>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success mr-2"></i>
                                    <strong>Transaksi Aman:</strong> Sistem sudah terverifikasi
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-shield-alt text-warning mr-2"></i>
                                    <strong>Data Terenkripsi:</strong> Semua data dilindungi
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-history text-info mr-2"></i>
                                    <strong>Riwayat Lengkap:</strong> Semua aktivitas tercatat
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-user-check text-primary mr-2"></i>
                                    <strong>Petugas Terverifikasi:</strong> Semua petugas telah diverifikasi
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modals -->

<!-- Assign Petugas Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-tag mr-2"></i>
                    Assign Petugas
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tariktunai.assign-petugas', $transaction->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="modal_petugas_id">Pilih Petugas</label>
                        <select name="petugas_id" id="modal_petugas_id" class="form-control" required>
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($petugasList as $petugas)
                                <option value="{{ $petugas->id }}">{{ $petugas->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Assign</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Complete Transaction Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle mr-2"></i>
                    Tandai Sebagai Selesai
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tariktunai.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="selesai">
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Pastikan petugas sudah menyerahkan uang tunai ke customer sebelum menandai selesai.
                    </div>
                    
                    <div class="form-group">
                        <label for="bukti_serah_terima_petugas">Upload Bukti Serah Terima (Opsional)</label>
                        <input type="file" 
                               class="form-control-file" 
                               id="bukti_serah_terima_petugas" 
                               name="bukti_serah_terima_petugas"
                               accept="image/*">
                        <small class="text-muted">Format: JPG, JPEG, PNG | Maks: 2MB</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="waktu_diserahkan">Waktu Diserahkan</label>
                        <input type="datetime-local" 
                               name="waktu_diserahkan" 
                               id="waktu_diserahkan"
                               class="form-control"
                               value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>
                    
                    <div class="form-group">
                        <label for="complete_catatan">Catatan</label>
                        <textarea name="catatan_admin" 
                                  id="complete_catatan" 
                                  class="form-control" 
                                  rows="3"
                                  placeholder="Tambahkan catatan penyelesaian transaksi..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Tandai Selesai</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cancel Transaction Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle mr-2"></i>
                    Batalkan Transaksi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tariktunai.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="dibatalkan">
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>PERHATIAN!</strong> Transaksi yang dibatalkan tidak dapat dikembalikan.
                    </div>
                    
                    <div class="form-group">
                        <label for="cancel_reason">Alasan Pembatalan <span class="text-danger">*</span></label>
                        <textarea name="catatan_admin" 
                                  id="cancel_reason" 
                                  class="form-control" 
                                  rows="4"
                                  placeholder="Jelaskan alasan pembatalan transaksi..."
                                  required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Ya, Batalkan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-trash-alt mr-2"></i>
                    Hapus Transaksi
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.tariktunai.destroy', $transaction->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body text-center">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-3"></i>
                    <h4>Apakah Anda yakin?</h4>
                    <p class="text-muted">
                        Transaksi #{{ $transaction->id }} akan dihapus permanen. 
                        Data tidak dapat dikembalikan!
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak, Kembali</button>
                    <button type="submit" class="btn btn-danger">Ya, Hapus Permanen</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalTitle">Preview Gambar</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Preview" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
$(document).ready(function() {
    // Image Modal
    $('#imageModal').on('show.bs.modal', function(event) {
        const button = $(event.relatedTarget);
        const imageSrc = button.data('image');
        const imageTitle = button.data('title');
        
        const modal = $(this);
        modal.find('#modalImage').attr('src', imageSrc);
        modal.find('#imageModalTitle').text(imageTitle);
    });
    
    // Set current datetime for completion modal
    $('#waktu_diserahkan').val(new Date().toISOString().slice(0, 16));
    
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
});
</script>
@endsection
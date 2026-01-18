<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TarikTunai extends Model
{
    use HasFactory;

    protected $table = 'tarik_tunais';

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'kode_transaksi',
        'user_id',
        'petugas_id',
        'assigned_by',
        'jumlah',
        'biaya_admin',
        'total_dibayar',
        'payment_method_id',
        'lokasi_cod_id',
        'bukti_bayar_customer',
        'waktu_upload_bukti_customer',
        'bukti_serah_terima_petugas',
        'waktu_upload_bukti_petugas', 
        'waktu_diproses',
        'waktu_dalam_perjalanan',
        'waktu_diserahkan',
        'waktu_verifikasi_qris', // TAMBAH INI
        'waktu_selesai',
        'waktu_dibatalkan',
        'status',
        'catatan_admin',
        'catatan_petugas',
        'catatan_customer',
        'catatan_serah_terima',
        'is_qris_cod', // TAMBAH INI
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'waktu_upload_bukti_customer' => 'datetime',
        'waktu_upload_bukti_petugas' => 'datetime',
        'waktu_diproses' => 'datetime',
        'waktu_dalam_perjalanan' => 'datetime',
        'waktu_diserahkan' => 'datetime',
        'waktu_verifikasi_qris' => 'datetime', // TAMBAH INI
        'waktu_selesai' => 'datetime',
        'waktu_dibatalkan' => 'datetime',
        'is_qris_cod' => 'boolean', // TAMBAH INI
    ];

    /**
     * Auto generate kode transaksi saat create
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->kode_transaksi)) {
                $model->kode_transaksi = self::generateKodeTransaksi();
            }
            
            // Auto set is_qris_cod berdasarkan payment method
            if ($model->payment_method_id) {
                $paymentMethod = PaymentMethod::find($model->payment_method_id);
                if ($paymentMethod && $paymentMethod->nama === 'QRIS COD') {
                    $model->is_qris_cod = true;
                }
            }
        });
        
        static::updated(function ($model) {
            // Update is_qris_cod jika payment method berubah
            if ($model->isDirty('payment_method_id')) {
                $paymentMethod = PaymentMethod::find($model->payment_method_id);
                if ($paymentMethod && $paymentMethod->nama === 'QRIS COD') {
                    $model->is_qris_cod = true;
                } else {
                    $model->is_qris_cod = false;
                }
                $model->saveQuietly(); // Save tanpa memicu event lagi
            }
        });
    }

    /**
     * Generate kode transaksi unik
     * Contoh: TT-2026-00001
     */
    public static function generateKodeTransaksi()
    {
        $year = date('Y');

        $last = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $number = $last ? ((int) substr($last->kode_transaksi, -5)) + 1 : 1;

        return 'TT-' . $year . '-' . str_pad($number, 5, '0', STR_PAD_LEFT);
    }

    // ==========================================
    // RELATIONSHIP
    // ==========================================

    /**
     * Customer yang melakukan tarik tunai
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Petugas yang mengantar uang
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    /**
     * Admin yang assign petugas
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Metode pembayaran
     */
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    /**
     * Lokasi COD
     */
    public function lokasiCod()
    {
        return $this->belongsTo(LokasiCod::class, 'lokasi_cod_id');
    }

    // ==========================================
    // HELPER METHOD STATUS
    // ==========================================

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSelesai()
    {
        return $this->status === 'selesai';
    }

    public function isDibatalkan()
    {
        return in_array($this->status, ['dibatalkan_customer', 'dibatalkan_admin']);
    }
    
    public function isMenungguVerifikasiQRIS()
    {
        return $this->status === 'menunggu_verifikasi_qris';
    }
    
    public function isQRISCOD()
    {
        return $this->is_qris_cod || 
               ($this->paymentMethod && $this->paymentMethod->nama === 'QRIS COD');
    }

    // ==========================================
    // SCOPE QUERY
    // ==========================================
    
    /**
     * Scope untuk QRIS COD
     */
    public function scopeQrisCod($query)
    {
        return $query->where('is_qris_cod', true);
    }
    
    /**
     * Scope untuk non-QRIS COD
     */
    public function scopeNonQrisCod($query)
    {
        return $query->where('is_qris_cod', false);
    }
    
    /**
     * Scope untuk transaksi yang menunggu verifikasi QRIS
     */
    public function scopeMenungguVerifikasiQris($query)
    {
        return $query->where('status', 'menunggu_verifikasi_qris');
    }
    
    /**
     * Scope untuk transaksi berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        if (is_array($status)) {
            return $query->whereIn('status', $status);
        }
        return $query->where('status', $status);
    }

    // ==========================================
    // CUSTOM ATTRIBUTES
    // ==========================================
    
    /**
     * Attribute untuk menampilkan nama status yang lebih user-friendly
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Pending',
            'menunggu_admin' => 'Menunggu Admin',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi_admin' => 'Menunggu Verifikasi Admin',
            'menunggu_verifikasi_qris' => 'Menunggu Verifikasi QRIS',
            'diproses' => 'Diproses',
            'dalam_perjalanan' => 'Dalam Perjalanan',
            'menunggu_serah_terima' => 'Menunggu Serah Terima',
            'selesai' => 'Selesai',
            'dibatalkan_customer' => 'Dibatalkan Customer',
            'dibatalkan_admin' => 'Dibatalkan Admin',
        ];
        
        return $labels[$this->status] ?? $this->status;
    }
    
    /**
     * Attribute untuk menampilkan warna badge berdasarkan status
     */
    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'secondary',
            'menunggu_admin' => 'warning',
            'menunggu_pembayaran' => 'info',
            'menunggu_verifikasi_admin' => 'purple',
            'menunggu_verifikasi_qris' => 'orange',
            'diproses' => 'primary',
            'dalam_perjalanan' => 'blue',
            'menunggu_serah_terima' => 'teal',
            'selesai' => 'success',
            'dibatalkan_customer' => 'danger',
            'dibatalkan_admin' => 'dark',
        ];
        
        return $colors[$this->status] ?? 'secondary';
    }
    
    /**
     * Attribute untuk mendapatkan timeline berdasarkan tipe transaksi
     */
    public function getTimelineStepsAttribute()
    {
        if ($this->isQRISCOD()) {
            return [
                'Dibuat' => $this->created_at,
                'Diproses Admin' => $this->waktu_diproses,
                'Dalam Perjalanan' => $this->waktu_dalam_perjalanan,
                'Serah Terima' => $this->waktu_diserahkan,
                'Verifikasi QRIS' => $this->waktu_verifikasi_qris,
                'Selesai' => $this->waktu_selesai,
                'Dibatalkan' => $this->waktu_dibatalkan,
            ];
        } else {
            return [
                'Dibuat' => $this->created_at,
                'Diproses Admin' => $this->waktu_diproses,
                'Dalam Perjalanan' => $this->waktu_dalam_perjalanan,
                'Serah Terima' => $this->waktu_diserahkan,
                'Selesai' => $this->waktu_selesai,
                'Dibatalkan' => $this->waktu_dibatalkan,
            ];
        }
    }
    
    /**
     * Attribute untuk mendapatkan current step pada timeline
     */
    public function getCurrentStepAttribute()
    {
        $step = 0;
        
        if ($this->isQRISCOD()) {
            switch($this->status) {
                case 'pending': $step = 1; break;
                case 'menunggu_admin': $step = 1; break;
                case 'diproses': $step = 2; break;
                case 'dalam_perjalanan': $step = 3; break;
                case 'menunggu_serah_terima': $step = 4; break;
                case 'menunggu_verifikasi_qris': $step = 5; break;
                case 'selesai': $step = 6; break;
                case 'dibatalkan_customer':
                case 'dibatalkan_admin': $step = 7; break;
            }
        } else {
            switch($this->status) {
                case 'pending': $step = 1; break;
                case 'menunggu_admin': $step = 1; break;
                case 'menunggu_pembayaran': $step = 1; break;
                case 'menunggu_verifikasi_admin': $step = 1; break;
                case 'diproses': $step = 2; break;
                case 'dalam_perjalanan': $step = 3; break;
                case 'menunggu_serah_terima': $step = 4; break;
                case 'selesai': $step = 5; break;
                case 'dibatalkan_customer':
                case 'dibatalkan_admin': $step = 6; break;
            }
        }
        
        return $step;
    }
}
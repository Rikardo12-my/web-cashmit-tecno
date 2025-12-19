<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TarikTunai extends Model
{
    protected $fillable = [
        'user_id',
        'petugas_id',
        'jumlah',
        'payment_method_id', // UBAH INI
        'lokasi_cod_id',
        'bukti_bayar_customer',
        'bukti_serah_terima_petugas',
        'waktu_diserahkan',
        'status',
        'catatan_admin'
    ];

    protected $casts = [
        'waktu_diserahkan' => 'datetime',
        'jumlah' => 'integer'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function paymentMethod() // UBAH INI
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    public function lokasiCod()
    {
        return $this->belongsTo(LokasiCod::class, 'lokasi_cod_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeDibatalkan($query)
    {
        return $query->where('status', 'dibatalkan');
    }

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    // Helpers
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => ['label' => 'Pending', 'color' => 'warning'],
            'diproses' => ['label' => 'Diproses', 'color' => 'info'],
            'menunggu_petugas' => ['label' => 'Menunggu Petugas', 'color' => 'primary'],
            'dalam_perjalanan' => ['label' => 'Dalam Perjalanan', 'color' => 'secondary'],
            'selesai' => ['label' => 'Selesai', 'color' => 'success'],
            'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'danger']
        ];

        return $labels[$this->status] ?? ['label' => $this->status, 'color' => 'secondary'];
    }

    public function getFormattedJumlahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    public function getBuktiBayarUrlAttribute()
    {
        return $this->bukti_bayar_customer 
            ? asset('storage/' . $this->bukti_bayar_customer)
            : null;
    }

    public function getBuktiSerahTerimaUrlAttribute()
    {
        return $this->bukti_serah_terima_petugas 
            ? asset('storage/' . $this->bukti_serah_terima_petugas)
            : null;
    }
}
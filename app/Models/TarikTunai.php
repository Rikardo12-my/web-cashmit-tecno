<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BankDompet;
use App\Models\LokasiCod;


class TarikTunai extends Model
{
    use HasFactory;

    protected $table = 'tarik_tunais';

    protected $fillable = [
        'user_id',
        'petugas_id',
        'jumlah',
        'metode_pembayaran',
        'bukti_bayar_customer',
        'bank_dompet_id',
        'lokasi_cod_id',
        'bukti_serah_terima_petugas',
        'waktu_diserahkan',
        'status',
        'catatan_admin',
    ];

    protected $casts = [
        'waktu_diserahkan' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
    public function bankDompet()
    {
        return $this->belongsTo(BankDompet::class, 'bank_dompet_id');
    }
    public function lokasiCod()
    {
        return $this->belongsTo(LokasiCod::class, 'lokasi_cod_id');
    }
}

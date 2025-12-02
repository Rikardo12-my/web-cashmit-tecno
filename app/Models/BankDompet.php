<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TarikTunai;
class BankDompet extends Model
{
    use HasFactory;

    protected $table = 'bank_dompets';

    protected $fillable = [
        'nama',
        'tipe',
        'kode',
        'nomor_rekening',
        'atas_nama',
        'gambar_qris',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Relasi ke transaksi tarik tunai (banyak transaksi bisa menggunakan 1 bank/e-wallet)
    public function tarikTunai()
    {
        return $this->hasMany(TarikTunai::class, 'bank_dompet_id');
    }
}

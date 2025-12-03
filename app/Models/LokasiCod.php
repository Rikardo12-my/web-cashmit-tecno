<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\TarikTunai;
class LokasiCod extends Model
{
    use HasFactory;

    protected $table = 'lokasi_cod';

    protected $fillable = [
        'nama_lokasi',
        'area_detail',
        'latitude',
        'longitude',
        'status',
    ];

    /**
     * Relasi: satu lokasi COD bisa dipakai banyak transaksi tarik tunai.
     */
    public function tarikTunai()
    {
        return $this->hasMany(TarikTunai::class, 'lokasi_cod_id');
    }
}

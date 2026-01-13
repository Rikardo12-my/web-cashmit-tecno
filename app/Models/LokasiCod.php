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
        'gambar', // Tambah di fillable
        'status',
    ];

    /**
     * Relasi: satu lokasi COD bisa dipakai banyak transaksi tarik tunai.
     */
    public function tarikTunai()
    {
        return $this->hasMany(TarikTunai::class, 'lokasi_cod_id');
    }

    /**
     * Accessor untuk URL gambar
     */
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            return asset('storage/lokasi-cod/' . $this->gambar);
        }
        return asset('images/default-location.jpg'); // Gambar default
    }

    /**
     * Accessor untuk thumbnail gambar
     */
    public function getGambarThumbnailAttribute()
    {
        if ($this->gambar) {
            return asset('storage/lokasi-cod/thumbnails/' . $this->gambar);
        }
        return asset('images/default-location-thumb.jpg');
    }
}
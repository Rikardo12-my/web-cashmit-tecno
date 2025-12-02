<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TarikTunai;
class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';

    protected $fillable = [
        'nama',
        'kategori',
        'is_active',
        'deskripsi',
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // Satu payment method dapat digunakan pada banyak transaksi tarik tunai
    public function tarikTunai()
    {
        return $this->hasMany(TarikTunai::class, 'payment_method_id');
    }
}

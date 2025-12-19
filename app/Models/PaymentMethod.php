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
        'qris_image',
        'account_name',
        'account_number',
        'provider',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tarikTunai()
    {
        return $this->hasMany(TarikTunai::class, 'payment_method_id');
    }

    public function isQris()
    {
        return in_array($this->kategori, ['bank_qris', 'qris_cod']);
    }

    public function qrisImageUrl()
    {
        return $this->qris_image
            ? asset('storage/' . $this->qris_image)
            : null;
    }
}

<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    // Tentukan kolom yang dapat diisi
    protected $fillable = [
        'code',
        'discount_amount',
        'expiry_date',
        'is_active',
    ];

    // Aksesors untuk mendapatkan format tanggal
    public function getExpiryDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d-m-Y'); // Format tanggal
    }

    // Aksesors untuk mendapatkan diskon dalam format mata uang
    public function getDiscountAmountRupiahAttribute()
    {
        return "Rp " . number_format($this->discount_amount, 0, ',', '.');
    }
    
    // Jika ingin menambahkan relasi, bisa ditambahkan di sini
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'alamat_id',
        'metode_pembayaran',
        'bukti_pembayaran',
        'status',
    ];

    // Relasi: pesanan milik 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: pesanan punya 1 alamat
    public function alamat()
    {
        return $this->belongsTo(UserAddress::class, 'alamat_id');
    }

    // Relasi: pesanan punya banyak detail produk
    public function detailProduk()
    {
        return $this->hasMany(detail_pesanan::class, 'pesanan_id');
    }

    // Relasi: pesanan punya 1 metode pembayaran
    public function metodePembayaran()
    {
        return $this->belongsTo(MetodePembayaran::class, 'metode_pembayaran', 'id');
    }
}

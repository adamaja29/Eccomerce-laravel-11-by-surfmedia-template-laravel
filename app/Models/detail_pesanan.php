<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class detail_pesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'sub_total',
        'stok_awal',
        'stok_akhir',
    ];

    // Relasi: detail milik 1 pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    // Relasi: detail mengacu ke 1 produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}

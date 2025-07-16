<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $table = 'pembelian';

    protected $fillable = [
        'supplier_id', 'tanggal_pembelian', 'nomor_invoice', 'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Suppliers::class);
    }

    public function detailPembelian()
    {
        return $this->hasMany(DetailPembelian::class,);
    }
}

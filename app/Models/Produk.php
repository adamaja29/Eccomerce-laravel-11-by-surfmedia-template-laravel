<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    public function Kategori(){
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function detail_pesanan()
{
    return $this->hasMany(detail_pesanan::class, 'produk_id');
}

    public function suppliers()
    {
        return $this->belongsTo(Suppliers::class, 'supplier_id');
    }
}

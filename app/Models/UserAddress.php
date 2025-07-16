<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'user_id',
        'label',
        'nama_penerima',
        'phone',
        'full_address',
        'kecamatan',
        'kota',
        'provinsi',
        'kode_post',
    ];

    public function user()
{
    return $this->belongsTo(User::class);
}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Produk;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'produk_id', 'quantity'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Produk::class);
    }
    // App\Models\Cart.php

public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

}


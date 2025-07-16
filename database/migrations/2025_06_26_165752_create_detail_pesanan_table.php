<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pesanan_id');    // Foreign key ke tabel pesanan
            $table->unsignedBigInteger('produk_id');      // Foreign key ke tabel produk
            $table->integer('jumlah');                    // Jumlah produk yang dipesan
            $table->decimal('harga_satuan', 10, 2);       // Harga per item saat dipesan
            $table->decimal('subtotal', 12, 2);  
            $table->integer('stok_awal')->default(0);
            $table->integer('stok_akhir')->nullable(0);         // jumlah * harga_satuan
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};

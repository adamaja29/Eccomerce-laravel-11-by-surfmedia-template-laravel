<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label')->default('Rumah'); // contoh: Rumah, Kantor, Kos
            $table->string('nama_penerima'); // nama penerima
            $table->string('phone'); // no HP penerima
            $table->text('full_address'); // alamat lengkap
            $table->string('kecamatan')->nullable(); // negara, default Indonesia
            $table->string('kota')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kode_post')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}

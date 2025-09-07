<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tanahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode')->nullable();
            $table->string('nomor_register')->nullable();
            $table->string('luas')->nullable();
            $table->string('tahun_pengadaan')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('nomor')->nullable();
            $table->string('penggunaan')->nullable();
            $table->string('asal_usul')->nullable();
            $table->string('harga')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('pemeliharaan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tanahs');
    }
};

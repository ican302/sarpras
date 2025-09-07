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
        Schema::create('bangunans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_bangunan');
            $table->string('kode_bangunan')->nullable();
            $table->string('nomor_register')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('bertingkat')->nullable();
            $table->string('beton')->nullable();
            $table->string('luas')->nullable();
            $table->string('luas_lantai')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('nomor')->nullable();
            $table->date('tanggal')->nullable();
            $table->string('status_tanah')->nullable();
            $table->string('kode_tanah')->nullable();
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
        Schema::dropIfExists('bangunans');
    }
};

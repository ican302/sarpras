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
        Schema::create('saranas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('kategori');
            $table->string('kode_barang')->nullable();
            $table->string('kode_sekolah')->nullable();
            $table->string('spesifikasi')->nullable();
            $table->string('satuan')->nullable();
            $table->string('sumber_dana')->nullable();
            $table->integer('harga')->nullable();
            $table->date('tanggal_masuk')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('kondisi')->nullable();
            $table->integer('jumlah')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('service')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saranas');
    }
};

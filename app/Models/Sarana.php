<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sarana extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_barang',
        'kategori',
        'kode_barang',
        'kode_sekolah',
        'spesifikasi',
        'satuan',
        'sumber_dana',
        'harga',
        'tanggal_masuk',
        'lokasi',
        'kondisi',
        'jumlah',
        'keterangan',
        'service',
    ];

    public function getNamaAttribute()
    {
        return $this->nama_barang;
    }

    public function getKodeAttribute()
    {
        return $this->kode_barang;
    }

    public function penyewaans()
    {
        return $this->morphMany(Penyewaan::class, 'penyewaanable');
    }
}

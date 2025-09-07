<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bangunan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bangunan',
        'kode_bangunan',
        'nomor_register',
        'kondisi',
        'bertingkat',
        'beton',
        'luas',
        'luas_lantai',
        'lokasi',
        'nomor',
        'tanggal',
        'status_tanah',
        'kode_tanah',
        'asal_usul',
        'harga',
        'keterangan',
        'pemeliharaan',
    ];

    public function getNamaAttribute()
    {
        return $this->nama_bangunan;
    }

    public function getKodeAttribute()
    {
        return $this->kode_bangunan;
    }

    public function penyewaans()
    {
        return $this->morphMany(Penyewaan::class, 'penyewaanable');
    }
}

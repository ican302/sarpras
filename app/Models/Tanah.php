<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'kode',
        'nomor_register',
        'luas',
        'tahun_pengadaan',
        'lokasi',
        'status_tanah',
        'tanggal',
        'nomor',
        'penggunaan',
        'asal_usul',
        'harga',
        'keterangan',
        'pemeliharaan',
    ];

    public function getNamaAttribute()
    {
        return $this->attributes['nama'];
    }

    public function getKodeAttribute()
    {
        return $this->attributes['kode'];
    }

    public function penyewaans()
    {
        return $this->morphMany(Penyewaan::class, 'penyewaanable');
    }
}

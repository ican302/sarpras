<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    protected $fillable = [
        'penyewaanable_type',
        'penyewaanable_id',
        'jumlah',
        'harga',
        'keterangan',
    ];

    public function penyewaanable()
    {
        return $this->morphTo();
    }
}

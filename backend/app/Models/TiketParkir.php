<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TiketParkir extends Model
{
    protected $fillable = [
        'kode_tiket',
        'plat_nomor',
        'kategori',
        'waktu_masuk',
        'status',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'nama',
        'plat_nomor',
        'no_telp',
        'status',
        'tanggal_mulai',
        'tanggal_berakhir',
        'nominal',
    ];
}

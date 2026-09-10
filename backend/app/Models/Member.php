<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'kode_member',
        'token',
        'nama_member',
        'nama_perusahaan',
        'total_harga',
        'jumlah_bayar',
        'kembalian',
        'status',
        'tanggal_mulai',
        'tanggal_expired',
        'tanggal_bayar',
        'tanggal_reset',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'datetime',
        'tanggal_expired' => 'datetime',
        'tanggal_bayar'   => 'datetime',
        'tanggal_reset'   => 'date',
    ];
}
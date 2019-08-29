<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $primaryKey = 'voucher_id';
    protected $fillable = [
        'kode_voucher',
        'nama',
        'deskripsi',
        'type',
        'value',
        'limit_voucher',
        'tanggal_mulai',
        'tanggal_selesai'
    ];
}

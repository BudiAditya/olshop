<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $primaryKey = 'alamat_id';

    protected $fillable = [
        'customer_id',
        'nama_depan',
        'nama_belakang',
        'nama_perusahaan',
        'alamat',
        'no_hp',
        'kode_rajaongkir'
    ];
}

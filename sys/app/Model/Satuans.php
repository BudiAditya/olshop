<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Satuans extends Model
{
    protected $primaryKey = 'satuan_id';

    protected $fillable = [
        'satuan_nama',
        'satuan_deskripsi'
    ];

}

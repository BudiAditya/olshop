<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kategoris extends Model
{
    protected $primaryKey = 'kategori_id';

    protected $fillable = [
        'kategori_nama',
        'kategori_deskripsi',
        'kategori_gambar'
    ];

    public function Products() {
        return $this->hasMany('App\Model\Products', 'kategori_id');
    }
}

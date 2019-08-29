<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable  = [
        'nama',
        'deskripsi',
        'kategori_id',
        'satuan_id',
        'tag_id',
        'stok',
        'berat',
        'harga_beli',
        'harga_jual',
        'gambar',
        'rating',
        'dilihat'
    ];

    public function Kategori() {
        return $this->belongsTo('App\Model\Kategoris', 'kategori_id', 'kategori_id');
    }

    public function Satuan() {
        return $this->belongsTo('App\Model\Satuans', 'satuan_id', 'satuan_id');
    }

    public function Tag() {
        return $this->belongsTo('App\Model\Tags', 'tag_id', 'tag_id');
    }
    
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    protected $fillable = [
        'transaksi_id',
        'product_id',
        'quantity',
        'harga_jual',
        'diskon'
    ];

    public function Produk() {
        return $this->belongsTo('App\Model\Products', 'product_id', 'id');
    }
}

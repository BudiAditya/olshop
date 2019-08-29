<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Carts extends Model
{
    protected $fillable = [
        'customer_id',
        'product_id',
        'quantity',
    ];

    public function Produk() {
        return $this->belongsTo('App\Model\Products', 'product_id', 'id');
    }

    public static function getAll(){
        $cart = Carts::all();
        return $cart;
    }
}

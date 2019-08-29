<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $primaryKey = 'transaksi_id';
    protected $fillable = [
        'customer_id',
        'is_guest',
        'alamat_id',
        'status_pembayaran',
        'status_transaksi',
        'jenis_pembayaran',
        'voucher',
        'diskon',
        'harga_beli',
        'total_transaksi',
        'catatan',
        'no_resi'
    ];

    public function Alamat() {
        return $this->belongsTo(Alamat::class, 'alamat_id', 'alamat_id');
    }

    public function TransaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class, 'transaksi_id', 'transaksi_id')->with('Produk');
    }
}


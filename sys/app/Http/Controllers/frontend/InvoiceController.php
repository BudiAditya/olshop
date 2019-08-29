<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Transaksi;
use App\Model\Config;
use App\Model\Carts;

class InvoiceController extends Controller
{
    public function index($id){
        $transaksi = Transaksi::find($id);
        $config = Config::all();
        $carts = Carts::all();

        // return $transaksi;
        return view('frontend.invoice', compact('transaksi', 'config', 'carts'));
    }
}

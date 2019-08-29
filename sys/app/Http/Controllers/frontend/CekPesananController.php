<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Transaksi;

class CekPesananController extends Controller
{
    
    public function index(){
        return view('frontend.cekstatuspesanan');
    }

    public function cekPesanan(Request $request){
        $no = $request->post('no_pesanan');
        $transaksi = Transaksi::with( 'TransaksiDetail', 'Alamat')->find($no);

        if($transaksi->Alamat->no_hp == $request->post('no_hp')){
            return  Response()->json($transaksi);
        }else{   
            return null;
        }
    }
}

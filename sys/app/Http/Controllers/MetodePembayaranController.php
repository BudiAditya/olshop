<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use BCAParser\BCAParser;
use App\Model\Config;


class MetodePembayaranController extends Controller
{
    public function index(){
        return view('admin.metodepembayaran');
    }

    public function cekSaldo(){
        $username = config('setting.UserBCA');
        $password = config('setting.PassBCA');
        
        $Parser = new BCAParser($username, $password);
        $data = $Parser->getSaldo();
        $Parser->logout();

        return $data;
    }
    
    public function getMutasiRekening(Request $request){
        $username = config('setting.UserBCA');
        $password = config('setting.PassBCA');
        
        $Parser = new BCAParser($username, $password);
        $data = $Parser->getMutasiRekening($request->post('dari_tanggal'), $request->post('sampai_tanggal'));
        $Parser->logout();

        return $data;
    }

    public function changeBCA(Request $request){
        foreach($request->except('_token') as $key => $value){
            $config = Config::where('nama', $key)->first();
            $config->value = $value;
            $config->save();
        };

        return redirect()->back()->with('success', 'Data berhasil diubah');

    }
 
}

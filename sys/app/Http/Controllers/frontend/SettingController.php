<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Alamat;
use App\Model\Carts;
use Auth;
use Hash;
use App\User;

class SettingController extends Controller
{
    public function pengaturan(){
        $carts = Carts::all();
        $alamats = Alamat::where('customer_id', Auth::user()->id)->get();

        return view('frontend.setting', compact('carts', 'alamats'));
    }

    public function profil(){
        $carts = Carts::all();

        return view('frontend.setting', compact('carts'));
    }

    public function tambahAlamat(Request $request){
        $alamat = new Alamat();
        $alamat->customer_id         = Auth::user()->id;
        $alamat->nama_depan          = $request->post('nama_depan');
        $alamat->nama_belakang       = $request->post('nama_belakang');
        $alamat->nama_perusahaan     = $request->post('nama_perusahaan');
        $alamat->alamat              = $request->post('alamat');
        $alamat->provinsi            = $request->post('provinsi');
        $alamat->kota                = $request->post('kota');
        $alamat->kecamatan           = $request->post('kecamatan');
        $alamat->kode_pos            = $request->post('kode_pos');
        $alamat->no_hp               = $request->post('no_hp');
        $alamat->kode_rajaongkir     = $request->post('rajaongkir');
        $alamat->save();

        return redirect()->back()->with('alamat', 'Alamat berhasil ditambahkan');
    }

    public function updateProfil(Request $request){
        $user = User::find(Auth::user()->id);
        $user->name     = $request->post('name');
        $user->no_hp    = $request->post('no_hp');
        $user->bio      = $request->post('bio');
        $user->save();

        return redirect('pengaturan')->with('profil', 'Profil berhasil diubah');        
    }

    public function updateProfilGambar(Request $request){
        if($request->hasfile('gambar'))
        {
            $nama = 'profil.'.$request->file('gambar')->extension();
            $request->file('gambar')->move(public_path()."/img/", $nama);  
        }

        $user = User::find(Auth::user()->id);
        $user->gambar = $nama;
        $user->save();

        return redirect('pengaturan')->with('profil', 'Foto Profil berhasil diubah');        
    }

    public function updatePassword(Request $request){
        $current_password = Auth::User()->password;           
        if(Hash::check($request->post('password_lama'), $current_password)){           
            $user = User::find(Auth::User()->id);
            $user->password = Hash::make($request->post('password_baru'));;
            $user->save(); 
            
            return redirect('pengaturan')->with('password', 'Password berhasil diubah');        
        }else{           
            return redirect('pengaturan')->with('password', 'Password Lama Salah!');        
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Config;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;

class ConfigController extends Controller
{
    public function index(){
        $configs = Config::where('nama', 'NOT LIKE', ['%BCA'])->get();
        return view('admin.config', compact('configs'));
    }

    public function updateLogo(Request $request){
        if($request->hasfile('gambar'))
        {
            $nama = 'logo.'.$request->file('gambar')->extension();
            $request->file('gambar')->move(public_path()."/img/", $nama);  
        }

        return redirect('admin-panel/pengaturan')->with('success', 'Logo berhasil diubah');        
    }

    public function updateFavicon(Request $request){
        if($request->hasfile('gambar'))
        {
            $nama = 'favicon.'.$request->file('gambar')->extension();
            $request->file('gambar')->move(public_path()."/img/", $nama);  
        }

        return redirect('admin-panel/pengaturan')->with('success', 'Favicon berhasil diubah');        
    }

    public function updatePengaturan(Request $request){
        
        foreach($request->except('_token') as $key => $value){
            $config = Config::where('nama', $key)->first();
            $config->value = $value;
            $config->save();
        };

        return redirect('admin-panel/pengaturan')->with('success', 'Pengaturan berhasil diubah');
    }

    public function showRegisterAdminForm()
    {
        $users = User::where('is_admin', 1)->paginate(10);
        return view('admin.addadmin', compact('users'));
    }

    protected function createAdmin(request $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'no_hp' => $data['no_hp'],
            'email' => $data['email'],
            'is_admin' => 1,
            'password' => Hash::make($data['password']),
        ]);

        Mail::to($data['email'])->send(new RegisterMail());

        return redirect()->back()->with('success', 'Admin berhasil ditambah');
    }
}

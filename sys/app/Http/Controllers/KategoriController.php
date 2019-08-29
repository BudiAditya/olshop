<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Kategoris;

class KategoriController extends Controller
{
   // Daftar Kategori
   public function index(){
        $kategori = Kategoris::paginate(5);
        
        return view('admin.kategori.daftar', compact('kategori'));
    }

    // Tambah Kategori
    public function TambahProduk()
    {   
        return view('admin.kategori.tambah');
    }

    public function ProsesTambahProduk(Request $request){
        $validator = $this->validator($request->all());

        if($request->hasfile('gambar'))
        {
            $nama_gambar= md5(date('Y m d H:i:s')).'.'.$request->file('gambar')[0]->extension();
            $request->file('gambar')[0]->move(public_path()."/gambar_kategori/", $nama_gambar);  
        }else{
            $nama_gambar = "";
        }
        
        $kategori = new Kategoris();
        $kategori->kategori_nama        = $request->post('nama');
        $kategori->kategori_deskripsi   = $request->post('deskripsi');
        $kategori->kategori_gambar      = $nama_gambar;
        $kategori->save();

        return redirect('kategori/tambah')->with('success', 'Kategori berhasil disimpan');
    }


    // Edit Kategori
    public function EditProduk($id)
    {
        $kategori = Kategoris::find($id);

        return view('admin.kategori.edit', compact('kategori'));
    }

    public function ProsesEditProduk(Request $request){
        $validator = $this->validator($request->all());

        if($request->hasfile('gambar'))
        {
            $nama_gambar= md5(date('Y m d H:i:s')).'.'.$request->file('gambar')[0]->extension();
            $request->file('gambar')[0]->move(public_path()."/gambar_kategori/", $nama_gambar);  
        }else{
            $nama_gambar = "";
        }

        $id = $request->post('id');
        $kategori = Kategoris::find($id);
        $kategori->kategori_nama        = $request->post('nama');
        $kategori->kategori_deskripsi   = $request->post('deskripsi');
        if($request->hasfile('gambar')){
            $kategori->kategori_gambar = $nama_gambar;
        };
        $kategori->save();
        
        return redirect('kategori/edit/'.$id)->with('success', 'Kategori berhasil diubah');
    }

    // Hapus Kategori
    public function HapusProduk($id){
        Kategoris::where('kategori_id', $id)->delete();

        return redirect('kategori')->with('success', 'Kategori berhasil dihapus');
    }

    protected function validator(array $data){
        $rules = [
            'nama'        => 'required|max:40',
        ];
        $messages = [
            'required' => ':attribute wajib di isi',
            'max'      => ':attribute terlalu panjang',
        ];
        return Validator::make($data, $rules, $messages)->validate();
    }
}

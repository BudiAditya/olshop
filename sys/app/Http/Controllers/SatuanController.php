<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Satuans;

class SatuanController extends Controller
{
    // Daftar satuan
    public function index(){
        $satuan = Satuans::paginate(3);

        return view('admin.satuan.daftar', compact('satuan'));
    }

    // Tambah satuan
    public function TambahProduk()
    {   
        return view('admin.satuan.tambah');
    }

    public function ProsesTambahProduk(Request $request){
        $validator = $this->validator($request->all());

        $satuan = new Satuans();
        $satuan->satuan_nama        = $request->post('nama');
        $satuan->satuan_deskripsi   = $request->post('deskripsi');
        $satuan->save();

        return redirect('satuan/tambah')->with('success', 'satuan berhasil disimpan');
    }


    // Edit satuan
    public function EditProduk($id)
    {
        $satuan = Satuans::find($id);

        return view('admin.satuan.edit', compact('satuan'));
    }

    public function ProsesEditProduk(Request $request){
        $validator = $this->validator($request->all());

        $id = $request->post('id');
        $satuan = satuans::find($id);
        $satuan->satuan_nama        = $request->post('nama');
        $satuan->satuan_deskripsi   = $request->post('deskripsi');
        $satuan->save();
        
        return redirect('satuan/edit/'.$id)->with('success', 'satuan berhasil diubah');
    }

    // Hapus satuan
    public function HapusProduk($id){
        Satuans::where('satuan_id', $id)->delete();

        return redirect('satuan')->with('success', 'satuan berhasil dihapus');
    }

    protected function validator(array $data){
        $rules = [
            'nama'        => 'required|max:40'
        ];
        $messages = [
            'required' => ':attribute wajib di isi',
            'max'      => ':attribute terlalu panjang',
        ];
        return Validator::make($data, $rules, $messages)->validate();
    }

}

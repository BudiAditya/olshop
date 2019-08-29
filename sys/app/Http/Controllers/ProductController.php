<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Products;
use App\Model\Kategoris;
use App\Model\Satuans;

class ProductController extends Controller
{
    // Daftar Produk
    public function index(){
        $product = Products::paginate(5);

        return view('admin.produk.daftar', compact('product'));
    }

    // Tambah Produk
    public function TambahProduk()
    {
        $kategori = Kategoris::all();
        $satuan = Satuans::all();
        
        return view('admin.produk.tambah', compact('kategori', 'satuan'));
    }

    public function ProsesTambahProduk(Request $request){
        $validator = $this->validator($request->all());

        if($request->hasfile('gambar'))
        {
            foreach($request->file('gambar') as $key => $gambar)
            {
                $nama= md5($key.date('Y m d H:i:s')).'.'.$gambar->extension();
                $gambar->move(public_path()."/gambar_produk/", $nama);  
                $data[] = $nama;
            }
        }
        
        $product = new Products();
        $product->nama        = $request->post('nama');
        $product->deskripsi   = $request->post('deskripsi');
        $product->kategori_id = $request->post('kategori');
        $product->satuan_id   = $request->post('satuan');
        $product->stok        = $request->post('stok');
        $product->berat       = $request->post('berat');
        $product->harga_beli  = $request->post('harga_beli');
        $product->harga_jual  = $request->post('harga_jual');
        $product->gambar      = implode(',', $data);
        $product->rating      = 0;
        $product->dilihat     = 0;
        $product->save();

        return redirect('produk/tambah')->with('success', 'Produk berhasil disimpan');
    }


    // Edit Produk
    public function EditProduk($id)
    {
        $product = Products::find($id);
        $kategori = Kategoris::all();
        $satuan = Satuans::all();

        return view('admin.produk.edit', compact('product', 'kategori', 'satuan') );
    }

    public function ProsesEditProduk(Request $request){
        $validator = $this->validator($request->all());

        $id = $request->post('id');
        $product = Products::find($id);
        $product->nama        = $request->post('nama');
        $product->deskripsi   = $request->post('deskripsi');
        $product->kategori_id = $request->post('kategori');
        $product->satuan_id   = $request->post('satuan');
        $product->stok        = $request->post('stok');
        $product->berat       = $request->post('berat');
        $product->harga_beli  = $request->post('harga_beli');
        $product->harga_jual  = $request->post('harga_jual');
        // $product->gambar      = implode(',', $data);
        $product->rating      = 0;
        $product->dilihat     = 0;
        $product->save();
        
        return redirect('produk/edit/'.$id)->with('success', 'Produk berhasil diubah');
    }

    // Hapus Produk
    public function HapusProduk($id){
        Products::where('id', $id)->delete();

        return redirect('produk')->with('success', 'Produk berhasil dihapus');
    }
    
    protected function validator(array $data){
        $rules = [
            'nama'        => 'required|max:255',
            'deskripsi'   => 'required',
            'kategori' => 'required',
            'satuan'   => 'required',
            'stok'        => 'required',
            'berat'       => 'required',
            'harga_beli'  => 'required',
            'harga_jual'  => 'required',
            'gambar'      => 'required'
        ];
        $messages = [
            'required' => ':attribute wajib di isi',
            'max'      => ':attribute terlalu panjang',
        ];
        return Validator::make($data, $rules, $messages)->validate();
    }
}

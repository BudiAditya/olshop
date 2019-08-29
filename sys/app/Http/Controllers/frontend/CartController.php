<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Products;
use App\Model\Carts;
use Auth;

class CartController extends Controller
{
    public function index(){

        if (Auth::user()){

            $carts = Carts::where('customer_id', Auth::user()->id)->get();
            return view('frontend.cart', compact('carts'));

        }else{

            return view('frontend.cart');
            
        }


    }

    public function tambah($id){

        $product = Products::find($id);
        if(!$product){
            abort(404);
        }

        if(Auth::user()){

            $cek = Carts::where('product_id', $id)->first();
            if($cek){
                // Jika produk sudah pernah ditambahkan quantity +1
                $keranjang = Carts::find($cek->id);
                $keranjang->quantity += 1;
                $keranjang->save();

            }else{
                // Jika produk belum di tambahkan di tabel keranjang
                $keranjang  = new Carts();
                $keranjang->customer_id = Auth::user()->id;
                $keranjang->product_id = $id;
                $keranjang->quantity = 1;
                $keranjang->save();
            }


        }else{

            $cart = session()->get('cart');

            if(!$cart){
                $cart[$id] = [
                    "nama"      => $product->nama,
                    "quantity"  => 1,
                    "berat"     => $product->berat,
                    "harga"     => $product->harga_jual,
                    "gambar"    => $product->gambar
                ];

                session()->put('cart', $cart);
                return redirect('/cart')->with('success', 'Products added to cart successfully');
            }

            if(isset($cart[$id])){
                $cart[$id]['quantity']++;

                session()->put('cart', $cart);

                return redirect('/cart')->with('success', 'Products added cart successfully');
            }

            $cart[$id] = [
                "nama"      => $product->nama,
                "quantity"  => 1,
                "berat"     => $product->berat,
                "harga"     => $product->harga_jual,
                "gambar"    => $product->gambar
            ];

            session()->put('cart', $cart);

        }

        return redirect('/cart')->with('success', 'Products added cart successfully');
    }

    public function edit(Request $request){

        if($request->id and $request->quantity){

            if (Auth::user()){

                $cek = Carts::where('product_id', $request->id)
                            ->where('customer_id', Auth::user()->id)
                            ->first();

                if($cek){
                    $keranjang = Carts::find($cek->id);
                    $keranjang->quantity = $request->quantity;
                    $keranjang->save();
                }

            }else{
                
                $cart = session()->get('cart');
                
                $cart[$request->id]['quantity'] = $request->quantity;
                
                session()->put('cart', $cart);
                
            }

            session()->flash('success', 'Cart updated successfully');

        }

    }

    public function hapus(Request $request){
        if($request->id){

            if (Auth::user()){

                $cek = Carts::where('product_id', $request->id)
                      ->where('customer_id', Auth::user()->id)
                      ->delete();

            }else{

                $cart = session()->get('cart');

                if(isset($cart[$request->id])){
                    
                    unset($cart[$request->id]);

                    session()->put('cart', $cart);
                }

            }

            session()->flash('success', 'Product removed successfully');
        }
    }


    // Temp, hapus untuk lihat ( development )
    public function show(){
        $cart = session()->get('cart');
        return $cart;
    }
    public function delete(){
        session()->forget('cart');
        return redirect('cart/show')->with('success', 'Products added cart successfully');
    }
}

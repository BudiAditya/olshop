<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Products;
use App\Model\Kategoris;
use App\Model\Carts;

class ShopController extends Controller
{
    public function index(Request $request){

        switch($request->order_by){
            case('termurah') :
                $column = 'harga_jual';
                $order ='ASC';
                break;
            case('termahal') :
                $column = 'harga_jual';
                $order ='DESC';
                break;
            default:
                $column = 'created_at';
                $order ='DESC';
                break;
        }

        $products = Products::when($request->keyword, function ($query) use ($request) {
            $query->where('nama', 'like', "%{$request->keyword}%")
                ->orWhere('deskripsi', 'like', "%{$request->keyword}%");
        })
        ->when($request->order_by,function($query) use ($request, $column, $order) {
            $query->orderBy( $column , $order);
        })
        ->paginate(8);

        $products->appends($request->only('keyword', 'order_by'));



        return view('frontend.shop', compact('products'));
    }

    public function detailproduk($id){
        $products = Products::find($id);
        $relatedproducts = Products::limit(8)
        ->where('kategori_id', $products->kategori_id)
        ->whereNotIn('id', [$products->id])
        ->get();

        return view('frontend.detail-product', compact('products', 'relatedproducts'));
    }

}

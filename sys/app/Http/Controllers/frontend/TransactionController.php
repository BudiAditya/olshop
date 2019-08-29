<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Transaksi;
use App\Model\TransaksiDetail;
use Auth;

class TransactionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $transaksi = Transaksi::all();
 
        $order_by = $request->orderby;
        if(!empty($order_by)){

            if ($order_by == 'pending'){
                $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('status_pembayaran', 'Menunggu Pembayaran')->where('customer_id', Auth::User()->id);
            }else if ($order_by == 'diproses') {
                $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('status_pembayaran', 'Sudah Bayar')->where('customer_id', Auth::User()->id);
            } else if ($order_by == 'dikirim') {
                $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('status_pengiriman', 'Sedang Dikirim')->where('customer_id', Auth::User()->id);
            } else if ($order_by == 'selesai') {            
                $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('status_pengiriman', 'Telah Sampai')->where('customer_id', Auth::User()->id);
            }else{
                $transaksi = new Transaksi;
            }

            $transaksi = $transaksi->orderBy('created_at', 'DESC')->where('customer_id', Auth::User()->id)->paginate(8)->appends(request()->except('page'));
        
        }else{
            $transaksi = Transaksi::orderBy('created_at', 'DESC')->where('customer_id', Auth::User()->id)->paginate(8);
        }

        $model = TransaksiDetail::all();
        return view('frontend.transaction', compact('transaksi'))->withModel($model);
    }
}
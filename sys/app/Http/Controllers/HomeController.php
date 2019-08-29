<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Transaksi;
use App\Model\TransaksiDetail;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $transaksi_today = Transaksi::whereDate('created_at', Carbon::today())->count();
        $omset = Transaksi::whereDate('created_at', Carbon::today())->sum('total_transaksi');
        $produkterjual = TransaksiDetail::whereDate('created_at', Carbon::today())->sum('quantity');

        $topproduk = TransaksiDetail::select('product_id',  \DB::raw('SUM(quantity) as quantity'))
        ->groupBy('product_id')
        ->whereDate('created_at', Carbon::today())
        ->orderBy('quantity', 'DESC')
        ->limit(5)
        ->get();

        return view('admin.dashboard', compact('transaksi_today', 'omset', 'produkterjual', 'topproduk'));
    }
}

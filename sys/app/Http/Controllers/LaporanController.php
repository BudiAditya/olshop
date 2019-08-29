<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Transaksi;
use App\Model\TransaksiDetail;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(){
        $laporan = Transaksi::whereDate('created_at', Carbon::today())->get();

        return view('admin.laporan.laporan', compact('laporan'));
    }

    public function laporanproduk(){
        $laporan = TransaksiDetail::select('product_id',  \DB::raw('SUM(quantity) as quantity'))
        ->groupBy('product_id')->whereDate('created_at', Carbon::today())
        ->get();

        return view('admin.laporan.laporanproduk', compact('laporan'));
    }
}

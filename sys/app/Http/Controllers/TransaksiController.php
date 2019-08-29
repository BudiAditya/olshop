<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Transaksi;
use App\Model\TransaksiDetail;
use App\Model\Config;
use BCAParser\BCAParser;
use PDF;
use Carbon\Carbon;


class TransaksiController extends Controller
{
    public function index(){
        $transaksi = Transaksi::where('status_pembayaran', 'Menunggu Pembayaran')->paginate(10);

        return view('admin.transaksi.daftar', compact('transaksi'));
    }

    public function detailTransaksi($id){
        $transaksi = Transaksi::find($id);

        return $transaksi;
    }

    public function konfirmasiPembayaran($id){
        $transaksi = Transaksi::find($id);
        $transaksi->status_pembayaran = "Sudah Bayar";
        $transaksi->status_pengiriman = "Sedang Diproses";
        $transaksi->status_transaksi = "PROSES";
        $transaksi->save();

        return redirect('admin-panel/transaksi/resi');
    }

    public function tolakPembayaran($id, Request $request){
        $transaksi = Transaksi::find($id);
        $transaksi->status_transaksi = "PROSES";
        $transaksi->status_pembayaran = "Sudah Bayar";
        $transaksi->save();

        return redirect();
    }

    public function resi(){
        $transaksi = Transaksi::where('status_transaksi', 'PROSES')->orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.transaksi.uploadresi', compact('transaksi'));
    }

    public function uploadresi(Request $request){
        $transaksi = Transaksi::find($request->post('id'));
        $transaksi->no_resi = $request->post('resi');
        $transaksi->status_pengiriman = "Sedang Dikirim";        
        $transaksi->save();

        return "success bos";
    }

    public function cekresi($noresi){

        $curl = curl_init();
        $options = [
            CURLOPT_URL => 'https://pro.rajaongkir.com/api/waybill',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "waybill=$noresi&courier=jne",
            CURLOPT_HTTPHEADER => array(
              "content-type: application/x-www-form-urlencoded",
              "key: 24e57029b197a799eb96fd5afea6d55f"
            ),
        ];
        curl_setopt_array($curl, $options);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            $result = json_decode($response, true);
            $result = $result["rajaongkir"]["result"];
            return $result;
        }

    }


    public function daftartransaksi(){
        $transaksi = Transaksi::paginate(10);

        return view('admin.transaksi.daftartransaksi', compact('transaksi'));
    }


    public function cekPembayaran(){
        $username = config('setting.UserBCA');
        $password = config('setting.PassBCA');
        
        $Parser = new BCAParser($username, $password);
        $data = $Parser->getListTransaksi(Carbon::today(), Carbon::today()->addDay(1));
        $Parser->logout();

        foreach($data as $val){
            $total_transaksi = intval(preg_replace('/[^\d.]/', '', end($val['description'])));

            $transaksi = Transaksi::where('total_transaksi', $total_transaksi)->where('created_at', Carbon::today())->first();
            if($transaksi){
                $transaksi->status_pembayaran = "Sudah Bayar";
                $transaksi->status_transaksi =  "PROSES";
                $transaksi->save();
            }
        }

        return redirect()->back();
    }

    public function cetakTransaksi($id){
        $array = array($id);
        $invoices = array();
        $arr = explode(",", $id);

        foreach($arr as $a){
            $data = Transaksi::with('TransaksiDetail')->where('transaksi_id', $a)->first();

            // echo json_encode($data);
            array_push($invoices, $data);
        }

        return view('admin.transaksi.cetaktransaksi', compact('invoices'));
    }

    public function konfirmasi_transaksiselesai($id){
        $transaksi = Transaksi::find($id);
        $transaksi->status_pengiriman =  "DELIVERED";
        $transaksi->status_transaksi  =  "SELESAI";
        $transaksi->save();

        if($transaksi){
            return json_encode(['status' => 'success']);
        }else{
            return json_encode(['status' => 'failed']);
        }
    }

}

<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Alamat;
use App\Model\Transaksi;
use App\Model\TransaksiDetail;
use App\Model\Config;
use App\Model\Voucher;
use App\Model\Carts;
use Auth;


class CheckoutController extends Controller
{
    public function index(){
        $carts = Carts::all();

        if(Auth::user()){
            $alamats = Alamat::where('customer_id', Auth::user()->id)->get();
        }else{
            $alamats = NULL;
        }

        $curl_prov =  json_decode($this->curl("province", null), true);
        $provinsi = $curl_prov['rajaongkir']['results'];

        $config_kota = config('setting.DikirimDari');
        return view('frontend.checkout', compact('provinsi', 'config_kota', 'carts', 'alamats'));
    }

    public function tampilKota($id_provinsi){
        $curl_kota =  json_decode($this->curl("city?province=$id_provinsi", null), true);
        $kota = $curl_kota['rajaongkir']['results'];

        return $kota;
    }

    public function tampilKecamatan($id_kota){
        $curl_kecamatan =  json_decode($this->curl("subdistrict?city=$id_kota", null), true);
        $kecamatan = $curl_kecamatan['rajaongkir']['results'];

        return $kecamatan;
    }

    public function cekOngkir($asal, $tujuan, $berat){
        $response = array();
        $kurirs = ['jne' , 'jnt', 'sicepat'];

        foreach ($kurirs as $kurir ){

            $option = [
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin=$asal&originType=city&destination=$tujuan&destinationType=subdistrict&weight=$berat&courier=$kurir",
                CURLOPT_HTTPHEADER => [
                    "content-type: application/x-www-form-urlencoded",
                    "key: 24e57029b197a799eb96fd5afea6d55f"
                ]
            ];

            $cekongkir = json_decode($this->curl("cost", $option), true);
            $arr  = array();
            $arr['code'] = $cekongkir["rajaongkir"]["results"][0]["code"];
            $service_total = count($cekongkir["rajaongkir"]["results"][0]["costs"]);
            for($x=0; $x<$service_total;$x++){
                $arr['service'] = $cekongkir["rajaongkir"]["results"][0]["costs"][$x]["service"];
                $arr['ongkir'] = $cekongkir["rajaongkir"]["results"][0]["costs"][$x]["cost"][0]["value"];

                array_push($response, $arr);
            }

        }

        return $response;
    }

    public function checkout(Request $request){
        $total_harga = 0;

        if (Auth::user()){
            $carts = Carts::where('customer_id', Auth::User()->id)->get();
            foreach($carts as $cart){
                $total_harga += $cart->quantity * $cart->Produk->harga_jual;
            }
            $user_id = Auth::User()->id;
            $guest = 0;
        }else{
            // Ambil Total Harga
            $cart = session()->get('cart');
            $total_harga = 0;
            foreach($cart as $id => $product){
                $total_harga += $product['harga'] * $product['quantity'];
            }
            $user_id = 0;
            $guest = 1;
        }

        if(empty($request->post('daftar-alamat'))){
            // Proses masukan alamat
            $billing_address = New Alamat();
            $billing_address->customer_id       = $user_id;
            $billing_address->nama_depan        = $request->post('nama_depan');
            $billing_address->nama_belakang     = $request->post('nama_belakang');
            $billing_address->nama_perusahaan   = $request->post('nama_perusahaan');
            $billing_address->alamat            = $request->post('alamat');
            $billing_address->provinsi          = $request->post('provinsi');
            $billing_address->kota              = $request->post('kota');
            $billing_address->kecamatan         = $request->post('kecamatan');
            $billing_address->kode_pos          = $request->post('kode_pos');
            $billing_address->no_hp             = $request->post('no_hp');
            $billing_address->kode_rajaongkir   = $request->post('kode_rajaongkir');
            $billing_address->save();
            $alamat_id = $billing_address->alamat_id;
        }else{
            $alamat_id = $request->post('daftar-alamat');
        }

        // Proses masukan transaksi
        $transaksi = New Transaksi();
        $transaksi->customer_id         = $user_id;
        $transaksi->is_guest            = $guest;
        $transaksi->kurir               = $request->post('kurir');
        $transaksi->kurir_service       = $request->post('service');
        $transaksi->alamat_id           = $alamat_id;
        $transaksi->status_pembayaran   = "Menunggu Pembayaran";
        $transaksi->status_pengiriman   = "";
        $transaksi->status_transaksi    = "PENDING";
        $transaksi->jenis_pembayaran    = $request->post('pembayaran');
        if(session()->has('voucher')){
            if(session()->get('voucher')['type'] == 'fixed'){
                $transaksi->voucher = session()->get('voucher')['value'];
            }elseif(session()->get('voucher')['type'] == 'percent'){
                $transaksi->voucher = $total_harga * ((100 - session()->get('voucher')['value']) / 100 );
            }
        }
        $transaksi->kode_unik           = rand(0, 99);
        $transaksi->total_transaksi     = $total_harga + $request->post('ongkir');
        $transaksi->catatan             = $request->post('catatan');
        $transaksi->save();

        $this->delvoucher();

        if (Auth::user()){
            $carts = Carts::where('customer_id', Auth::User()->id)->get();
            foreach($carts as $cart){
                $detail = new TransaksiDetail();
                $detail->transaksi_id = $transaksi->transaksi_id;
                $detail->product_id = $cart->product_id;
                $detail->quantity = $cart->quantity;
                $detail->harga_jual = $cart->quantity * $cart->Produk->harga_jual;
                $detail->diskon = 0;
                $detail->save();
                
                Carts::find($cart->id)->delete();
            }
        }else{ 
            // Proses Transaksi Detail
            foreach($cart as $id => $product){
                $detail = new TransaksiDetail();
                $detail->transaksi_id = $transaksi->transaksi_id;
                $detail->product_id = $id;
                $detail->quantity = $product['quantity'];
                $detail->harga_jual = $product['harga'] * $product['quantity'];
                $detail->diskon = 0;
                $detail->save();
            }

            session()->forget('cart');
        }

        $sms_total =  number_format($transaksi->total_transaksi + $transaksi->kode_unik, 0, ',','.');
        $message = "[DEMO] Toko Segar\n\nSelamat Pesanan anda berhasil dibuat.\nSilahkan Lakukan Pembayaran Sebesar Rp $sms_total.\nTransfer tepat sampai 2 digit terakhir.\n\nTerima Kasih";
        // $this->sendSMS($billing_address->no_hp, $message);

        return redirect()->route('invoice', ['id' => $transaksi->transaksi_id]);
    }

    public function curl($params, $option){
        $curl = curl_init();
        
        $options = [
            CURLOPT_URL => 'https://pro.rajaongkir.com/api/'.$params,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: 24e57029b197a799eb96fd5afea6d55f"
            ),
        ];

        if(!empty($option)){
            foreach( $option as $key => $val){
                $options[$key] = $val;
            }
        }

        curl_setopt_array($curl, $options);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

    public function cekvoucher(Request $request){
        $voucher = Voucher::where('kode_voucher', $request->post('kode'))->first();

        if(is_null($voucher)){
            return Response()->json(['status' => 0, 'pesan' => 'Voucher yang anda gunakan tidak valid']);
        }else{
            return Response()->json(['status' => 1, 'pesan' => 'Selamat anda bisa menggunakan voucher ini', 'voucher' => $voucher]);
        }
    }

    public function usevoucher(Request $request){
        $voucher = Voucher::where('kode_voucher', $request->post('kode_voucher'))->first();
        

        if(is_null($voucher)){
            return redirect()->back()->with(['notif_voucher' => 'Voucher yang anda gunakan tidak valid']);
        }else{
            session()->put('voucher', [
                'name' => $voucher->nama,
                'kode_voucher' => $voucher->kode_voucher,
                'value' => $voucher->value,
                'type' => $voucher->type
            ]);
            
            return redirect()->back()->with(['notif_voucher' => 'Selamat anda bisa menggunakan voucher ini']);
        }
    }

    public function delvoucher(){
        session()->forget('voucher');

        return redirect()->back()->with(['notif_voucher' => 'Voucher berhasil dihapus']);
    }

    public function showsession(){
        return session()->all();

    }


    //SMS Gateway
    public function SendSMS($no_hp, $pesan){
        $url = "https://semysms.net/api/3/sms.php"; //Url address for sending SMS

        $data = array(
                "phone" => $no_hp, // 6289646781772 testing
                "msg" => $pesan,
                "device" => '143500', // Device code
                "token" => '6e3bb6e4b83556c211021a4f71fc8fb2' //  Your token (secret)

        );

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }
}

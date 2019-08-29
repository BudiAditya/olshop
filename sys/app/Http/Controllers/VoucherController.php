<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Model\Voucher;
use Carbon\Carbon;

class VoucherController extends Controller
{
    public function index(){
        $vouchers = Voucher::paginate(10);

        foreach($vouchers as $voucher){
            if((date('Y-m-d H:i:s') >= $voucher->tanggal_mulai) && (date('Y-m-d H:i:s') <= $voucher->tanggal_selesai)){
                $voucher->status = 'Active';
            }else{
                $voucher->status = 'Nonactive';                
            }
        }

        // return $vouchers;
        return view('admin.voucher.daftar', compact('vouchers'));
    }

    public function check_in_range($start_date, $end_date, $date_from_user)
        {
        // Convert to timestamp
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);

        // Check that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
        }

    public function Tambah(){
        return view('admin.voucher.tambah');
    }

    public function ProsesTambah(Request $request){
        $validator = $this->validator($request->all());

        $voucher = new Voucher();
        $voucher->kode_voucher       = $request->post('kode');
        $voucher->nama               = $request->post('nama');
        $voucher->deskripsi          = $request->post('deskripsi');
        $voucher->tpye               = $request->post('type');
        $voucher->value              = $request->post('nilai');
        $voucher->limit_voucher      = $request->post('stok');
        $voucher->tanggal_mulai      = $request->post('tanggal_mulai');
        $voucher->tanggal_selesai    = $request->post('tanggal_selesai');
        $voucher->save();

        return redirect('admin/voucher/tambah')->with('success', 'voucher berhasil disimpan');
    }

    public function Edit($id){
        $voucher = Voucher::find($id);

        return view('admin.voucher.edit', compact('voucher'));
    }

    public function ProsesEdit(Request $request){
        $validator = $this->validator($request->all());

        $id = $request->post('id');
        $voucher = Voucher::find($id);
        $voucher->kode_voucher       = $request->post('kode');
        $voucher->nama               = $request->post('nama');
        $voucher->deskripsi          = $request->post('deskripsi');
        $voucher->tpye               = $request->post('type');
        $voucher->value              = $request->post('nilai');
        $voucher->limit_voucher      = $request->post('stok');
        $voucher->tanggal_mulai      = $request->post('tanggal_mulai');
        $voucher->tanggal_selesai    = $request->post('tanggal_selesai');
        $voucher->save();

        return redirect('admin/voucher/tambah')->with('success', 'voucher berhasil diubah');
    }

    public function Hapus($id){
        Voucher::where('voucher_id', $id)->delete();

        return redirect('admin/voucher')->with('success', 'voucher berhasil dihapus');
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

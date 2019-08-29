<?php

use Illuminate\Database\Seeder;
use App\Model\Voucher;
use Carbon\Carbon;

class VoucherTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Voucher::create([
            'kode_voucher'      => 'PROMOJUNI',
            'nama'              => 'Promo Spesial Juni',
            'deskripsi'         => 'Potongan 10 Ribu',
            'type'              => 'fixed',
            'value'             => '10000',
            'limit_voucher'     => '10',
            'tanggal_mulai'     => Carbon::now(),
            'tanggal_selesai'   =>  Carbon::now()->addDays(2)
        ]);
    }
}

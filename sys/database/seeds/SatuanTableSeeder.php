<?php

use Illuminate\Database\Seeder;
use App\Model\Satuans;

class SatuanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Satuans::create([
            'satuan_nama'      => 'Pcs',
            'satuan_deskripsi' => '-'
        ]);

        Satuans::create([
            'satuan_nama'      => 'Buah',
            'satuan_deskripsi' => '-'
        ]);

        Satuans::create([
            'satuan_nama'      => 'Lusin',
            'satuan_deskripsi' => '-'
        ]);

        Satuans::create([
            'satuan_nama'      => 'Koli',
            'satuan_deskripsi' => '-'
        ]);
    }
}

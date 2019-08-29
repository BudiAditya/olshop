<?php

use Illuminate\Database\Seeder;
use App\Model\Kategoris;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Kategoris::create([
            'kategori_nama'      => 'Daging',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);

        Kategoris::create([
            'kategori_nama'      => 'Ikan',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);

        Kategoris::create([
            'kategori_nama'      => 'Frozen',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);

        Kategoris::create([
            'kategori_nama'      => 'Buah',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);

        Kategoris::create([
            'kategori_nama'      => 'Paket',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);

        Kategoris::create([
            'kategori_nama'      => 'Sayur',
            'kategori_deskripsi' => 'Semua Jenis Ikan',
            'kategori_gambar'    => '',
        ]);
    }
}

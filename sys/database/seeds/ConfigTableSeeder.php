<?php

use Illuminate\Database\Seeder;
use App\Model\Config;

class ConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Config::create([
            'nama' => 'NamaToko',
            'value' => 'Toko Segar',
        ]);

        Config::create([
            'nama' => 'Deskripsi',
            'value' => 'Nisi esse dolor irure dolor eiusmod ex deserunt proident cillum eu qui enim occaecat sunt aliqua anim eiusmod qui ut voluptate.',
        ]);

        Config::create([
            'nama' => 'Alamat',
            'value' => 'Jl Kencana No 68, Ciberereum, Cimahi Selatan, Kota Cimahi',
        ]);

        Config::create([
            'nama' => 'Telp',
            'value' => '08123456789',
        ]);

        Config::create([
            'nama' => 'Email',
            'value' => 'tokosegar@gmail.com',
        ]);

        Config::create([
            'nama' => 'DikirimDari',
            'value' => '23',
        ]);

        Config::create([
            'nama' => 'NamaBCA',
            'value' => '-',
        ]);

        Config::create([
            'nama' => 'NorekBCA',
            'value' => '-',
        ]);

        Config::create([
            'nama' => 'UserBCA',
            'value' => '-',
        ]);

        Config::create([
            'nama' => 'PassBCA',
            'value' => '',
        ]);

    }
}

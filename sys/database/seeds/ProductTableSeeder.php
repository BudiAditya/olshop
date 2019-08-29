<?php

use Illuminate\Database\Seeder;
use App\Model\Products;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Products::create([
            'nama'        => 'Daging Sapi',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '1',
            'satuan_id'   => '1',
            'tag_id'      =>  1,
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '9000',
            'gambar'      => 'meats.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

        Products::create([
            'nama'        => 'Ikan',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '2',
            'satuan_id'   => '1',
            'tag_id'      =>  2,
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '20000',
            'gambar'      => 'fish.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

        Products::create([
            'nama'        => 'Frozen',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '3',
            'satuan_id'   => '1',
            'tag_id'      =>  3,
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '18000',
            'gambar'      => 'frozen.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

        Products::create([
            'nama'        => 'Buah',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '4',
            'satuan_id'   => '1',
            'tag_id'      =>  4,
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '34000',
            'gambar'      => 'fruits.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

        Products::create([
            'nama'        => 'Paket Sayur',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '5',
            'satuan_id'   => '1',
            'tag_id'      =>  5,
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '55000',
            'gambar'      => 'package.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

        Products::create([
            'nama'        => 'Sayuran',
            'deskripsi'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'kategori_id' => '5',
            'satuan_id'   => '1',
            'berat'       => '800',
            'harga_beli'  => '8000',
            'harga_jual'  => '13000',
            'gambar'      => 'vegetables.jpg',
            'rating'      => '5',
            'dilihat'     => '8'
        ]);

    }
}

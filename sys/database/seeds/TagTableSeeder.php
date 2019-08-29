<?php

use Illuminate\Database\Seeder;
use App\Model\Tags;

class TagTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tags::create([
            'tag_nama'  => 'Populer',
            'tag_warna'  => 'primary'
        ]);

        Tags::create([
            'tag_nama'  => 'Rekomend',
            'tag_warna'  => 'info'
        ]);

        Tags::create([
            'tag_nama'  => 'Hot',
            'tag_warna'  => 'danger'
        ]);

        Tags::create([
            'tag_nama'  => 'Spesial',
            'tag_warna'  => 'success'
        ]);

        Tags::create([
            'tag_nama'  => 'Terbaru',
            'tag_warna'  => 'secondary'
        ]);

        Tags::create([
            'tag_nama'  => '',
            'tag_warna'  => 'none'
        ]);
    }
}

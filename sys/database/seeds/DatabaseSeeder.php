<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ProductTableSeeder::class,
            KategoriTableSeeder::class,
            SatuanTableSeeder::class,
            TagTableSeeder::class,
            VoucherTableSeeder::class,
            ConfigTableSeeder::class,
            UsersTableSeeder::class
        ]);
    }
}

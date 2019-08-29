<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Ganteng',
            'no_hp' => '08991010888',
            'is_admin' => 1,
            'email' => 'admin@mailinator.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(10)
        ]);

        User::create([
            'name' => 'Pejalan Kaki',
            'no_hp' => '08991010777',
            'is_admin' => 0,
            'email' => 'customer@mailinator.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin123'),
            'remember_token' => Str::random(10)
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'      => 'Rahmat Hidayatullah',
                'email'     => 'admin@gmail.com',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'umur' => 31,
                'alamat' => 'Jl. Merdeka No. 1',
                'no_hp' => '081234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'admin',
            ],
            [
                'name'      => 'Ayane',
                'email'     => 'ayane@gmail.com',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'umur' => 31,
                'alamat' => 'Jl. Merdeka No. 1',
                'no_hp' => '081234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'pengurus',
            ],
            [
                'name'      => 'Bambang',
                'email'     => 'bambang@gmail.com',
                'jenis_kelamin' => 'Laki-laki',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'umur' => 31,
                'alamat' => 'Jl. Merdeka No. 1',
                'no_hp' => '081234567890',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
                'role' => 'anggota',
            ],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('anggota')->insert([
            'name' => 'John Doe',
            'alamat' => 'Jl. Sudirman No. 123',
            'no_hp' => '08123456789',
            'password' => Hash::make('password'),
            'email' => 'johndoe@example.com',
            'jenis_kelamin' => 'Laki-laki',
            'umur' => 25,
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Posts;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	// $this->call(UserSeeder::class);
        // User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AnggotaSeeder::class,
            CategorySeeder::class,
            PostSeeder::class
        ]);
    }
}

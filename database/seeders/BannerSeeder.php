<?php

namespace Database\Seeders;

use App\Models\Banners;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banners::create([
            'name' => 'Banner 1',
            'author' => 'John Doe',
            'is_show' => true,
            'image' => 'image1.jpg'
        ]);

        Banners::create([
            'name' => 'Banner 2',
            'author' => 'Jane Doe',
            'is_show' => false,
            'image' => 'image2.jpg'
        ]);
    }
}

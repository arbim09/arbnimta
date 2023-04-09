<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Posts;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = DB::table('categories')->pluck('id');
        $faker = \Faker\Factory::create();

        foreach ($categories as $categoryId) {
            for ($i = 0; $i < 5; $i++) {
                $title = $faker->sentence;
                $content = $faker->paragraph;
                $slug = Str::slug($title, '-');
                DB::table('posts')->insert([
                    'title' => $title,
                    'content' => $content,
                    'slug' => $slug,
                    'category_id' => $categoryId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

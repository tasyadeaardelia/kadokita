<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category2 = Category::create([
            'name' => 'Ulang Tahun',
            'slug' => 'ulang-tahun',
            'description' => 'Kado untuk ulang tahun',
            'cover' => 'birthdayy.jpg',
        ]);

        $category2 = Category::create([
            'name' => 'Natal',
            'slug' => 'natal',
            'description' => 'Kado untuk hari Natal',
            'cover' => 'xmas.jpg',
        ]);

        
    }
}

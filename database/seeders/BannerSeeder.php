<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banner = Banner::create([
            'file' => 'Kadokita_banner.png',
            'active' => true,
        ]);
    }
}

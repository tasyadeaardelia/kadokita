<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'name' => 'Official Kado Kita',
            'url' => 'kadokitastore',
            'description' => 'Kado Kita Official',
            'profil' => 'kadokita.png',
            'is_approved' => true,
            'user_id' => 1,
        ]);


    }
}

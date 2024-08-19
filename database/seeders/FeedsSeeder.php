<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeedsSeeder extends Seeder
{
    public function run()
    {
        DB::table('feeds')->insert([
            ['name' => 'Dry Cat Food'],
            ['name' => 'Wet Dog Food'],
            ['name' => 'Bird Seed Mix'],
            ['name' => 'Horse Pellets'],
            ['name' => 'Fish Flakes'],
            ['name' => 'Small Animal Hay'],
            // Agrega más registros si es necesario
        ]);
    }
}

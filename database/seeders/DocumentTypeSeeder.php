<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('document_type')->insert([
            ['name' => 'Passport'],
            ['name' => 'DNI'],
            ['name' => 'Driver\'s License'],
            ['name' => 'Residence Permit'],
            ['name' => 'Social Security Card'],
            // Agrega más registros si es necesario
        ]);
    }
}

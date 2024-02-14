<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        // Dodajte 4 rubrike
        DB::table('categories')->insert([
            ['category' => 'Politika'],
            ['category' => 'Sport'],
            ['category' => 'Zabava'],
            ['category' => 'Tehnologija'],
        ]);
    }
}
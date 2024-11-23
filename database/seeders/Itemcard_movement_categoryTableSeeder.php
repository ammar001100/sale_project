<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Itemcard_movement_category;

class Itemcard_movement_categoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Itemcard_movement_category::create([
            'id' => '1',
            'name' => 'حركة على المشتريات',
        ]);
        Itemcard_movement_category::create([
            'id' => '2',
            'name' => 'حركة على المبيعات',
        ]);
        Itemcard_movement_category::create([
            'id' => '3',
            'name' => 'حركة على المخزن',
        ]);
    }
}

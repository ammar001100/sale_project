<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Account_Type::create([
            'name' => 'رأس المال',
            'relatedIternalAccounts' => '0',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
    }
}

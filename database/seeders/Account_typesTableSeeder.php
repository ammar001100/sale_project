<?php

namespace Database\Seeders;

use App\Models\Account_Type;
use Illuminate\Database\Seeder;

class Account_typesTableSeeder extends Seeder
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
        Account_Type::create([
            'name' => 'مورد',
            'relatedIternalAccounts' => '1',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'عميل',
            'relatedIternalAccounts' => '1',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'مندوب',
            'relatedIternalAccounts' => '1',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'موظف',
            'relatedIternalAccounts' => '1',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'بنكي',
            'relatedIternalAccounts' => '0',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'مصروفات',
            'relatedIternalAccounts' => '0',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'قسم داخلي',
            'relatedIternalAccounts' => '1',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
        Account_Type::create([
            'name' => 'عام',
            'relatedIternalAccounts' => '0',
            'com_code' => '0',
            'date' => date('Y-m-d'),
            'active' => '1',
        ]);
    }
}

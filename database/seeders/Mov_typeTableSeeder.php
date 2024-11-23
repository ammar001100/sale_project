<?php

namespace Database\Seeders;

use App\Models\Mov_type;
use Illuminate\Database\Seeder;

class Mov_typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mov_type::create([
            'name'=>'مراجعة واستلام نقدية شفت على نفس الخزنة',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'مراجعة واستلام شفت خزنة اخرى',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف مبلغ لحساب مالي',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'تحصيل مبلغ لحساب مالي',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'تحصيل ايراد مبيعات',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف نظير مرتجع مبيعات',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف سلفة على راتب موظف',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف نظير مشتريات من مورد',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'تحصيل نظير مرتجع مشتريات الى مورد',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'ايراد زيادة رأس المال',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'مصاريف شراء',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف للايداع البنكي',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'رد سلفة على راتب موظف',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'تحصيل خصومات موظفين',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف مرتب لموظف',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 1,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'سحب من البنك',
            'system_id'=> 1,
            'in_screen'=> 2,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        Mov_type::create([
            'name'=>'صرف لرد رأس المال',
            'system_id'=> 1,
            'in_screen'=> 1,
            'is_private_intemal'=> 0,
            'active'=> 1,
            'added_by'=> 1,
            
            'com_code'=> 1,
            'date'=> date('Y-m-d'),
        ]);
        
    }
}

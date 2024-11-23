<?php

namespace Database\Seeders;

use App\Models\Itemcard_movement_type;
use Illuminate\Database\Seeder;

class Itemcard_movement_typeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Itemcard_movement_type::create([
            'id' => '1',
            'type' => 'مشتريات',
        ]);
        Itemcard_movement_type::create([
            'id' => '2',
            'type' => 'مرتجع مشتريات بأصل الفاتورة',
        ]);
        Itemcard_movement_type::create([
            'id' => '3',
            'type' => 'مرتجع مشتريات عام',
        ]);
        Itemcard_movement_type::create([
            'id' => '4',
            'type' => 'مبيعات',
        ]);
        Itemcard_movement_type::create([
            'id' => '5',
            'type' => 'مرتجع مبيعات',
        ]);
        Itemcard_movement_type::create([
            'id' => '6',
            'type' => 'صرف داخلي لمندوب',
        ]);
        Itemcard_movement_type::create([
            'id' => '7',
            'type' => 'مرتجع صرف داخلي لمندوب',
        ]);
        Itemcard_movement_type::create([
            'id' => '8',
            'type' => 'تحويل من مخازن',
        ]);
        Itemcard_movement_type::create([
            'id' => '9',
            'type' => 'مبيعات صرف مباشر لعميل',
        ]);
        Itemcard_movement_type::create([
            'id' => '10',
            'type' => 'مبيعات صرف لمندوب التوصيل',
        ]);
        Itemcard_movement_type::create([
            'id' => '11',
            'type' => 'صرف خامات لخط التصنيع',
        ]);
        Itemcard_movement_type::create([
            'id' => '12',
            'type' => 'رد خامات من خط التصنيع',
        ]);
        Itemcard_movement_type::create([
            'id' => '13',
            'type' => 'استلام انتاج تام من خط التصنيع',
        ]);
        Itemcard_movement_type::create([
            'id' => '14',
            'type' => 'رد انتاج تام الى خط التصميع',
        ]);
        Itemcard_movement_type::create([
            'id' => '15',
            'type' => 'حذف صنف من تفاصيل فاتورة مبيعات',
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_with_order_details extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'supplier_with_order_id',
        'item_card_id',
        'item_type',
        'batch_id',
        'order_type',
        'deliverd_quantity',
        'uom_id',
        'is_master_uom',
        'unit_price',
        'total_price',
        'order_date',
        'pro_date',
        'ex_date',
        'added_by',
        'updated_by',
        'com_code',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select([
                'id',
                'supplier_with_order_id',
                'item_card_id',
                'batch_id',
                'order_type',
                'deliverd_quantity',
                'uom_id',
                'is_master_uom',
                'unit_price',
                'total_price',
                'order_date',
                'pro_date',
                'ex_date',
                'item_type',
                'added_by',
                'updated_by',
                'com_code',
            ])
            ->orderby('id', 'DESC');
    }

    public function item_cards()
    {
        return $this->belongsTo(Item_card::class, 'item_card_id');
    }
}

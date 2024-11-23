<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_invoice_detail extends Model
{
    use HasFactory;
    protected $fillable = [
        'sale_invoice_id',
        'item_card_id',
        'sale_item_type',
        'batch_id',
        //'order_type',
        'quantity',
        'uom_id',
        'is_master_uom',
        'is_bounce_or_other',
        'unit_price',
        'total_price',
        'invoice_date',
        'pro_date',
        'ex_date',
        'added_by',
        'updated_by',
        'com_code',
        'date',
    ];
    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->orderby('id', 'DESC');
    }
    public function sale_invoice()
    {
        return $this->belongsTo(Sale_invoice::class);
    }
    public function item_cards()
    {
        return $this->belongsTo(Item_card::class, 'item_card_id');
    }
}

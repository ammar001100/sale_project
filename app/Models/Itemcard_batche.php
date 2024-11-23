<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcard_batche extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_id',
        'auto_serial',
        'item_card_id',
        'uom_id',
        'unit_cost_price',
        'quantity',
        'total_cost_price',
        'pro_date',
        'exp_date',
        'is_send_to_archived',
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
    public function batches()
    {
        return $this->belongsTo(Item_card::class);
    }
}

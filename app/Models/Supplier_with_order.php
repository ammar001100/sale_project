<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_with_order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'order_type',
        'auto_serial',
        'doc_no',
        'order_date',
        'supplier_id',
        'store_id',
        'is_approved',
        'discount_type',
        'discount_percent',
        'discount_value',
        'tax_percent',
        'tax_value',
        'total_befor_discount',
        'total_cost',
        'total_cost_items',
        'account_number',
        'money_for_account',
        'pill_type',
        'what_paid',
        'what_remain',
        'treasuries_transaction_id',
        'supplier_balance_befor',
        'supplier_balance_after',
        'notes',
        'active',
        'approved_by',
        'added_by',
        'updated_by',
        'com_code',
        'date',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select([
                'id',
                'order_type',
                'auto_serial',
                'doc_no',
                'order_date',
                'supplier_id',
                'store_id',
                'is_approved',
                'discount_type',
                'discount_percent',
                'discount_value',
                'tax_percent',
                'tax_value',
                'total_befor_discount',
                'total_cost',
                'total_cost_items',
                'account_number',
                'money_for_account',
                'pill_type',
                'what_paid',
                'what_remain',
                'treasuries_transaction_id',
                'supplier_balance_befor',
                'supplier_balance_after',
                'notes',
                'active',
                'added_by',
                'updated_by',
                'com_code',
                'date',
            ])
            ->orderby('id', 'DESC');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function supplier_with_order_details()
    {
        return $this->hasMany(Supplier_with_order_details::class);
    }
}

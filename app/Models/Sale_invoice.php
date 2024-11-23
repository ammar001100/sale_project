<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale_invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'auto_serial',
        'invoice_date',
        'customer_id',
        'is_has_customer',
        'account_number',
        'delegate_id',
        'delegate_auto_invoice_number',
        'sales_matrial_type_id',
        'is_approved',
        'discount_type',
        'discount_percent',
        'discount_value',
        'tax_percent',
        'tax_value',
        'total_befor_discount',
        'total_cost',
        'total_cost_items',
        'money_for_account',
        'pill_type',
        'what_paid',
        'what_remain',
        'treasuries_transaction_id',
        'customer_balance_befor',
        'customer_balance_after',
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
            ->orderby('id', 'DESC');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function sales_matrial_type()
    {
        return $this->belongsTo(Sales_matrial_type::class);
    }
    public function delegate()
    {
        return $this->belongsTo(Delegate::class, 'delegate_id', 'id');
    }
    public function sale_inv_details()
    {
        return $this->hasMany(Sale_invoice_detail::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'system_name',
        'photo',
        'active',
        'general_alert',
        'customer_parent_account_id',
        'supplier_parent_account_id',
        'delegate_parent_account_id',
        'employee_parent_account_id',
        'address',
        'phone',
        'added_by',
        'updated_by',
        'com_code',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }

    public function customer_parent_account()
    {
        return $this->belongsTo(Account::class, 'customer_parent_account_id');
    }

    public function supplier_parent_account()
    {
        return $this->belongsTo(Account::class, 'supplier_parent_account_id');
    }
    public function delegate_parent_account()
    {
        return $this->belongsTo(Account::class, 'delegate_parent_account_id');
    }
    public function employee_parent_account()
    {
        return $this->belongsTo(Account::class, 'employee_parent_account_id');
    }
}

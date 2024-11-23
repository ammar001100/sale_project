<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_shifts extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'admin_id',
        'shift_code',
        'treasury_id',
        'treasury_balnce_in_shift_start',
        'start_date',
        'end_date',
        'is_finished',
        'is_delivered',
        'delivered_to_admin_id',
        'delivered_to_admin_shift_id',
        'delivered_to_treasury_id',
        'money_should_deviled',
        'what_realy_delivered',
        'money_state',
        'money_state_value',
        'receive_type',
        'review_recevie_date',
        'treasury_transactions_id',
        'notes',
        'added_by',
        'updated_by',
        'com_code',
        'date',   
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['*']);
    }
    public function treasury()
    {
        return $this->belongsTo(Treasury::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function Treasury_transactions()
    {
        return $this->hasMany(Treasury_transaction::class,'admin_shift_id','id');
    }
}

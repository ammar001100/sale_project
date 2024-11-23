<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury_transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'trans_code',
        'auto_serial',
        'isal_number',
        'admin_shift_id',
        'treasury_id',
        'mov_type_id',
        'the_foregin_key',
        'account_id',
        'is_account',
        'is_approved',
        'money',
        'money_for_account',
        'mov_date',
        'byan',
        'added_by',
        'updated_by',
        'com_code',
        'date',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['*'])
            ->orderby('id', 'DESC');
    }

    public function treasury()
    {
        return $this->belongsTo(Treasury::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function mov_type()
    {
        return $this->belongsTo(Mov_type::class);
    }
}

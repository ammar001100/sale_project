<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'account_type_id', 'account_id',
        'current_balance', 'other_table_FK', 'notes',
        'account_number', 'is_archived', 'com_code', 'start_balance',
        'start_balance_status', 'is_parent', 'added_by', 'updated_by', 'date',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select([
                'id', 'name', 'account_type_id', 'account_id',
                'current_balance', 'other_table_FK', 'notes',
                'account_number', 'is_archived', 'com_code', 'start_balance',
                'start_balance_status', 'is_parent', 'added_by', 'updated_by', 'date',
            ]);
    }

    public function scopeSelectionIsArchivedParent($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'is_archived' => '0', 'is_parent' => '0'])
            ->select([
                'id', 'name', 'account_type_id', 'account_id',
                'current_balance', 'other_table_FK', 'notes',
                'account_number', 'is_archived', 'com_code', 'start_balance',
                'is_parent', 'added_by', 'updated_by', 'date',
            ]);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }

    public function parent()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }

    public function children()
    {
        return $this->hasMany(Account::class);
    }

    public function account_type()
    {
        return $this->belongsTo(Account_type::class);
    }
}

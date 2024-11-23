<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'name', 'phone', 'supplier_code', 'supplier_category_id',
        'current_balance', 'notes', 'photo', 'city_id', 'address',
        'account_number', 'active', 'com_code', 'start_balance',
        'start_balance_status', 'added_by', 'updated_by', 'date',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select([
                'id', 'name', 'phone', 'supplier_code', 'supplier_category_id',
                'current_balance', 'notes', 'photo', 'city_id', 'address',
                'account_number', 'active', 'com_code', 'start_balance',
                'start_balance_status', 'added_by', 'updated_by', 'date',
            ])
            ->orderby('id', 'DESC'); //ASC
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => 1])
            ->select([
                'id', 'name', 'phone', 'supplier_code', 'supplier_category_id',
                'current_balance', 'notes', 'photo', 'city_id', 'address',
                'account_number', 'active', 'com_code', 'start_balance',
                'start_balance_status', 'added_by', 'updated_by', 'date',
            ])
            ->orderby('id', 'DESC'); //ASC
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }

    public function accuont()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function parentAccuont()
    {
        return $this->belongsTo(Account::class, 'account_number', 'id');
    }

    public function supplierCategory()
    {
        return $this->belongsTo(supplier_category::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active',
        'com_code',
        'relatedIternalAccounts',
        'updated_by',
        'date',

    ];

    public function scopeSelection($q)
    {
        return $q
            ->select(['id', 'name', 'com_code', 'active', 'relatedIternalAccounts', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('relatedIternalAccounts', 'ASC');
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['active' => '1'])
            ->select(['id', 'name', 'com_code', 'active', 'relatedIternalAccounts', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('relatedIternalAccounts', 'ASC');
    }

    public function scopeSelectionIternal($q)
    {
        return $q
            ->where(['active' => '1', 'relatedIternalAccounts' => '0'])
            ->select(['id', 'name', 'com_code', 'active', 'relatedIternalAccounts', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'ASC');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

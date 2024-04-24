<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_master',
        'active',
        'com_code',
        'added_by',
        'updated_by',
        'date',

    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['id', 'name', 'is_master', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1'])
            ->select(['id', 'name', 'is_master', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function scopeSelectionActiveAndMaster($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1', 'is_master' => '1'])
            ->select(['id', 'name', 'is_master', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function scopeSelectionActiveAndNotMaster($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1', 'is_master' => '0'])
            ->select(['id', 'name', 'is_master', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

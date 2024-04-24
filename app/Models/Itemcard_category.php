<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcard_category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
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
            ->select(['id', 'name', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1'])
            ->select(['id', 'name', 'com_code', 'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_master',
        'last_isal_exhcange',
        'last_isal_collect',
        'active',
        'com_code',
        'date',
        'added_by',
        'updated_by',

    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['id', 'name', 'is_master', 'last_isal_exhcange', 'last_isal_collect', 'active', 'com_code', 'date', 'added_by', 'updated_by', 'created_at', 'updated_at'])
            ->orderby('id', 'DESC');
        //->get();
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

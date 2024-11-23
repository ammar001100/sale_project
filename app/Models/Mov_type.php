<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mov_type extends Model
{
    use HasFactory;
    protected $fillable = [
           'id',
            'name',
            'system_id',
            'in_screen',
            'is_private_intemal',
            'active',
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
            ->orderby('id', ); //DESC
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1'])
            ->select(['*'])
            ->orderby('id', 'DESC');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

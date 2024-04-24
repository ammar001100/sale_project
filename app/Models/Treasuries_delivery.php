<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasuries_delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'treasuries_id',
        'treasuries_can_delivery_id',
        'com_code',
        'added_by',
        'updated_by',

    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['id', 'treasuries_id', 'treasuries_can_delivery_id', 'com_code', 'added_by', 'updated_by', 'created_at', 'updated_at'])
            ->orderby('id', 'DESC');
        //->get();
    }
}

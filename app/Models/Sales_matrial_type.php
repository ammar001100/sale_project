<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_matrial_type extends Model
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
            //->select([])
            ->orderby('id', 'DESC'); //ASC
    }
    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => 1])
            ->orderby('id', 'DESC'); //ASC
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }
}

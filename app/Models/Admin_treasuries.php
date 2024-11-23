<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_treasuries extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'admin_id',
        'treasury_id',
        'active',
        'added_by',
        'updated_by',
        'com_code',
    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['*']);
    }

    public function scopeSelectionActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1'])
            ->select(['*']);
    }

    //public function admins()
    //{
    //    return $this->newBelongsToMany(Admin::class);
    //}

    public function treasury()
    {
        return $this->belongsTo(Treasury::class);
    }
}

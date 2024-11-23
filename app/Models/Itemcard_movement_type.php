<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemcard_movement_type extends Model
{
    use HasFactory;
    protected $fillable = [];
    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->orderby('id', 'DESC');
    }
}

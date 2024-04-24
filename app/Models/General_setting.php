<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'system_name',
        'photo',
        'active',
        'general_alert',
        'address',
        'phone',
        'added_by',
        'updated_by',
        'com_code',
    ];
    public function admin(){
       return $this->belongsTo(Admin::class,'com_code');
    }
}

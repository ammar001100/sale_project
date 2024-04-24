<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'password',
        'com_code',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function generalSetting(){
        return $this->belongsTo(General_setting::class,'com_code');
     }
     public function treasury(){
        return $this->belongsTo(Treasury::class,'com_code');
     }

     public function sales_matrial_type(){
        return $this->belongsTo(Sales_matrial_type::class,'com_code');
     }
}

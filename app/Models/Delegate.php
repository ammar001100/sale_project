<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delegate extends Model
{
    use HasFactory;
    protected $fillable = [];

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

    public function accuont()
    {
        return $this->belongsTo(Account::class, 'account_number', 'account_number');
    }

    public function parentAccuont()
    {
        return $this->belongsTo(Account::class, 'account_number', 'id');
    }
    public function sale_invoices()
    {
        return $this->hasMany(Sale_invoice::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_card extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'name',
        'item_type',
        'itemcard_category_id',
        'item_card_id',
        'does_has_retailunit',
        'retail_uom_id', 'price',
        'uom_id', 'nos_gomal_price', 'gomal_price',
        'retail_uom_quntToparent',
        'active', 'price_retail', 'gomal_price_retail',
        'com_code', 'nos_gomal_price_retail',
        'added_by', 'cost_price', 'cost_price_retail',
        'updated_by', 'has_fixced_price',
        'date', 'quentity', 'quentity_retail', 'quentity_all_retails',
        'barcode', 'item_code', 'photo',

    ];

    public function scopeSelection($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code])
            ->select(['id', 'name', 'item_type', 'itemcard_category_id',
                'item_card_id', 'does_has_retailunit', 'retail_uom_id',
                'uom_id', 'retail_uom_quntToparent', 'com_code', 'barcode',
                'active', 'added_by', 'updated_by', 'price', 'photo',
                'nos_gomal_price', 'gomal_price', 'gomal_price_retail',
                'nos_gomal_price_retail', 'price_retail', 'has_fixced_price',
                'created_at', 'updated_at', 'cost_price', 'cost_price_retail',
                'quentity', 'quentity_retail', 'quentity_all_retails', 'date'])
            ->orderby('id', 'DESC');
    }

    public function scopeActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1'])
            ->select(['id', 'name', 'item_type', 'itemcard_category_id',
                'item_card_id', 'does_has_retailunit', 'retail_uom_id',
                'uom_id', 'retail_uom_quntToparent', 'com_code',
                'active', 'added_by', 'updated_by', 'created_at', 'updated_at', 'date'])
            ->orderby('id', 'DESC');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'com_code');
    }

    public function children()
    {
        return $this->hasMany(Item_card::class, 'item_card_id');
    }

    public function scopeAllChildItemCardActive($q)
    {
        return $q
            ->where(['com_code' => auth()->user()->com_code, 'active' => '1', 'item_card_id' => '0'])
            ->select()
            ->orderby('id', 'DESC');
    }

    public function parent()
    {
        return $this->belongsTo(Item_card::class, 'item_card_id');
    }

    public function mainParent()
    {
        return $this->belongsTo(Item_card::class, 'item_card_id')->whereNull('item_card_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function retail_uom()
    {
        return $this->belongsTo(Uom::class, 'retail_uom_id');
    }

    public function itemcard_category()
    {
        return $this->belongsTo(Itemcard_Category::class);
    }
}

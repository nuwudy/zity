<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'business_id',
        'category',
        'name',
        'description',
        'price',
        'original_price',
        'discount_percent',
        'deal_coins',
        'badge',
        'image',
        'is_active',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function getEffectiveDiscountPercentAttribute()
    {
        if ($this->discount_percent) {
            return $this->discount_percent;
        }
        if ($this->original_price && $this->original_price > $this->price && $this->price > 0) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function getSavingsAmountAttribute()
    {
        if ($this->original_price && $this->original_price > $this->price) {
            return round($this->original_price - $this->price);
        }
        return 0;
    }
}

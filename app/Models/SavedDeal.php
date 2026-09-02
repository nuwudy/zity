<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_id',
        'product_id',
        'deal_title',
        'type', // 'saved', 'unlocked', 'booking'
        'coins_used',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

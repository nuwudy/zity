<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'business_id',
        'city',
        'area',
        'pincode',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

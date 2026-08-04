<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = [
        'business_id',
        'name',
        'phone',
        'message',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

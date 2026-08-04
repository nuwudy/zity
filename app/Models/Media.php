<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'business_id',
        'file_url',
        'type',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}

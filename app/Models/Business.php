<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    const STATUS_ACTIVE = 'active';
    const STATUS_SUSPENDED = 'suspended';

    const TYPE_SHOP    = 'shop';
    const TYPE_SERVICE = 'service';
    const TYPE_BOTH    = 'both';


    protected $fillable = [
        'name',
        'slug',
        'logo',
        'cover_image',
        'address',
        'city',
        'state',
        'phone',
        'description',
        'user_id',
        'is_verified',
        'whatsapp',
        'email',
        'status',
        'type',
        'services',
        'service_area',
        'experience_years',
        'availability',
        'tagline',
        'badges',
        'why_choose_us',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'twitter_url',
        'google_url',
        'website_url',
        'branches',
    ];

    protected $casts = [
        'services' => 'array',
        'branches' => 'array',
        'badges' => 'array',
        'why_choose_us' => 'array',
    ];

    public function isService(): bool
    {
        return in_array($this->type, [self::TYPE_SERVICE, self::TYPE_BOTH]);
    }

    public function isShop(): bool
    {
        return in_array($this->type, [self::TYPE_SHOP, self::TYPE_BOTH]);
    }

    public function getUrl(): string
    {
        return route('card.show', ['slug' => $this->slug]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admins()
    {
        return $this->belongsToMany(User::class, 'business_user');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'business_categories');
    }

    public function getCategoryAttribute()
    {
        return $this->categories->first();
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function media()
    {
        return $this->hasMany(Media::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}

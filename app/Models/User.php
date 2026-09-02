<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Filament\Models\Contracts\FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'coins',
        'credits',
        'avatar',
        'is_profile_completed',
        'is_verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
        ];
    }

    public function business()
    {
        return $this->hasOne(Business::class);
    }

    public function businesses()
    {
        return $this->belongsToMany(Business::class, 'business_user');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function savedDeals()
    {
        return $this->hasMany(SavedDeal::class);
    }

    public function getAllOwnedBusinessesAttribute()
    {
        $direct = $this->business ? collect([$this->business]) : collect();
        $attached = $this->businesses;
        return $direct->merge($attached)->unique('id');
    }

    public function canAccessPanel(\Filament\Panel $panel): bool
    {
        return in_array($this->role, ['admin', 'business_owner']);
    }

    public function isMasterAdmin(): bool
    {
        return in_array($this->email, [
            'admin@zity.in',
            'ansluva@gmail.com',
            'nuwudy@gmail.com',
        ]);
    }
}

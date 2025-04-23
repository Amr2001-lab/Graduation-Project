<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{


    protected $fillable = ['name', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'user_id');
    }

    public function properties()
    {
        return $this->hasMany(Apartment::class, 'seller_id');
    }

    public function bookmarkedApartments()
    {
        return $this->belongsToMany(Apartment::class, 'bookmarks')->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'buyer_id');
    }
}

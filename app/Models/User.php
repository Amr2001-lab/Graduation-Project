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
}

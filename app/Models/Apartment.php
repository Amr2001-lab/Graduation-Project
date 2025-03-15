<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Apartment extends Model
{
    use HasFactory;

    protected $table = 'apartment';

    protected $fillable = [
        'seller_id',
        'size',
        'price',
        'street',
        'city',
        'age',
        'rooms',
        'bathrooms',
        'phone',

    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'apartment_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ApartmentImage::class, 'apartment_id');
    }

    public function getMainImageAttribute()
    {
        return $this->images()->first();
    }
}

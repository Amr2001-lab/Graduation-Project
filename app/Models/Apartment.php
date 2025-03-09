<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;

    // This is correct because your MySQL table name is "apartment"
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
        'image_url'
    ];

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class, 'apartment_id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}

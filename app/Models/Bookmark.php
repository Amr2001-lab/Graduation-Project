<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    // Point to the "bookmarks" table
    protected $table = 'bookmarks';

    // Allow mass assignment on these columns
    protected $fillable = [
        'user_id',
        'apartment_id',
    ];

    // (Optional) Relationship back to the user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // (Optional) Relationship back to the apartment
    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }
}

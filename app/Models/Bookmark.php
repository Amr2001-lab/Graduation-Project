<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{

    protected $table = 'bookmarks';

    protected $fillable = [
        'user_id',
        'apartment_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class, 'apartment_id');
    }
}

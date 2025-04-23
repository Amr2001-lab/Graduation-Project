<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentImage extends Model
{
    protected $table = 'apartment_images';

    protected $fillable = ['apartment_id', 'image_url'];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class, 'apartment_id');
    }

}
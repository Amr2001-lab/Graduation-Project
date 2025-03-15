<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentImage extends Model
{
    protected $table = 'apartment_images';

    protected $fillable = ['apartment_id', 'image_url']; // Corrected spelling here

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

}
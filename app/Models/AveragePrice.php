<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AveragePrice extends Model
{
    protected $table = 'average_prices';

    protected $fillable = ['city', 'avg_price_per_sqft'];
}

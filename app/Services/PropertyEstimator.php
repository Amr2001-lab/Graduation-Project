<?php

namespace App\Services;

use App\Models\AveragePrice;

class PropertyEstimator
{
    public static function estimate($city, $size, $age, $rooms)
    {
        $cityData = AveragePrice::where('city', $city)->first();

        if (!$cityData) {
            return null;
        }

        $basePrice = $cityData->avg_price_per_sqft * $size;

        $ageFactor = 1.0;
        if($age>5)
        {
            $ageOver = $age - 5;
            $ageFactor = max(0.5, 1 - (0.01*$ageOver));
        }

        $roomFactor = 1.0;
        if($rooms>2)
        {
            $extraRooms = $rooms - 2;
            $roomFactor = 1 + (0.05 * $extraRooms);
        }

        $estimatedPrice = $basePrice * $ageFactor * $roomFactor;

        return round($estimatedPrice, 2);
    }
}

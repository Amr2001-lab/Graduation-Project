<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::query();

        // Filter by Price Range (format: "min-max" or "min-")
        if ($price = $request->input('price')) {
            $parts = explode('-', $price);
            $minPrice = $parts[0];
            $maxPrice = $parts[1];
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        }

        // Filter by Location (City)
        if ($location = $request->input('location')) {
            $query->where('city', 'like', '%' . $location . '%');
        }

        // Filter by Building Age
        if ($age = $request->input('age')) {
            if ($age === '21+') {
                $query->where('age', '>', 20);
            } else {
                $parts = explode('-', $age);
                $minAge = $parts[0];
                $maxAge = $parts[1];
                $query->whereBetween('age', [$minAge, $maxAge]);
            }
        }

        // Filter by Rooms
        if ($rooms = $request->input('rooms')) {
            if ($rooms == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', '=', $rooms);
            }
        }

        $apartment = $query->get();
        return view('homepage', compact('apartment'));
    }
}

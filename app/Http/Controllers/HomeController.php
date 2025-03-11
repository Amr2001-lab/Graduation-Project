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

            // Make sure $parts has 2 items; otherwise $parts[1] may not exist
            if (count($parts) === 2) {
                $minPrice = (int)$parts[0];
                $maxSegment = $parts[1];  // Could be empty if "1000000-"

                if ($maxSegment === '') {
                    // Means "Over minPrice" (e.g., "1000000-")
                    $query->where('price', '>=', $minPrice);
                } else {
                    // Normal "min-max" range
                    $maxPrice = (int)$maxSegment;
                    $query->whereBetween('price', [$minPrice, $maxPrice]);
                }
            }
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
                if (count($parts) === 2) {
                    $minAge = (int)$parts[0];
                    $maxAge = (int)$parts[1];
                    $query->whereBetween('age', [$minAge, $maxAge]);
                }
            }
        }

        // Filter by Rooms
        if ($rooms = $request->input('rooms')) {
            if ($rooms == '4') {
                // means "4 or more"
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', (int)$rooms);
            }
        }

        // Paginate and preserve query parameters
        $apartment = $query->paginate(12)->appends($request->query());

        // If AJAX, return just the partial; otherwise return the main view
        if ($request->ajax()) {
            return view('homepage', compact('apartment'))->render();
        }

        return view('homepage', compact('apartment'));
    }
}

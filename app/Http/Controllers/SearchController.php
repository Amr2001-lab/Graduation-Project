<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('q');

        if (!$query) {
            return response()->json([]);
        }

        $apartments = Apartment::where('street', 'like', '%' . $query . '%')
            ->orWhere('city', 'like', '%' . $query . '%')
            ->orWhere('price', 'like', '%' . $query . '%')
            ->get();

        return response()->json($apartments);
    }

    public function showResults(Request $request)
    {
        $query = $request->input('q');

        $property = Apartment::where('street', 'like', '%' . $query . '%')->orWhere('city', 'like', '%' . $query . '%')->orWhere('price', 'like' , '%' . $query . '%')->first();

        if (!$property)
        {
            abort(404, 'No property found!');
        }
        return view('property.show', compact('property'));
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PropertyEstimator;

class EstimateController extends Controller
{
    public function index(Request $request)
    {
        $estimatedPrice = null;
        $city = null;
        $size = null;
        $age  = null;
        $rooms= null;

        if ($request->isMethod('post')) {
            // Validate the input
            $request->validate([
                'city'  => 'required|string',
                'size'  => 'required|numeric',
                'age'   => 'required|integer',
                'rooms' => 'required|integer',
            ]);

            // Extract form data
            $city  = (string)$request->input('city');
            $size  = (float)$request->input('size');
            $age   = (int)$request->input('age');
            $rooms = (int)$request->input('rooms');

            // Estimate the price
            $estimatedPrice = PropertyEstimator::estimate($city, $size, $age, $rooms);
        }

        // Always return the same view (the form + optional result)
        return view('estimate.form', compact('estimatedPrice', 'city', 'size', 'age', 'rooms'));
    }
}

<?php
namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function show($id, Request $request)
    {
        $property = Apartment::findOrFail($id);
        $otherProperty = null;
        
        if ($request->has('other_id')) {
            $otherProperty = Apartment::find($request->get('other_id'));
        }
        
        return view('property.compare', compact('property', 'otherProperty'));
    }

    public function updateComparison($id)
    {
        $property = Apartment::findOrFail($id);
        return view('property._compareColumn', ['prop' => $property]);
    }
}

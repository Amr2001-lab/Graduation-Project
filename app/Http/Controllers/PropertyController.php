<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Routing\Controller;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show($id)
    {
        $property = Apartment::findOrFail($id);
        return view('property.show', compact('property'));
    }

    public function create()
    {
        return view('property.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'size'      => 'required|integer',
            'price'     => 'required|numeric',
            'street'    => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'age'       => 'required|integer',
            'rooms'     => 'required|integer',
            'bathrooms' => 'required|integer',
            'phone'     => 'required|string|max:20',
            'images.*'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['seller_id'] = auth()->id();
        $apartment = Apartment::create($validated);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $originalFilename = $imageFile->getClientOriginalName();
                $imageFile->storeAs('Images', $originalFilename, 'public');
                $apartment->images()->create(['image_url' => $originalFilename]);
            }
        }

        return redirect()->route('property.show', $apartment->id);
    }
}

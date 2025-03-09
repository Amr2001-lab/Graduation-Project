<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;
use Illumiante\Auth\AuthServiceProvider;

class PropertyController extends Controller
{
    public function show($id)
    {
        $property = Apartment::findOrFail($id);
        return view('property.show', compact('property'));
    }

    public function create()
    {
        return view('property.create');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'size'      => 'required|integer',
            'price'     => 'required|numeric',
            'street'    => 'required|string|max:255',
            'city'      => 'required|string|max:255',
            'age'       => 'nullable|integer',
            'rooms'     => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'phone'     => 'nullable|string|max:20',
            'images.*'  => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['seller_id'] = auth()->id();
        $apartment = Apartment::create($validated);

        if ($request->hasFile('images')) {
            $imageFile = $request->file('images')[0];
            $path = $imageFile->store('storage/Images');
            $filename = basename($path);

            $apartment->image_url = $filename;
            $apartment->save();
        }

        return redirect()->route('property.show', $apartment->id);
    }
}

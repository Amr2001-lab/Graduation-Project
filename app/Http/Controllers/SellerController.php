<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\ApartmentImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    public function edit(Apartment $apartment)
    {
        $apartment->load('images');
        return view('seller.edit-property', compact('apartment'));
    }

    public function update(Request $request, Apartment $apartment)
    {
        $validatedData = $request->validate([
            'city' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'size' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0',
            'rooms' => 'required|integer|min:1',
            'bathrooms' => 'required|integer|min:1',
            'phone' => 'nullable|string|max:20',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $apartment->update([
            'city' => $validatedData['city'],
            'street' => $validatedData['street'],
            'size' => $validatedData['size'],
            'price' => $validatedData['price'],
            'age' => $validatedData['age'],
            'rooms' => $validatedData['rooms'],
            'bathrooms' => $validatedData['bathrooms'],
            'phone' => $validatedData['phone'],
        ]);

        if($request->hasFile('images'))
        {
            foreach($request->file('images') as $image)
            {
                $imageName =  $image->getClientOriginalName();
                $image->storeAs('Images', $imageName, 'public');
                ApartmentImage::create([
                    'apartment_id' => $apartment->id,
                    'image_url' => $imageName,
                ]);
            }
        }

        return redirect()->route('property.show', $apartment->id)->with('success', 'Property updated successfully');
    }

    public function destroyImage(ApartmentImage $image)
    {
        if(Storage::exists('public/Images/' . $image->image_url))
        {
            Storage::delete('public/Images/' . $image->image_url);
        }
        $image->delete();
        return response()->json(['success'=> 'Image deleted successfully']);
    }

    public function destroy(Apartment $apartment)
    {
        foreach($apartment->images as $image)
        {
            if(Storage::exists('public/Images' . $image->image_url))
            {
                Storage::delete('public/Images' . $image->image_url);
            }
            $image->delete();
        }
        $apartment->delete();
        return redirect()->route('profile.show')->with('success', 'Property removed');
    }
}

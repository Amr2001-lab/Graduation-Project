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

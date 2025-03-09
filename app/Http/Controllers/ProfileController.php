<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;   // Include Bookmark model
use App\Models\Apartment;  // Include Apartment model if needed

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        // Eager load the apartment relationship on bookmarks
        $bookmarks = $user->bookmarks()->with('apartment')->get();
        $properties = $user->properties;
        
        return view('profile.show', compact('user', 'bookmarks', 'properties'));
    }
}

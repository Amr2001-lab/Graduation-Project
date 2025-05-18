<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bookmark;  
use App\Models\Apartment; 

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $bookmarks = $user->bookmarks()->with('apartment')->get();
        $properties = $user->properties;
        
        return view('profile.show', compact('user', 'bookmarks', 'properties'));
    }
}

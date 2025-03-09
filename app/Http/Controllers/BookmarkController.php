<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;
use App\Models\User;

class BookmarkController extends Controller
{
        public function store(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required|exists:apartment,id',
        ]);
    
        $user = Auth::user();
        $apartmentId = $request->input('apartment_id');
    
        // Prevent duplicate bookmarks
        if ($user->bookmarks()->where('apartment_id', $apartmentId)->exists()) {
            return redirect()->back()->with('message', 'Property already bookmarked.');
        }
    
        $user->bookmarks()->create([
            'apartment_id' => $apartmentId,
        ]);
    
        return redirect()->back()->with('message', 'Property bookmarked successfully.');
    }

}

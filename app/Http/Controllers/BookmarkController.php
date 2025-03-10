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
    $apartmentId = (int) $request->input('apartment_id');

    // 1) Check the DB for a matching bookmark for this user/apartment.
    //    (Make sure your "bookmarks()" relationship is defined in User.)
    $alreadyBookmarked = $user->bookmarks()
        ->where('apartment_id', $apartmentId)
        ->exists();

    if ($alreadyBookmarked) {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Property already bookmarked.'], 200);
        }
        return redirect()->back()->with('message', 'Property already bookmarked.');
    }

    // 2) Create the bookmark
    $user->bookmarks()->create(['apartment_id' => $apartmentId]);

    // 3) Return success
    if ($request->expectsJson()) {
        return response()->json(['message' => 'Property bookmarked successfully.'], 200);
    }
    return redirect()->back()->with('message', 'Property bookmarked successfully.');
}

}

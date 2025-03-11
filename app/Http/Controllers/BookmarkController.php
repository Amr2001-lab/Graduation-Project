<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;
use App\Models\Apartment;

class BookmarkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'apartment_id' => 'required|exists:apartment,id', // Fixed table name
        ]);

        $user = Auth::user();
        $apartmentId = $request->input('apartment_id');

        // Toggle bookmark
        $bookmark = $user->bookmarks()
            ->where('apartment_id', $apartmentId)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $added = false;
        } else {
            $user->bookmarks()->create(['apartment_id' => $apartmentId]);
            $added = true;
        }

        return response()->json([
            'added' => $added,
            'message' => $added ? 'Property bookmarked successfully.' : 'Bookmark removed.'
        ]);
    }
}
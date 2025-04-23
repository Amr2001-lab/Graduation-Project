<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Apartment::query()->with('images');

        if ($price = $request->input('price')) {
            $parts = explode('-', $price);

            if (count($parts) === 2) {
                $minPrice = (int)$parts[0];
                $maxSegment = $parts[1];

                if ($maxSegment === '') {
                    $query->where('price', '>=', $minPrice);
                } else {
                    $maxPrice = (int)$maxSegment;
                    $query->whereBetween('price', [$minPrice, $maxPrice]);
                }
            }
        }

        if ($location = $request->input('location')) {
            $query->where('city', 'like', '%' . $location . '%');
        }

        if ($age = $request->input('age')) {
            if ($age === '21+') {
                $query->where('age', '>', 20);
            } else {
                $parts = explode('-', $age);
                if (count($parts) === 2) {
                    $minAge = (int)$parts[0];
                    $maxAge = (int)$parts[1];
                    $query->whereBetween('age', [$minAge, $maxAge]);
                }
            }
        }

        if ($rooms = $request->input('rooms')) {
            if ($rooms == '4') {
                $query->where('rooms', '>=', 4);
            } else {
                $query->where('rooms', (int)$rooms);
            }
        }

        if ($time_posted = $request->input('time_posted')) {
            if ($time_posted === '24h') {
                $query->where('created_at', '>=', Carbon::now()->subDay());
            } elseif ($time_posted === 'week') {
                $query->where('created_at', '>=', Carbon::now()->subWeek());
            } elseif ($time_posted === 'month') {
                $query->where('created_at', '>=', Carbon::now()->subMonth());
            } elseif ($time_posted === 'year') {
                $query->where('created_at', '>=', Carbon::now()->subYear());
            }
        }

        $query->orderBy('created_at', 'desc');

        $apartment = $query->paginate(12)->appends($request->query());

        if ($request->ajax()) {
            return view('homepage', compact('apartment'))->render();
        }

        return view('homepage', compact('apartment'));
    }
}
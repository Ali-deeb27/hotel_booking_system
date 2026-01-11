<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $query = Hotel::where('is_active', true)->with('rooms');

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by city
        if ($request->has('city')) {
            $query->where('city', $request->city);
        }

        // Filter by star rating
        if ($request->filled('star_rating')) {
        $query->where('star_rating', '>=', $request->star_rating);
}

        $hotels = $query->paginate(12);
        $cities = Hotel::where('is_active', true)->distinct()->pluck('city');

        return view('hotels.index', compact('hotels', 'cities'));
    }

    public function show(Hotel $hotel)
    {
        $hotel->load(['rooms' => function ($query) {
            $query->where('is_available', true);
        }]);

        // Get check-in/check-out from session if available
        $checkIn = session('booking.check_in');
        $checkOut = session('booking.check_out');
        $guests = session('booking.guests', 1);

        return view('hotels.show', compact('hotel', 'checkIn', 'checkOut', 'guests'));
    }
}

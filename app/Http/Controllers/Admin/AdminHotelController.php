<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminHotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::withCount('rooms')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.hotels.index', compact('hotels'));
    }

    public function create()
    {
        return view('admin.hotels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
        }

        $validated['is_active'] = $request->has('is_active');
        if ($imagePath) {
            $validated['image_path'] = $imagePath;
        }
        Hotel::create($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel created successfully!');
    }

    public function edit(Hotel $hotel)
    {
        return view('admin.hotels.edit', compact('hotel'));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'star_rating' => 'required|integer|min:1|max:5',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_active'] = $request->has('is_active');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotels', 'public');
        }
        if (isset($imagePath)) {
            $validated['image_path'] = $imagePath;
        }

        $hotel->update($validated);

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel updated successfully!');
}


    public function destroy(Hotel $hotel)
    {
        // Check if hotel has bookings
        if ($hotel->bookings()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete hotel with existing bookings.']);
        }

        $hotel->delete();

        return redirect()->route('admin.hotels.index')->with('success', 'Hotel deleted successfully!');
    }
}

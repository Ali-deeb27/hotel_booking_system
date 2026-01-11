<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Hotel;
use App\Models\Amenity;
use Illuminate\Http\Request;

class AdminRoomController extends Controller
{

    public function index(Request $request)
    {
        $query = Room::with(['hotel', 'amenities']);

        if ($request->has('hotel_id') && $request->hotel_id) {
            $query->where('hotel_id', $request->hotel_id);
        }

        $rooms = $query->orderBy('created_at', 'desc')->paginate(15);
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();

        return view('admin.rooms.index', compact('rooms', 'hotels'));
    }

    public function create(Request $request)
    {
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();
        $amenities = Amenity::orderBy('name')->get();
        $selectedHotel = $request->hotel_id ? Hotel::find($request->hotel_id) : null;

        return view('admin.rooms.create', compact('hotels', 'amenities', 'selectedHotel'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:255',
            'description' => 'required|string',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'price_per_night' => 'required|numeric|min:0',
            'size_sqm' => 'nullable|integer|min:0',
            'bed_type' => 'nullable|string|max:255',
            'has_wifi' => 'boolean',
            'has_tv' => 'boolean',
            'has_ac' => 'boolean',
            'has_balcony' => 'boolean',
            'is_available' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['has_wifi'] = $request->has('has_wifi');
        $validated['has_tv'] = $request->has('has_tv');
        $validated['has_ac'] = $request->has('has_ac');
        $validated['has_balcony'] = $request->has('has_balcony');
        $validated['is_available'] = $request->has('is_available');
       
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotels', 'public');
        }
        if (isset($path)) {
            $validated['image'] = $path;
        }

        $room = Room::create($validated);

        if ($request->has('amenities')) {
            $room->amenities()->attach($request->amenities);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully!');
    }

    public function edit(Room $room)
    {
        $hotels = Hotel::where('is_active', true)->orderBy('name')->get();
        $amenities = Amenity::orderBy('name')->get();
        $room->load('amenities');

        return view('admin.rooms.edit', compact('room', 'hotels', 'amenities'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'room_number' => 'required|string|max:50',
            'room_type' => 'required|string|max:255',
            'description' => 'required|string',
            'max_occupancy' => 'required|integer|min:1|max:20',
            'price_per_night' => 'required|numeric|min:0',
            'size_sqm' => 'nullable|integer|min:0',
            'bed_type' => 'nullable|string|max:255',
            'has_wifi' => 'boolean',
            'has_tv' => 'boolean',
            'has_ac' => 'boolean',
            'has_balcony' => 'boolean',
            'is_available' => 'boolean',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['has_wifi'] = $request->has('has_wifi');
        $validated['has_tv'] = $request->has('has_tv');
        $validated['has_ac'] = $request->has('has_ac');
        $validated['has_balcony'] = $request->has('has_balcony');
        $validated['is_available'] = $request->has('is_available');
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('hotels', 'public');
        }
        if (isset($path)) {
            $validated['image'] = $path;
        }

        $room->update($validated);

        if ($request->has('amenities')) {
            $room->amenities()->sync($request->amenities);
        } else {
            $room->amenities()->detach();
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy(Room $room)
    {
        // Check if room has bookings
        if ($room->bookings()->exists()) {
            return back()->withErrors(['error' => 'Cannot delete room with existing bookings.']);
        }

        $room->amenities()->detach();
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}

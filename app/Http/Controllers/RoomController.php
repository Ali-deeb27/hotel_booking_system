<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RoomController extends Controller
{
    public function search(Request $request)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1',
            'city' => 'nullable|string',
        ]);

        // Store search criteria in session
        session([
            'booking.check_in' => $request->check_in,
            'booking.check_out' => $request->check_out,
            'booking.guests' => $request->guests,
            'booking.city' => $request->city,
        ]);

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);

        $query = Room::where('is_available', true)
            ->where('max_occupancy', '>=', $request->guests)
            ->with(['hotel', 'amenities']);

        if ($request->city) {
            $query->whereHas('hotel', function ($q) use ($request) {
                $q->where('city', $request->city)->where('is_active', true);
            });
        } else {
            $query->whereHas('hotel', function ($q) {
                $q->where('is_active', true);
            });
        }

        // Filter available rooms based on dates
        $bookedRoomIds = \App\Models\Booking::where('status', '!=', 'cancelled')
            ->where(function ($q) use ($checkIn, $checkOut) {
                $q->whereBetween('check_in', [$checkIn, $checkOut])
                  ->orWhereBetween('check_out', [$checkIn, $checkOut])
                  ->orWhere(function ($query) use ($checkIn, $checkOut) {
                      $query->where('check_in', '<=', $checkIn)
                            ->where('check_out', '>=', $checkOut);
                  });
            })
            ->pluck('room_id');

        $rooms = $query->whereNotIn('id', $bookedRoomIds)->get();

        // Group by hotel for better display
        $roomsByHotel = $rooms->groupBy('hotel_id');

        return view('rooms.search', compact('rooms', 'roomsByHotel', 'checkIn', 'checkOut'));
    }

    public function show(Room $room)
    {
        $room->load(['hotel', 'amenities']);

        $checkIn = session('booking.check_in');
        $checkOut = session('booking.check_out');
        $guests = session('booking.guests', 1);

        if ($checkIn && $checkOut) {
            $checkInDate = Carbon::parse($checkIn);
            $checkOutDate = Carbon::parse($checkOut);
            $nights = $checkInDate->diffInDays($checkOutDate);
            $totalPrice = $room->price_per_night * $nights;
        } else {
            $nights = 1;
            $totalPrice = $room->price_per_night;
        }

        return view('rooms.show', compact('room', 'checkIn', 'checkOut', 'guests', 'nights', 'totalPrice'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller{
    public function create(Request $request, Room $room)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'guests' => 'required|integer|min:1|max:' . $room->max_occupancy,
        ]);

        // Verify room availability
        if (!$room->isAvailableForDates($request->check_in, $request->check_out)) {
            return back()->withErrors(['error' => 'This room is not available for the selected dates.']);
        }

        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nights = $checkIn->diffInDays($checkOut);
        $totalPrice = $room->price_per_night * $nights;

        // Store booking details in session
        session([
            'booking.room_id' => $room->id,
            'booking.check_in' => $request->check_in,
            'booking.check_out' => $request->check_out,
            'booking.guests' => $request->guests,
            'booking.total_price' => $totalPrice,
            'booking.nights' => $nights,
        ]);

        $room->load(['hotel', 'amenities']);

        return view('bookings.create', compact('room', 'checkIn', 'checkOut', 'nights', 'totalPrice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'special_requests' => 'nullable|string|max:1000',
        ]);

        // Get booking data from session
        $bookingData = session('booking');

        if (!$bookingData || !isset($bookingData['room_id'])) {
            return redirect()->route('hotels.index')->withErrors(['error' => 'Booking session expired. Please search again.']);
        }

        $room = Room::findOrFail($bookingData['room_id']);

        // Double-check availability
        if (!$room->isAvailableForDates($bookingData['check_in'], $bookingData['check_out'])) {
            return redirect()->route('rooms.show', $room)->withErrors(['error' => 'This room is no longer available for the selected dates.']);
        }

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $bookingData['room_id'],
            'check_in' => $bookingData['check_in'],
            'check_out' => $bookingData['check_out'],
            'guests' => $bookingData['guests'],
            'total_price' => $bookingData['total_price'],
            'status' => 'confirmed',
            'payment_status' => 'paid', // In production, integrate with payment gateway
            'special_requests' => $request->special_requests,
        ]);

        // Clear booking session
        session()->forget('booking');

        return redirect()->route('bookings.show', $booking)->with('success', 'Booking confirmed successfully!');
    }

    public function index()
    {
        $bookings = Auth::user()->bookings()
            ->with(['room.hotel'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['room.hotel', 'room.amenities', 'user']);

        return view('bookings.show', compact('booking'));
    }

    public function cancel(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->withErrors(['error' => 'Booking is already cancelled.']);
        }

        if (Carbon::parse($booking->check_in)->isPast()) {
            return back()->withErrors(['error' => 'Cannot cancel past bookings.']);
        }

        $booking->update([
            'status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);

        return back()->with('success', 'Booking cancelled successfully.');
    }
}

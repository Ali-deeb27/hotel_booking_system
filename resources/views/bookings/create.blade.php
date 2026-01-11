@extends('layouts.app')

@section('title', 'Confirm Booking')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">Confirm Your Booking</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Booking Summary -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Room Details</h2>
                <div class="flex gap-4">
                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->room_number }}" class="w-32 h-32 object-cover rounded-lg">
                    @else
                        <div class="w-32 h-32 bg-gray-300 rounded-lg flex items-center justify-center text-white text-4xl">
                            X
                        </div>
                    @endif
                    <div class="flex-1">
                        <h3 class="text-lg font-bold">{{ $room->room_type }} - {{ $room->room_number }}</h3>
                        <p class="text-gray-600">{{ $room->hotel->name }}, {{ $room->hotel->city }}</p>
                        <p class="text-sm text-gray-500 mt-2">{{ Str::limit($room->description, 100) }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold mb-4">Booking Information</h2>
                <div class="space-y-4">
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Check-in:</span>
                        <span class="font-medium">{{ $checkIn->format('l, F d, Y') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Check-out:</span>
                        <span class="font-medium">{{ $checkOut->format('l, F d, Y') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Nights:</span>
                        <span class="font-medium">{{ $nights }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Guests:</span>
                        <span class="font-medium">{{ session('booking.guests') }}</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span class="text-gray-600">Price per night:</span>
                        <span class="font-medium">${{ number_format($room->price_per_night, 2) }}</span>
                    </div>
                    <div class="flex justify-between pt-2">
                        <span class="text-lg font-bold">Total Price:</span>
                        <span class="text-2xl font-bold text-emerald-600">${{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-4">
                <h2 class="text-xl font-bold mb-4">Complete Booking</h2>
                
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Special Requests (Optional)</label>
                        <textarea name="special_requests" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md" placeholder="Any special requests or notes..."></textarea>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Subtotal:</span>
                            <span class="font-medium">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-300 pt-2 flex justify-between items-center">
                            <span class="font-bold">Total:</span>
                            <span class="text-xl font-bold text-emerald-600">${{ number_format($totalPrice, 2) }}</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-medium">
                        Confirm Booking
                    </button>

                    <a href="{{ route('rooms.show', $room) }}" class="block text-center text-gray-600 hover:text-gray-800 mt-3">
                        ← Back to room
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

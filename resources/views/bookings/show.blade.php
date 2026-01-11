@extends('layouts.app')

@section('title', 'Booking Details')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('bookings.index') }}" class="text-emerald-600 hover:text-emerald-800">← Back to My Bookings</a>
    </div>

    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-600 p-6 text-white">
            <h1 class="text-3xl font-bold mb-2">Booking Confirmation</h1>
            <p class="text-emerald-100">Reference: {{ $booking->booking_reference }}</p>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Hotel & Room Info -->
                <div>
                    <h2 class="text-xl font-bold mb-4">Hotel & Room</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Hotel</p>
                            <p class="font-medium text-lg">{{ $booking->room->hotel->name }}</p>
                            <p class="text-gray-600">{{ $booking->room->hotel->address }}, {{ $booking->room->hotel->city }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Room</p>
                            <p class="font-medium text-lg">{{ $booking->room->room_type }} - {{ $booking->room->room_number }}</p>
                            <p class="text-gray-600">{{ Str::limit($booking->room->description, 100) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div>
                    <h2 class="text-xl font-bold mb-4">Booking Details</h2>
                    <div class="space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Check-in</p>
                            <p class="font-medium">{{ $booking->check_in->format('l, F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Check-out</p>
                            <p class="font-medium">{{ $booking->check_out->format('l, F d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Duration</p>
                            <p class="font-medium">{{ $booking->number_of_nights }} nights</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Guests</p>
                            <p class="font-medium">{{ $booking->guests }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Status</p>
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            @if($booking->special_requests)
                <div class="mt-6 border-t pt-6">
                    <h3 class="font-bold mb-2">Special Requests</h3>
                    <p class="text-gray-700">{{ $booking->special_requests }}</p>
                </div>
            @endif

            <div class="mt-6 border-t pt-6">
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Price per night:</span>
                        <span class="font-medium">${{ number_format($booking->room->price_per_night, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Nights:</span>
                        <span class="font-medium">{{ $booking->number_of_nights }}</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2 flex justify-between items-center">
                        <span class="text-lg font-bold">Total Paid:</span>
                        <span class="text-2xl font-bold text-emerald-600">${{ number_format($booking->total_price, 2) }}</span>
                    </div>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Payment Status: <span class="font-medium text-green-600">{{ ucfirst($booking->payment_status) }}</span></p>
                    </div>
                </div>
            </div>

            @if($booking->status === 'confirmed' && $booking->check_in->isFuture())
                <div class="mt-6">
                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')" 
                                class="bg-red-600 text-white px-6 py-3 rounded-md hover:bg-red-700">
                            Cancel Booking
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

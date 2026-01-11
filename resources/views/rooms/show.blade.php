@extends('layouts.app')

@section('title', $room->room_type)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
        <div class="md:flex">
            <div class="md:w-1/2">
                @if($room->image)
                    <img src="{{ asset( $room->image) }}" alt="{{ $room->room_number }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-96 bg-gray-300 flex items-center justify-center text-white text-9xl">
                        X
                    </div>
                @endif
            </div>
            <div class="md:w-1/2 p-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $room->room_type }} - {{ $room->room_number }}</h1>
                <p class="text-gray-600 mb-4">
                    <a href="{{ route('hotels.show', $room->hotel) }}" class="hover:text-emerald-600">
                        {{ $room->hotel->name }}, {{ $room->hotel->city }}
                    </a>
                </p>

                <div class="border-t border-b border-gray-200 py-6 my-6">
                    <h2 class="text-xl font-bold mb-4">Description</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $room->description }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Max Occupancy</p>
                        <p class="text-xl font-bold">👥 {{ $room->max_occupancy }}</p>
                    </div>
                    @if($room->size_sqm)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Size</p>
                            <p class="text-xl font-bold">📐 {{ $room->size_sqm }} m²</p>
                        </div>
                    @endif
                    @if($room->bed_type)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500 mb-1">Bed Type</p>
                            <p class="text-xl font-bold">🛏️ {{ $room->bed_type }}</p>
                        </div>
                    @endif
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-500 mb-1">Price per Night</p>
                        <p class="text-2xl font-bold text-indigo-600">${{ number_format($room->price_per_night, 2) }}</p>
                    </div>
                </div>

                <div class="mb-6">
                    <h3 class="font-bold mb-2">Room Features:</h3>
                    <div class="flex flex-wrap gap-2">
                        @if($room->has_wifi)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">✓ WiFi</span>
                        @endif
                        @if($room->has_tv)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">✓ TV</span>
                        @endif
                        @if($room->has_ac)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">✓ AC</span>
                        @endif
                        @if($room->has_balcony)
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">✓ Balcony</span>
                        @endif
                    </div>
                </div>

                @if($room->amenities->count() > 0)
                    <div class="mb-6">
                        <h3 class="font-bold mb-2">Amenities:</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($room->amenities as $amenity)
                                <span class="bg-blue-100 text-emerald-700 px-3 py-1 rounded-full text-sm">
                                    @if($amenity->icon) {{ $amenity->icon }} @endif {{ $amenity->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Booking Form -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Book This Room</h2>
        
        <form action="{{ route('bookings.create', $room) }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check In</label>
                    <input type="date" name="check_in" value="{{ $checkIn ?? date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check Out</label>
                    <input type="date" name="check_out" value="{{ $checkOut ?? date('Y-m-d', strtotime('+1 day')) }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Guests</label>
                    <input type="number" name="guests" value="{{ $guests ?? 1 }}" min="1" max="{{ $room->max_occupancy }}" required class="w-full px-4 py-2 border border-gray-300 rounded-md">
                </div>
            </div>

            @if($checkIn && $checkOut)
                @php
                    $nights = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut));
                    $totalPrice = $room->price_per_night * $nights;
                @endphp
                <div class="bg-gray-50 rounded-lg p-4 mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <span>Price per night:</span>
                        <span class="font-bold">${{ number_format($room->price_per_night, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span>Nights:</span>
                        <span class="font-bold">{{ $nights }}</span>
                    </div>
                    <div class="border-t border-gray-300 pt-2 flex justify-between items-center">
                        <span class="text-lg font-bold">Total:</span>
                        <span class="text-2xl font-bold text-emerald-600">${{ number_format($totalPrice, 2) }}</span>
                    </div>
                </div>
            @endif

            @auth
                <button type="submit" class="w-full bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 font-medium text-lg">
                    Continue to Booking
                </button>
            @else
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                    <p class="text-yellow-800">Please <a href="{{ route('login') }}" class="underline font-medium">login</a> or <a href="{{ route('register') }}" class="underline font-medium">register</a> to make a booking.</p>
                </div>
                <button type="button" disabled class="w-full bg-gray-400 text-white px-6 py-3 rounded-md font-medium text-lg cursor-not-allowed">
                    Login to Book
                </button>
            @endauth
        </form>
    </div>
</div>
@endsection

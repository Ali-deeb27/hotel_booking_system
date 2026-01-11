@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Available Rooms</h1>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <p class="text-blue-800">
                <strong>Search Criteria:</strong> 
                Check-in: {{ $checkIn->format('M d, Y') }} | 
                Check-out: {{ $checkOut->format('M d, Y') }} | 
                Nights: {{ $checkIn->diffInDays($checkOut) }}
            </p>
        </div>
    </div>

    @if($rooms->count() > 0)
        @foreach($roomsByHotel as $hotelId => $hotelRooms)
            @php $hotel = $hotelRooms->first()->hotel; @endphp
            <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
                <div class="bg-gradient-to-r from-emerald-600 to-emerald-800 p-6 text-white">
                    <h2 class="text-2xl font-bold">{{ $hotel->name }}</h2>
                    <p class="text-indigo-100">{{ $hotel->city }}, {{ $hotel->country }}</p>
                    <div class="text-yellow-300 mt-1">
                        @for($i = 0; $i < $hotel->star_rating; $i++)
                            ★
                        @endfor
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($hotelRooms as $room)
                            <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                                @if($room->image)
                                    <img src="{{ asset( $room->image) }}" alt="{{ $room->room_number }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-white text-5xl">
                                        X
                                    </div>
                                @endif
                                <div class="p-4">
                                    <h3 class="text-lg font-bold mb-2">{{ $room->room_type }} - {{ $room->room_number }}</h3>
                                    <p class="text-gray-600 text-sm mb-3">{{ Str::limit($room->description, 80) }}</p>
                                    
                                    <div class="flex flex-wrap gap-2 mb-3">
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">👥 {{ $room->max_occupancy }}</span>
                                        @if($room->size_sqm)
                                            <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">📐 {{ $room->size_sqm }}m²</span>
                                        @endif
                                    </div>

                                    @php
                                        $nights = $checkIn->diffInDays($checkOut);
                                        $totalPrice = $room->price_per_night * $nights;
                                    @endphp

                                    <div class="flex items-center justify-between mt-4">
                                        <div>
                                            <p class="text-xl font-bold text-indigo-600">${{ number_format($room->price_per_night, 2) }}</p>
                                            <p class="text-xs text-gray-500">${{ number_format($totalPrice, 2) }} total</p>
                                        </div>
                                        <a href="{{ route('rooms.show', $room) }}?check_in={{ $checkIn->format('Y-m-d') }}&check_out={{ $checkOut->format('Y-m-d') }}&guests={{ session('booking.guests', 1) }}" 
                                           class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700 text-sm font-medium">
                                            Book Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-xl mb-4">No rooms available for your search criteria.</p>
            <a href="{{ route('hotels.index') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 inline-block">
                Search Again
            </a>
        </div>
    @endif
</div>
@endsection

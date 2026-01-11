@extends('layouts.app')

@section('title', $hotel->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        @if($hotel->image)
            <img src="{{ asset('storage/' . $hotel->image) }}" alt="{{ $hotel->name }}" class="w-full h-96 object-cover">
        @else
            <div class="w-full h-96 bg-gray-300 flex items-center justify-center text-white text-9xl">
                X
            </div>
        @endif
        
        <div class="p-8">
            <div class="flex justify-between items-start mb-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $hotel->name }}</h1>
                    <div class="flex items-center text-gray-600 mb-2">
                        <span class="mr-2">📍</span>
                        <span>{{ $hotel->address }}, {{ $hotel->city }}, {{ $hotel->country }}</span>
                    </div>
                    <div class="text-yellow-400 text-xl">
                        @for($i = 0; $i < $hotel->star_rating; $i++)
                            ★
                        @endfor
                    </div>
                </div>
                <div class="text-right">
                    @if($hotel->phone)
                        <p class="text-gray-600">📞 {{ $hotel->phone }}</p>
                    @endif
                    @if($hotel->email)
                        <p class="text-gray-600">✉️ {{ $hotel->email }}</p>
                    @endif
                </div>
            </div>

            <div class="border-t border-b border-gray-200 py-6 my-6">
                <h2 class="text-xl font-bold mb-4">Description</h2>
                <p class="text-gray-700 leading-relaxed">{{ $hotel->description }}</p>
            </div>

            <h2 class="text-2xl font-bold mb-6">Available Rooms</h2>
            
            @if($checkIn && $checkOut)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <p class="text-blue-800">
                        <strong>Search Criteria:</strong> 
                        Check-in: {{ \Carbon\Carbon::parse($checkIn)->format('M d, Y') }} | 
                        Check-out: {{ \Carbon\Carbon::parse($checkOut)->format('M d, Y') }} | 
                        Guests: {{ $guests }}
                    </p>
                </div>
            @endif

            @if($hotel->rooms->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($hotel->rooms as $room)
                        <div class="border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow">
                            @if($room->image)
                                <img src="{{ asset('storage/' . $room->image) }}" alt="{{ $room->room_number }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-white text-5xl">
                                    X
                                </div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2">{{ $room->room_type }} - {{ $room->room_number }}</h3>
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($room->description, 100) }}</p>
                                
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">👥 Max {{ $room->max_occupancy }}</span>
                                    @if($room->size_sqm)
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">📐 {{ $room->size_sqm }} m²</span>
                                    @endif
                                    @if($room->bed_type)
                                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">🛏️ {{ $room->bed_type }}</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-2xl font-bold text-emerald-600">${{ number_format($room->price_per_night, 2) }}</p>
                                        <p class="text-sm text-gray-500">per night</p>
                                    </div>
                                    @if($checkIn && $checkOut)
                                        <a href="{{ route('rooms.show', $room) }}?check_in={{ $checkIn }}&check_out={{ $checkOut }}&guests={{ $guests }}" 
                                           class="bg-emerald-600 text-white px-6 py-2 rounded-md hover:bg-emerald-700 font-medium">
                                            Book Now
                                        </a>
                                    @else
                                        <a href="{{ route('rooms.show', $room) }}" 
                                           class="bg-emerald-600 text-white px-6 py-2 rounded-md hover:bg-emerald-700 font-medium">
                                            View Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 text-lg">No rooms available at this hotel.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

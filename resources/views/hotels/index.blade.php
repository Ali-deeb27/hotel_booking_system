@extends('layouts.app')

@section('title', 'Hotels')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Hero Section with Search -->
    <div class="bg-gradient-to-r from-emerald-800 to-stone-100 rounded-lg shadow-xl p-8 mb-8 text-stone-100">
        <h1 class="text-4xl font-bold mb-4">Find Your Perfect Stay</h1>
        <p class="text-xl mb-6">Search for hotels and book your dream vacation</p>
        
        <form action="{{ route('rooms.search') }}" method="GET" class="bg-emerald-900 rounded-lg p-4 shadow-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-stone-100 mb-1">City</label>
                    <input type="text" name="city" value="{{ request('city') }}" placeholder="Enter city" class="w-full px-3 py-2 border border-gray-300 rounded-md text-stone-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-100 mb-1">Check In</label>
                    <input type="date" name="check_in" value="{{ request('check_in') }}" min="{{ date('Y-m-d') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-stone-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-100 mb-1">Check Out</label>
                    <input type="date" name="check_out" value="{{ request('check_out') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-stone-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-stone-100 mb-1">Guests</label>
                    <input type="number" name="guests" value="{{ request('guests', 1) }}" min="1" required class="w-full px-3 py-2 border border-gray-300 rounded-md text-stone-200">
                </div>
            </div>
            <button type="submit" class="mt-4 w-full bg-stone-300 text-stone-800 px-6 py-3 rounded-md hover:bg-stone-400 font-medium">
                Search Hotels
            </button>
        </form>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-4 mb-6">
        <form method="GET" action="{{ route('hotels.index') }}" class="flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search hotels..." class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                <select name="city" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">All Cities</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
                    @endforeach
                </select>
            </div>
            <div class="min-w-[150px]">
                <label class="block text-sm font-medium text-gray-700 mb-1">Star Rating</label>
                <select name="star_rating" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Any</option>
                    <option value="5" {{ request('star_rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                    <option value="4" {{ request('star_rating') == '4' ? 'selected' : '' }}>4+ Stars</option>
                    <option value="3" {{ request('star_rating') == '3' ? 'selected' : '' }}>3+ Stars</option>
                </select>
            </div>
            <button type="submit" class="bg-stone-400 text-white px-6 py-2 rounded-md hover:bg-stone-700">Filter</button>
            @if(request()->hasAny(['search', 'city', 'star_rating']))
                <a href="{{ route('hotels.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">Clear</a>
            @endif
        </form>
    </div>

    <!-- Hotels Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($hotels as $hotel)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                @if($hotel->image)
                    <img src="{{ asset( $hotel->image) }}" alt="{{ $hotel->name }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-300 flex items-center justify-center text-white text-6xl">
                        X
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="text-xl font-bold text-gray-900">{{ $hotel->name }}</h3>
                        <div class="text-yellow-400">
                            @for($i = 0; $i < $hotel->star_rating; $i++)
                                ★
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">{{ $hotel->city }}, {{ $hotel->country }}</p>
                    <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ Str::limit($hotel->description, 100) }}</p>
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">{{ $hotel->availableRooms->count() }} Rooms Available</p>
                        </div>
                        <a href="{{ route('hotels.show', $hotel) }}" class="bg-emerald-800 text-white px-4 py-2 rounded-md hover:bg-emerald-700 text-sm font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No hotels found. Try adjusting your search criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $hotels->links() }}
    </div>
</div>
@endsection

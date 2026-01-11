@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <h1 class="text-3xl font-bold mb-8">My Bookings</h1>

    @if($bookings->count() > 0)
        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <h3 class="text-xl font-bold">{{ $booking->room->hotel->name }}</h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $booking->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                        {{ $booking->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $booking->status === 'completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-2">{{ $booking->room->room_type }} - {{ $booking->room->room_number }}</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-gray-600">
                                    <div>
                                        <span class="font-medium">Check-in:</span>
                                        <p>{{ $booking->check_in->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium">Check-out:</span>
                                        <p>{{ $booking->check_out->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium">Guests:</span>
                                        <p>{{ $booking->guests }}</p>
                                    </div>
                                    <div>
                                        <span class="font-medium">Total:</span>
                                        <p class="font-bold text-emerald-600">${{ number_format($booking->total_price, 2) }}</p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Booking Reference: <strong>{{ $booking->booking_reference }}</strong></p>
                            </div>
                            <div class="mt-4 md:mt-0 md:ml-6">
                                <a href="{{ route('bookings.show', $booking) }}" class="block bg-emerald-800 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-center mb-2">
                                    View Details
                                </a>
                                @if($booking->status === 'confirmed' && $booking->check_in->isFuture())
                                    <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')" 
                                                class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                                            Cancel Booking
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <p class="text-gray-500 text-xl mb-4">You don't have any bookings yet.</p>
            <a href="{{ route('hotels.index') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-md hover:bg-emerald-700 inline-block">
                Browse Hotels
            </a>
        </div>
    @endif
</div>
@endsection

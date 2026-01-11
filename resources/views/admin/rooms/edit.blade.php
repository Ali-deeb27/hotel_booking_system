@extends('admin.layout')

@section('admin-content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Edit Room</h2>

    <form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hotel *</label>
                <select name="hotel_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    @foreach($hotels as $hotel)
                        <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>
                            {{ $hotel->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Number *</label>
                <input type="text" name="room_number" value="{{ old('room_number', $room->room_number) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Room Type *</label>
                <input type="text" name="room_type" value="{{ old('room_type', $room->room_type) }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Price Per Night *</label>
                <input type="number" step="0.01" name="price_per_night" value="{{ old('price_per_night', $room->price_per_night) }}" min="0" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Max Occupancy *</label>
                <input type="number" name="max_occupancy" value="{{ old('max_occupancy', $room->max_occupancy) }}" min="1" max="20" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Size (sqm)</label>
                <input type="number" name="size_sqm" value="{{ old('size_sqm', $room->size_sqm) }}" min="0" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bed Type</label>
                <input type="text" name="bed_type" value="{{ old('bed_type', $room->bed_type) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description', $room->description) }}</textarea>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Room Features</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="has_wifi" value="1" {{ old('has_wifi', $room->has_wifi) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700">WiFi</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="has_tv" value="1" {{ old('has_tv', $room->has_tv) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700">TV</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="has_ac" value="1" {{ old('has_ac', $room->has_ac) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700">AC</span>
                    </label>
                    <label class="flex items-center">
                        <input type="checkbox" name="has_balcony" value="1" {{ old('has_balcony', $room->has_balcony) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-2 text-sm text-gray-700">Balcony</span>
                    </label>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Amenities</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-h-48 overflow-y-auto border border-gray-200 rounded-md p-4">
                    @foreach($amenities as $amenity)
                        <label class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" {{ in_array($amenity->id, old('amenities', $room->amenities->pluck('id')->toArray())) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                            <span class="ml-2 text-sm text-gray-700">
                                @if($amenity->icon) {{ $amenity->icon }} @endif {{ $amenity->name }}
                            </span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $room->is_available) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-2 text-sm text-gray-700">Available</span>
                </label>
            </div>
            <div>
                <input type="file" name="image" accept="image/*">
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="bg-emerald-900 text-white px-6 py-2 rounded-md hover:bg-emerald-700">
                Update Room
            </button>
            <a href="{{ route('admin.rooms.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

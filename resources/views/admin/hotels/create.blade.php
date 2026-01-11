@extends('admin.layout')

@section('admin-content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-2xl font-bold text-gray-900 mb-6">Add New Hotel</h2>

    <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Hotel Name *</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Star Rating *</label>
                <select name="star_rating" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                    <option value="">Select Rating</option>
                    @for($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('star_rating') == $i ? 'selected' : '' }}>{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
                @error('star_rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                <textarea name="description" rows="4" required class="w-full px-3 py-2 border border-gray-300 rounded-md">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                <input type="text" name="address" value="{{ old('address') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('address')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                <input type="text" name="city" value="{{ old('city') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('city')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                <input type="text" name="state" value="{{ old('state') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Country *</label>
                <input type="text" name="country" value="{{ old('country') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('country')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Zip Code</label>
                <input type="text" name="zip_code" value="{{ old('zip_code') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Latitude</label>
                <input type="number" step="any" name="latitude" value="{{ old('latitude') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Longitude</label>
                <input type="number" step="any" name="longitude" value="{{ old('longitude') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md">
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>
            <div>
                <input type="file" name="image" accept="image/*">
            </div>
        </div>

        <div class="mt-6 flex space-x-4">
            <button type="submit" class="bg-emerald-900 text-white px-6 py-2 rounded-md hover:bg-emerald-700">
                Create Hotel
            </button>
            <a href="{{ route('admin.hotels.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-md hover:bg-gray-400">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection

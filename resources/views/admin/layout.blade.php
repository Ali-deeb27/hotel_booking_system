@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <nav class="mt-4 flex space-x-4">
            <a href="{{ route('admin.hotels.index') }}" class="px-4 py-2 bg-emerald-900 text-white rounded-md hover:bg-emerald-700">
                Manage Hotels
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-emerald-900 text-white rounded-md hover:bg-emerald-700">
                Manage Rooms
            </a>
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 bg-emerald-900 text-white rounded-md hover:bg-emerald-700">
                Manage Users
            </a>
        </nav>
    </div>

    @yield('admin-content')
</div>
@endsection


<?php

namespace Database\Seeders;

use App\Models\Amenity;
use Illuminate\Database\Seeder;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            ['name' => 'WiFi', 'icon' => '📶'],
            ['name' => 'TV', 'icon' => '📺'],
            ['name' => 'Air Conditioning', 'icon' => '❄️'],
            ['name' => 'Balcony', 'icon' => '🌅'],
            ['name' => 'Mini Bar', 'icon' => '🍷'],
            ['name' => 'Safe', 'icon' => '🔒'],
            ['name' => 'Room Service', 'icon' => '🍽️'],
            ['name' => 'Coffee Maker', 'icon' => '☕'],
            ['name' => 'Hair Dryer', 'icon' => '💇'],
            ['name' => 'Iron', 'icon' => '♨️'],
            ['name' => 'Work Desk', 'icon' => '💼'],
            ['name' => 'Ocean View', 'icon' => '🌊'],
            ['name' => 'City View', 'icon' => '🏙️'],
            ['name' => 'Mountain View', 'icon' => '⛰️'],
            ['name' => 'Hot Tub', 'icon' => '🛁'],
        ];

        foreach ($amenities as $amenity) {
            Amenity::create($amenity);
        }
    }
}

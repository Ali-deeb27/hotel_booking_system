<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Hotel;
use App\Models\Amenity;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = Hotel::all();
        $amenities = Amenity::all();

        foreach ($hotels as $hotel) {
            // Create different room types for each hotel
            $roomTypes = [
                [
                    'room_type' => 'Standard Single',
                    'description' => 'Comfortable single room with modern amenities, perfect for solo travelers.',
                    'max_occupancy' => 1,
                    'price_per_night' => rand(80, 120),
                    'size_sqm' => 25,
                    'bed_type' => 'Single',
                    'count' => 1,
                    'image' => 'images/hotels/room1.jpg',
                ],
                [
                    'room_type' => 'Deluxe Double',
                    'description' => 'Spacious double room with comfortable king-size bed and city views.',
                    'max_occupancy' => 2,
                    'price_per_night' => rand(150, 200),
                    'size_sqm' => 35,
                    'bed_type' => 'King',
                    'count' => 1,
                    'image' => 'images/hotels/room2.jpg',
                ],
                [
                    'room_type' => 'Suite',
                    'description' => 'Luxurious suite with separate living area, premium amenities, and stunning views.',
                    'max_occupancy' => 4,
                    'price_per_night' => rand(300, 450),
                    'size_sqm' => 60,
                    'bed_type' => 'King',
                    'count' => 1,
                    'image' => 'images/hotels/room3.jpg',
                ],
                [
                    'room_type' => 'Family Room',
                    'description' => 'Large family-friendly room with multiple beds, perfect for families with children.',
                    'max_occupancy' => 4,
                    'price_per_night' => rand(200, 280),
                    'size_sqm' => 45,
                    'bed_type' => 'Queen',
                    'count' => 1,
                    'image' => 'images/hotels/room4.jpg',
                ],
            ];

            foreach ($roomTypes as $roomType) {
                for ($i = 1; $i <= $roomType['count']; $i++) {
                    $room = Room::create([
                        'hotel_id' => $hotel->id,
                        'room_number' => strtoupper(substr($hotel->name, 0, 2)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                        'room_type' => $roomType['room_type'],
                        'description' => $roomType['description'],
                        'max_occupancy' => $roomType['max_occupancy'],
                        'price_per_night' => $roomType['price_per_night'],
                        'size_sqm' => $roomType['size_sqm'],
                        'bed_type' => $roomType['bed_type'],
                        'has_wifi' => true,
                        'has_tv' => true,
                        'has_ac' => true,
                        'has_balcony' => rand(0, 1) == 1,
                        'is_available' => rand(0, 10) > 1, // 90% available
                        'image' => $roomType['image'],
                    ]);

                    // Attach random amenities (3-6 amenities per room)
                    $randomAmenities = $amenities->random(rand(3, 6));
                    $room->amenities()->attach($randomAmenities->pluck('id'));
                }
            }
        }
    }
}

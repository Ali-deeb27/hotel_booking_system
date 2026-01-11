<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Grand Paradise Resort',
                'description' => 'A luxurious 5-star resort located on the beautiful beachfront. Featuring world-class amenities, fine dining restaurants, and exceptional service. Perfect for families and couples seeking an unforgettable vacation experience.',
                'address' => '123 Beach Boulevard',
                'city' => 'Miami',
                'state' => 'Florida',
                'country' => 'United States',
                'zip_code' => '33139',
                'phone' => '+1-305-555-0100',
                'email' => 'info@grandparadise.com',
                'star_rating' => 5,
                'latitude' => 25.7617,
                'longitude' => -80.1918,
                'is_active' => true,
                'image' => 'hotels/hotel1.jpg',
            ],
            [
                'name' => 'Urban City Hotel',
                'description' => 'Modern boutique hotel in the heart of downtown. Stylish rooms with city views, rooftop bar, and easy access to shopping, dining, and entertainment. Ideal for business travelers and urban explorers.',
                'address' => '456 Main Street',
                'city' => 'New York',
                'state' => 'New York',
                'country' => 'United States',
                'zip_code' => '10001',
                'phone' => '+1-212-555-0200',
                'email' => 'hello@urbancity.com',
                'star_rating' => 4,
                'latitude' => 40.7128,
                'longitude' => -74.0060,
                'is_active' => true,
                'image' => 'hotels/hotel2.jpg',
            ],
            [
                'name' => 'Mountain View Lodge',
                'description' => 'Cozy lodge nestled in the mountains, offering breathtaking views and outdoor activities. Perfect for nature lovers and adventure seekers. Features spa facilities and traditional cuisine.',
                'address' => '789 Mountain Road',
                'city' => 'Aspen',
                'state' => 'Colorado',
                'country' => 'United States',
                'zip_code' => '81611',
                'phone' => '+1-970-555-0300',
                'email' => 'stay@mountainview.com',
                'star_rating' => 4,
                'latitude' => 39.1911,
                'longitude' => -106.8175,
                'is_active' => true,
                'image' => 'hotels/hotel3.jpg',
            ],
            [
                'name' => 'Riverside Inn',
                'description' => 'Charming historic inn by the river with traditional architecture and warm hospitality. Each room is uniquely decorated. Great for romantic getaways and peaceful retreats.',
                'address' => '321 River Lane',
                'city' => 'Portland',
                'state' => 'Oregon',
                'country' => 'United States',
                'zip_code' => '97201',
                'phone' => '+1-503-555-0400',
                'email' => 'info@riversideinn.com',
                'star_rating' => 3,
                'latitude' => 45.5152,
                'longitude' => -122.6784,
                'is_active' => true,
                'image' => 'hotels/hotel4.jpg',
            ],
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}

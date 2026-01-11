<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Create an admin user
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        // Seed hotels, amenities, and rooms
        $this->call([
            HotelSeeder::class,
            AmenitySeeder::class,
            RoomSeeder::class,
        ]);
    }
}

# Hotel Booking System

A complete, dynamic hotel booking system built with Laravel 12, featuring a modern UI with Tailwind CSS, session-based booking management, and a fully database-driven architecture.

## Features

- ✅ **Dynamic Database-Driven System** - All data is stored and managed through the database
- ✅ **User Authentication** - Secure login and registration system
- ✅ **Hotel Management** - Browse and search hotels by city, rating, and keywords
- ✅ **Room Management** - View room details, amenities, pricing, and availability
- ✅ **Session-Based Booking Flow** - Booking information stored in sessions during the booking process
- ✅ **Booking Management** - View, manage, and cancel bookings
- ✅ **Modern UI** - Clean, responsive design with Tailwind CSS
- ✅ **Search & Filter** - Advanced search and filtering capabilities
- ✅ **Availability Checking** - Real-time room availability checking based on dates

## Requirements

- PHP >= 8.2
- Composer
- Node.js & NPM (for asset compilation)
- SQLite (default) or MySQL/PostgreSQL

## Installation

1. **Clone or navigate to the project directory:**
   ```bash
   cd hotel
   ```

2. **Install PHP dependencies:**
   ```bash
   composer install
   ```

3. **Install NPM dependencies:**
   ```bash
   npm install
   ```

4. **Set up environment file:**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Run migrations:**
   ```bash
   php artisan migrate
   ```

6. **Seed the database with sample data:**
   ```bash
   php artisan db:seed
   ```

   This will create:
   - 6 sample hotels (various cities and ratings)
   - Multiple room types for each hotel
   - 15 amenities
   - 1 test user (email: `test@example.com`, password: `password`)

7. **Build frontend assets:**
   ```bash
   npm run build
   ```

   Or for development with hot reload:
   ```bash
   npm run dev
   ```

8. **Start the development server:**
   ```bash
   php artisan serve
   ```

9. **Visit the application:**
   ```
   http://localhost:8000
   ```

## Default Login Credentials

- **Email:** test@example.com
- **Password:** password

## Database Structure

### Tables

- **users** - User accounts for authentication
- **hotels** - Hotel information (name, location, rating, etc.)
- **rooms** - Room details (type, price, capacity, amenities)
- **amenities** - Available amenities (WiFi, TV, AC, etc.)
- **room_amenities** - Pivot table for room-amenity relationships
- **bookings** - Booking records with status and payment information

## Key Features Explained

### Booking Flow with Sessions

The booking system uses Laravel sessions to maintain booking state:

1. User searches for rooms (dates stored in session)
2. User selects a room (room ID stored in session)
3. User confirms booking (all details retrieved from session)
4. Booking is created and session is cleared

### Room Availability

The system checks room availability by:
- Verifying the room is marked as available
- Checking existing bookings for date conflicts
- Excluding cancelled bookings from availability checks

### Dynamic Content

All content is database-driven:
- Hotels can be added/edited through the database
- Rooms and their pricing are managed in the database
- Amenities are dynamically loaded from the database
- All filtering and search works with database queries

## Project Structure

```
app/
├── Http/
│   └── Controllers/
│       ├── Auth/          # Authentication controllers
│       ├── HotelController.php
│       ├── RoomController.php
│       └── BookingController.php
├── Models/                # Eloquent models
│   ├── User.php
│   ├── Hotel.php
│   ├── Room.php
│   ├── Booking.php
│   └── Amenity.php

database/
├── migrations/            # Database migrations
└── seeders/              # Database seeders

resources/
└── views/
    ├── layouts/          # Layout templates
    ├── hotels/           # Hotel views
    ├── rooms/            # Room views
    ├── bookings/         # Booking views
    └── auth/             # Authentication views

routes/
└── web.php               # Application routes
```

## Routes

### Public Routes
- `GET /` - Homepage (redirects to hotels)
- `GET /hotels` - List all hotels
- `GET /hotels/{hotel}` - Show hotel details
- `GET /rooms/search` - Search available rooms
- `GET /rooms/{room}` - Show room details
- `GET /login` - Login page
- `POST /login` - Login process
- `GET /register` - Registration page
- `POST /register` - Registration process

### Authenticated Routes
- `GET /bookings` - List user's bookings
- `GET /bookings/create/{room}` - Show booking form
- `POST /bookings` - Create booking
- `GET /bookings/{booking}` - Show booking details
- `DELETE /bookings/{booking}/cancel` - Cancel booking
- `POST /logout` - Logout

## Technology Stack

- **Backend:** Laravel 12
- **Frontend:** Blade Templates + Tailwind CSS 4
- **Database:** SQLite (default), supports MySQL/PostgreSQL
- **Authentication:** Laravel's built-in authentication
- **Sessions:** Database sessions (configurable)

## Customization

### Adding New Hotels/Rooms

You can add hotels and rooms through:
1. Database seeders (for development/testing)
2. Database directly (for production)
3. Create an admin panel (extension)

### Modifying UI

All views use Tailwind CSS. Modify the views in `resources/views/` and styles will be compiled with `npm run build` or `npm run dev`.

### Changing Session Driver

Edit `.env` file:
```
SESSION_DRIVER=database  # or 'file', 'redis', etc.
```

## License

This project is open-sourced software licensed under the MIT license.

## Support

For issues or questions, please check the Laravel documentation at https://laravel.com/docs

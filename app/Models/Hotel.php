<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'state',
        'country',
        'zip_code',
        'phone',
        'email',
        'star_rating',
        'latitude',
        'longitude',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'star_rating' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function availableRooms()
    {
        return $this->rooms()->where('is_available', true);
    }

    public function bookings()
    {
        return $this->hasManyThrough(Booking::class, Room::class);
    }
}

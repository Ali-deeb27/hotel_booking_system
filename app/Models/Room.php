<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'hotel_id',
        'room_number',
        'room_type',
        'description',
        'max_occupancy',
        'price_per_night',
        'size_sqm',
        'bed_type',
        'has_wifi',
        'has_tv',
        'has_ac',
        'has_balcony',
        'image',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'has_wifi' => 'boolean',
        'has_tv' => 'boolean',
        'has_ac' => 'boolean',
        'has_balcony' => 'boolean',
        'price_per_night' => 'decimal:2',
        'max_occupancy' => 'integer',
        'size_sqm' => 'integer',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailableForDates($checkIn, $checkOut)
    {
        if (!$this->is_available) {
            return false;
        }

        return !$this->bookings()
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('check_in', [$checkIn, $checkOut])
                    ->orWhereBetween('check_out', [$checkIn, $checkOut])
                    ->orWhere(function ($q) use ($checkIn, $checkOut) {
                        $q->where('check_in', '<=', $checkIn)
                          ->where('check_out', '>=', $checkOut);
                    });
            })
            ->exists();
    }
}

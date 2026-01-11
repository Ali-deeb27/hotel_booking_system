<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');
            $table->string('room_number');
            $table->string('room_type'); // Single, Double, Suite, Deluxe, etc.
            $table->text('description');
            $table->integer('max_occupancy');
            $table->decimal('price_per_night', 10, 2);
            $table->integer('size_sqm')->nullable();
            $table->string('bed_type')->nullable(); // King, Queen, Twin, etc.
            $table->boolean('has_wifi')->default(true);
            $table->boolean('has_tv')->default(true);
            $table->boolean('has_ac')->default(true);
            $table->boolean('has_balcony')->default(false);
            $table->string('image')->nullable();
            $table->boolean('is_available')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};

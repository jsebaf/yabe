<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table): void {
            $table->id();
            $table->string('locator')->unique();
            $table->string('hotel');
            $table->string('roomType');
            $table->unsignedInteger('paxes');
            $table->date('checkin');
            $table->date('checkout');
            $table->string('status');
            $table->index(['hotel', 'roomType', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};

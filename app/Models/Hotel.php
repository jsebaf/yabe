<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function roomTypes(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }
}

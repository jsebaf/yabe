<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'maxOccupancy' => 'integer',
        ];
    }

    public function hotels(): HasMany
    {
        return $this->hasMany(HotelRoomType::class);
    }
}

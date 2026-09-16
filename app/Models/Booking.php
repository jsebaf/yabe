<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'paxes' => 'integer',
            'checkin' => 'date:Y-m-d',
            'checkout' => 'date:Y-m-d',
        ];
    }
}

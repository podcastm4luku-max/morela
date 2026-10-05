<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TouristRouteDestination extends Pivot
{
    protected $table = 'tourist_route_destinations';

    protected $fillable = [
        'tourist_route_id',
        'tourist_destination_id',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}

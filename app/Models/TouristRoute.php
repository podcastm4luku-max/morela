<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TouristRoute extends Model
{
    use HasFactory;

    protected $table = 'tourist_routes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'start_name',
        'start_latitude',
        'start_longitude',
        'end_name',
        'end_latitude',
        'end_longitude',
        'distance',
        'duration',
        'google_maps_url',
        'is_active',
        'sort_order',
    ];

    /**
     * Tipe data casting kompatibel dengan Laravel 11
     */
    protected function casts(): array
    {
        return [
            'start_latitude' => 'decimal:7',
            'start_longitude' => 'decimal:7',
            'end_latitude' => 'decimal:7',
            'end_longitude' => 'decimal:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relasi many-to-many ke Destinasi yang Dilewati Rute
     */
    public function destinations()
    {
        return $this->belongsToMany(TouristDestination::class, 'tourist_route_destinations', 'tourist_route_id', 'tourist_destination_id')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    /**
     * Helper URL Google Maps Navigation dengan Waypoints
     */
    public function getNavigationUrlAttribute(): string
    {
        if (! empty($this->google_maps_url)) {
            return $this->google_maps_url;
        }

        $origin = "{$this->start_latitude},{$this->start_longitude}";
        $destination = "{$this->end_latitude},{$this->end_longitude}";

        $waypoints = $this->destinations->map(function ($d) {
            return "{$d->latitude},{$d->longitude}";
        })->implode('|');

        $url = "https://www.google.com/maps/dir/?api=1&origin={$origin}&destination={$destination}";
        if (! empty($waypoints)) {
            $url .= '&waypoints='.urlencode($waypoints);
        }

        return $url;
    }

    /**
     * Scope rute aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    /**
     * Boot model untuk otomatis slug dan sort_order
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
            if (is_null($model->sort_order)) {
                $maxOrder = static::max('sort_order') ?? 0;
                $model->sort_order = $maxOrder + 1;
            }
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TouristDestination extends Model
{
    use HasFactory;

    protected $table = 'tourist_destinations';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'address',
        'latitude',
        'longitude',
        'image',
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
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * Relasi many-to-many ke Rute Wisata
     */
    public function routes()
    {
        return $this->belongsToMany(TouristRoute::class, 'tourist_route_destinations', 'tourist_destination_id', 'tourist_route_id')
            ->withPivot('sort_order')
            ->withTimestamps()
            ->orderByPivot('sort_order');
    }

    /**
     * Helper URL Google Maps Navigation
     */
    public function getNavigationUrlAttribute(): string
    {
        if (! empty($this->google_maps_url)) {
            return $this->google_maps_url;
        }

        return "https://www.google.com/maps/dir/?api=1&destination={$this->latitude},{$this->longitude}";
    }

    /**
     * Helper string koordinat terformat
     */
    public function getCoordinatesTextAttribute(): string
    {
        return "{$this->latitude}, {$this->longitude}";
    }

    /**
     * Scope destinasi aktif
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

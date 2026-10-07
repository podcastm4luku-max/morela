<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'name_en',
        'category',
        'tagline',
        'tagline_en',
        'description',
        'description_en',
        'location',
        'latitude',
        'longitude',
        'visiting_hours',
        'ticket_price',
        'facilities',
        'contact_name',
        'contact_phone',
        'image_url',
        'gallery_images',
        'featured',
        'published',
    ];

    protected $casts = [
        'facilities' => 'array',
        'gallery_images' => 'array',
        'featured' => 'boolean',
        'published' => 'boolean',
        'ticket_price' => 'integer',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function ticketBookings()
    {
        return $this->hasMany(TicketBooking::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return $this->ticket_price > 0
            ? 'Rp '.number_format($this->ticket_price, 0, ',', '.').' / orang'
            : 'Gratis';
    }
}

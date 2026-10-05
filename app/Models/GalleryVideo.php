<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GalleryVideo extends Model
{
    use HasFactory;

    protected $table = 'gallery_videos';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'video_url',
        'thumbnail_url',
        'duration',
        'file_size_mb',
        'category',
        'author',
        'is_published',
    ];

    protected $casts = [
        'file_size_mb' => 'float',
        'is_published' => 'boolean',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->title) . '-' . Str::random(5);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function getFormattedSizeAttribute(): string
    {
        return number_format($this->file_size_mb, 1) . ' MB';
    }
}

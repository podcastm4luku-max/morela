<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SocialMedia extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'social_media';

    /**
     * Atribut yang dapat diisi secara massal
     */
    protected $fillable = [
        'name',
        'slug',
        'icon',
        'url',
        'username',
        'description',
        'is_active',
        'sort_order',
    ];

    /**
     * Tipe data casting
     */
    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot model untuk otomatis membuat slug jika kosong
     */
    public static function boot()
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

    /**
     * Scope untuk media sosial yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan urutan tampilan
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');
    }

    /**
     * Helper untuk mendapatkan warna khas platform
     */
    public function getBadgeColorAttribute(): string
    {
        $slug = strtolower($this->slug ?: Str::slug($this->name));
        return match ($slug) {
            'instagram' => 'bg-pink-100 text-pink-700 border-pink-200',
            'facebook' => 'bg-blue-100 text-blue-700 border-blue-200',
            'youtube' => 'bg-red-100 text-red-700 border-red-200',
            'tiktok' => 'bg-stone-900 text-white border-stone-800',
            'whatsapp' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
            'twitter', 'x' => 'bg-stone-100 text-stone-800 border-stone-300',
            'telegram' => 'bg-sky-100 text-sky-800 border-sky-200',
            default => 'bg-stone-100 text-stone-700 border-stone-200',
        };
    }
}

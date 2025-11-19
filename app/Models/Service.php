<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'icon_path',
        'is_active',
        'sort_order',
    ];

    protected static function booted()
    {
        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = static::makeUniqueSlug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && !$service->isDirty('slug')) {
                $service->slug = static::makeUniqueSlug($service->title, $service->id);
            }
        });
    }

    public static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($title, 70, ''));
        if ($base === '') {
            $base = 'service';
        }

        $slug = $base;
        $i = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function scopeActive($q)
    {
        return $q->where('is_active', true);
    }

    public function getIconUrlAttribute()
    {
        if (!$this->icon_path) {
            return asset('service-placeholder.png');
        }

        // kalau disimpan via Storage disk public
        if (str_starts_with($this->icon_path, 'services/')) {
            return Storage::url($this->icon_path);
        }

        return asset($this->icon_path);
    }
}

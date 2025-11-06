<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
    ];

    protected $appends = ['status'];

    protected static function booted()
    {
        // AUTOGEN saat create kalau slug kosong
        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = static::makeUniqueSlug($post->title);
            }
        });

        // AUTOGEN saat update kalau title berubah & slug tidak disentuh
        static::updating(function ($post) {
            if ($post->isDirty('title') && !$post->isDirty('slug')) {
                $post->slug = static::makeUniqueSlug($post->title, $post->id);
            }
        });
    }

    public static function makeUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug(Str::limit($title, 70, ''));
        if ($base === '') $base = 'post';

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

    // Status scopes
    public function scopePublished($q)
    {
        return $q->where('is_published', true)->where('published_at', '<=', now());
    }
    public function scopeScheduled($q)
    {
        return $q->where('is_published', true)->where('published_at', '>',  now());
    }
    public function scopeDrafts($q)
    {
        return $q->where('is_published', false);
    }
    public function scopeType($q, $t)
    {
        if ($t) $q->where('type', $t);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getStatusAttribute(): string
    {
        if (!$this->is_published) return 'draft';
        if (optional($this->published_at)->isFuture()) return 'scheduled';
        return 'published';
    }

    public function getPublishedAtLocalAttribute()
    {
        return $this->published_at; // sudah WIB, tinggal format
    }
}

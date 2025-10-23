<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $slug = Str::slug($tag->name);
                $count = static::where('slug', 'like', "{$slug}%")->count();
                $tag->slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }
        });
    }

    /** Relationships */
    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

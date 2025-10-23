<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    /** Auto-generate slug if not provided */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $slug = Str::slug($category->name);
                $count = static::where('slug', 'like', "{$slug}%")->count();
                $category->slug = $count ? "{$slug}-" . ($count + 1) : $slug;
            }
        });
    }

    /** Relationships */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}

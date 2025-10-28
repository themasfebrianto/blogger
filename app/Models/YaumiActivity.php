<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YaumiActivity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'order',
        'is_active',
    ];

    /**
     * Relasi: satu aktivitas bisa punya banyak log.
     */
    public function logs()
    {
        return $this->hasMany(YaumiLog::class, 'activity_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YaumiLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'activity_id',
        'date',
        'value',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Relasi: log milik satu user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: log milik satu aktivitas yaumi.
     */
    public function activity()
    {
        return $this->belongsTo(YaumiActivity::class, 'activity_id');
    }
}

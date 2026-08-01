<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invitation extends Model
{
    protected $fillable = [
        'user_id',
        'theme_id',
        'slug',
        'active_until',
        'features'
    ];

    protected $casts = [
        'active_until' => 'datetime',
        'features' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function theme()
    {
        return $this->belongsTo(Theme::class);
    }

    public function wishes()
    {
        return $this->hasMany(Wish::class);
    }

    public function media(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    protected static function booted(): void
    {
        static::deleting(function (Invitation $invitation) {
            // Hapus semua record media milik undangan ini (trigger booted Media untuk hapus file fisik)
            $invitation->media()->get()->each->delete();
        });
    }
}

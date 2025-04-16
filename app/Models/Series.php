<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Series extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'user_name',
        'user_photo_url',
        'published_at'
    ];

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    public function testedBy()
    {
        return $this->belongsToMany(User::class, 'series_tests');
    }

    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function getFormattedForHumansCreatedAtAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    public function getCreatedAtTimestampAttribute(): int
    {
        return $this->created_at->timestamp;
    }
}

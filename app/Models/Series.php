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

    /**
     * Relació 1:N -> Una sèrie té molts vídeos
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class);
    }

    /**
     * Relació fictícia per exemplificar testedby (si es refereix a usuaris que han testejat)
     */
    public function testedBy()
    {
        return $this->belongsToMany(User::class, 'series_tests');
    }

    /**
     * Obtenir la data de creació en format 'd/m/Y'
     */
    public function getFormattedCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    /**
     * Obtenir la data de creació en format llegible per humans
     */
    public function getFormattedForHumansCreatedAtAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Obtenir la data de creació com a timestamp
     */
    public function getCreatedAtTimestampAttribute(): int
    {
        return $this->created_at->timestamp;
    }
}

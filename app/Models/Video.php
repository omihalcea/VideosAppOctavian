<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Video extends Model
{
    use HasFactory;
    /**
     * Els camps assignables massivament.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'url',
        'published_at',
        'previous',
        'next',
        'series_id',
        'user_id',
    ];

    /**
     * Els camps que són de tipus dates.
     *
     * @var list<string>
     */
    protected $dates = ['published_at'];

    /**
     * Retorna la data de publicació formatada com "13 de gener de 2025".
     *
     * @return string|null
     */
    public function getFormattedPublishedAtAttribute(): ?string
    {
        return $this->published_at
            ? Carbon::parse($this->published_at)->locale('ca')->isoFormat('D [de] MMMM [de] YYYY')
            : null; // Retorna null si no està publicat
    }

    /**
     * Retorna la data de publicació en un format llegible per humans com "fa 2 hores".
     *
     * @return string
     */
    public function getFormattedForHumansPublishedAtAttribute()
    {
        return Carbon::parse($this->published_at)->locale('ca')->diffForHumans();
    }

    /**
     * Retorna la data de publicació com un valor Unix timestamp.
     *
     * @return int
     */
    public function getPublishedAtTimestampAttribute()
    {
        return Carbon::parse($this->published_at)->timestamp;
    }

    public function getThumbnailUrlAttribute()
    {
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->url, $matches);

        if (!empty($matches[1])) {
            return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
        }

        return asset('images/default-thumbnail.jpg'); // Miniatura per defecte
    }

    /**
     * Comprova si el vídeo és de YouTube.
     */
    public function getIsYoutubeAttribute(): bool
    {
        return str_contains($this->url, 'youtube.com') || str_contains($this->url, 'youtu.be');
    }

    /**
     * Genera la URL d'embed per al vídeo.
     */
    public function getEmbedUrlAttribute(): string
    {
        // Patró per YouTube
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->url, $matches);

        if (!empty($matches[1])) {
            return "https://www.youtube.com/embed/{$matches[1]}";
        }

        return $this->url;
    }

    /**
     * Obtenir el vídeo anterior.
     */
    public function getPreviousVideoAttribute(): ?Video
    {
        if ($this->previous) {
            return static::find($this->previous);
        }
        return null;
    }

    /**
     * Obtenir el vídeo següent.
     */
    public function getNextVideoAttribute(): ?Video
    {
        if ($this->next) {
            return static::find($this->next);
        }
        return null;
    }

    /**
     * Relació: Un vídeo pertany a un usuari.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relació 1:N inversa -> Un vídeo pertany a una sèrie
     */
    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function setSeriesIdAttribute($value)
    {
        $this->attributes['series_id'] = $value === '' ? null : $value;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function setUser()
    {
        return $this->belongsTo(User::class);
    }
}

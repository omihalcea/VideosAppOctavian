<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Multimedia extends Model
{
    use HasFactory;

    protected $table = 'multimedia';

    protected $fillable = [
        'filename',
        'path',
        'type', // image, video
        'size',
        'user_id',
    ];

    /**
     * Relació amb l'usuari que ha pujat el fitxer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

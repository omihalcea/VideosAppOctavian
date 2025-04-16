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
        'display_name',
        'description',
        'path',
        'type', // image, video
        'size',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

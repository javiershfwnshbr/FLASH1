<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'original_name',
        'filesize',
        'resolution',
        'verdict',
        'ai_score',
        'camera_model',
        'date_taken',
        'time_taken',
        'gps_coordinates',
        'social_media',
    ];
}

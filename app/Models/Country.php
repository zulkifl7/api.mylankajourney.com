<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'flag',
        'currency',
        'image',
        'video_url',
        'poster_url',
        'description',
        'timezone',
        'isActive',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryCity extends Model
{
    protected $fillable = [
        'city',
        'image',
        'alt',
        'type',
    ];
}

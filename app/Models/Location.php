<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'slug',
        'image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($location) {
            if (!$location->slug) {
                $location->slug = Str::slug($location->name);
            }
        });

        static::updating(function ($location) {
            if ($location->isDirty('name') && !$location->isDirty('slug')) {
                $location->slug = Str::slug($location->name);
            }
        });
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}

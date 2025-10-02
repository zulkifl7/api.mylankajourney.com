<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'preferred_travel_date',
        'no_of_travelers',
        'special_requests',
        'hotel_preferences',
        'food_preferences',
        'vehicle_preferences',
    ];

    protected $casts = [
        'preferred_travel_date' => 'date',
    ];

    public function activities()
    {
        return $this->belongsToMany(Activity::class);
    }
}
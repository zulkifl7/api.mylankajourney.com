<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Country::truncate();

        $countries = [
            [
                'name' => 'United Kingdom',
                'slug' => 'united-kingdom',
                'flag' => '/images/flags/uk_flag.png',
                'currency' => 'GBP',
                'image' => '/images/country/british_tourist_edited.jpg',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'United States',
                'slug' => 'united-states',
                'flag' => '/images/flags/us_flag.png',
                'currency' => 'USD',
                'image' => '/images/country/US_tourist_edited.jpg',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'Australia',
                'slug' => 'australia',
                'flag' => '/images/flags/australia_flag.png',
                'currency' => 'AUD',
                'image' => '/images/country/autralian_tourist_edited.jpg',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'Germany',
                'slug' => 'germany',
                'flag' => '/images/flags/germany_flag.png',
                'currency' => 'EUR',
                'image' => '/images/country/germany_tourist_edited.webp',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'France',
                'slug' => 'france',
                'flag' => '/images/flags/france_flag.png',
                'currency' => 'EUR',
                'image' => '/images/country/france_tourist_edited.jpg',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'Canada',
                'slug' => 'canada',
                'flag' => '/images/flags/canada_flag.png',
                'currency' => 'CAD',
                'image' => '/images/country/canada_tourist_edited.jpg',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
            [
                'name' => 'Other',
                'slug' => 'other',
                'flag' => '/images/flags/world_flag.png',
                'currency' => 'USD',
                'image' => '/images/country/global-trends.webp',
                'video_url' => '',
                'poster_url' => '',
                'description' => '',
                'timezone' => '',
            ],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}

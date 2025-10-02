<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\Location;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(base_path('..\my-lanka-journey-frontend\src\data\activities.json'));
        $data = json_decode($json);

        foreach ($data->activities as $activityData) {
            $category = ActivityCategory::where('name', 'like', '%' . $activityData->category . '%')->first();
            $location = Location::where('name', 'like', '%' . $activityData->location . '%')->first();

            if ($category && $location) {
                Activity::create([
                    'title' => $activityData->title,
                    'slug' => $activityData->id,
                    'location_id' => $location->id,
                    'activity_category_id' => $category->id,
                    'description' => $activityData->description,
                    'image' => $activityData->image,
                    'duration' => $activityData->duration,
                    'price' => $activityData->price,
                ]);
            }
        }
    }
}
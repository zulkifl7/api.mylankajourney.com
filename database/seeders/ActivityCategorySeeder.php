<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ActivityCategory;

class ActivityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Adventure', 'slug' => 'adventure'],
            ['name' => 'Culture', 'slug' => 'culture'],
            ['name' => 'Wildlife', 'slug' => 'wildlife'],
            ['name' => 'Wellness', 'slug' => 'wellness'],
            ['name' => 'Beach', 'slug' => 'beach'],
            ['name' => 'Food', 'slug' => 'food'],
        ];

        foreach ($categories as $category) {
            ActivityCategory::create($category);
        }
    }
}
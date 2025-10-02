<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents('c:\\Users\\user\\Documents\\Daxium\\My Lanka Journey\\lanka-venture-builder\\With backend\\my-lanka-journey-frontend\\src\\data\\locations.json');
        $data = json_decode($json, true);

        foreach ($data['locations'] as $location) {
            Location::create([
                'name' => $location['name'],
                'slug' => $location['id'],
                'description' => $location['description'],
                'image' => $location['image'],
            ]);
        }
    }
}
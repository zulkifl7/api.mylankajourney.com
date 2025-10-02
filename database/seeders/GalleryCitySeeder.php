<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GalleryCity;

class GalleryCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $galleryCities = [
            [
                'city' => 'Colombo',
                'image' => 'images/gallery/colombo-with-berei-lake.jpg',
                'alt' => 'Colombo skyline with modern buildings',
                'type' => 'default',
            ],
            [
                'city' => 'Kandy',
                'image' => 'images/gallery/SL_Kandy_Queens_Hotel.jpg',
                'alt' => 'Temple of the Tooth in Kandy',
                'type' => 'default',
            ],
            [
                'city' => 'Galle',
                'image' => 'images/gallery/galle-fort-1050x700-1.jpg',
                'alt' => 'Galle Fort historic walls',
                'type' => 'default',
            ],
            [
                'city' => 'Sigiriya',
                'image' => 'images/gallery/1200px-Sigiriya_(141688197).jpeg',
                'alt' => 'Sigiriya Rock Fortress',
                'type' => 'default',
            ],
            [
                'city' => 'Ella',
                'image' => 'images/gallery/ella.webp',
                'alt' => 'Nine Arch Bridge in Ella',
                'type' => 'default',
            ],
            [
                'city' => 'Anuradhapura',
                'image' => 'images/gallery/anuradhapura.jpeg',
                'alt' => 'Ancient ruins of Anuradhapura',
                'type' => 'default',
            ],
            [
                'city' => 'Jaffna',
                'image' => 'images/gallery/jaffna.jpeg',
                'alt' => 'Historic Jaffna Fort and cultural sites',
                'type' => 'default',
            ],
            [
                'city' => 'Negombo',
                'image' => 'images/gallery/negombo-lagoon-in-sri-lanka.webp',
                'alt' => 'Negombo beach and fishing boats',
                'type' => 'default',
            ],
            [
                'city' => 'Nuwara Eliya',
                'image' => 'images/gallery/10-Nuwara-Eliya-City-Tour-2.jpg',
                'alt' => 'Tea plantations in Nuwara Eliya',
                'type' => 'alternative',
            ],
            [
                'city' => 'Polonnaruwa',
                'image' => 'images/gallery/Polonnaruwa-Vatadage.jpg',
                'alt' => 'Ancient city of Polonnaruwa',
                'type' => 'alternative',
            ],
            [
                'city' => 'Mirissa',
                'image' => 'images/gallery/Mirissa-Sri-Lanka4.jpg',
                'alt' => 'Mirissa beach and palm trees',
                'type' => 'alternative',
            ],
            [
                'city' => 'Dambulla',
                'image' => 'images/gallery/dambulla.webp',
                'alt' => 'Dambulla Cave Temple',
                'type' => 'alternative',
            ],
            [
                'city' => 'Bentota',
                'image' => 'images/gallery/bentotoa.jpg',
                'alt' => 'Bentota beach resort',
                'type' => 'alternative',
            ],
            [
                'city' => 'Trincomalee',
                'image' => 'images/gallery/Places-to-visit-in-Trincomalee-3.jpg',
                'alt' => 'Trincomalee harbor and beaches',
                'type' => 'alternative',
            ],
            [
                'city' => 'Matara',
                'image' => 'images/gallery/Matara.jpg',
                'alt' => 'Matara coastal views and lighthouse',
                'type' => 'alternative',
            ],
            [
                'city' => 'Badulla',
                'image' => 'images/gallery/Badulla-1.jpg',
                'alt' => 'Badulla hill country and tea estates',
                'type' => 'alternative',
            ],
        ];

        foreach ($galleryCities as $city) {
            GalleryCity::create($city);
        }
    }
}

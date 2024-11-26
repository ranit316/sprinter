<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Offer::create([
            'name' => 'Offer1',
            'description' => 'test Offer',
            'status' => 'Active',
            'is_feature' => 'Yes',
            'photo' => 'image/offer/offer1.jpg',
            'cta_type' => 'WA',
            'start_date' => '2024-03-19 16:00:00',
            'end_date' => '2024-03-30 16:00:00',
            'cta_link' => '+917429000000',
            'created_by'=> 1,
        ]);

        Offer::create([
            'name' => 'Offer2',
            'description' => 'test Offer 2',
            'status' => 'Active',
            'is_feature' => 'No',
            'photo' => 'image/offer/offer2.jpg',
            'cta_type' => 'WA',
            'start_date' => '2024-03-19 16:00:00',
            'end_date' => '2024-03-30 16:00:00',
            'cta_link' => '+917429000000',
            'created_by'=> 1,
        ]);
    }
}

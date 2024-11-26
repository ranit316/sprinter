<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Event::create([
            'name' => 'Indian Premier League / Mar 01 2024 16:30 (IST)',
            'description' => 'test',
            'status' => 'Active',
            'cta_type' => 'WA',
            'cta_link' => '+917429000000',
            'photo' => 'image/event/event1.jpeg',
            'category_id' => 1,
            'created_by' => 1,
        ]);

        Event::create([
            'name' => 'WEST INDIES ACADEMY V COMBINED CAMPUSES / Mar 20 2024 19:30 (IST)',
            'description' => 'test1232',
            'status' => 'Active',
            'cta_type' => 'WA',
            'photo' => 'image/event/event2.jpeg',
            'cta_link' => '+917429000000',
            'category_id' => 1,
            'created_by' => 1,
        ]);

    }
}

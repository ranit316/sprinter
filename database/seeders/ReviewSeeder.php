<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::create([
            'type' => 'Video',
            'photo' => 'image/review/video1.jpg',
            'video' => 'www.youtube.com/embed/xmq24yDHzz8',
            'status' => 'Approved',
            'marks' => '4',
            'created_by' => 1,
            'user_name' => 'ranit',
            'review' => 'celeb'

        ]);

        Review::create([
            'type' => 'Video',
            'photo' => 'image/review/video2.jpg',
            'video' => 'www.youtube.com/embed/1Vmr5bTVqZ0',
            'status' => 'Approved',
            'marks' => '5',
            'created_by' => 1,
            'user_name' => 'venit',
            'review' => 'celeb'


        ]);

        Review::create([
            'type' => 'Text',
            'content' => 'Sprinter is the best gaming platform',
            'status' => 'Approved',
            'marks' => '5',
            'created_by' => 1,
            'user_name' => 'satya',
            'review' => 'customer',
        ]);

        Review::create([
            'type' => 'Image',
            'photo' => 'image/review/review1.jpg',
            'status' => 'Approved',
            'marks' => '5',
            'created_by' => 1,
            'user_name' => 'abhishek',
            'review' => 'customer',
        ]);
    }
}

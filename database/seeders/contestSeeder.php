<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contest;
use Illuminate\Support\Carbon;

class contestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contest::create([
            'name' => 'Ball by Ball',
            'category_id' => '1',
            'cta_type' => 'Email',
            'cta_link' => 'test@gmail.com',
            'start_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addMonth()->format('Y-m-d H:i:s'),
            'price' => 'samsung galaxy s6',
            'photo' => 'image/contest/contest1.jpeg',
            'description' => '<p>This is for test</p>',
            'status' => 'Active',
            //'platform_id' => '',
            'created_by' => 1,
            'result_link' => 'demo',
        ]);
        Contest::create([
            'name' => 'Chennai Super Kings vs Royal Challengers Bangalore',
            'category_id' => '2',
            'cta_type' => 'Email',
            'cta_link' => 'test2@gmail.com',
            'start_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addMonth()->format('Y-m-d H:i:s'),
            'price' => 'samsung galaxy S12',
            'photo' => 'image/contest/contest2.jpeg',
            'description' => '<p>This is for test</p>',
            'status' => 'Active',
            //'platform_id' => '',
            'created_by' => 1,
            'result_link' => 'tiger',
        ]);
        Contest::create([
            'name' => 'Chennai Super Kings vs Royal Challengers Bangalore',
            'category_id' => '2',
            'cta_type' => 'WA',
            'cta_link' => '+917429000000',
            'start_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addMonth()->format('Y-m-d H:i:s'),
            'price' => 'samsung galaxy S12',
            'photo' => 'image/contest/contest2.jpeg',
            'description' => '<p>This is for test</p>',
            'status' => 'Active',
            //'platform_id' => '',
            'created_by' => 1,
            'result_link' => 'demo2',
        ]);
        Contest::create([
            'name' => 'Chennai Super Kings vs Royal Challengers Bangalore',
            'category_id' => '2',
            'cta_type' => 'Tel',
            'cta_link' => '+917737000000',
            'start_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            'end_date' => Carbon::now()->addMonth()->format('Y-m-d H:i:s'),
            'price' => 'samsung galaxy S12',
            'photo' => 'image/contest/contest2.jpeg',
            'description' => '<p>This is for test</p>',
            'status' => 'Active',
            //'platform_id' => '',
            'created_by' => 1,
            'result_link' => 'tiger4',
        ]);
    }
}

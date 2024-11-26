<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class GamecategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Game 1',
            'description' => 'test game Catagory',
            'status' => 'Active',
            'created_by' => 1,
        ]);

        Category::create([
            'name' => 'Game 2',
            'description' => 'test2 game Catagory',
            'status' => 'Active',
            'created_by' => 1,
        ]);
    }
}

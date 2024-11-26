<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FaqCategory;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FaqCategory::create([
            'name' =>'Feedback',
            'description' => 'category',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Getting Demo ID:',
            'description' => 'Test Category 1',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Getting Live ID:',
            'description' => 'Test Category 2',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Account and Registration:',
            'description' => 'Test Category 3',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'App Performance:',
            'description' => 'Test Category 4',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Features and Functionality:',
            'description' => 'Test Category 5',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Account Management:',
            'description' => 'Test Category 6',
            'status' => 'Active',
            'created_by' => 1,
        ]);
        FaqCategory::create([
            'name' => 'Privacy and Security:',
            'description' => 'Test Category 7',
            'status' => 'Active',
            'created_by' => 1,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Type;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['Feedback', 'Support'];

        foreach ($types as $typeName) {
            Type::updateOrCreate(['name' => $typeName]);
        }
    }
}

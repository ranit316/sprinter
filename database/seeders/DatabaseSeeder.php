<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
           
            PermissionTableSeeder::class,
            FaqSeeder::class,
            PermissionTableSeeder2::class,
            CreateAdminUserSeeder::class,
            AppinfoSeeder::class,
            FaqSeeder::class,
            CategorySeeder::class,
            CmsPageSeeder::class,
            platfromSeeder::class,
            GamecategorySeeder::class,
            ReviewSeeder::class,
            contestSeeder::class,
            OfferSeeder::class,
            EventSeeder::class,
            FaqsSeeder::class,
        ]);
       
    }
}

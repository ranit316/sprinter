<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cms_pages;

class CmsPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cms_pages::create([
            'title' => 'Privacy Policy',
            'description' => '#',
        ]);
        Cms_pages::create([
            'title' => 'Terms & Conditions',
            'description' => '#',
        ]);
        // Cms_pages::create([
        //     'title' => 'Disclaimer',
        //     'description' => '#',
        // ]);
        Cms_pages::create([
            'title' => 'Get Support',
            'description' => '#',
        ]);
        Cms_pages::create([
            'title' => 'Unsubscibe',
            'description' => '#',
        ]);
    }
}

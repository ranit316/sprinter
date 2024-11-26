<?php

namespace Database\Seeders;

use App\Models\AppInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppinfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppInfo::create([
            'title' => 'Sprinter Online',
            'description' => 'Sprinter Description',
            'version' => '1.0',
            'beta_url' => 'https://sprinteronline.in',
            'playstore_url' => 'https://sprinteronline.in',
            'appstore_url' => 'https://sprinteronline.in',
            'logo' => '',
            'dark_logo' => '',
            'fav_icon' => '',
            'footer_left' => 'Copyright © 2024 Sprinter Online',
            'email' => 'customersqueries247@gmail.com',
            'cc_email' => 'support@sprintersonline.in',
            'bcc_email' => 'support@sprintersonline.in',
            'phone' => '+7737000000',
            'whats_app_1' => '+917429000000',
            'whats_app_2' => '+917429000000',
            'whats_app_3' => '+917429000000',
            'whats_app_4' => '',
            'whats_app_5' => '',
            'whats_app_6' => '+917429000000',
        ]);
    }
}

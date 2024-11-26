<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Platform;
class platfromSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Platform::create([
            'name' => 'Jewel Exch',
            'description' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'status' => 'Active',
            'photo' => 'image/platform/platform1.png',
            'created_by' => 1,
            'demo_user_id' => 'Demodemnd02',
            'demo_password' => 123456,
            'demo_details' => 'www.jewelexch.com/',
        ]);
        Platform::create([
            'name' => 'Jewel 247 (Auto Deposite)',
            'description' => 'Demo Available In Site',
            'status' => 'Active',
            'photo' => 'image/platform/platform2.png',
            'created_by' => 1,
            'demo_user_id' => 'Demosil04',
            'demo_password' => 654321,
            'demo_details' => 'www.jewel247.com',
        ]);
        Platform::create([
            'name' => 'Jewel 365 (Auto Deposit)',
            'description' => 'Test Description 3',
            'status' => 'Active',
            'photo' => 'image/platform/platform3.png',
            'created_by' => 1,
            'demo_user_id' => 'Demo Available In Site',
            'demo_password' => 'Demo Available In Site',
            'demo_details' => 'www.jewel365.com',
        ]);
        Platform::create([
            'name' => 'Hawk Exch',
            'description' => 'Test Description 4',
            'status' => 'Active',
            'photo' => 'image/platform/platform4.png',
            'created_by' => 1,
            'demo_user_id' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_password' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_details' => 'www.hawkexch.com',
        ]);
        Platform::create([
            'name' => 'Jewel 999',
            'description' => 'Test Description 5',
            'status' => 'Active',
            'photo' => 'image/platform/platform5.png',
            'created_by' => 1,
            'demo_user_id' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_password' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_details' => 'www.jewel999.com/',
        ]);
        Platform::create([
            'name' => 'Sprint Book 247',
            'description' => 'Test Description 6',
            'status' => 'Active',
            'photo' => 'image/platform/platform6.png',
            'created_by' => 1,
            'demo_user_id' => 'Demospr2470',
            'demo_password' => 'Asdf1122',
            'demo_details' => 'www.sprintbook247.com/d/index.html#/home',
        ]);
        Platform::create([
            'name' => 'Tiger Exch247',
            'description' => 'Test Description 7',
            'status' => 'Active',
            'photo' => 'image/platform/platform7.png',
            'created_by' => 1,
            'demo_user_id' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_password' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_details' => 'www.tigerexch247.vip/',
        ]);
        Platform::create([
            'name' => 'Contra247',
            'description' => 'Test Description 8',
            'status' => 'Active',
            'photo' => 'image/platform/platform8.png',
            'created_by' => 1,
            'demo_user_id' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_password' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_details' => 'www.contra247.com/',
        ]);
        Platform::create([
            'name' => 'Jewel777',
            'description' => 'Test Description 9',
            'status' => 'Active',
            'photo' => 'image/platform/platform9.png',
            'created_by' => 1,
            'demo_user_id' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_password' => 'DEMO LOGIN AVAILABLE IN SITE WITHOUT USERNAME',
            'demo_details' => 'www.jewel777.com/',
        ]);
        Platform::create([
            'name' => 'Diamond Exch9',
            'description' => 'Test Description 10',
            'status' => 'Active',
            'photo' => 'image/platform/platform10.png',
            'created_by' => 1,
            'demo_user_id' => 'Demodmnd02',
            'demo_password' => 'Asdf1122',
            'demo_details' => 'www.diamondexch99.com/',
        ]);
        Platform::create([
            'name' => 'Sprinters Sky',
            'description' => 'Test Description 11',
            'status' => 'Active',
            'photo' => 'image/platform/platform11.png',
            'created_by' => 1,
            'demo_user_id' => 'Demosky',
            'demo_password' => 'Asdf1122',
            'demo_details' => 'www.sprintersky.com/',
        ]);
        Platform::create([
            'name' => 'Silver Exch',
            'description' => 'Test Description 12',
            'status' => 'Active',
            'photo' => 'image/platform/platform12.png',
            'created_by' => 1,
            'demo_user_id' => 'Demosil04',
            'demo_password' => 'Asdf1122',
            'demo_details' => 'www.silverexch.com/login',
        ]);
    }
}

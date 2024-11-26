<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder2 extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
            
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            'platform-list',
            'platform-create',
            'platform-edit',
            'platform-delete',

            'contest-list',
            'contest-create',
            'contest-edit',
            'contest-delete',

            'event-list',
            'event-create',
            'event-edit',
            'event-delete',

            'customer-list',
            'customer-create',
            'customer-edit',
            'customer-delete',

            'offer-list',
            'offer-create',
            'offer-edit',
            'offer-delete',

            
            'review-list',
            'review-create',
            'review-edit',
            'review-delete',

            'faq-category-list',
            'faq-category-create',
            'faq-category-edit',
            'faq-category-delete',

            'faq-list',
            'faq-create',
            'faq-edit',
            'faq-delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}

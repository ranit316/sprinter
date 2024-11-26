<?php
  
namespace Database\Seeders;
  
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
  
class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin 1', 
            'email' => 'admin@admin.com',
            'password' => bcrypt('Admin@$2024')
        ]);
        
        $role = Role::create(['name' => 'Admin']);

        $customerRole = Role::create(['name' => 'Customer']);
         
        $permissions = Permission::pluck('id')->all();
       
        $role->syncPermissions($permissions);
         
        $user->assignRole([$role->id]);
    }
}

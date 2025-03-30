<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if the admin user already exists
        $user = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // Unique identifier
            [
                'name' => 'admin',
                'password' => bcrypt('12345'),
            ]
        );

        // Fetch the existing admin role
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Get all permissions and sync them to the admin role
        $permissions = Permission::all();
        $role->syncPermissions($permissions);

        // Assign the admin role to the user
        $user->assignRole($role);
    }
}

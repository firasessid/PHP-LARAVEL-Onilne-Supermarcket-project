<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminPermissionsSeeder extends Seeder
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

        // Fetch or create the admin role
        $role = Role::firstOrCreate(['name' => 'admin']);

        // Get all permissions
        $permissions = Permission::all();

        // Attach all permissions to the admin role
        foreach ($permissions as $permission) {
            $role->permissions()->syncWithoutDetaching($permission->id);
        }

        // Assign the admin role to the user
        $user->assignRole($role);
    }
}

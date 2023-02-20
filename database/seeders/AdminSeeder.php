<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('12345678')
        ]);

        $role = \App\Models\Role::create([
            'name' => 'Admin'
        ]);

        $add_users = \App\Models\Permission::create([
            'name' => 'create_users',
            'description' => 'This permission will allow user to add users'
        ]);

        $view_users = \App\Models\Permission::create([
            'name' => 'view_users',
            'description' => 'This permission will allow user to view users'
        ]);

        $update_users = \App\Models\Permission::create([
            'name' => 'update_users',
            'description' => 'This permission will allow user to update users'
        ]);

        $delete_users = \App\Models\Permission::create([
            'name' => 'delete_users',
            'description' => 'This permission will allow user to delete users'
        ]);

        $add_roles = \App\Models\Permission::create([
            'name' => 'create_roles',
            'description' => 'This permission will allow user to add roles'
        ]);

        $view_roles = \App\Models\Permission::create([
            'name' => 'view_roles',
            'description' => 'This permission will allow user to view roles'
        ]);

        $update_roles = \App\Models\Permission::create([
            'name' => 'update_roles',
            'description' => 'This permission will allow user to update roles'
        ]);

        $delete_roles = \App\Models\Permission::create([
            'name' => 'delete_roles',
            'description' => 'This permission will allow user to delete roles'
        ]);

        $add_permissions = \App\Models\Permission::create([
            'name' => 'create_permissions',
            'description' => 'This permission will allow user to add permissions'
        ]);

        $view_permissions = \App\Models\Permission::create([
            'name' => 'view_permissions',
            'description' => 'This permission will allow user to view permissions'
        ]);

        $update_permissions = \App\Models\Permission::create([
            'name' => 'update_permissions',
            'description' => 'This permission will allow user to update permissions'
        ]);

        $delete_permissions = \App\Models\Permission::create([
            'name' => 'delete_permissions',
            'description' => 'This permission will allow user to delete permissions'
        ]);

        $role->permissions()->sync([
            $add_users->id,
            $view_users->id,
            $update_users->id,
            $delete_users->id,
            $add_roles->id,
            $view_roles->id,
            $update_roles->id,
            $delete_roles->id,
            $add_permissions->id,
            $view_permissions->id,
            $update_permissions->id,
            $delete_permissions->id,
        ]);

        $user->roles()->sync($role->id);
    }
}

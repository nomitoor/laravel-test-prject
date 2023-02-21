<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;


class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_role_with_permissions()
    {
        $permissions = Permission::factory()->count(2)->create();

        $role = Role::factory()->create();
        $role->permissions()->sync($permissions);

        $this->assertEquals($permissions->pluck('id'), $role->permissions->pluck('id'));
    }


    public function test_can_update_role_with_permissions()
    {
        $permissions = Permission::factory()->count(2)->create();

        $role = Role::factory()->create();
        $role->permissions()->sync($permissions);

        $newPermissions = Permission::factory()->count(1)->create();

        $role->permissions()->sync($newPermissions);

        $this->assertEquals($newPermissions->pluck('id'), $role->permissions->pluck('id'));
    }

    public function test_can_delete_role_with_permissions()
    {
        $permissions = Permission::factory()->count(2)->create();

        $role = Role::factory()->create();
        $role->permissions()->sync($permissions);

        $role->delete();

        $this->assertEquals(0, Role::count());
        $this->assertEquals(0, $role->permissions()->count());
    }
}

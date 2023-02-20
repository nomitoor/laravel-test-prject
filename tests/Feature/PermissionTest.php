<?php

namespace Tests\Unit;

use App\Models\Permission;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    public function test_permission_has_name()
    {
        // Create a new permission with a name
        $permission = new Permission(['name' => 'edit-posts']);

        // Assert that the permission's name is 'edit-posts'
        $this->assertEquals('edit-posts', $permission->name);
    }

    public function test_permission_can_be_created()
    {
        // Create a new permission
        $permission = Permission::create([
            'name' => 'edit-posts',
            'description' => 'Allows the user to edit posts',
        ]);

        // Assert that the permission was created successfully
        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => 'edit-posts',
            'description' => 'Allows the user to edit posts',
        ]);
    }
}

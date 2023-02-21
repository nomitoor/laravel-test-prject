<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;

class RoleService
{

    /**
     * It gets all the roles from the database and returns them as a collection of RoleResource objects
     * 
     * @return A collection of RoleResource objects.
     */
    public function getAllRoles()
    {
        $roles = Role::with('permissions')->get();
        return RoleResource::collection($roles);
    }

    /**
     * It creates a new role, then it syncs the permissions to the role
     * 
     * @param array data The data to be used to create the role.
     * 
     * @return A new RoleResource object.
     */
    public function createRole(array $data)
    {
        $role = Role::create($data);
        $role->permissions()->sync($data['permissions']);

        return new RoleResource($role->load('permissions'));
    }

    /**
     * It updates the role and then syncs the permissions
     * 
     * @param Role role The role object that we want to update.
     * @param array data The data that will be used to update the role.
     * 
     * @return A RoleResource
     */
    public function updateRole(Role $role, array $data)
    {
        $role->update($data);
        $role->permissions()->sync($data['permissions']);

        return new RoleResource($role->load('permissions'));
    }

    /**
     * > Delete a role and all of its permissions and users
     * 
     * @param Role role The role to be deleted.
     * 
     * @return bool A boolean value.
     */
    public function deleteRole(Role $role): bool
    {
        DB::beginTransaction();
        try {
            if ($role->permissions()->count() > 0) {
                $role->permissions()->detach();
            }
            if ($role->users()->count() > 0) {
                $role->users()->detach();
            }
            $role->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * > This function loads the permissions relationship and returns a RoleResource
     * 
     * @param Role role The role model instance.
     * 
     * @return A RoleResource
     */
    public function showRole(Role $role)
    {
        return new RoleResource($role->load('permissions'));
    }
}

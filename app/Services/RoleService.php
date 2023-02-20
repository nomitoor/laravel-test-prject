<?php

namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RoleResource;

class RoleService
{

    public function getAllRoles()
    {
        $roles = Role::with('permissions')->get();
        return RoleResource::collection($roles);
    }

    public function createRole(array $data)
    {   
        $role = Role::create($data);
        $role->permissions()->sync($data['permissions']);

        return new RoleResource($role->load('permissions'));
    }

    public function updateRole(Role $role, array $data)
    {
        $role->update($data);
        $role->permissions()->sync($data['permissions']);

        return new RoleResource($role->load('permissions'));
    }

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

    public function assignPermission(Role $role, int $permissionId): bool
    {
        if ($role->permissions()->where('id', $permissionId)->exists()) {
            return false;
        }

        $role->permissions()->attach($permissionId);
        return true;
    }

    public function removePermission(Role $role, int $permissionId): bool
    {
        if (!$role->permissions()->where('id', $permissionId)->exists()) {
            return false;
        }

        $role->permissions()->detach($permissionId);
        return true;
    }
}

<?php

namespace App\Services;

use App\Models\Permission;
use App\Http\Resources\PermissionResource;

class PermissionService
{
    /**
     * It creates a new permission.
     * 
     * @param array attributes An array of attributes to create the model with.
     * 
     * @return Permission A new instance of the Permission model.
     */
    public function create(array $attributes): Permission
    {
        return Permission::create($attributes);
    }

    /**
     * It updates the given permission with the given attributes
     * 
     * @param Permission permission The permission instance to update.
     * @param array attributes The attributes to update the permission with.
     * 
     * @return Permission A fresh instance of the permission.
     */
    public function update(Permission $permission, array $attributes): Permission
    {
        $permission->update($attributes);

        return $permission->fresh();
    }

    /**
     * It deletes the permission.
     * 
     * @param Permission permission The permission to be deleted.
     */
    public function delete(Permission $permission)
    {
        return $permission->delete();
    }

    /**
     * It returns a collection of all the permissions in the database
     * 
     * @return A collection of all the permissions in the database.
     */
    public function getAll()
    {
        $permission = Permission::all();
        return PermissionResource::collection($permission);
    }

    /**
     * > This function returns a permission object from the database
     * 
     * @param int id The id of the permission you want to retrieve.
     * 
     * @return Permission A Permission object
     */
    public function getById(int $id): Permission
    {
        return Permission::findOrFail($id);
    }
}

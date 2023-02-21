<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\PermissionService;
use Illuminate\Validation\ValidationException;

class PermissionController extends Controller
{
    private $permissionService;

    /**
     * The constructor function is called when the class is instantiated. It takes the
     * PermissionService class as a parameter and assigns it to the  property
     * 
     * @param PermissionService permissionService This is the service that we created in the previous
     * step.
     */
    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * > The index function returns a view of all permissions
     * 
     * @return A view called permissions.index with the variable permissions
     */
    public function index()
    {
        $permissions = $this->permissionService->getAll();

        return $this->successResponse($permissions);
    }

    /**
     * It returns a view called `permissions.create`
     * 
     * @return A view called permissions.create
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * The `store` function validates the request, creates a new permission, and redirects the user to
     * the permissions index page with a success message
     * 
     * @param Request request The request object.
     * 
     * @return A redirect to the permissions index page with a success message.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|unique:permissions,name',
                'description' => 'nullable|string'
            ]);

            $permission = $this->permissionService->create($request->only(['name', 'description']));
            return $this->successResponse($permission);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * > The `edit` function returns a view called `permissions.edit` and passes the `` variable
     * to the view
     * 
     * @param Permission permission The model instance passed by the route.
     * 
     * @return A view called permissions.edit with the compacted permission variable.
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    /**
     * It validates the request, updates the permission, and redirects the user back to the permissions
     * index page with a success message
     * 
     * @param Request request The request object.
     * @param Permission permission The permission model instance.
     * 
     * @return A redirect to the permissions index page with a success message.
     */
    public function update(Request $request, Permission $permission)
    {
        try {
            $this->validate($request, [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('permissions', 'name')->ignore($permission->id)
                ],
                'description' => 'nullable|string'
            ]);

            $permission =  $this->permissionService->update($permission, $request->only(['name', 'description']));
            return $this->successResponse($permission);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * The show function is a public function that takes a User object as a parameter and returns a
     * success response with the found user
     * 
     * @param User user The user object that is passed in from the route.
     * 
     * @return The user object
     */
    public function show(Permission $permission)
    {
        $found_permission = $this->permissionService->showPermission($permission);
        return $this->successResponse($found_permission);
    }
    /**
     * It deletes a permission from the database
     * 
     * @param Permission permission The permission model instance.
     * 
     * @return A redirect to the permissions index page with a success message.
     */
    public function destroy(Permission $permission)
    {
        $this->permissionService->delete($permission);

        return response()->json(['message' => 'Permission deleted successfully.']);
    }
}

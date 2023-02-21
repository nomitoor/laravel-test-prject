<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Services\RoleService;
use Illuminate\Validation\Rule;
use App\Services\PermissionService;
use Illuminate\Validation\ValidationException;

class RoleController extends Controller
{
    protected $roleService;
    private $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->roleService = $roleService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = $this->roleService->getAllRoles();

        return $this->successResponse($roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = $this->permissionService->getAll();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|unique:roles,name',
            ]);

            $role = $this->roleService->createRole($request->all());

            return $this->successResponse($role);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $found_role = $this->roleService->showRole($role);
        return $this->successResponse($found_role);    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        try {
            $this->validate($request, [
                'name' => [
                    'required',
                    'string',
                    Rule::unique('roles', 'name')->ignore($role->id)
                ],
            ]);

            $this->roleService->updateRole($role, $request->all());

            return $this->successResponse($role);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $this->roleService->deleteRole($role);

        return response()->json(['message' => 'Role deleted successfully.']);
    }
}

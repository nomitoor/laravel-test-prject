<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    private $userService;
    protected $roleService;

    /**
     * The constructor function is called when the class is instantiated. It takes the UserService
     * class as a parameter and assigns it to the userService property
     * 
     * @param UserService userService This is the name of the service that we want to inject.
     */
    public function __construct(UserService $userService, RoleService $roleService,)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * > The index function gets all users from the user service and passes them to the view
     * 
     * @return A view called users.index with the variable 
     */
    public function index()
    {
        $users = $this->userService->getAllUsers();

        return $this->successResponse($users);
    }

    /**
     * The show function takes a User object as a parameter and returns a view called users.show, which
     * is passed the User object
     * 
     * @param User user The variable name we'll use in the view.
     * 
     * @return A view called 'users.show' with a compacted variable called 'user'
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }


    /**
     * The `create()` function returns a view called `roles.create` and passes the ``
     * variable to it
     * 
     * @return A view called roles.create with the variable permissions
     */
    public function create()
    {
        $roles = $this->roleService->getAllRoles();
        return view('users.create', compact('roles'));
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
                'name' => 'bail|required|string|max:255',
                'email' => 'bail|required|string|email|max:255|unique:users',
            ]);

            $password = $this->generateRandomPassword();
            $request_array = array_merge($request->all(), array('password' => bcrypt($password)));

            $user = $this->userService->createUser($request_array);

            return $this->successResponse($user);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        try {
            $this->validate($request, [
                'name' => [
                    'required',
                    'string',
                    'bail',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'string',
                    'bail',
                    'max:255',
                    'email',
                    Rule::unique('users', 'email')->ignore($user->id)
                ],
            ]);

            $updated_user = $this->userService->updateUser($user, $request->all());

            return $this->successResponse($updated_user);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $this->userService->deleteUser($user);
        
        return response()->json(['message' => 'User deleted successfully.']);
    }

    /**
     * Generates a random string of characters of the length specified.
     * 
     * @param length The length of the password.
     * 
     * @return string A random string of 10 characters.
     */
    function generateRandomPassword($length = 10): string
    {
        return Str::random($length);
    }
}

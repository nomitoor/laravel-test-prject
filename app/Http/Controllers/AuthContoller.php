<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthContoller extends Controller
{
    private $userService;

    /**
     * The constructor function is called when the class is instantiated. It takes the UserService
     * class as a parameter and assigns it to the userService property
     * 
     * @param UserService userService This is the name of the service that we want to inject.
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * It returns the view `authentication.register`
     * 
     * @return A view called register.
     */
    public function showRegistrationForm()
    {
        return view('authentication.register');
    }

    /**
     * It takes a request, validates it, creates a user, and logs the user in
     * 
     * @param Request request The request object.
     * 
     * @return A redirect to the intended route.
     */
    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:255',
                'email' => 'bail|required|string|email|max:255|unique:users',
                'password' => 'bail|required|string|min:6|confirmed',
            ]);

            $token = hash('sha256', Str::random(40));
            $expiresAt = now()->addHours(48);

            $user_data = array_merge($validatedData, array('api_token' => $token, 'api_token_expires_at' => $expiresAt));

            $user = $this->userService->createUser($user_data);

            return response()->json([
                'access_token'  => $token,
                'token_type'    => 'Bearer',
                'user'          => $user,
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * It returns the view `authentication.login`
     * 
     * @return A view called login.
     */
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    /**
     * If the user's credentials are valid, redirect them to the home page, otherwise, redirect them
     * back to the login page with an error message
     * 
     * @param Request request The request object.
     * 
     * @return The user is being returned.
     */
    public function login(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($validatedData)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            $user = $request->user();
            $token = hash('sha256', Str::random(40));
            
            $this->userService->updateUserToken($user, $token);

            return response()->json([
                'access_token' => $token,
                'user'         => $user,
                'token_type'   => 'Bearer',
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors(), 422);
        }
    }

    /**
     * It logs the user out and redirects them to the login page
     * 
     * @return A redirect to the login page.
     */
    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }
}

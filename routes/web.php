<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthContoller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthContoller::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthContoller::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthContoller::class, 'logout'])->name('logout');
Route::get('/register', [AuthContoller::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthContoller::class, 'register'])->name('register.submit');

// Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [UserController::class, 'index']);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
// });
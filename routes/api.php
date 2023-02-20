<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AuthContoller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthContoller::class, 'register'])->name('register.submit');
Route::post('/login', [AuthContoller::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthContoller::class, 'logout'])->name('logout');

Route::middleware(['api-authenticate'])->group(function () {
    
    Route::get('/dashboard', [UserController::class, 'index'])->middleware('check_permissions:view_users');
    Route::get('/users', [UserController::class, 'index'])->middleware('check_permissions:view_users');
    Route::post('/users', [UserController::class, 'store'])->middleware('check_permissions:create_users');
    Route::get('/users/{user}', [UserController::class, 'show'])->middleware('check_permissions:view_users');
    Route::put('/users/{user}', [UserController::class, 'update'])->middleware('check_permissions:update_users');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('check_permissions:delete_users');
    
    Route::get('/roles', [RoleController::class, 'index'])->middleware('check_permissions:view_roles');
    Route::post('/roles', [RoleController::class, 'store'])->middleware('check_permissions:create_roles');
    Route::get('/roles/{role}', [RoleController::class, 'show'])->middleware('check_permissions:view_roles');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->middleware('check_permissions:update_roles');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->middleware('check_permissions:delete_roles');
    
    Route::get('/permissions', [PermissionController::class, 'index'])->middleware('check_permissions:view_permissions');
    Route::post('/permissions', [PermissionController::class, 'store'])->middleware('check_permissions:create_permissions');
    Route::get('/permissions/{permission}', [PermissionController::class, 'show'])->middleware('check_permissions:view_permissions');
    Route::put('/permissions/{permission}', [PermissionController::class, 'update'])->middleware('check_permissions:update_permissions');
    Route::delete('/permissions/{permission}', [PermissionController::class, 'destroy'])->middleware('check_permissions:delete_permissions');
});

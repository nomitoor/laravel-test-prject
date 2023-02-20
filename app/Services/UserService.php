<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserResource;

class UserService
{
    /**
     * It returns all the users in the database
     * 
     * @return All users in the database.
     */
    public function getAllUsers()
    {
        $users = User::with('roles')->get();
        return UserResource::collection($users);
    }

    /**
     * It creates a user and hashes the password.
     * 
     * @param array data An array of data to create the user with.
     * 
     * @return User A user object
     */
    public function createUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        } else {
            $user->roles()->sync([]);
        }

        return new UserResource($user->load('roles'));
    }

    /**
     * > It updates the user and then syncs the roles
     * 
     * @param User user The user object that we want to update.
     * @param array data The data to be updated.
     * 
     * @return User The user object.
     */
    public function updateUser(User $user, array $data)
    {
        $user->update($data);
        if (isset($data['roles'])) {
            $user->roles()->sync($data['roles']);
        } else {
            $user->roles()->sync([]);
        }

        return UserResource::collection($user->load('roles'));
    }

    /**
     * > Delete a user and all of their roles
     * 
     * @param User user The user object to be deleted.
     * 
     * @return bool A boolean value.
     */
    public function deleteUser(User $user): bool
    {
        DB::beginTransaction();
        try {
            if ($user->roles()->count() > 0) {
                $user->roles()->detach();
            }

            $user->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function updateUserToken(User $user, $token): User
    {
        $user->update(array('api_token' => $token, 'api_token_expires_at' => now()->addHours(48)));
        return $user;
    }
}

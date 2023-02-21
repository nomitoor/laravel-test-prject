<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Role $role) {
            $permissions = Permission::all()->random(2);
            $role->permissions()->attach($permissions);
        });
    }
}

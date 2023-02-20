<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role');
    }

    public function hasPermission($permission)
    {
        foreach ($this->permissions as $perm) {
            if ($perm->name === $permission) {
                return true;
            }
        }

        return false;
    }
}

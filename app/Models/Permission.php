<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description'];

    /**
     * A user can have many roles.
     * 
     * @return A collection of roles
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}

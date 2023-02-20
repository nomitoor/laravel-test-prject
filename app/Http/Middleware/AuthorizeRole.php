<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate;

class AuthorizeRole
{
    protected $gate;

    public function __construct(Gate $gate)
    {
        $this->gate = $gate;
    }

    public function handle($request, Closure $next, $role)
    {
        $user = $request->user();

        if ($user && $this->gate->check('role', [$user, $role])) {
            return $next($request);
        }

        return redirect('/login');
    }
}

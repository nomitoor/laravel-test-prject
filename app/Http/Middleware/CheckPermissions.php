<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission)
    {
        if ($request->user() && $request->user()->hasPermission($permission)) {
            return $next($request);
        }
        
        return response()->json(['message' => 'Unauthrized'], 403);
    }
}


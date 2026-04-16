<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $userRole = auth()->user()->role_id;
        foreach ($roles as $role) {
            $roleId = match($role) {
                'admin' => 1,
                'manager' => 2,
                'employ' => 3,
                default => null
            };
            
            if ($userRole === $roleId) {
                return $next($request);
            }
        }
        abort(403, 'Access denied');
    }
}

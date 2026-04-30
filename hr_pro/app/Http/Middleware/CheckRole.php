<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

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
            $roleId = match(strtolower($role)) {
                'admin' => User::ROLE_ADMIN,
                'manager' => User::ROLE_MANAGER,
                'employ' => User::ROLE_EMPLOYEE,
                default => null
            };
            
            if ($roleId !== null && $userRole === $roleId) {
                return $next($request);
            }
        }
        abort(403, 'Access denied - Insufficient role permissions');
    }
}

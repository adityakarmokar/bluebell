<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        if(session('type') != 'admin'){
            $teamId = session('id');

            if (!$teamId) {
                abort(403, 'Access Denied.');
            }

            $hasPermission = Permission::where('team_id', $teamId)->value($permission);

            if ($hasPermission != 1) {
                // If the team does not have the required permission, return a 403 response
                abort(403, 'You do not have permission to access this resource.');
            }

            return $next($request);

        }
        

        return $next($request);
    }
}

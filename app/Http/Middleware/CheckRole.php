<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;
class CheckRole
{
    /**
     * Usage:
     * ->middleware('role:admin')
     * ->middleware('role:admin,project-manager')
     * ->middleware('role:super-admin')
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(401, 'Unauthenticated.');
        }
        setPermissionsTeamId(session('company_id'));

        $validRoles = Role::pluck('name')->toArray();

        foreach ($roles as $role) {

            // skip custom super-admin keyword
            if ($role === 'super_admin') {
                continue;
            }

            if (!in_array($role, $validRoles)) {

                Auth::logout();

                return redirect()
                    ->route('login')
                    ->with('error', "Invalid role configured: {$role}");
            }
        }

        if (in_array('super_admin', $roles)) {

            if ($user->super_admin) {
                return $next($request);
            }

            $roles = array_filter($roles, fn($role) => $role !== 'super-admin');
        }


        if (!empty($roles) && $user->hasAnyRole($roles)) {
            return $next($request);
        }

        abort(403, 'Unauthorized.');
    }
}

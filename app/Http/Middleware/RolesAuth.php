<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use Closure;

class RolesAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // get user role permissions
        $role = Role::findOrFail(auth()->user()->role_id);
        $permissions = $role->permissions;

        // get requested action
        $actionName = class_basename($request->route()->getActionname());

        // check if requested action is in permission list
        foreach ($permissions as $permission) {
            $_namespaces_chunk = \explode('\\', $permission->controller);
            $controller = end($_namespaces_chunk);
            if ($actionName == $controller . '@' . $permission->method) {
                // authorized request
                return $next($request);
            }
        }

        // none authorized request
        // return response('Unauthorized Action', 403);
        abort(403);
    }
}

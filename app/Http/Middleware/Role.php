<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Session::get('level');
        $roles = explode('_', $role);
        $x = 0;
        foreach ($roles as $r) {
            if ($user == $r) {
                $x = 1;
            }
        }
        if ($x == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}

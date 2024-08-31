<?php

namespace App\Http\Middleware;

use App\Models\Child;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roleArray = explode('|', $roles);
        $userRole = null;

        if (Auth::guard('children')->check()) {
            $userRole = 'Child';
        } else if (Auth::guard('users')->check()) {
            $userRole = Auth::user()->role;
        }

        if (!in_array($userRole, $roleArray)) {
            throw new Exception(__('messages.NoPermission'), 403);
        }
        return $next($request);
    }
}

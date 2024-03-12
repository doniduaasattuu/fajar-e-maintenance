<?php

namespace App\Http\Middleware;

use App\Data\Modal;
use App\Data\Popup;
use App\Models\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($role == 'admin') {
            if (Auth::user()->isAdmin()) {
                return $next($request);
            } else {
                return back()->with('modal', new Modal('[403] Forbidden', 'You are not allowed to perform this operation!'));
            }
        }

        if ($role == 'superadmin') {
            if (Auth::user()->isSuperAdmin()) {
                return $next($request);
            } else {
                return back()->with('modal', new Modal('[403] Forbidden', 'You are not allowed to perform this operation!'));
            }
        }
    }
}

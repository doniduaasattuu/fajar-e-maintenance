<?php

namespace App\Http\Middleware;

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
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $nik = Auth::user()->nik;

        foreach ($roles as $role) {

            $hasRoles = Role::query()->where(['nik' => $nik, 'role' => $role])->first();

            if (
                !is_null($hasRoles) &&
                $hasRoles->nik == $nik &&
                $hasRoles->role == $role
            ) {
                continue;
            } else {
                return redirect()->back()->with('message', ['header' => '[403] You are not authorized!', 'message' => "You are not allowed to perform this operation!."]);
            }
        }

        return $next($request);
    }
}

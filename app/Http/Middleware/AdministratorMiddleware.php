<?php

namespace App\Http\Middleware;

use App\Models\Administrators;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $administrators = Administrators::query()->get();
        $administrator = [];

        foreach ($administrators as $admin) {
            $administrator[] = $admin->admin_nik;
        }

        if (in_array(session()->get("nik"), $administrator)) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}

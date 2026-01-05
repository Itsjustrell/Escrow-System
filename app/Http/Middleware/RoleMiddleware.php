<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!$request->user()) {
            return redirect('/login');
        }

        // 2. Cek apakah user punya role yang diminta
        // Kita gunakan fungsi 'hasRole' yang ada di model User.php Anda
        if (!$request->user()->hasRole($role)) {
            // Jika tidak punya akses, tampilkan error 403
            abort(403, 'Unauthorized. Anda tidak memiliki akses sebagai ' . $role);
        }

        return $next($request);
    }
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureEscrowState
{
    /**
     * Guard agar aksi hanya boleh di state tertentu
     * Contoh: escrow.state:created
     */
    public function handle(Request $request, Closure $next, string ...$allowed): Response
    {
        $escrow = $request->route('escrow');

        if (!$escrow) {
            abort(404, 'Escrow not found');
        }

        if (!in_array($escrow->status, $allowed, true)) {
            abort(403, 'Invalid escrow state');
        }

        return $next($request);
    }
}

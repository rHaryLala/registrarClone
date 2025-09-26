<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AccountantMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['accountant', 'admin', 'superadmin'])) {
            abort(403, 'Accès réservé aux comptables');
        }
        return $next($request);
    }
}

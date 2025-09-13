<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['parent', 'admin', 'superadmin'])) {
            abort(403, 'Accès réservé aux parents');
        }
        return $next($request);
    }
}

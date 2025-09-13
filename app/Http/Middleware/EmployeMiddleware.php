<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['employe', 'admin', 'superadmin'])) {
            abort(403, 'Accès réservé au personnel');
        }
        return $next($request);
    }
}

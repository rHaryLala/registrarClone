<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['student', 'parent', 'admin', 'superadmin'])) {
            abort(403, 'Accès réservé aux étudiants et parents');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['teacher', 'admin', 'superadmin'])) {
            abort(403, 'Accès réservé aux enseignants');
        }
        return $next($request);
    }
}

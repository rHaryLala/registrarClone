<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChiefAccountantMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (!$user || !$user->hasRole(['chief_accountant', 'superadmin'])) {
            abort(403, 'Unauthorized - Chief accountant only');
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $lang = session('app_locale');
            if (auth()->check()) {
                $lang = auth()->user()->lang ?? $lang;
            }

            if ($lang) {
                app()->setLocale($lang);
                Carbon::setLocale($lang);
                // also set locale for strftime etc if needed
                setlocale(LC_ALL, $lang);
            }
        } catch (\Throwable $e) {
            // don't break the request flow if locale can't be set
        }

        return $next($request);
    }
}

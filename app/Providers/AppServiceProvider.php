<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\Course;
use App\Observers\CourseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set locale from authenticated user or session
        try {
            if (auth()->check()) {
                $lang = auth()->user()->lang ?? session('app_locale', config('app.locale'));
                app()->setLocale($lang);
            } elseif (session()->has('app_locale')) {
                app()->setLocale(session('app_locale'));
            }
        } catch (\Exception $e) {
            // auth may not be available in some contexts (console), ignore
        }

        Blade::directive('activeLink', function ($patterns) {
            return "<?php echo Route::is($patterns) ? 'bg-blue-900 text-blue-100' : ''; ?>";
        });

        // Register model observers
        try {
            Course::observe(CourseObserver::class);
        } catch (\Throwable $e) {
            // In some contexts (e.g., during migrations) models may not be available; log and continue
            logger()->info('AppServiceProvider: unable to register CourseObserver: ' . $e->getMessage());
        }
    }
}

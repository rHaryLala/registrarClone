<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        Blade::directive('activeLink', function ($patterns) {
            return "<?php echo Route::is($patterns) ? 'bg-blue-900 text-blue-100' : ''; ?>";
        });
    }
}

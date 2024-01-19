<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;

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
        Carbon::setUTF8(true);
        
        Carbon::setLocale('es');

        setlocale(LC_ALL, 'es_CO', 'es', 'ES', 'es_CO.utf8');

        Blade::directive('money', function ($amount) {
            
            return "<?php echo '$' . number_format($amount, 2, ',', '.'); ?>";
        });
    }
}

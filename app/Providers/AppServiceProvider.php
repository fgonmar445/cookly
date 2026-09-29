<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
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
        // Fuerza que todas las URLs generadas (rutas, assets, enlaces
        // firmados) usen https:// en producción, incluso si algo por
        // detrás no detectara el esquema correctamente.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

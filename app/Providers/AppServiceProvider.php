<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use App\Models\Setting;

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
        // 1. Forzar al paginador a usar los estilos de Bootstrap 5
        Paginator::useBootstrapFive();

        // 2. Compartir ajustes en todas las vistas
        View::share('settings', [
            'site_title'             => Setting::get('site_title', 'Mi Sitio'),
            'per_page'               => (int) Setting::get('per_page', 9),
            'max_resources_per_user' => (int) Setting::get('max_resources_per_user', 10),
        ]);
    }
}

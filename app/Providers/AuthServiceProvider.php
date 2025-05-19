<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Recurso;
use App\Policies\RecursoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Recurso::class => RecursoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Opcional: definir gates adicionales
        Gate::before(function ($user, $ability) {
            // Si es admin, permitir cualquier acción sobre recursos
            if ($user->role_id === 1) {
                return true;
            }
        });
    }
}

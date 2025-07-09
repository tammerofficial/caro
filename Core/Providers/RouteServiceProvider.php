<?php

namespace Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            if (env('IS_USER_REGISTERED') == 1) {
                $middlewares = routeApplicableMiddlewares();
                Route::middleware($middlewares['web'])->prefix(getAdminPrefix())->group(base_path('Core/routes/core.php'));
                Route::middleware($middlewares['api'])->prefix('api')->group(base_path('Core/routes/api.php'));
            }
        });
    }
}

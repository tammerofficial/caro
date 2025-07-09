<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class PluginRouteServices extends ServiceProvider
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
        if (env('IS_USER_REGISTERED') == 1) {
            $this->routes(function () {
                $plugins = getActivePlugins(true);
                $middlewares = routeApplicableMiddlewares();

                foreach ($plugins as $plugin) {
                    if (file_exists(base_path('plugins/' . $plugin->location . '/routes/api.php'))) {
                        Route::middleware($middlewares['api'])->prefix('api')->group(base_path('plugins/' . $plugin->location . '/routes/api.php'));
                    }

                    if (file_exists(base_path('plugins/' . $plugin->location . '/routes/web.php'))) {
                        Route::middleware($middlewares['web'])->group(base_path('plugins/' . $plugin->location . '/routes/web.php'));
                    }

                    if (file_exists(base_path('plugins/' . $plugin->location . '/routes/user.php'))) {
                        Route::middleware($middlewares['web'])->group(base_path('plugins/' . $plugin->location . '/routes/user.php'));
                    }
                }
            });
        }
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}

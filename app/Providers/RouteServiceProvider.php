<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapApiRoutes();
            $this->mapWebRoutes();

            if (env('IS_USER_REGISTERED') == 1) {

                $middlewares = routeApplicableMiddlewares();
                $active_theme = getActiveTheme();

                if (file_exists(base_path('themes/' . $active_theme->location . '/routes/api.php'))) {
                    Route::middleware($middlewares['api'])->prefix('api')->group(base_path('themes/' . $active_theme->location . '/routes/api.php'));
                }

                if (file_exists(base_path('themes/'  . $active_theme->location . '/routes/web.php'))) {
                    Route::middleware($middlewares['web'])->group(base_path('themes/' . $active_theme->location . '/routes/web.php'));
                }
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(200)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/install.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}

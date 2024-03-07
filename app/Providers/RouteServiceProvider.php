<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/';
    public const COMPANY = '/company';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';
    protected $namespacePanel = 'App\\Http\\Controllers\\Panel';
    protected $namespaceApi = 'App\\Http\\Controllers\\Website';
    protected $namespaceEmail = 'App\\Http\\Controllers\\Email';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapPanelRoutes();
        $this->mapMailRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */


    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespaceApi)
            ->group(base_path('routes/api.php'));
    }

    protected function mapPanelRoutes()
    {
        Route::prefix('panel')
            ->middleware('cors')
            ->namespace($this->namespacePanel)
            ->group(base_path('routes/panel.php'));
    }

    protected function mapMailRoutes()
    {
        Route::prefix('mail')
            ->middleware('cors')
            ->namespace($this->namespaceEmail)
            ->group(base_path('routes/mail.php'));
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}

<?php

namespace Mafftor\LaravelFileManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelFileManagerServiceProvider.
 */
class LaravelFileManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'laravel-file-manager');

        $this->loadViewsFrom(__DIR__ . '/views', 'laravel-file-manager');

        $this->publishes([
            __DIR__ . '/config/lfm.php' => config_path('lfm.php'),
        ], 'lfm_config');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/laravel-file-manager'),
        ], 'lfm_public');

        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/laravel-file-manager'),
        ], 'lfm_view');

        $this->publishes([
            __DIR__ . '/Handlers/LfmConfigHandler.php' => base_path('app/Handlers/LfmConfigHandler.php'),
        ], 'lfm_handler');

        if (config('lfm.route.use_package_routes')) {
            $this->registerRoutes();
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // merge default config
        $this->mergeConfigFrom(
            __DIR__ . '/config/lfm.php',
            'lfm'
        );

        $this->app->singleton('laravel-file-manager', function () {
            return true;
        });
    }

    /**
     * Register the application routes.
     *
     * @return void
     */
    public function registerRoutes()
    {
        $attributes = config('lfm.route.attributes');
        Route::group($attributes, function () {
            \Mafftor\LaravelFileManager\Lfm::routes();
        });
    }
}

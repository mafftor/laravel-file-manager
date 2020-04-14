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
        $this->loadTranslationsFrom(__DIR__.'/lang', 'laravel-file-manager');

        $this->loadViewsFrom(__DIR__.'/views', 'laravel-file-manager');

        $this->publishes([
            __DIR__ . '/config/lfm.php' => base_path('config/lfm.php'),
        ], 'lfm_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/laravel-file-manager'),
        ], 'lfm_public');

        $this->publishes([
            __DIR__.'/views'  => base_path('resources/views/vendor/laravel-file-manager'),
        ], 'lfm_view');

        $this->publishes([
            __DIR__.'/Handlers/LfmConfigHandler.php' => base_path('app/Handlers/LfmConfigHandler.php'),
        ], 'lfm_handler');

        if (config('lfm.use_package_routes')) {
            Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth']], function () {
                \Mafftor\LaravelFileManager\Lfm::routes();
            });
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('laravel-file-manager', function () {
            return true;
        });
    }
}

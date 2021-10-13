<?php

namespace Rulya\NovaLocalizableModel;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('nova-localizable-model', __DIR__.'/../dist/js/field.js');
            Nova::style('nova-localizable-model', __DIR__.'/../dist/css/field.css');

            Nova::provideToScript([
                'tinymce_api_key' => config('nova.tinymce_api_key'),
            ]);
        });

        $this->publishes([
            __DIR__.'/../config/nova-localizable-model.php' => config_path('nova-localizable-model.php')
        ], 'nova-localizable-model-config');
    }



    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova'])
            ->prefix('nova-vendor/nova-localizable-model')
            ->group(__DIR__ . '/../routes/api.php');
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

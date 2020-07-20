<?php

namespace Rulya\NovaLocalizableModel;

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
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

<?php

namespace Wilsenhc\RifValidation;

use Illuminate\Support\ServiceProvider;

class RifValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath().'/vendor/validateRif',
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'validateRif');
    }
}
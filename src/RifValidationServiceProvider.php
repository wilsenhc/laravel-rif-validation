<?php

namespace Wilsenhc\RifValidation;

use Illuminate\Support\ServiceProvider;

class RifValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/validateRif'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'validateRif');
    }
}
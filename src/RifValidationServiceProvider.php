<?php

namespace Wilsenhc\RifValidation;

use Illuminate\Support\Facaded\Validator;
use Illuminate\Support\ServiceProvider;

use Wilsenhc\RifValidation\Rules\Rif;

class RifValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/validateRif'),
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/', 'validateRif');

        Validator::extend('rif', [Rif::class, 'passes']);
    }
}
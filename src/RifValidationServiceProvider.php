<?php

namespace Wilsenhc\RifValidation;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;
use Wilsenhc\RifValidation\Rules\Rif;

class RifValidationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath() . '/vendor/validateRif',
        ]);

        $this->loadTranslationsFrom(__DIR__.'/../lang/', 'validateRif');

        // Register custom validation rule
        $this->app['validator']->extend('rif', function ($attribute, $value, $parameters, $validator) {
            return (new Rif())->validate($attribute, $value, function ($message) {
                return $message;
            });
        });
    }
}

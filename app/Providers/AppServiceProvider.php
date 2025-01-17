<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('cpf_format', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $value);
        }, 'O CPF deve ter um formato válido');
    }
}

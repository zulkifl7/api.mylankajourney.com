<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Configure trusted proxies for production
        if (app()->environment('production')) {
            $trustedProxies = config('app.trusted_proxies', '*');
            if ($trustedProxies === '*') {
                \Illuminate\Http\Request::setTrustedProxies(
                    ['*'],
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL
                );
            } else {
                \Illuminate\Http\Request::setTrustedProxies(
                    explode(',', $trustedProxies),
                    \Illuminate\Http\Request::HEADER_X_FORWARDED_ALL
                );
            }
        }
    }
}

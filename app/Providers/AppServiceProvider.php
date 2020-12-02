<?php

namespace App\Providers;

use App\Gateways\Aws\S3Gateway;
use App\Gateways\Aws\S3GatewayContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->app->bind(S3GatewayContract::class, S3Gateway::class);
    }
}

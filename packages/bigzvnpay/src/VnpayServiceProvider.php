<?php

namespace Bigzvnpay;

use Illuminate\Support\ServiceProvider;

class VnpayServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/vnpay.php', 'vnpay');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublish();
    }

    private function registerPublish()
    {
        $this->publishes([
            __DIR__ . '/../config/vnpay.php' => config_path('vnpay.php')
        ]);
    }
}

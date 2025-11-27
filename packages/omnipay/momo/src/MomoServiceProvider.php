<?php

namespace Omnipay\Momo;

use Illuminate\Support\ServiceProvider;

class MomoServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/momo.php', 'momo');
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
            __DIR__.'/../config/momo.php' => config_path('momo.php')
        ]);
    }
}

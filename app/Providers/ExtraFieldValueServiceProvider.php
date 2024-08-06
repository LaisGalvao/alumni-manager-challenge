<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\library\Services\ExtraFieldValueService;

class ExtraFieldValueServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExtraFieldValueService::class, function($app) {
            return new ExtraFieldValueService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

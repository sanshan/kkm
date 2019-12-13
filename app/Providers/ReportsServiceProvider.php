<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
//use App\Services\ReportManager\ReportFactory;

class ReportsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->bind('ReportFactory', function($app){
//            return new ReportFactory();
//        });
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

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
	//var_dump(env('APP_ENV'));
	//die();
        if(env('APP_ENV')=='production') {
            \URL::forceScheme('https');
        }
        Paginator::useBootstrap();
    }
}

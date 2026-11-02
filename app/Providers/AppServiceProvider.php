<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    //View::share('key', 'value');
        //
        // if(config('app.env') === 'production') {
        //     \URL::forceScheme('https');
        // }
        If (env('APP_ENV') !== 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }

        Schema::defaultStringLength(191);

    }
}

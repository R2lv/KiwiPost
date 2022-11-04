<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() 
    {
        app()->singleton("isGeorgian", function() {
            $path = request()->root();
            return strpos($path,'kiwipost.ge') !== false;
        });


        Config::set("app.url", app('isGeorgian') ? env('APP_URL') : env('APP_URL_UK'));

        Config::set("mail.username", env(app("isGeorgian") ?'MAIL_USERNAME_GE':'MAIL_USERNAME'));

        Config::set("mail.from", [
            'address'=>env(app("isGeorgian") ?'MAIL_FROM_ADDRESS_GE':'MAIL_FROM_ADDRESS'),
            'name'=>env(app("isGeorgian") ?'MAIL_FROM_NAME_GE':'MAIL_FROM_NAME'),
        ]);

        URL::forceRootUrl(Config::get('app.url'));

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}

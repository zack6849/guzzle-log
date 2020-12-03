<?php

namespace App\Providers;

use App\DatabaseHandler;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleLogMiddleware\LogMiddleware;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;

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
        $this->app->bind('GuzzleClient', function () {
            $logger = new Logger('laravel');
            $stack = HandlerStack::create();
            $stack->push(new LogMiddleware($logger, new DatabaseHandler()));
            return function ($config) use ($stack){
                return new Client(array_merge($config, ['handler' => $stack]));
            };
        });
    }
}

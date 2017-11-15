<?php

namespace Forum\Providers;

use Forum\Models\Business\Channel;
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
        $channelBusiness = new Channel();
        \View::composer('*', function($view) use ($channelBusiness){
             $view->with('channels', $channelBusiness->all());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

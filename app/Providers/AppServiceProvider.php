<?php

namespace Forum\Providers;

use Cache;
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
            $channels = Cache::rememberForever('channels', function() use ($channelBusiness){
                return $channelBusiness->all();
            });
            
             $view->with('channels', $channels);
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

<?php

namespace Forum\Providers;

use Forum\Models\Entities\Eloquent\Reply;
use Forum\Models\Entities\Eloquent\Thread;
use Forum\Models\Entities\Eloquent\User;
use Forum\Policies\ReplyPolicy;
use Forum\Policies\ThreadPolicy;
use Forum\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
    
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'Forum\Model' => 'Forum\Policies\ModelPolicy',
        Thread::class => ThreadPolicy::class,
        Reply::class  => ReplyPolicy::class,
        User::class => UserPolicy::class
    ];
    
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();
        
//        Gate::before(function ($user) {
//            if ($user->name === 'David Sprauel') {
//                return true;
//            }
//        });
    }
}

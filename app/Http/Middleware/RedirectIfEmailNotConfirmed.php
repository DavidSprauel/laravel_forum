<?php

namespace Forum\Http\Middleware;

use Closure;

class RedirectIfEmailNotConfirmed {
    
    public function handle($request, Closure $next) {
    
        if(! $request->user()->confirmed) {
            return redirect('/threads')->with('flash', 'You must first confirm your email address.');
        }
        
        return $next($request);
    }
}

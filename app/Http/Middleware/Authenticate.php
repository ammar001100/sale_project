<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;




class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            if($request->is('admin') or $request->is('admin/*')) {
                return route('admin.login');
            }else {
                return route('login');
            }
      }
        //return $request->expectsJson() ? null : route('login');
    }
}

<?php

namespace app\http\middleware;

class Auth
{
    public function handle($request, \Closure $next)
    {
    	$request->Auth='auth';
    	return $next($request);
    }
}

<?php

namespace app\http\middleware;

class Auth
{
    public function handle($request, \Closure $next)
    {
    	// $request->Auth='auth';
    	$token = request()->header('token');

        $vars = cache($token);
        if (empty($vars)) {
            return json(['msg'=>'未登录']);
        }
    	
    	return $next($request);
    }
}

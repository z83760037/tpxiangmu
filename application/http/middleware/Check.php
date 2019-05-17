<?php

namespace app\http\middleware;

use think\facade\Log;

class Check
{
    public function handle($request, \Closure $next)
    {
    	Log::write('进入中间件');
    	// $request->Check = 'check';
        return $next($request);
    }
}

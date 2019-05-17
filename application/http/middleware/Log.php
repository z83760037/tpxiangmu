<?php

namespace app\http\middleware;

class Log
{
    public function handle($request, \Closure $next)
    {
    	if (!isset($_COOKIE['adminid'])) {
			//去登录页面
			header('location:' . url('admin/user/login'));
			exit();
		}
		return $next($request); //继续执行
    }
}

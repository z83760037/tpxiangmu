<?php

namespace app\http\middleware;

class Log
{
    public function handle($request, \Closure $next)
    {
    	if (!session("admin")) {
			//去登录页面
			header('location:' . url('admin/login/login'));
			exit();
		}
		return $next($request); //继续执行
    }
}

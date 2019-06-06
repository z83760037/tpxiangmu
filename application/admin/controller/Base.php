<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/4
 * Time: 17:05
 */

namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    protected $middleware = [
        'login',
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/19
 * Time: 11:22
 */

namespace app\web\serivice;


class Token
{
    public static function ifUserlogin()
    {
        $token = request()->header('token');

        $vars = cache($token);
        if (empty($vars)) {
            return false;
        }

        return true;
    }
}
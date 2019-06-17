<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/17
 * Time: 11:51
 */

namespace app\web\exception;


use think\Exception;
use Throwable;

class BaseException extends Exception
{
    //Http 状态码
    public $code = 400;

    //错误信息
    public  $msg = '参数错误';

    //自定义错误码
    public $errorCode = 10000;

    public function __construct($params = [])
    {
        if (is_array($params)) {
            return ;
        }

        if (array_key_exists('code',$params)) {
            $this->code = $params['code'];
        }

        if (array_key_exists('msg',$params)) {
            $this->code = $params['msg'];
        }

        if (array_key_exists('errorCode',$params)) {
            $this->code = $params['errorCode'];
        }
    }
}
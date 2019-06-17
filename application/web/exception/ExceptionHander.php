<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/17
 * Time: 11:47
 */

namespace app\web\exception;


use Exception;
use think\exception\Handle;

class ExceptionHander extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException) {
            $this->code = $e->code;
            $this->msg  = $e->msg;
            $this->errorCode = $e->errorCode;
        } else {
            if (config('app_debug')) {
                return parent::render($e);
            } else {
                $this->code = 500;
                $this->msg  = '服务器内部错误';
                $this-> errorCode = 999;
            }
        }

        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => request()->url(),
        ];
        return json($result,$this->code);
    }
}
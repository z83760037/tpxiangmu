<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/19
 * Time: 11:51
 */

namespace app\web\serivice;

use Exception;

class UserToken
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    public function __construct($code)
    {
        $this->code 		= $code;
        $this->wxAppID 		= config('wx.app_id');
        $this->wxAppSecret 	= config('wx.app_secret');
        $this->wxLoginUrl 	= sprintf(config('wx.login_url'), $this->wxAppID, $this->wxAppSecret, $this->code);
    }

    public function get()
    {
        $result 	= curl_get($this->wxLoginUrl);
        $wxResult 	= json_decode($result, true);
        if (empty($wxResult)) {
            throw new Exception("获取session_key及openID异常");
        } else {
            $login = array_key_exists('errcode', $wxResult);

            if ($login) {
                $this->processLoginError($wxResult);
            } else {
                return $this->grantToken($wxResult);
            }
        }

    }
}
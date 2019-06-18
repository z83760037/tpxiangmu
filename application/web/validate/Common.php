<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/18
 * Time: 16:38
 */

namespace app\web\validate;


class Common extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'aid'	     => 'require',
        'uid'	     => 'require',
        'content'   => 'require',
        'pid'	     => 'require',
        'reply_uid' => 'require',
    ];

    // 提示消息
    protected $message = [
        'aid.require' 	       => "缺少参数",
        'uid.require' 	       => "缺少参数",
        'content.require' 	   => "缺少参数",
        'pid.require' 	       => "缺少参数",
        'reply_uid.require'  => "缺少参数",
    ];
}
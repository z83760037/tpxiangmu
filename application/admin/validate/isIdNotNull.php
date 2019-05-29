<?php

namespace app\admin\validate;


class isIdNotNull extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'id'	   => 'require|isPostitive',

    ];

    // 提示消息
    protected $message = [
        'id.require' 	       => "缺少参数",
        'id.isPostitive' 	   => "参数错误",
    ];
}
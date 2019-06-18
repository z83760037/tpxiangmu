<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/18
 * Time: 17:28
 */

namespace app\web\validate;


class CollectionValidate extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'aid'	     => 'require',
        'uid'	     => 'require',
        'type'      => 'require',
    ];

    // 提示消息
    protected $message = [
        'aid.require' 	       => "缺少参数",
        'uid.require' 	       => "缺少参数",
        'type.require' 	       => "缺少参数",
    ];
}
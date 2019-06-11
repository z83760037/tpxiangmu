<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 10:15
 */

namespace app\admin\validate;


class Links extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'name'	   => 'require|unique:links',
        'url'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'name.require'    => "链接名必须填写",
        'url.require'    => "链接地址必须添加",
        'name.unique' 	   => "链接名已存在",
    ];
}
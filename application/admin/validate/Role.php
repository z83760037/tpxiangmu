<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/28
 * Time: 16:30
 */

namespace app\admin\validate;


class Role extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'name'	   => 'require|unique:system_role',
        'ids'	   => 'require',

    ];

    // 提示消息
    protected $message = [
        'name.require' 	   => "权限名必须填写",
        'name.unique' 	        => "权限名已存在",
        'ids.require' 	       => "可视模块必须选择",
    ];
}
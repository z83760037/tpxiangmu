<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/29
 * Time: 15:18
 */

namespace app\admin\validate;


class Admin extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'name'	    => 'require|unique:system_user',
        'username' => 'require|unique:system_user',
        'password' => 'require',
        'role'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'name.require' 	   => "用户名名必须填写",
        'name.unique' 	       => "用户名已存在",
        'username.require'   => "账号必须填写",
        'username.unique' 	   => "账号已存在",
        'password.require'   => "密码必须填写",
        'role.require' 	   => "用户角色必须选择",
    ];
}
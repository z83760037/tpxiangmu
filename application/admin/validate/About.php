<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 11:49
 */

namespace app\admin\validate;


class About extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'title'	   => 'require|unique:about',
        'content'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'title.require'    => "标题必须填写",
        'content.require'  => "内容必须添加",
        'title.unique' 	 => "标题已存在",
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/5
 * Time: 17:31
 */

namespace app\admin\validate;


class Cate extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'name'	   => 'require|unique:article_cate',
        'img'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'name.require'    => "栏目名必须填写",
        'img.require'    => "图片必须添加",
        'name.unique' 	   => "栏目名已存在",
    ];
}
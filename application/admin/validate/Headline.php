<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 13:59
 */

namespace app\admin\validate;


class Headline extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'title'	   => 'require|unique:article_headline',
        'img'     => 'require',
        'url'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'title.require'    => "标题必须填写",
        'img.require'    => "图片必须添加",
        'url.require'    => "跳转地址必须添加",
        'title.unique' 	   => "标题已存在",
    ];
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 16:41
 */

namespace app\admin\validate;


class NewsFlash extends BaseValidate
{

    // 验证规则
    protected $rule = [
        'title'	   => 'require',
        'content'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'title.require'    => "文章标题必须填写",
        'content.require'  => "文章内容必须填写",
    ];
}
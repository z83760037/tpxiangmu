<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 16:53
 */

namespace app\admin\validate;


class Article extends BaseValidate
{
    // 验证规则
    protected $rule = [
        'title'	   => 'require',
        'img'     => 'require',
        'content'     => 'require',
        'cid'     => 'require',
    ];

    // 提示消息
    protected $message = [
        'title.require'    => "文章标题必须填写",
        'img.require'      => "文章图片必须添加",
        'content.require'  => "文章内容必须填写",
        'cid.require'      => "文章栏目必须选择",
    ];
}
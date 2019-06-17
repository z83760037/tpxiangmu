<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/17
 * Time: 15:54
 */

namespace app\web\exception;


class ArticleException extends BaseException
{
    public $code = 404;

    public $msg = '没有文章数据';

}
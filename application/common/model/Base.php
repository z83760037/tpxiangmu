<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 15:20
 */

namespace app\common\model;


use think\Model;

class Base extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间
}
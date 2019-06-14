<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/31
 * Time: 14:23
 */

namespace app\common\model;


use think\Model;

class SystemAuth extends Model
{
    //权限列表
    public function authList()
    {
        $data = $this->select();
        return $data;
    }
}
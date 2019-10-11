<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/11
 * Time: 11:33
 */

namespace app\common\model;



class Activity extends Base
{
    //分页查询活动
    public function getActivityAll($page,$limit)
    {   
        $pages = ($page-1)*$limit;
        $data = $this->field('id,name,status,created')->limit($pages,$limit)->select();
        return $data;
    }

    //数量
    public function num()
    {
        $num = $this->count();
        return $num;
    }
}
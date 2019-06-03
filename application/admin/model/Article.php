<?php
/**
 * 文章模型
 * Date: 2019/5/31
 * Time: 16:35
 */

namespace app\admin\model;


use think\Model;

class Article extends Model
{
    //作者文章数
    public function bookUserCount($uid)
    {
        return  $this->where('uid',$uid)->count();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/18
 * Time: 17:34
 */

namespace app\common\model;


class UserCollect extends Base
{
    protected $updateTime = false;

    protected $field = true;

    //文章收藏
    public function add($data)
    {
        if ($data['type'] == 'up') {//收藏
//            unset($data['type']);
            $arr = $this->where('aid',$data['aid'])->where('uid',$data['uid'])->find();
            if (!empty($arr)) {
                return false;
            }
            return $this->save($data);
        } elseif ($data['type'] == 'down') { //取消收藏
            return  $this->where('aid',$data['aid'])->where('uid',$data['uid'])->delete();
        }
    }
}
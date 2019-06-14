<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/12
 * Time: 14:07
 */

namespace app\common\model;


class UserFeedback extends Base
{
    protected $updateTime = false;

    public function user()
    {
        return $this->belongsTo('User','uid','id');
    }

    public function getFeedbackData($page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = $this->with(['user'])->limit($size,$limit)->select();
        $num  = $this->count();
        $arr = [
            'code' => 0,
            'msg'  => '',
            'count' => $num,
            'data'  => $data,
        ];
        return $arr;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 14:14
 */

namespace app\common\model;



class ArticleCommen extends Base
{
    protected $updateTime = false;//修改时间

    public function user()
    {
        return $this->belongsTo('User','uid','id');
    }

    public function article()
    {
        return $this->belongsTo('Article','aid','id');
    }

    public function getComment($size,$limit)
    {
        $data = $this->with(['user','article'])->limit($size,$limit)->order('created desc')->select();
        return $data;
    }
}
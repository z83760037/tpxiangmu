<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/6
 * Time: 14:14
 */

namespace app\admin\model;


use think\Model;

class ArticleCommen extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
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
        $data = $this->with(['user','article'])->limit($size,$limit)->select();
        return $data;
    }
}
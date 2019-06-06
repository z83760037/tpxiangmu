<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/31
 * Time: 15:36
 */

namespace app\admin\model;


use think\Model;

class Author extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

    public function user()
    {
        return $this->belongsTo('User','cid','id');
    }

    //作者数据
    public function getAuthorData($page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = db('author')->limit($size,$limit)->select();
        foreach ($data as &$v) {
            if ($v['type'] == 1) {
                $v['name'] = db('SystemUser')->where('id',$v['uid'])->value('name');
                $v['type'] = '后台';
            } elseif ($v['type'] == 2) {
                $v['type'] = '前台';
                $v['name'] = db('User')->where('id',$v['uid'])->value('name');
            }
            $v['count'] = model('Article')->bookUserCount($v['uid']);
        }
        return $data;
    }


}
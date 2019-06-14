<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/31
 * Time: 15:36
 */

namespace app\common\model;



class Author extends Base
{
    public function user()
    {
        return $this->belongsTo('User','cid','id');
    }

    //作者数据
    public function getAuthorData($page,$limit)
    {
        $size = ($page-1)*$limit;
        $data = db('author')->limit($size,$limit)->order('created desc')->select();
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

    //根据id获取作者名
    public function getAuthorById($id)
    {
        $data = db('author')->find($id);
        if ($data['type'] == 1) {
            $name = db('SystemUser')->where('id',$data['uid'])->value('name');
        } elseif ($data['type'] == 2) {
            $name = db('User')->where('id',$data['uid'])->value('name');
        }
        return $name;
    }

}
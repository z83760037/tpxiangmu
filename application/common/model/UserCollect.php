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

    public function article()
    {
        return $this->belongsTo('Article','aid','id');
    }

    public function user()
    {
        return $this->belongsTo('User','uid','id');
    }

    //文章收藏
    public function add($data)
    {
        if ($data['type'] == 'up') {//收藏
            $arr = $this->where('aid',$data['aid'])->where('uid',$data['uid'])->find();
            if (!empty($arr)) {
                return false;
            }
            return $this->save($data);
        } elseif ($data['type'] == 'down') { //取消收藏
            return  $this->where('aid',$data['aid'])->where('uid',$data['uid'])->delete();
        }
    }

    //用户收藏
    public function myCollectData($uid,$page,$limit)
    {
        $size = ($page-1)*$limit;

        $data = $this->with(['user'=>function($query){
            $query->field('id,name,img');
        },'article' => function ($query1){
            $query1->field('id,title,img');
        }])->where('uid',$uid)->limit($size,$limit)->order('id desc')->select();

        return $data;
    }
}
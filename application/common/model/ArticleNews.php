<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 16:11
 */

namespace app\common\model;



class ArticleNews extends Base
{
    //列表数据
    public function getNewsFalsh($page,$limit,$type)
    {
        $size = ($page-1)*$limit;
        $data = $this->where(['status' => $type])->limit($size,$limit)->order('created desc')->select();
        foreach ($data as &$v){
            if ($v['type'] == 1) {
                $v['name'] = db('system_user')->where('id',$v['uid'])->value('name');
                $v['nameImg'] = db('author')->where('id',$v['uid'])->value('img');
            } elseif ($v['type'] == 2) {
                $v['name'] = db('user')->where('id',$v['uid'])->value('name');
                $v['nameImg'] = db('user')->where('id',$v['uid'])->value('img');
            }
            $v['onlineTime'] = $v['onlineTime'] ? date('Y-m-d H:i:s',$v['onlineTime']) : '';
        }
        return $data;
    }

    //数据添加
    public function addNewsFlash($data)
    {
        $admin = session('admin');
        $data['type']   = 1;
        $data['status'] = 0;
        $data['uid']    = $admin['id'];

        return $this->save($data);
    }

    //用户的快讯
    public function getMyNews($uid,$type)
    {
        $data = $this->where('uid',$uid)
            ->where('type',$type)
            ->order('id desc')
            ->select();
        foreach($data as &$v) {
            $v['formatDate'] = formatDate(strtotime($v['created']));
        }
        return $data;
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/10
 * Time: 16:11
 */

namespace app\admin\model;


use think\Model;

class ArticleNews extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

    //列表数据
    public function getNewsFalsh($page,$limit,$type)
    {
        $size = ($page-1)*$limit;
        $data = $this->where(['status' => $type])->limit($size,$limit)->order('created desc')->select();
        foreach ($data as &$v){
            if ($v['type'] == 1) {
                $v['name'] = db('system_user')->where('id',$v['uid'])->value('name');
            } elseif ($v['type'] == 2) {
                $v['name'] = db('user')->where('id',$v['uid'])->value('name');
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
}
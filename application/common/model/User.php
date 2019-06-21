<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/4
 * Time: 16:43
 */

namespace app\common\model;


use think\Db;
use think\Exception;

class User extends Base
{
    protected $updateTime = 'loginTime';

    public function getUserAll($page,$limit,$name)
    {
        $size = ($page-1)*$limit;
        $where = [];
        if ($name) {
            $where = ['name'=>$name];
        }
        $data = $this->limit($size,$limit)->where($where)->order('created desc')->select();
        foreach ($data as &$v) {
            $v['count'] = model('Article')->bookUserCount($v['id']);
        }
        return $data;
    }

    //删除用户
    public function userDel($id)
    {
        Db::startTrans();//开启事物
        try{
            $author = model('author')->where(['uid' => $id, 'type' => 2])->find();
            if (!empty($author)) {
                model('author')->where(['uid' => $id, 'type' => 2])->delete();
            }
            $this->where('id',$id)->delete();
            Db::commit();//提交事物
            return true;
        } catch (Exception $e) {
            Db::rollback();//回滚事物
            return false;
        }
    }


}
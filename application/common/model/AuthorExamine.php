<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/3
 * Time: 16:46
 */

namespace app\common\model;


use think\Exception;
use think\Db;

class AuthorExamine extends Base
{
    public function user(){
        return $this->belongsTo('User','uid','id');
    }

    public function admin() {
        return $this->belongsTo('SystemUser','admin','id');
    }

    public function getAuthorDataAll($page,$size)
    {
        $lit = ($page-1)*$size;
        $data = $this->with(['user'])->where('status',0)->limit($lit,$size)->select();
        foreach ($data as &$v) {
            $v['count'] = model('Article')->bookUserCount($v['uid']);
        }
        return $data;
    }

    //作者审核失败数据列表
    public function getAuthorFailDataAll($page,$size)
    {
        $lit = ($page-1)*$size;
        $data = $this->with(['user','admin'])->where('status',2)->limit($lit,$size)->select();
        foreach ($data as &$v) {
            $v['count'] = model('Article')->bookUserCount($v['uid']);
        }
        return $data;
    }

    //通过
    public function adopt($id,$uid)
    {
        $admin = session('admin');//当前管理员
        Db::startTrans();
        try{
            $this->where('id',$id)->update(['status' => 1, 'admin' => $admin['id']]);
            model('author')->save(['uid' => $uid, 'type' => 2]);
            Db::commit();//提交
            return true;
        }catch (Exception $e) {
            Db::rollback();// 回滚事务
            return false;
        }
    }

    //审核失败
    public function failed($id)
    {
        $admin = session('admin');//当前管理员
        $res = $this->where('id',$id)->update(['status' => 2, 'admin' => $admin['id']]);
        return $res;
    }

}
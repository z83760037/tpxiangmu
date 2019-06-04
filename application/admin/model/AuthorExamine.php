<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/6/3
 * Time: 16:46
 */

namespace app\admin\model;


use think\Exception;
use think\Model;
use think\Db;

class AuthorExamine extends Model
{
    //自动时间戳
    protected $autoWriteTimestamp = true;
    protected $createTime = 'created';//添加时间
    protected $updateTime = 'updated';//修改时间

    public function user(){
        return $this->belongsTo('User','uid','id');
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

    //通过
    public function adopt($id,$uid)
    {
        $admin = session('admin');
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
}
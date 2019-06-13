<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/29
 * Time: 15:08
 */

namespace app\admin\model;


use think\Model;

class SystemUser extends Base
{
    protected $updateTime = 'longtime';

    public function role(){
        return $this->belongsTo('SystemRole','role','id');
    }

    //所有的管理员
    public function getAdminAll($page,$size)
    {
        $lit = ($page-1)*$size;
        $adminData = $this->with(['role'])->limit($lit,$size)->order('longtime desc')->select();
        return $adminData;
    }

    //管理员数量
    public function getAdminCount()
    {
        $num = $this->count();
        return $num;
    }

    //添加管理员
    public function addAdminUser($data)
    {
        $data['password'] = mdPassword($data['password']);
        $res = $this->save($data);
        return $res;
    }

    //修改管理员
    public function editAdminUser($data)
    {
        $data['password'] = mdPassword($data['password']);
        $id = $data['id'];
        unset($data['id']);
        $res = $this->where('id',$id)->update($data);
        return $res;
    }

    //权限修改
    public function authEdit($data)
    {
        $data['actions'] = implode(',',$data['actions']);
        return $this->where('id',$data['id'])->update(['auth' => $data['actions']]);
    }
}
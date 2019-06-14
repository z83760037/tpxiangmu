<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/28
 * Time: 16:13
 */

namespace app\common\model;

use app\admin\validate\isIdNotNull;
use think\Model;

class SystemRole extends Model
{
    public function getGroup()
    {
        $data = db('system_role')
                ->field('id,name,ids')
                ->select();
        foreach ($data as &$v) {
            $v['role'] = tree(db('system_mune')->where('id','in',$v['ids'])->select());
        }
        return $data;
    }

    //添加
    public function addAdminRole($data)
    {
        $data['ids'] = implode(',',$data['ids']);
        $res = $this->save($data);
        return $res;
    }

    public function getAdminRole($id)
    {
        $data = db('system_role')->where('id',$id)->find();
        $data['ids'] = explode(',',$data['ids']);
        return $data;
    }

    //修改
    public function editAdminRole($data)
    {
        $data['ids'] =  implode(',',$data['ids']);
        $id = $data['id'];
        unset($data['id']);
        $res = $this->where('id',$id)->update($data);
        return $res;
    }


}
<?php
/**
 * Created by PhpStorm.
 * User: VULCAN
 * Date: 2019/5/28
 * Time: 16:10
 */

namespace app\admin\controller;


use think\Controller;
use  app\admin\validate\isIdNotNull;

class Role extends Controller
{
    //用户组列表
    public function index()
    {
        $data = model('SystemRole')->getGroup();
        $this->assign('data',$data);
        return $this->fetch();
    }

    //添加页面
    public function add()
    {
        $data = model('SystemMune')->getMune();
        $this->assign('data',$data);
        return $this->fetch();
    }

    //数据添加
    public function addRole()
    {
        $data = request()->param();
        $validate = validate('Role');
        if (!$validate->check($data)) {
            return json_encode(['info' => $validate->getError(), 'status' => 'n']);
        }
        $res = model('SystemRole')->addAdminRole($data);

        if ($res) {
            return json_encode(['info'=>'添加成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'添加失败','status'=>'n']);
        }
    }

    //编辑页面
    public function edit($id)
    {
        $arr  = model('SystemRole')->getAdminRole($id);
        $data = model('SystemMune')->getMune();

        $this->assign([
            'data' => $data,
            'arr'  => $arr,
        ]);
        return $this->fetch();
    }

    //修改数据
    public function editRole()
    {
        $data     = request()->param();
        $validate = validate('Role');

        if (!$validate->check($data)) {
            return json_encode(['info' => $validate->getError(), 'status' => 'n']);
        }

        $res = model('SystemRole')->editAdminRole($data);

        if ($res) {
            return json_encode(['info'=>'修改成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'修改失败','status'=>'n']);
        }
    }

    //删除
    public function del($id)
    {
        $is = (new isIdNotNull())->goCheck();

        if ($is) {
            return json_encode(['info' => $is, 'status' => 'n']);
        }
        $res = model('SystemRole')->where('id',$id)->delete();

        if ($res) {
            return json_encode(['info'=>'删除成功','status'=>'y']);
        } else {
            return json_encode(['info'=>'删除失败','status'=>'n']);
        }
    }
}